<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\SiteEndorsementEvent;
use App\Notifications\SiteEndorsementNotification;

class SiteEndorsementListener
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
     * @param  SiteEndorsementEvent  $event
     * @return void
     */
    public function handle(SiteEndorsementEvent $event)
    {
        \Auth::user()->notify(new SiteEndorsementNotification($event->endorsement));
    }
}
