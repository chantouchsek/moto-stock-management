<?php

namespace App\Notifications\Category;

use Carbon\Carbon;

class Created extends CategoryNotification
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
            'body' => "{$this->category->name} was created at {$this->category->created_at} by {$notifiable->full_name}",
            'notify_type' => 'category_created',
            'notify_id' => $this->category->uuid,
            'created_at' => $timestamp,
            'updated_at' => $timestamp
        ];
    }
}
