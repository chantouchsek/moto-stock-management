<?php

namespace App\Notifications;

use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;
use NotificationChannels\OneSignal\OneSignalChannel;
use NotificationChannels\OneSignal\OneSignalMessage;

class LoanRequested extends Notification implements ShouldQueue
{
    use Queueable;

    private $loan;

    /**
     * Create a new notification instance.
     *
     * @param Loan $loan
     */
    public function __construct(Loan $loan)
    {
        $this->loan = $loan;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database', 'broadcast', OneSignalChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(Lang::getFromJson('Salary Loan Requested'))
            ->greeting($this->loan->staff->full_name . " was request to loan salary amount: $" . $this->loan->amount)
            ->line(Lang::getFromJson('You are receiving this email because you needed provide feedback to your staff back.'))
            ->line(Lang::getFromJson('So, Plz response back ASAP, Do not let them waiting for you. They may need it in hurry.'));
    }

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
            'body' => $this->loan->staff->full_name . " was request to loan salary amount: $" . $this->loan->amount . "<br/>Reason: {$this->loan->reason}",
            'notify_type' => 'loan_request',
            'notify_id' => $this->loan->uuid,
            'title' => 'Loan Request',
            'created_at' => $timestamp,
            'updated_at' => $timestamp
        ];
    }

    /**
     * @param $notifiable
     * @return OneSignalMessage
     */
    public function toOneSignal($notifiable)
    {
        $timestamp = Carbon::now()->addSecond()->toDateTimeString();
        return OneSignalMessage::create()
            ->subject("Loan Requested")
            ->body($this->loan->staff->full_name . " was request to loan salary amount: $" . $this->loan->amount . "<br/>Reason: {$this->loan->reason}")
            ->setData('notify_type', 'loan')
            ->setData('created_at', $timestamp)
            ->setData('updated_at', $timestamp)
            ->setData('notify_id', $this->loan->uuid);
    }
}
