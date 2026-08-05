<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'avatar_icon'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return ['email_verified_at' => 'datetime', 'password' => 'hashed'];
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function accounts()
    {
        return $this->hasMany(FinancialAccount::class);
    }

    public function creditCards()
    {
        return $this->hasMany(CreditCard::class);
    }

    public function transactionSeries()
    {
        return $this->hasMany(TransactionSeries::class);
    }

    public function transactions()
    {
        return $this->hasMany(TransactionOccurrence::class);
    }
}
