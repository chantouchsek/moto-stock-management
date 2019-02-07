<?php

namespace App\Notifications\Expense;

use Carbon\Carbon;

class Created extends ExpenseNotification
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
            'body' => "Expense amount: {$this->expense->amount} was created at {$this->expense->created_at} by {$notifiable->full_name}",
            'notify_type' => 'expense_created',
            'notify_id' => $this->expense->uuid,
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
            'title' => 'Expense Created'
        ];
    }
}
