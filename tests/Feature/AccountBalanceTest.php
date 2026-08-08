<?php

namespace Tests\Feature;

use App\Livewire\FinancialAccountsPage;
use App\Models\User;
use App\Services\AccountBalanceService;
use Livewire\Livewire;

test('an account exposes realized and projected balances', function () {
    $user = User::factory()->create();
    $account = $user->accounts()->create([
        'name' => 'Conta principal',
        'initial_balance' => 1000,
    ]);

    $account->transactions()->createMany([
        [
            'user_id' => $user->id, 'type' => 'income', 'amount' => 500,
            'description' => 'Salário', 'due_date' => '2026-08-01',
            'competence_month' => '2026-08-01', 'status' => 'settled',
            'settled_at' => '2026-08-01',
        ],
        [
            'user_id' => $user->id, 'type' => 'expense', 'amount' => 200,
            'description' => 'Aluguel', 'due_date' => '2026-08-05',
            'competence_month' => '2026-08-01', 'status' => 'settled',
            'settled_at' => '2026-08-05',
        ],
        [
            'user_id' => $user->id, 'type' => 'income', 'amount' => 100,
            'description' => 'Freela', 'due_date' => '2026-08-20',
            'competence_month' => '2026-08-01', 'status' => 'pending',
        ],
        [
            'user_id' => $user->id, 'type' => 'expense', 'amount' => 50,
            'description' => 'Mercado', 'due_date' => '2026-08-21',
            'competence_month' => '2026-08-01', 'status' => 'pending',
        ],
        [
            'user_id' => $user->id, 'type' => 'expense', 'amount' => 999,
            'description' => 'Cancelado', 'due_date' => '2026-08-22',
            'competence_month' => '2026-08-01', 'status' => 'canceled',
        ],
    ]);

    $summary = app(AccountBalanceService::class)->summarize($account);

    expect($summary['realized_balance'])->toBe(1300.0)
        ->and($summary['projected_balance'])->toBe(1350.0)
        ->and($summary['pending_income'])->toBe(100.0)
        ->and($summary['pending_expense'])->toBe(50.0);
});

test('the accounts page displays consolidated balances for active accounts', function () {
    $user = User::factory()->create();
    $account = $user->accounts()->create(['name' => 'Conta principal', 'initial_balance' => 1000]);
    $account->transactions()->create([
        'user_id' => $user->id, 'type' => 'income', 'amount' => 300,
        'description' => 'Entrada', 'due_date' => '2026-08-01',
        'competence_month' => '2026-08-01', 'status' => 'settled',
        'settled_at' => '2026-08-01',
    ]);

    Livewire::actingAs($user)
        ->test(FinancialAccountsPage::class)
        ->assertSee('R$ 1.300,00')
        ->assertSee('Saldo atual consolidado');
});
