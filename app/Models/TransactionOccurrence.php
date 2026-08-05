<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionOccurrence extends Model
{
    protected $fillable = ['user_id', 'transaction_series_id', 'category_id', 'financial_account_id', 'credit_card_id', 'type', 'amount', 'description', 'merchant', 'notes', 'due_date', 'competence_month', 'status', 'settled_at', 'installment_number'];

    protected function casts(): array
    {
        return ['amount' => 'decimal:2', 'due_date' => 'date', 'competence_month' => 'date', 'settled_at' => 'date'];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function series()
    {
        return $this->belongsTo(TransactionSeries::class, 'transaction_series_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function account()
    {
        return $this->belongsTo(FinancialAccount::class, 'financial_account_id');
    }

    public function creditCard()
    {
        return $this->belongsTo(CreditCard::class);
    }
}
