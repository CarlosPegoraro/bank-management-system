<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'store', 'amount', 'installments', 'finally', 'description'];

    protected $casts = [
        'date' => 'date',
        'finally' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
