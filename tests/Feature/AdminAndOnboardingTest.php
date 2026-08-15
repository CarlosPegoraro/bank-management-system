<?php

use App\Models\User;
use App\Services\AuditService;
use App\Services\OnboardingProgressService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('only administrators can access the admin dashboard', function () {
    $user = User::factory()->create();
    $admin = User::factory()->admin()->create();

    $this->actingAs($user)->get(route('admin.dashboard'))->assertForbidden();
    $this->actingAs($admin)->get(route('admin.dashboard'))->assertOk();
});

test('login records the last access and an audit event', function () {
    $user = User::factory()->create(['password' => 'password']);

    auth()->login($user);
    $user->forceFill(['last_login_at' => now()])->save();
    app(AuditService::class)->record($user, 'auth.login');

    expect($user->fresh()->last_login_at)->not->toBeNull();
    $this->assertDatabaseHas('audit_logs', ['actor_id' => $user->id, 'action' => 'auth.login']);
});

test('onboarding progress reflects financial activation milestones', function () {
    $user = User::factory()->create();
    $service = app(OnboardingProgressService::class);

    expect($service->summary($user))->toMatchArray([
        ['step' => 'profile', 'label' => 'Completar o perfil', 'completed' => true],
        ['step' => 'account', 'label' => 'Cadastrar uma conta', 'completed' => false],
    ]);

    $user->accounts()->create([
        'name' => 'Conta principal',
        'type' => 'checking',
        'initial_balance' => 0,
    ]);
    $user->onboarding_completed_at = now();
    $user->save();
    $user->onboardingEvents()->create(['tour' => 'first-access', 'event' => 'completed', 'step' => 4]);

    $summary = collect($service->summary($user->fresh()));
    expect($summary->where('step', 'account')->first()['completed'])->toBeTrue();
    expect($summary->where('step', 'dashboard')->first()['completed'])->toBeTrue();
    $this->assertDatabaseHas('onboarding_progress', ['user_id' => $user->id, 'step' => 'account']);
});

test('admin metrics do not expose financial records', function () {
    $admin = User::factory()->admin()->create();
    $user = User::factory()->create(['last_login_at' => now()]);
    $user->accounts()->create(['name' => 'Conta', 'type' => 'checking', 'initial_balance' => 500]);

    $response = $this->actingAs($admin)->get(route('admin.dashboard'));

    $response->assertOk()->assertSee($user->email)->assertDontSee('500,00');
});
