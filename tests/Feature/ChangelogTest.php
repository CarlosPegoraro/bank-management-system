<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('authenticated users can view the changelog', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('changelog'))
        ->assertOk()
        ->assertSee('O que mudou no Cadim')
        ->assertSee('Painel administrativo e onboarding mais inteligente')
        ->assertSee('v1.2.0');
});

test('the changelog entry component renders its slot content', function () {
    $view = view('components.changelog-entry', [
        'title' => 'Teste',
        'date' => '2026-08-14',
        'version' => '9.9.9',
    ])->with('slot', '<p>Texto da atualização</p>');

    expect($view->render())->toContain('Teste')
        ->toContain('v9.9.9')
        ->toContain('Texto da atualização');
});
