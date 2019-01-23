<?php

namespace App\Notifications\Category;

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
        return [
            'body' => "Category: {$this->category->name} was created at {$this->category->created_at} by {$notifiable->full_name}",
            'notify_type' => 'category_created',
            'notify_id' => $this->category->uuid
        ];
    }
}
