<?php

namespace App\Policies;

use App\Models\FinancialAccount;
use App\Models\User;

class FinancialAccountPolicy
{
    public function view(User $user, FinancialAccount $account): bool
    {
        return $account->user_id === $user->id;
    }

    public function update(User $user, FinancialAccount $account): bool
    {
        return $this->view($user, $account);
    }
}
