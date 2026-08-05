<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\CategorySeeder;

test('it creates the default categories without duplicates', function () {
    $user = User::factory()->create();

    $this->seed(CategorySeeder::class);
    $this->seed(CategorySeeder::class);

    expect($user->categories()->count())->toBe(10);
    $this->assertDatabaseHas('categories', [
        'user_id' => $user->id,
        'name' => 'Alimentação',
        'type' => 'expense',
    ]);
});
