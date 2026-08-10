<?php

namespace Tests\Feature;

use App\Models\User;

test('the application uses the new brand name', function () {
    $this->actingAs(User::factory()->create())
        ->get('/dashboard')
        ->assertOk()
        ->assertSee('Cadim')
        ->assertSee('logo.svg');
});
