<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\RecurrenceService;
use App\Services\TransactionService;
use Carbon\Carbon;

test('an individual edit detaches the occurrence from its recurring series', function () {
    $user = User::factory()->create();
    $series = $user->transactionSeries()->create([
        'type' => 'expense', 'amount' => 100, 'description' => 'Aluguel',
        'recurrence' => 'monthly', 'starts_on' => '2026-08-05',
    ]);
    app(RecurrenceService::class)->materialize($series, Carbon::parse('2026-10-31'));
    $occurrence = $series->occurrences()->whereDate('due_date', '2026-08-05')->firstOrFail();

    app(TransactionService::class)->updateOccurrence($occurrence, [
        'type' => 'expense', 'amount' => 125, 'description' => 'Aluguel reajustado',
        'merchant' => null, 'notes' => null, 'category_id' => null,
        'financial_account_id' => null, 'credit_card_id' => null,
        'due_date' => '2026-08-05', 'status' => 'settled', 'settled_at' => '2026-08-06',
    ]);

    $occurrence->refresh();
    expect($occurrence->transaction_series_id)->toBeNull()
        ->and($occurrence->description)->toBe('Aluguel reajustado')
        ->and($occurrence->settled_at->toDateString())->toBe('2026-08-06')
        ->and($series->occurrences()->whereDate('due_date', '2026-09-05')->value('description'))->toBe('Aluguel');
});

test('a series edit updates pending occurrences from the selected occurrence forward', function () {
    $user = User::factory()->create();
    $series = $user->transactionSeries()->create([
        'type' => 'expense', 'amount' => 100, 'description' => 'Assinatura',
        'recurrence' => 'monthly', 'starts_on' => '2026-08-05',
    ]);
    app(RecurrenceService::class)->materialize($series, Carbon::parse('2026-10-31'));
    $occurrence = $series->occurrences()->whereDate('due_date', '2026-09-05')->firstOrFail();

    app(TransactionService::class)->updateSeries($occurrence, [
        'type' => 'expense', 'amount' => 150, 'description' => 'Assinatura atualizada',
        'merchant' => 'Fornecedor', 'notes' => null, 'category_id' => null,
        'financial_account_id' => null, 'credit_card_id' => null,
    ]);

    expect($series->occurrences()->whereDate('due_date', '2026-08-05')->value('description'))->toBe('Assinatura')
        ->and($series->occurrences()->whereDate('due_date', '2026-09-05')->value('description'))->toBe('Assinatura atualizada')
        ->and($series->occurrences()->whereDate('due_date', '2026-10-05')->value('amount'))->toBe('150.00');
});

test('a transaction can be duplicated, confirmed and unconfirmed', function () {
    $user = User::factory()->create();
    $series = $user->transactionSeries()->create([
        'type' => 'income', 'amount' => 200, 'description' => 'Freela',
        'recurrence' => 'one_time', 'starts_on' => '2026-08-10',
    ]);
    app(RecurrenceService::class)->materialize($series);
    $occurrence = $series->occurrences()->firstOrFail();
    $service = app(TransactionService::class);

    $service->duplicate($occurrence);
    expect($user->transactionSeries()->count())->toBe(2);

    $service->toggleSettled($occurrence, Carbon::parse('2026-08-11'));
    expect($occurrence->refresh()->status)->toBe('settled')
        ->and($occurrence->settled_at->toDateString())->toBe('2026-08-11');

    $service->toggleSettled($occurrence);
    expect($occurrence->refresh()->status)->toBe('pending')
        ->and($occurrence->settled_at)->toBeNull();
});

test('canceling a series preserves its occurrences as canceled', function () {
    $user = User::factory()->create();
    $series = $user->transactionSeries()->create([
        'type' => 'expense', 'amount' => 90, 'description' => 'Plano',
        'recurrence' => 'monthly', 'starts_on' => '2026-08-05',
    ]);
    app(RecurrenceService::class)->materialize($series, Carbon::parse('2026-10-31'));
    $occurrence = $series->occurrences()->whereDate('due_date', '2026-09-05')->firstOrFail();

    app(TransactionService::class)->cancelFuture($occurrence);

    expect($series->refresh()->is_active)->toBeFalse()
        ->and($series->occurrences()->where('status', 'canceled')->count())->toBe(2)
        ->and($series->occurrences()->where('status', 'pending')->count())->toBe(1);
});

test('deleting a one-time occurrence also removes its empty series', function () {
    $user = User::factory()->create();
    $series = $user->transactionSeries()->create([
        'type' => 'expense', 'amount' => 50, 'description' => 'Compra',
        'recurrence' => 'one_time', 'starts_on' => '2026-08-10',
    ]);
    app(RecurrenceService::class)->materialize($series);
    $occurrence = $series->occurrences()->firstOrFail();

    app(TransactionService::class)->deleteOccurrence($occurrence);

    expect($user->transactions()->count())->toBe(0)
        ->and($user->transactionSeries()->count())->toBe(0);
});
