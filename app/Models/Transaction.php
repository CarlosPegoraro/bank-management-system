<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'store', 'amount', 'installments', 'finnaly'];

    protected $casts = [
        'date' => 'date',
        'finnaly' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
