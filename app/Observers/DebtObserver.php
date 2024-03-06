<?php

namespace App\Observers;

use App\Models\Debt;
use App\Notifications\DebtNotification;
use Illuminate\Support\Facades\Auth;

class DebtObserver
{
    /**
     * Handle the Debt "created" event.
     */
    public function created(Debt $debt): void
    {
        $user = Auth::user();

        $user->notify(new DebtNotification('created'));
    }

    /**
     * Handle the Debt "updated" event.
     */
    public function updated(Debt $debt): void
    {
        $user = Auth::user();

        $user->notify(new DebtNotification('updated'));
    }

    /**
     * Handle the Debt "deleted" event.
     */
    public function deleted(Debt $debt): void
    {
        $user = Auth::user();

        $user->notify(new DebtNotification('deleted'));
    }

    /**
     * Handle the Debt "restored" event.
     */
    public function restored(Debt $debt): void
    {
        $user = Auth::user();

        $user->notify(new DebtNotification('restored'));
    }

    /**
     * Handle the Debt "force deleted" event.
     */
    public function forceDeleted(Debt $debt): void
    {
        $user = Auth::user();

        $user->notify(new DebtNotification('forceDeleted'));
    }
}
