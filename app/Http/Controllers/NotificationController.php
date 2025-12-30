<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Mark a notification as read and redirect to the target URL.
     */
    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        // Determine redirect URL based on notification type
        if ($notification->type === 'App\Notifications\ComplaintSubmitted') {
            return redirect()->route('admin.complaints.show', $notification->data['complaint_id']);
        } elseif ($notification->type === 'App\Notifications\ComplaintResolved') {
            return redirect()->route('complaints.show', $notification->data['complaint_id']);
        } elseif ($notification->type === 'App\Notifications\NewBookingCreated') {
            return redirect()->route('admin.reservations.index', ['search' => $notification->data['user_name']]); // Or a specific show route if available
        } elseif ($notification->type === 'App\Notifications\BookingStatusUpdated') {
            return redirect()->route('reservations.show', $notification->data['reservation_id']);
        } elseif ($notification->type === 'App\Notifications\RentalStatusUpdated' || $notification->type === 'App\Notifications\RentalOverdue') {
            return redirect()->route('rentals.show', $notification->data['rental_id']);
        }

        return back();
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return back()->with('success', 'All notifications marked as read.');
    }
}
