<?php

namespace App\Listeners;

use App\Events\ActivityCompleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendActivityCompleted
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ActivityCompleted  $event
     * @return void
     */
    public function handle(ActivityCompleted $event)
    {
        //
    }
}
