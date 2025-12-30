<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RentalOverdue extends Notification
{
    use Queueable;

    public $rental;

    /**
     * Create a new notification instance.
     */
    public function __construct($rental)
    {
        $this->rental = $rental;
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
            'end_date' => $this->rental->end_date->format('Y-m-d'),
            'subject' => 'Rental Overdue Warning',
            'message' => "Your rental for {$this->rental->car->name} was due on {$this->rental->end_date->format('M d, Y')}. Please return it immediately.",
            'type' => 'rental_overdue',
        ];
    }
}
