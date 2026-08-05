<?php

namespace Tests\Feature;

use App\Livewire\TransactionsPage;
use App\Models\User;
use Livewire\Livewire;

test('a transaction can be saved without a credit card', function () {
    $user = User::factory()->create();
    $category = $user->categories()->create(['name' => 'Salary', 'type' => 'income']);
    $account = $user->accounts()->create(['name' => 'Checking account']);

    Livewire::actingAs($user)
        ->test(TransactionsPage::class)
        ->set('form.type', 'income')
        ->set('form.amount', '1000')
        ->set('form.description', 'Test income')
        ->set('form.category_id', (string) $category->id)
        ->set('form.financial_account_id', (string) $account->id)
        ->set('form.credit_card_id', '')
        ->set('form.due_date', '2026-08-04')
        ->set('form.recurrence', 'one_time')
        ->call('save')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('transaction_series', [
        'user_id' => $user->id,
        'credit_card_id' => null,
        'description' => 'Test income',
    ]);
});
