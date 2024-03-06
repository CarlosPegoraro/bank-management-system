<?php

namespace App\Observers;

use App\Models\Debt;

class DebtObserver
{
    /**
     * Handle the Debt "created" event.
     */
    public function created(Debt $debt): void
    {
        session()->flash('toast', [['type' => 'success', 'message' => __('Debt Created successfully')]]);
    }


    /**
     * Handle the Debt "updated" event.
     */
    public function updated(Debt $debt): void
    {

        session()->flash('toast', [['type' => 'success', 'message' => __('Debt Updated successfully')]]);
    }

    /**
     * Handle the Debt "deleted" event.
     */
    public function deleted(Debt $debt): void
    {
        session()->flash('toast', [['type' => 'success', 'message' => __('Debt Deleted successfully')]]);
    }

    /**
     * Handle the Debt "restored" event.
     */
    public function restored(Debt $debt): void
    {
        //
    }

    /**
     * Handle the Debt "force deleted" event.
     */
    public function forceDeleted(Debt $debt): void
    {
        //
    }
}
