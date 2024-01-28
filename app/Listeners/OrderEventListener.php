<?php

namespace App\Listeners;

use App\Mail\OrderPrinted;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Mail;

/**
 * Class OrderEventListener
 * @package App\Listeners
 */
class OrderEventListener
{
    public function onOrderPrinted($event)
    {
        Mail::send(new OrderPrinted($event->order));
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            \App\Events\Order\OrderPrinted::class,
            'App\Listeners\OrderEventListener@onOrderPrinted'
        );
    }
}
