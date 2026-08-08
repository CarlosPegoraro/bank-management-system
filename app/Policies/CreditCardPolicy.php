<?php

namespace App\Policies;

use App\Models\CreditCard;
use App\Models\User;

class CreditCardPolicy
{
    public function view(User $user, CreditCard $card): bool
    {
        return $card->user_id === $user->id;
    }

    public function update(User $user, CreditCard $card): bool
    {
        return $this->view($user, $card);
    }
}
