<?php

namespace App\Listeners\Category;

use App\Models\User;
use  App\Notifications\Category\Created as CategoryNotificationCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use App\Events\Category\Created as CategoryEvent;

class Created implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param CategoryEvent $event
     * @return void
     */
    public function handle(CategoryEvent $event)
    {
        $users = User::role(['Supper Admin'])->get();
        Notification::send($users, new CategoryNotificationCreated($event->model));
    }

    /**
     * Handle a job failure.
     *
     * @param CategoryEvent $event
     * @param  \Exception $exception
     * @return void
     */
    public function failed(CategoryEvent $event, $exception)
    {
        \Log::info($event);
    }
}
