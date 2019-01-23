<?php

namespace App\Notifications\Sale;

class Created extends SaleNotification
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
            'body' => "Sale number: #{$this->sale->sale_no} was created at {$this->sale->created_at} by {$notifiable->full_name}",
            'notify_type' => 'sale_created',
            'notify_id' => $this->sale->uuid
        ];
    }
}
