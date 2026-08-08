<?php

namespace Tests\Feature;

use App\Livewire\Dashboard;
use App\Models\User;
use App\Services\FinancialNotificationService;
use Carbon\Carbon;
use Livewire\Livewire;

test('the dashboard updates its metrics for the selected year and custom period', function () {
    $user = User::factory()->create();
    $user->transactions()->createMany([
        [
            'user_id' => $user->id, 'type' => 'income', 'amount' => 1000,
            'description' => 'Salário', 'due_date' => '2026-01-10',
            'purchase_date' => '2026-01-10', 'competence_month' => '2026-01-01', 'status' => 'settled',
        ],
        [
            'user_id' => $user->id, 'type' => 'expense', 'amount' => 250,
            'description' => 'Aluguel', 'due_date' => '2026-02-10',
            'purchase_date' => '2026-02-10', 'competence_month' => '2026-02-01', 'status' => 'pending',
        ],
    ]);

    Livewire::actingAs($user)
        ->test(Dashboard::class)
        ->set('period', 'year')
        ->set('referenceMonth', '2026-01')
        ->assertSee('R$ 1.000,00')
        ->assertSee('2026')
        ->set('period', 'custom')
        ->set('dateFrom', '2026-02-01')
        ->set('dateTo', '2026-02-28')
        ->assertSee('R$ 250,00');
});

test('the dashboard chart only shows transactions from the selected month', function () {
    $user = User::factory()->create();
    $user->transactions()->createMany([
        [
            'user_id' => $user->id, 'type' => 'income', 'amount' => 1000,
            'description' => 'Salário de janeiro', 'due_date' => '2026-01-10',
            'purchase_date' => '2026-01-10', 'competence_month' => '2026-01-01', 'status' => 'settled',
        ],
        [
            'user_id' => $user->id, 'type' => 'expense', 'amount' => 250,
            'description' => 'Aluguel de fevereiro', 'due_date' => '2026-02-10',
            'purchase_date' => '2026-02-10', 'competence_month' => '2026-02-01', 'status' => 'pending',
        ],
    ]);

    Livewire::actingAs($user)
        ->test(Dashboard::class)
        ->set('period', 'month')
        ->set('referenceMonth', '2026-01')
        ->assertSee('R$ 1.000,00')
        ->assertDontSee('R$ 250,00');
});

test('the monthly financial view distributes the chart across every day of the month', function () {
    $user = User::factory()->create();
    $user->transactions()->create([
        'user_id' => $user->id, 'type' => 'expense', 'amount' => 180,
        'description' => 'Compra do dia 15', 'due_date' => '2026-01-15',
        'purchase_date' => '2026-01-15', 'competence_month' => '2026-01-01', 'status' => 'pending',
    ]);

    Livewire::actingAs($user)
        ->test(Dashboard::class)
        ->set('period', 'month')
        ->set('referenceMonth', '2026-01')
        ->assertSee('01/01')
        ->assertSee('15/01')
        ->assertSee('31/01');
});

test('financial notifications report overdue, upcoming and card limit alerts', function () {
    Carbon::setTestNow(Carbon::parse('2026-08-07 10:00:00'));

    try {
        $user = User::factory()->create();
        $user->transactions()->createMany([
            [
                'user_id' => $user->id, 'type' => 'expense', 'amount' => 100,
                'description' => 'Atrasada', 'due_date' => '2026-08-01',
                'purchase_date' => '2026-08-01', 'competence_month' => '2026-08-01', 'status' => 'pending',
            ],
            [
                'user_id' => $user->id, 'type' => 'expense', 'amount' => 100,
                'description' => 'Próxima', 'due_date' => '2026-08-10',
                'purchase_date' => '2026-08-10', 'competence_month' => '2026-08-01', 'status' => 'pending',
            ],
        ]);
        $card = $user->creditCards()->create(['name' => 'Cartão', 'closing_day' => 25, 'due_day' => 5, 'limit' => 1000]);
        $card->transactions()->create([
            'user_id' => $user->id, 'type' => 'expense', 'amount' => 850,
            'description' => 'Compra grande', 'due_date' => '2026-08-05',
            'purchase_date' => '2026-08-01', 'competence_month' => '2026-08-01', 'status' => 'pending',
        ]);

        $notifications = app(FinancialNotificationService::class)->forUser($user);

        expect($notifications['count'])->toBe(3);
    } finally {
        Carbon::setTestNow();
    }
});
