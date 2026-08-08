<?php

namespace App\Livewire;

use App\Services\BudgetService;
use App\Services\FinancialGoalService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Component;

class BudgetsAndGoalsPage extends Component
{
    public array $budget = ['category_id' => '', 'month' => '', 'amount' => '', 'alert_threshold' => 80, 'is_recurring' => false];

    public string $activeTab = 'budgets';

    public bool $budgetModalOpen = false;

    public bool $goalModalOpen = false;

    public array $goal = ['name' => '', 'target_amount' => '', 'current_amount' => 0, 'deadline' => ''];

    public array $goalProgress = [];

    public string $successMessage = '';

    public function mount(BudgetService $budgets): void
    {
        $this->budget['month'] = now()->format('Y-m');
        $this->activeTab = in_array(request()->query('tab'), ['budgets', 'goals'], true) ? request()->query('tab') : 'budgets';
        $budgets->materializeRecurringForMonth(auth()->user());
    }

    public function saveBudget(): void
    {
        $data = $this->validate([
            'budget.category_id' => ['nullable', 'integer', Rule::exists('categories', 'id')->where(fn ($query) => $query->where('user_id', auth()->id())->where('type', 'expense'))],
            'budget.month' => 'required|date_format:Y-m',
            'budget.amount' => 'required|numeric|min:0.01',
            'budget.alert_threshold' => 'required|integer|min:1|max:100',
            'budget.is_recurring' => 'boolean',
        ])['budget'];
        $categoryId = filled($data['category_id']) ? (int) $data['category_id'] : null;

        if ($categoryId && ! auth()->user()->categories()->whereKey($categoryId)->where('type', 'expense')->exists()) {
            abort(403);
        }

        auth()->user()->budgets()->create([
            'category_id' => $categoryId,
            'month' => Carbon::createFromFormat('Y-m', $data['month'])->startOfMonth(),
            'amount' => $data['amount'],
            'alert_threshold' => $data['alert_threshold'],
            'is_recurring' => (bool) ($data['is_recurring'] ?? false),
        ]);
        $this->budget = ['category_id' => '', 'month' => now()->format('Y-m'), 'amount' => '', 'alert_threshold' => 80, 'is_recurring' => false];
        $this->budgetModalOpen = false;
        $this->successMessage = 'Orçamento criado com sucesso.';
    }

    public function archiveBudget(int $id): void
    {
        auth()->user()->budgets()->findOrFail($id)->update(['is_active' => false]);
        $this->successMessage = 'Orçamento arquivado.';
    }

    public function saveGoal(): void
    {
        $data = $this->validate([
            'goal.name' => 'required|string|max:100',
            'goal.target_amount' => 'required|numeric|min:0.01',
            'goal.current_amount' => 'nullable|numeric|min:0',
            'goal.deadline' => 'nullable|date',
        ])['goal'];
        $current = min((float) ($data['current_amount'] ?? 0), (float) $data['target_amount']);

        auth()->user()->financialGoals()->create([
            'name' => $data['name'],
            'target_amount' => $data['target_amount'],
            'current_amount' => $current,
            'deadline' => filled($data['deadline']) ? $data['deadline'] : null,
            'is_completed' => $current >= (float) $data['target_amount'],
        ]);
        $this->goal = ['name' => '', 'target_amount' => '', 'current_amount' => 0, 'deadline' => ''];
        $this->goalModalOpen = false;
        $this->successMessage = 'Meta criada com sucesso.';
    }

    public function addProgress(int $id): void
    {
        $amount = $this->goalProgress[$id] ?? null;
        Validator::make(['amount' => $amount], ['amount' => 'required|numeric|min:0.01'])->validate();
        $goal = auth()->user()->financialGoals()->findOrFail($id);
        app(FinancialGoalService::class)->addProgress($goal, (float) $amount);
        unset($this->goalProgress[$id]);
        $this->successMessage = 'Progresso atualizado.';
    }

    public function completeGoal(int $id): void
    {
        auth()->user()->financialGoals()->findOrFail($id)->update(['is_completed' => true]);
        $this->successMessage = 'Meta marcada como concluída.';
    }

    public function deleteGoal(int $id): void
    {
        auth()->user()->financialGoals()->findOrFail($id)->delete();
        $this->successMessage = 'Meta excluída.';
    }

    public function render(BudgetService $budgets, FinancialGoalService $goals)
    {
        $budgetSummary = $budgets->summarizeForUser(auth()->user(), now());
        $goalSummary = $goals->summarizeForUser(auth()->user());

        return view('livewire.budgets-and-goals-page', [
            'categories' => auth()->user()->categories()->where('type', 'expense')->where('is_archived', false)->orderBy('name')->get(),
            'budgets' => $budgetSummary['budgets'],
            'budgetSummaries' => $budgetSummary['summaries'],
            'goals' => $goalSummary['goals'],
            'goalSummaries' => $goalSummary['summaries'],
        ])->layout('layouts.app');
    }
}
