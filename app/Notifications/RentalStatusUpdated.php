<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RentalStatusUpdated extends Notification
{
    use Queueable;

    public $rental;
    public $status;

    /**
     * Create a new notification instance.
     */
    public function __construct($rental, $status)
    {
        $this->rental = $rental;
        $this->status = $status;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'rental_id' => $this->rental->id,
            'car_name' => $this->rental->car->name,
            'status' => $this->status,
            'subject' => 'Rental ' . ucfirst($this->status),
            'message' => "Your rental for {$this->rental->car->name} has been marked as {$this->status}.",
            'type' => 'rental_status',
        ];
    }
}
