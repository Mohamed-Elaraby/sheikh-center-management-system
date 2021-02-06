<?php

namespace App\Observers;

use App\Models\Check;

class CheckObserver
{
    /**
     * Handle the check "created" event.
     *
     * @param  \App\Models\Check  $check
     * @return void
     */
    public function created(Check $check)
    {
        //
    }

    /**
     * Handle the check "updated" event.
     *
     * @param  \App\Models\Check  $check
     * @return void
     */
    public function updated(Check $check)
    {
        //
    }

    /**
     * Handle the check "deleted" event.
     *
     * @param  \App\Models\Check  $check
     * @return void
     */
    public function deleted(Check $check)
    {
        $check -> images() -> delete();
    }

    /**
     * Handle the check "restored" event.
     *
     * @param  \App\Models\Check  $check
     * @return void
     */
    public function restored(Check $check)
    {
        //
    }

    /**
     * Handle the check "force deleted" event.
     *
     * @param  \App\Models\Check  $check
     * @return void
     */
    public function forceDeleted(Check $check)
    {
        //
    }
}
