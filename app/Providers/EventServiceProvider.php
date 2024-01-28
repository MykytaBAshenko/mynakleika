<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

/**
 * Class EventServiceProvider
 * @package App\Providers
 */
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [

    ];

    /**
     * Class event subscribers.
     *
     * @var array
     */
    protected $subscribe = [
        /*
         * Frontend Subscribers
         */

        /*
         * Auth Subscribers
         */
        \App\Listeners\Frontend\Auth\UserEventListener::class,

        /*
         * Backend Subscribers
         */

        /*
         * Auth Subscribers
         */
        \App\Listeners\Backend\Auth\User\UserEventListener::class,
        \App\Listeners\Backend\Auth\Role\RoleEventListener::class,

        /*
         * Income Subscribers
         */
        \App\Listeners\IncomeEventListener::class,
        /**
         * Order Subscribers
         */
        \App\Listeners\OrderEventListener::class,
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
