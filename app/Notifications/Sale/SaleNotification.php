<?php

namespace App\Notifications\Sale;

use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use NotificationChannels\OneSignal\OneSignalChannel;
use NotificationChannels\OneSignal\OneSignalMessage;
use NotificationChannels\OneSignal\OneSignalWebButton;

abstract class SaleNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $sale;

    /**
     * Create a new notification instance.
     *
     * @param Sale $sale
     */
    public function __construct(Sale $sale)
    {
        $this->sale = $sale;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast', OneSignalChannel::class];
    }

    /**
     * @param $notifiable
     * @return OneSignalMessage
     */
    public function toOneSignal($notifiable)
    {
        $timestamp = Carbon::now()->addSecond()->toDateTimeString();
        return OneSignalMessage::create()
            ->subject("Sale")
            ->body("Sale number: #{$this->sale->sale_no} was updated at {$this->sale->updated_at} by {$notifiable->full_name}")
            ->setData('notify_type', 'sale_updated')
            ->setData('created_at', $timestamp)
            ->setData('updated_at', $timestamp)
            ->setData('notify_id', $this->sale->uuid);
    }
}
