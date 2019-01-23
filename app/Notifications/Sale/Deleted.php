<?php

namespace App\Notifications\Sale;

class Deleted extends SaleNotification
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
            'body' => "Sale number: #{$this->sale->sale_no} was deleted at {$this->sale->created_at} by {$notifiable->full_name}",
            'notify_type' => 'sale_deleted',
            'notify_id' => $this->sale->uuid
        ];
    }
}
