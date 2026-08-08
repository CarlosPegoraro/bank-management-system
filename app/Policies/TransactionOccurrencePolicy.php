<?php

namespace App\Policies;

use App\Models\TransactionOccurrence;
use App\Models\User;

class TransactionOccurrencePolicy
{
    public function view(User $user, TransactionOccurrence $transaction): bool
    {
        return $transaction->user_id === $user->id;
    }

    public function update(User $user, TransactionOccurrence $transaction): bool
    {
        return $this->view($user, $transaction);
    }

    public function delete(User $user, TransactionOccurrence $transaction): bool
    {
        return $this->view($user, $transaction);
    }
}
