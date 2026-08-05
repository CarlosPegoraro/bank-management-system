<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;

test('the database seeder provides an analysis-ready financial history', function () {
    $this->seed(DatabaseSeeder::class);
    $this->seed(DatabaseSeeder::class);

    $user = User::query()->where('email', 'admin@example.com')->firstOrFail();

    expect($user->accounts()->count())->toBe(2)
        ->and($user->creditCards()->count())->toBe(1)
        ->and($user->transactionSeries()->count())->toBeGreaterThan(15)
        ->and($user->transactions()->where('status', 'settled')->count())->toBeGreaterThan(10)
        ->and($user->transactions()->where('status', 'pending')->count())->toBeGreaterThan(10);

    $this->assertDatabaseHas('transaction_occurrences', [
        'user_id' => $user->id,
        'description' => 'Salário mensal',
        'type' => 'income',
    ]);
});
