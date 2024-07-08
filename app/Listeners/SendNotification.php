<?php

namespace App\Listeners;

use App\Events\NewNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNotification
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
     * @param  \App\Events\NewNotification  $event
     * @return void
     */
    public function handle(NewNotification $event)
    {
        //
    }
}
