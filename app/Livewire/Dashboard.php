<?php

namespace App\Livewire;

use App\Services\RecurrenceService;
use Livewire\Component;

class Dashboard extends Component
{
    public function render(RecurrenceService $recurrence)
    {
        foreach (auth()->user()->transactionSeries()->where('is_active', true)->get() as $series) {
            $recurrence->materialize($series);
        } $start = now()->startOfMonth();
        $end = now()->endOfMonth();
        $month = auth()->user()->transactions()->whereBetween('due_date', [$start, $end]);
        $income = (clone $month)->where('type', 'income')->sum('amount');
        $expense = (clone $month)->where('type', 'expense')->sum('amount');
        $settledIncome = (clone $month)->where('type', 'income')->where('status', 'settled')->sum('amount');
        $settledExpense = (clone $month)->where('type', 'expense')->where('status', 'settled')->sum('amount');
        $months = collect(range(-5, 6))->map(function ($offset) {
            $m = now()->startOfMonth()->addMonths($offset);
            $items = auth()->user()->transactions()->whereBetween('due_date', [$m->copy()->startOfMonth(), $m->copy()->endOfMonth()]);

            return ['label' => $m->translatedFormat('M/y'), 'income' => (float) (clone $items)->where('type', 'income')->sum('amount'), 'expense' => (float) (clone $items)->where('type', 'expense')->sum('amount')];
        });
        $upcoming = auth()->user()->transactions()->with(['category', 'creditCard'])->where('status', 'pending')->whereDate('due_date', '>=', today())->orderBy('due_date')->limit(4)->get();
        $recentTransactions = auth()->user()->transactions()->with(['category', 'account'])->orderByDesc('due_date')->limit(5)->get();
        $primaryCard = auth()->user()->creditCards()->where('is_archived', false)->orderByDesc('limit')->first();
        $totalCardLimit = (float) auth()->user()->creditCards()->where('is_archived', false)->sum('limit');

        return view('livewire.dashboard', compact('income', 'expense', 'settledIncome', 'settledExpense', 'months', 'upcoming', 'recentTransactions', 'primaryCard', 'totalCardLimit'))->layout('layouts.app');
    }
}
