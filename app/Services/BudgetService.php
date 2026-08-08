<?php

namespace App\Services;

use App\Models\Budget;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class BudgetService
{
    public function materializeRecurringForMonth(User $user, ?Carbon $month = null): void
    {
        $month ??= now();
        $target = $month->copy()->startOfMonth();

        DB::transaction(function () use ($user, $target): void {
            $templates = $user->budgets()
                ->where('is_active', true)
                ->where('is_recurring', true)
                ->whereDate('month', '<', $target)
                ->orderByDesc('month')
                ->get();

            foreach ($templates as $template) {
                $query = $user->budgets()
                    ->where('is_active', true)
                    ->whereDate('month', $target);
                $template->category_id === null
                    ? $query->whereNull('category_id')
                    : $query->where('category_id', $template->category_id);

                if ($query->exists()) {
                    continue;
                }

                $user->budgets()->create([
                    'category_id' => $template->category_id,
                    'month' => $target,
                    'amount' => $template->amount,
                    'alert_threshold' => $template->alert_threshold,
                    'is_active' => true,
                    'is_recurring' => true,
                ]);
            }
        });
    }

    /** @return array<string, float|int|string> */
    public function summarize(Budget $budget): array
    {
        $start = $budget->month->copy()->startOfMonth();
        $end = $budget->month->copy()->endOfMonth();
        $query = $budget->user->transactions()
            ->where('type', 'expense')
            ->where('status', '!=', 'canceled')
            ->whereBetween('due_date', [$start, $end]);

        if ($budget->category_id) {
            $query->where('category_id', $budget->category_id);
        }

        $spent = (float) $query->sum('amount');
        $amount = (float) $budget->amount;
        $percentage = $amount > 0 ? ($spent / $amount) * 100 : 0;

        return [
            'amount' => $amount,
            'spent' => $spent,
            'remaining' => $amount - $spent,
            'percentage' => $percentage,
            'threshold' => (int) $budget->alert_threshold,
            'status' => $percentage >= 100 ? 'exceeded' : ($percentage >= $budget->alert_threshold ? 'warning' : 'ok'),
        ];
    }

    /** @return array{budgets: Collection<int, Budget>, summaries: Collection<int, array<string, float|int|string>>} */
    public function summarizeForUser(User $user, ?Carbon $month = null): array
    {
        $month ??= now();
        $budgets = $user->budgets()
            ->with('category')
            ->where('is_active', true)
            ->whereDate('month', $month->copy()->startOfMonth())
            ->orderBy('category_id')
            ->get();
        $summaries = $budgets->mapWithKeys(fn (Budget $budget): array => [$budget->id => $this->summarize($budget)]);

        return ['budgets' => $budgets, 'summaries' => $summaries];
    }
}
