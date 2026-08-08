<?php

namespace Tests\Feature;

use App\Livewire\BudgetsAndGoalsPage;
use App\Models\User;
use App\Services\BudgetService;
use Livewire\Livewire;

test('a budget tracks expenses and reaches its warning threshold', function () {
    $user = User::factory()->create();
    $category = $user->categories()->create(['name' => 'Alimentação', 'type' => 'expense']);
    $budget = $user->budgets()->create([
        'category_id' => $category->id, 'month' => now()->startOfMonth(), 'amount' => 500, 'alert_threshold' => 80,
    ]);
    $user->transactions()->create([
        'category_id' => $category->id, 'type' => 'expense', 'amount' => 450,
        'description' => 'Mercado', 'due_date' => now()->startOfMonth()->addDays(2),
        'purchase_date' => now()->startOfMonth()->addDays(2), 'competence_month' => now()->startOfMonth(), 'status' => 'pending',
    ]);

    $summary = app(BudgetService::class)->summarize($budget);

    expect($summary['spent'])->toBe(450.0)
        ->and($summary['remaining'])->toBe(50.0)
        ->and($summary['status'])->toBe('warning');
});

test('users can create a goal and add progress through the page', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(BudgetsAndGoalsPage::class)
        ->set('goal.name', 'Reserva de emergência')
        ->set('goal.target_amount', '1000')
        ->set('goal.current_amount', '100')
        ->call('saveGoal')
        ->assertHasNoErrors();

    $goal = $user->financialGoals()->firstOrFail();
    expect($goal->current_amount)->toBe('100.00');

    Livewire::actingAs($user)
        ->test(BudgetsAndGoalsPage::class)
        ->set("goalProgress.{$goal->id}", '250')
        ->call('addProgress', $goal->id)
        ->assertHasNoErrors();

    expect($goal->refresh()->current_amount)->toBe('350.00');
});

test('users can create a monthly budget only for their expense categories', function () {
    $user = User::factory()->create();
    $category = $user->categories()->create(['name' => 'Transporte', 'type' => 'expense']);

    Livewire::actingAs($user)
        ->test(BudgetsAndGoalsPage::class)
        ->set('budget.category_id', (string) $category->id)
        ->set('budget.month', now()->format('Y-m'))
        ->set('budget.amount', '800')
        ->set('budget.alert_threshold', 75)
        ->call('saveBudget')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('budgets', ['user_id' => $user->id, 'category_id' => $category->id, 'amount' => 800, 'alert_threshold' => 75]);
});

test('recurring budgets are copied to the next month only once', function () {
    $user = User::factory()->create();
    $category = $user->categories()->create(['name' => 'Transporte', 'type' => 'expense']);
    $service = app(BudgetService::class);
    $lastMonth = now()->subMonth()->startOfMonth();

    $user->budgets()->create([
        'category_id' => $category->id,
        'month' => $lastMonth,
        'amount' => 800,
        'alert_threshold' => 75,
        'is_recurring' => true,
    ]);

    $service->materializeRecurringForMonth($user, now());
    $service->materializeRecurringForMonth($user, now());

    expect($user->budgets()->count())->toBe(2);
    expect($user->budgets()->whereDate('month', now()->startOfMonth())->where('is_recurring', true)->exists())->toBeTrue();
});
