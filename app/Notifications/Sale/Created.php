<?php

namespace App\Notifications\Sale;

use Carbon\Carbon;

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
        $timestamp = Carbon::now()->addSecond()->toDateTimeString();
        return [
            'body' => "Sale number: #{$this->sale->sale_no} was created at {$this->sale->created_at} by {$notifiable->full_name}",
            'notify_type' => 'sale_created',
            'notify_id' => $this->sale->uuid,
            'created_at' => $timestamp,
            'updated_at' => $timestamp
        ];
    }
}
