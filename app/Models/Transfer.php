<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/** @property Carbon $transfer_date */
class Transfer extends Model
{
    protected $fillable = ['user_id', 'from_account_id', 'to_account_id', 'amount', 'transfer_date', 'description', 'status', 'settled_at'];

    protected function casts(): array
    {
        return ['amount' => 'decimal:2', 'transfer_date' => 'date', 'settled_at' => 'date'];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fromAccount()
    {
        return $this->belongsTo(FinancialAccount::class, 'from_account_id');
    }

    public function toAccount()
    {
        return $this->belongsTo(FinancialAccount::class, 'to_account_id');
    }
}
