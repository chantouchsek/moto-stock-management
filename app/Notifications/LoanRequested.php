<?php

namespace App\Notifications;

use App\Models\Loan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class LoanRequested extends Notification implements ShouldBroadcastNow
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
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url('/loans/' . $this->loan->id);

        return (new MailMessage)
            ->subject('Loan Requested')
            ->markdown('mail.loan.requested', [
                'url' => $url,
                'loan' => $this->loan
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'user' => $notifiable->id,
            'staff_id' => $this->loan->staff_id
        ];
    }
}
