<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id',
        'user_id',
        'car_id',
        'start_date',
        'end_date',
        'actual_start_date',
        'actual_end_date',
        'pickup_location',
        'return_location',
        'total_amount',
        'deposit_amount',
        'status',
        'notes',
        'created_by',
        'returned_by',
        'return_notes',
        'damage_report',
        'additional_charges',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'actual_start_date' => 'datetime',
        'actual_end_date' => 'datetime',
        'total_amount' => 'decimal:2',
        'deposit_amount' => 'decimal:2',
        'additional_charges' => 'decimal:2',
    ];

    /**
     * Get the reservation this rental was created from
     */
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    /**
     * Get the user who is renting
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the car being rented
     */
    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    /**
     * Get the staff member who created the rental
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the staff member who processed the return
     */
    public function returnedBy()
    {
        return $this->belongsTo(User::class, 'returned_by');
    }

    /**
     * Calculate the total amount including additional charges
     */
    public function calculateFinalAmount()
    {
        return $this->total_amount + $this->additional_charges;
    }

    /**
     * Get the status text
     */
    public function getStatusTextAttribute()
    {
        return ucfirst($this->status);
    }

    /**
     * Check if rental is overdue
     */
    public function isOverdue()
    {
        return $this->status === 'active' && $this->end_date->isPast();
    }

    /**
     * Calculate overdue days
     */
    public function getOverdueDaysAttribute()
    {
        if (!$this->isOverdue()) {
            return 0;
        }
        return $this->end_date->diffInDays(now());
    }

    /**
     * Check if rental can be returned
     */
    public function canBeReturned()
    {
        return $this->status === 'active';
    }

    /**
     * Scope for active rentals
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for completed rentals
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'returned');
    }

    /**
     * Scope for overdue rentals
     */
    public function scopeOverdue($query)
    {
        return $query->where('status', 'active')
                    ->where('end_date', '<', now());
    }

    /**
     * Scope for rentals by user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
} 