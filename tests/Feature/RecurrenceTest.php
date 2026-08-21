<?php

namespace Tests\Feature;

use App\Livewire\Dashboard;
use App\Models\User;
use App\Services\RecurrenceService;
use App\Services\TransactionService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Livewire\Livewire;

test('installment amount is divided across occurrences when created through the service', function () {
    $user = User::factory()->create();

    app(TransactionService::class)->create($user, [
        'type' => 'expense',
        'amount' => 6000,
        'description' => 'Compra parcelada',
        'recurrence' => 'installment',
        'installments' => 6,
        'due_date' => '2026-08-10',
        'purchase_date' => '2026-08-10',
    ]);

    expect($user->transactions()->count())->toBe(6)
        ->and($user->transactions()->pluck('amount')->map(fn ($amount) => (float) $amount)->all())
        ->toBe([1000.0, 1000.0, 1000.0, 1000.0, 1000.0, 1000.0]);
});

test('installments create one occurrence per month', function () {
    $user = User::factory()->create();
    $series = $user->transactionSeries()->create([
        'type' => 'expense', 'amount' => 100,
        'description' => 'Notebook', 'recurrence' => 'installment',
        'starts_on' => Carbon::parse('2026-01-10'), 'ends_on' => Carbon::parse('2026-03-10'),
        'installments' => 3,
    ]);

    app(RecurrenceService::class)->materialize($series, Carbon::parse('2026-06-01'));
    app(RecurrenceService::class)->materialize($series, Carbon::parse('2026-06-01'));

    expect($user->transactions()->count())->toBe(3)
        ->and($user->transactions()->orderBy('due_date')->pluck('installment_number')->all())->toBe([1, 2, 3]);
});

test('the materialization command projects active series using the configured window', function () {
    Carbon::setTestNow(Carbon::parse('2026-08-07 10:00:00'));

    try {
        config()->set('recurrence.materialization_months', 1);
        $user = User::factory()->create();
        $user->transactionSeries()->create([
            'type' => 'expense', 'amount' => 80, 'description' => 'Streaming',
            'recurrence' => 'monthly', 'starts_on' => '2026-08-01',
        ]);

        Artisan::call('transactions:materialize');

        expect($user->transactions()->count())->toBe(2)
            ->and(Artisan::output())->toContain('2 ocorrência(s) criada(s)');
    } finally {
        Carbon::setTestNow();
    }
});

test('the materialization command accepts an explicit limit and is idempotent', function () {
    Carbon::setTestNow(Carbon::parse('2026-08-07 10:00:00'));

    try {
        $user = User::factory()->create();
        $user->transactionSeries()->create([
            'type' => 'income', 'amount' => 500, 'description' => 'Consultoria',
            'recurrence' => 'monthly', 'starts_on' => '2026-08-01',
        ]);

        Artisan::call('transactions:materialize', ['--until' => '2026-10-31']);
        Artisan::call('transactions:materialize', ['--until' => '2026-10-31']);

        expect($user->transactions()->count())->toBe(3)
            ->and(Artisan::output())->toContain('0 ocorrência(s) criada(s)');
    } finally {
        Carbon::setTestNow();
    }
});

test('the dashboard does not materialize recurring series while rendering', function () {
    $user = User::factory()->create();
    $user->transactionSeries()->create([
        'type' => 'expense', 'amount' => 80, 'description' => 'Streaming',
        'recurrence' => 'monthly', 'starts_on' => now()->startOfMonth(),
    ]);

    Livewire::actingAs($user)->test(Dashboard::class)->assertOk();

    expect($user->transactions()->count())->toBe(0);
});
