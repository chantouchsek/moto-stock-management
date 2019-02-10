<?php

namespace App\Notifications\Expense;

use Carbon\Carbon;
use NotificationChannels\OneSignal\OneSignalMessage;

class Deleted extends ExpenseNotification
{
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $timestamp = Carbon::now()->addSecond()->toDateTimeString();
        return [
            'body' => "Expense amount: {$this->expense->amount} was deleted at {$this->expense->deleted_at} by {$notifiable->full_name}",
            'notify_type' => 'expense',
            'notify_id' => $this->expense->uuid,
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
            'title' => 'Expense Deleted'
        ];
    }

    /**
     * @param $notifiable
     * @return OneSignalMessage
     */
    public function toOneSignal($notifiable)
    {
        $timestamp = Carbon::now()->addSecond()->toDateTimeString();
        return OneSignalMessage::create()
            ->subject("Expense Deleted")
            ->body("Expense amount: {$this->expense->amount} was deleted at {$this->expense->created_at} by {$notifiable->full_name}")
            ->setData('notify_type', 'expense')
            ->setData('created_at', $timestamp)
            ->setData('updated_at', $timestamp)
            ->setData('notify_id', $this->expense->uuid);
    }
}
