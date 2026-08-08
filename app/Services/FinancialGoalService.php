<?php

namespace App\Services;

use App\Models\FinancialGoal;
use App\Models\User;
use Illuminate\Support\Collection;

class FinancialGoalService
{
    /** @return array<string, bool|float|int|string|null> */
    public function summarize(FinancialGoal $goal): array
    {
        $target = (float) $goal->target_amount;
        $current = (float) $goal->current_amount;
        $percentage = $target > 0 ? min(100.0, ($current / $target) * 100) : 0.0;
        $isCompleted = $goal->is_completed || ($target > 0 && $current >= $target);

        return [
            'target' => $target,
            'current' => $current,
            'remaining' => max(0, $target - $current),
            'percentage' => $percentage,
            'deadline' => $goal->deadline?->toDateString(),
            'is_completed' => $isCompleted,
        ];
    }

    /** @return array{goals: Collection<int, FinancialGoal>, summaries: Collection<int, array<string, bool|float|int|string|null>>} */
    public function summarizeForUser(User $user): array
    {
        $goals = $user->financialGoals()->where('is_completed', false)->orderBy('deadline')->orderBy('name')->get();
        $summaries = $goals->mapWithKeys(fn (FinancialGoal $goal): array => [$goal->id => $this->summarize($goal)]);

        return ['goals' => $goals, 'summaries' => $summaries];
    }

    public function addProgress(FinancialGoal $goal, float $amount): void
    {
        $current = min((float) $goal->target_amount, (float) $goal->current_amount + $amount);
        $goal->update(['current_amount' => $current, 'is_completed' => $current >= (float) $goal->target_amount]);
    }
}
