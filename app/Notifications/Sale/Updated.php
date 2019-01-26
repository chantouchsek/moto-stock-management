<?php

namespace App\Notifications\Sale;

use Carbon\Carbon;

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
        $timestamp = Carbon::now()->addSecond()->toDateTimeString();
        return [
            'body' => "Sale number: #{$this->sale->sale_no} was updated at {$this->sale->updated_at} by {$notifiable->full_name}",
            'notify_type' => 'sale_updated',
            'notify_id' => $this->sale->uuid,
            'created_at' => $timestamp,
            'updated_at' => $timestamp
        ];
    }
}