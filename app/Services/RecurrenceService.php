<?php

namespace App\Services;

use App\Models\TransactionOccurrence;
use App\Models\TransactionSeries;
use Carbon\Carbon;

class RecurrenceService
{
    public function materialize(TransactionSeries $series, ?Carbon $until = null): void
    {
        $until ??= now()->addMonths(6)->endOfMonth();
        $date = $series->starts_on->copy();
        $limit = $series->ends_on?->copy() ?? $until;
        if ($series->recurrence === 'one_time') {
            $limit = $date;
        }if ($limit->gt($until) && $series->recurrence === 'monthly') {
            $limit = $until;
        }
        for ($number = 1; $date->lte($limit); $date->addMonthNoOverflow(),$number++) {
            $occurrenceDate = $date->copy()->startOfDay();
            TransactionOccurrence::firstOrCreate(['transaction_series_id' => $series->id, 'due_date' => $occurrenceDate], ['user_id' => $series->user_id, 'category_id' => $series->category_id, 'financial_account_id' => $series->financial_account_id, 'credit_card_id' => $series->credit_card_id, 'type' => $series->type, 'amount' => $series->amount, 'description' => $series->description, 'merchant' => $series->merchant, 'notes' => $series->notes, 'competence_month' => $occurrenceDate->copy()->startOfMonth(), 'status' => 'pending', 'installment_number' => $series->recurrence === 'installment' ? $number : null]);
            if ($series->recurrence === 'one_time') {
                break;
            }
        }
    }
}
