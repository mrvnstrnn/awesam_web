<?php

namespace App\Listeners;

use App\Events\SiteEndorsement;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendSiteEndorsementNotification
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
     * @param  SiteEndorsement  $event
     * @return void
     */
    public function handle(SiteEndorsement $event)
    {
        //
    }
}
