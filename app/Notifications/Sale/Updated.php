<?php

namespace App\Notifications\Sale;

class Updated extends SaleNotification
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
            'body' => "Sale number: #{$this->sale->sale_no} was updated at {$this->sale->created_at} by {$notifiable->full_name}",
            'notify_type' => 'sale_updated',
            'notify_id' => $this->sale->uuid
        ];
    }
}
