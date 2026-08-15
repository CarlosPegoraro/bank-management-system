<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnboardingProgress extends Model
{
    protected $fillable = ['step', 'completed_at'];

    protected function casts(): array
    {
        return ['completed_at' => 'datetime'];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
