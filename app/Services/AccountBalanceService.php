<?php

namespace App\Services;

use App\Models\FinancialAccount;
use App\Models\User;
use Illuminate\Support\Collection;

class AccountBalanceService
{
    /**
     * @return array<string, float>
     */
    public function summarize(FinancialAccount $account): array
    {
        $transactions = $account->transactions()->where('status', '!=', 'canceled');
        $settled = (clone $transactions)->where('status', 'settled');
        $pending = (clone $transactions)->where('status', 'pending');

        $settledIncome = (float) (clone $settled)->where('type', 'income')->sum('amount');
        $settledExpense = (float) (clone $settled)->where('type', 'expense')->sum('amount');
        $pendingIncome = (float) (clone $pending)->where('type', 'income')->sum('amount');
        $pendingExpense = (float) (clone $pending)->where('type', 'expense')->sum('amount');
        $transfersIn = $account->incomingTransfers()->where('status', '!=', 'canceled');
        $transfersOut = $account->outgoingTransfers()->where('status', '!=', 'canceled');
        $settledTransferIn = (float) (clone $transfersIn)->where('status', 'settled')->sum('amount');
        $settledTransferOut = (float) (clone $transfersOut)->where('status', 'settled')->sum('amount');
        $pendingTransferIn = (float) (clone $transfersIn)->where('status', 'pending')->sum('amount');
        $pendingTransferOut = (float) (clone $transfersOut)->where('status', 'pending')->sum('amount');
        $initialBalance = (float) $account->initial_balance;

        return [
            'initial_balance' => $initialBalance,
            'settled_income' => $settledIncome,
            'settled_expense' => $settledExpense,
            'pending_income' => $pendingIncome,
            'pending_expense' => $pendingExpense,
            'settled_transfer_in' => $settledTransferIn,
            'settled_transfer_out' => $settledTransferOut,
            'pending_transfer_in' => $pendingTransferIn,
            'pending_transfer_out' => $pendingTransferOut,
            'realized_balance' => $initialBalance + $settledIncome - $settledExpense + $settledTransferIn - $settledTransferOut,
            'projected_balance' => $initialBalance + $settledIncome - $settledExpense + $settledTransferIn - $settledTransferOut + $pendingIncome - $pendingExpense + $pendingTransferIn - $pendingTransferOut,
        ];
    }

    /**
     * @return array{accounts: Collection<int, array<string, float>>, consolidated: array<string, float>}
     */
    public function summarizeForUser(User $user): array
    {
        $accounts = $user->accounts()
            ->where('is_archived', false)
            ->orderBy('name')
            ->get();

        $summaries = $accounts->mapWithKeys(
            fn (FinancialAccount $account): array => [$account->id => $this->summarize($account)]
        );

        return [
            'accounts' => $summaries,
            'consolidated' => [
                'initial_balance' => (float) $summaries->sum('initial_balance'),
                'settled_income' => (float) $summaries->sum('settled_income'),
                'settled_expense' => (float) $summaries->sum('settled_expense'),
                'pending_income' => (float) $summaries->sum('pending_income'),
                'pending_expense' => (float) $summaries->sum('pending_expense'),
                'settled_transfer_in' => (float) $summaries->sum('settled_transfer_in'),
                'settled_transfer_out' => (float) $summaries->sum('settled_transfer_out'),
                'pending_transfer_in' => (float) $summaries->sum('pending_transfer_in'),
                'pending_transfer_out' => (float) $summaries->sum('pending_transfer_out'),
                'realized_balance' => (float) $summaries->sum('realized_balance'),
                'projected_balance' => (float) $summaries->sum('projected_balance'),
            ],
        ];
    }
}
