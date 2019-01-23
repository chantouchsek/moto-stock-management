<?php

namespace App\Listeners\Sale;

use App\Events\Sale\Updated as SaleEvent;
use App\Models\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Sale\Updated as SaleNotificationUpdated;

class Updated implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param SaleEvent $event
     * @return void
     */
    public function handle(SaleEvent $event)
    {
        $users = User::role(['Supper Admin'])->get();
        Notification::send($users, new SaleNotificationUpdated($event->model));
    }

    /**
     * Handle a job failure.
     *
     * @param SaleEvent $event
     * @param  \Exception $exception
     * @return void
     */
    public function failed(SaleEvent $event, $exception)
    {
        \Log::info($event);
    }
}
