<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        'App\Events\Category\Created' => [
            'App\Listeners\Category\Created'
        ],
        'App\Events\Category\Updated' => [],
        'App\Events\Category\Deleted' => [],
        'App\Events\Sale\Created' => [
            'App\Listeners\Sale\Created'
        ],
        'App\Events\Sale\Updated' => [
            'App\Listeners\Sale\Updated'
        ],
        'App\Events\Sale\Deleted' => [
            'App\Listeners\Sale\Deleted'
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        Event::listen('revisionable.*', function ($model, $revisions) {
            //
        });
    }
}
