<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'car_id',
        'start_date',
        'end_date',
        'pickup_location',
        'return_location',
        'total_amount',
        'status',
        'notes',
        'created_by',
        'requires_driver',
        'payment_status',
        'payment_reference',
        'payment_receipt_path',
        'driver_id',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'total_amount' => 'decimal:2',
        'requires_driver' => 'boolean',
    ];

    /**
     * Get the user who made the reservation
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the assigned driver
     */
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    /**
     * Get the car being reserved
     */
    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    /**
     * Get the staff member who created the reservation
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the rental created from this reservation
     */
    public function rental()
    {
        return $this->hasOne(Rental::class);
    }

    /**
     * Payments made for the reservation
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Calculate the total amount based on dates and car rate
     */
    public function calculateTotalAmount()
    {
        $days = $this->start_date->diffInDays($this->end_date) + 1;
        return $this->car->daily_rate * $days;
    }

    /**
     * Get the status text
     */
    public function getStatusTextAttribute()
    {
        return ucfirst($this->status);
    }

    /**
     * Check if reservation can be cancelled
     */
    public function canBeCancelled()
    {
        return in_array($this->status, ['pending', 'confirmed']) &&
            $this->start_date->isFuture();
    }

    /**
     * Check if reservation can be converted to rental
     */
    public function canBeConvertedToRental()
    {
        // Allow conversion if the reservation is confirmed, regardless of dates
        return $this->status === 'confirmed';
    }

    /**
     * Scope for active reservations
     */
    public function scopeActive($query)
    {
        return $query->whereNotIn('status', ['cancelled', 'completed']);
    }

    /**
     * Scope for reservations by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for reservations by user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}