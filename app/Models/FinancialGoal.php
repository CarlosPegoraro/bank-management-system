<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property Carbon|null $deadline
 */
class FinancialGoal extends Model
{
    protected $fillable = ['user_id', 'name', 'target_amount', 'current_amount', 'deadline', 'color', 'is_completed'];

    protected function casts(): array
    {
        return ['target_amount' => 'decimal:2', 'current_amount' => 'decimal:2', 'deadline' => 'date', 'is_completed' => 'boolean'];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
