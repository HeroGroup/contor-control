<?php

namespace App\Listeners;

use App\Events\MeterDataUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMeterUpdatedData
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
     * @param  MeterDataUpdated  $event
     * @return void
     */
    public function handle(MeterDataUpdated $event)
    {
        //
    }
}
