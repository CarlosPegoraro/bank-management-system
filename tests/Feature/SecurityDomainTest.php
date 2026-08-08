<?php

use App\Models\User;
use App\Services\TransactionService;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

test('a transaction rejects a category from another user', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $category = $otherUser->categories()->create(['name' => 'Privada', 'type' => 'expense']);

    expect(fn () => app(TransactionService::class)->create($user, [
        'type' => 'expense',
        'amount' => 25,
        'description' => 'Tentativa',
        'category_id' => $category->id,
        'recurrence' => 'one_time',
        'due_date' => '2026-08-10',
        'purchase_date' => '2026-08-10',
    ]))->toThrow(HttpException::class);
});

test('a category must match the transaction type', function () {
    $user = User::factory()->create();
    $category = $user->categories()->create(['name' => 'Salário', 'type' => 'income']);

    expect(fn () => app(TransactionService::class)->create($user, [
        'type' => 'expense',
        'amount' => 25,
        'description' => 'Categoria inválida',
        'category_id' => $category->id,
        'recurrence' => 'one_time',
        'due_date' => '2026-08-10',
        'purchase_date' => '2026-08-10',
    ]))->toThrow(ValidationException::class);
});

test('credit cards cannot be linked to income', function () {
    $user = User::factory()->create();
    $card = $user->creditCards()->create([
        'name' => 'Cartão',
        'closing_day' => 25,
        'due_day' => 5,
        'limit' => 1000,
    ]);

    expect(fn () => app(TransactionService::class)->create($user, [
        'type' => 'income',
        'amount' => 25,
        'description' => 'Entrada inválida',
        'credit_card_id' => $card->id,
        'recurrence' => 'one_time',
        'due_date' => '2026-08-10',
        'purchase_date' => '2026-08-10',
    ]))->toThrow(ValidationException::class);
});
