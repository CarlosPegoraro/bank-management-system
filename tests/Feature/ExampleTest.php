<?php

namespace Tests\Feature;

use App\Livewire\Auth\Register;
use App\Livewire\FinancialAccountsPage;
use App\Models\User;
use Livewire\Livewire;

test('guests are redirected to login', function () {
    $this->get('/')->assertRedirect(route('login'));
});

test('application URLs use English slugs', function () {
    expect(route('login', absolute: false))->toBe('/login')
        ->and(route('register', absolute: false))->toBe('/register')
        ->and(route('logout', absolute: false))->toBe('/logout')
        ->and(route('transactions', absolute: false))->toBe('/transactions')
        ->and(route('accounts', absolute: false))->toBe('/accounts-and-cards')
        ->and(route('categories', absolute: false))->toBe('/categories');
});

test('an authenticated user can open dashboard', function () {
    $this->actingAs(User::factory()->create())->get('/dashboard')->assertOk();
});

test('registration creates default categories for the user', function () {
    Livewire::test(Register::class)
        ->set('name', 'New User')
        ->set('email', 'new@example.com')
        ->set('password', 'password')
        ->set('password_confirmation', 'password')
        ->call('register')
        ->assertHasNoErrors();

    $user = User::where('email', 'new@example.com')->firstOrFail();

    $this->assertDatabaseCount('categories', 10);
    expect($user->categories()->count())->toBe(10);
});

test('an authenticated user can save a credit card', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(FinancialAccountsPage::class)
        ->set('card.name', 'Cartão principal')
        ->set('card.brand', 'Visa')
        ->set('card.closing_day', 10)
        ->set('card.due_day', '05')
        ->set('card.limit', 2500)
        ->call('saveCard')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('credit_cards', [
        'user_id' => $user->id,
        'name' => 'Cartão principal',
        'closing_day' => 10,
        'due_day' => 5,
    ]);
});
