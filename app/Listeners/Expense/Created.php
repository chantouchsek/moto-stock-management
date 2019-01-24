<?php

namespace App\Listeners\Expense;

use App\Events\Expense\Created as ExpenseEvent;
use App\Models\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Expense\Created as ExpenseNotificationCreated;

class Created implements ShouldQueue
{

    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param ExpenseEvent $event
     * @return void
     */
    public function handle(ExpenseEvent $event)
    {
        $users = User::role(['Supper Admin'])->get();
        Notification::send($users, new ExpenseNotificationCreated($event->model));
    }

    /**
     * Handle a job failure.
     *
     * @param ExpenseEvent $event
     * @param  \Exception $exception
     * @return void
     */
    public function failed(ExpenseEvent $event, $exception)
    {
        \Log::info($event);
    }
}
