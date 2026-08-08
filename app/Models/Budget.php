<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property Carbon $month
 * @property User $user
 * @property Category|null $category
 */
class Budget extends Model
{
    protected $fillable = ['user_id', 'category_id', 'month', 'amount', 'alert_threshold', 'is_active', 'is_recurring'];

    protected function casts(): array
    {
        return ['month' => 'date', 'amount' => 'decimal:2', 'alert_threshold' => 'integer', 'is_active' => 'boolean', 'is_recurring' => 'boolean'];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
