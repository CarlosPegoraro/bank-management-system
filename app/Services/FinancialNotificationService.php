<?php

namespace App\Services;

use App\Models\User;

class FinancialNotificationService
{
    public function __construct(
        private readonly CreditCardBalanceService $cardBalances,
        private readonly BudgetService $budgets,
        private readonly FinancialGoalService $goals,
    ) {}

    /** @return array{count: int, items: array<int, array{title: string, text: string, url: string}>} */
    public function forUser(User $user): array
    {
        $items = [];
        $overdue = $user->transactions()->where('status', 'pending')->whereDate('due_date', '<', today())->count();
        $upcoming = $user->transactions()->where('status', 'pending')->whereBetween('due_date', [today(), today()->addDays(7)])->count();

        if ($overdue > 0) {
            $items[] = ['title' => 'Lançamentos atrasados', 'text' => "Você tem {$overdue} lançamento(s) pendente(s) vencido(s).", 'url' => route('transactions', ['status' => 'pending'])];
        }

        if ($upcoming > 0) {
            $items[] = ['title' => 'Vencimentos próximos', 'text' => "{$upcoming} lançamento(s) vencem nos próximos 7 dias.", 'url' => route('transactions', ['status' => 'pending'])];
        }

        foreach ($user->creditCards()->where('is_archived', false)->get() as $card) {
            $summary = $this->cardBalances->summarize($card);
            if ($summary['limit'] !== null && $summary['limit'] > 0 && $summary['available_limit'] <= ($summary['limit'] * 0.2)) {
                $items[] = ['title' => "Limite do {$card->name}", 'text' => 'O limite disponível está abaixo de 20%.', 'url' => route('accounts')];
            }
        }

        $budgetSummary = $this->budgets->summarizeForUser($user);
        foreach ($budgetSummary['budgets'] as $budget) {
            $summary = $budgetSummary['summaries'][$budget->id];
            if ($summary['status'] !== 'ok') {
                $label = $budget->category ? $budget->category->name : 'despesas gerais';
                $items[] = ['title' => "Orçamento de {$label}", 'text' => $summary['status'] === 'exceeded' ? 'O limite deste mês foi ultrapassado.' : 'Você alcançou o limite de alerta deste mês.', 'url' => route('budgets')];
            }
        }

        $goalSummary = $this->goals->summarizeForUser($user);
        foreach ($goalSummary['goals'] as $goal) {
            if ($goal->deadline && $goal->deadline->between(today(), today()->addDays(30))) {
                $items[] = ['title' => "Prazo da meta: {$goal->name}", 'text' => 'O prazo desta meta está próximo.', 'url' => route('budgets')];
            }
        }

        return ['count' => count($items), 'items' => $items];
    }
}
