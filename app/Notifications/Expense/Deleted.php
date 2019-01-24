<?php

namespace App\Notifications\Expense;

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
        return [
            'body' => "Expense amount: {$this->expense->amount} was deleted at {$this->expense->deleted_at} by {$notifiable->full_name}",
            'notify_type' => 'expense_deleted',
            'notify_id' => $this->expense->uuid
        ];
    }
}
