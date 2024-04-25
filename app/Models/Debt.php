<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Debt extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'store', 'amount', 'installments', 'finnaly', 'description', 'card_id'];

    protected $casts = [
        'date' => 'date',
        'finnaly' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function card(): BelongsTo
    {
        return $this->belongsTo(Card::class);
    }
}
