<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DriverAssigned extends Notification
{
    use Queueable;

    public $reservation;
    public $driver;

    /**
     * Create a new notification instance.
     */
    public function __construct($reservation, $driver)
    {
        $this->reservation = $reservation;
        $this->driver = $driver;
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
            'subject' => 'Driver Assigned',
            'message' => "Driver {$this->driver->name} has been assigned to your reservation (#{$this->reservation->id}). Contact: {$this->driver->phone}",
            'reservation_id' => $this->reservation->id,
            'driver_id' => $this->driver->id,
            'driver_name' => $this->driver->name,
            'driver_phone' => $this->driver->phone,
        ];
    }
}
