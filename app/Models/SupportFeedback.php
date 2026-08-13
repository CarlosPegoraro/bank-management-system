<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportFeedback extends Model
{
    protected $table = 'support_feedback';

    protected $fillable = ['article', 'type', 'message'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
