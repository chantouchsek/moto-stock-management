<?php

namespace App\Notifications\Sale;

use Carbon\Carbon;

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
        $timestamp = Carbon::now()->addSecond()->toDateTimeString();
        return [
            'body' => "Sale number: #{$this->sale->sale_no} was deleted at {$this->sale->deleted_at} by {$notifiable->full_name}",
            'notify_type' => 'sale_deleted',
            'notify_id' => $this->sale->uuid,
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
            'title' => 'Sale Deleted'
        ];
    }
}
