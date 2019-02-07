<?php

namespace App\Notifications\Expense;

use Carbon\Carbon;

class Updated extends ExpenseNotification
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
            'body' => "Expense amount: {$this->expense->amount} was updated at {$this->expense->updated_at} by {$notifiable->full_name}",
            'notify_type' => 'expense_updated',
            'notify_id' => $this->expense->uuid,
            'created_at' => $timestamp,
            'title' => 'Expense Updated'
        ];
    }
}
