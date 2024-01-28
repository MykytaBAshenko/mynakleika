<?php

namespace App\Listeners;

use App\Jobs\SendNotification;
use App\Mail\InvoicePayed;
use Illuminate\Support\Facades\Mail;

/**
 * Class IncomeEventListener
 * @package App\Listeners
 */
class IncomeEventListener
{
    /**
     * @param $event
     */
    public function onCreated($event)
    {
        /* @todo make notification about partly paid order */
        SendNotification::dispatch($event->income);
//        Mail::send(new InvoicePayed($event->income->invoice));
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            \App\Events\Income\IncomeCreated::class,
            'App\Listeners\IncomeEventListener@onCreated'
        );
    }
}
