<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnboardingEvent extends Model
{
    protected $fillable = ['tour', 'event', 'step', 'route'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
