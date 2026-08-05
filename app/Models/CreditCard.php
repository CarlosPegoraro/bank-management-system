<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditCard extends Model
{
    protected $fillable = ['name', 'brand', 'closing_day', 'due_day', 'limit', 'color', 'is_archived'];

    protected function casts(): array
    {
        return ['limit' => 'decimal:2', 'is_archived' => 'boolean'];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
