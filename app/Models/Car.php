<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'plate_number',
        'make',
        'model',
        'year',
        'color',
        'fuel_type',
        'transmission',
        'seats',
        'daily_rate',
        'weekly_rate',
        'monthly_rate',
        'mileage',
        'status',
        'description',
        'image',
        'features',
        'is_available',
    ];

    protected $casts = [
        'features' => 'array',
        'is_available' => 'boolean',
        'daily_rate' => 'decimal:2',
        'weekly_rate' => 'decimal:2',
        'monthly_rate' => 'decimal:2',
    ];

    /**
     * Get the reservations for this car
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Get the rentals for this car
     */
    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    /**
     * Check if car is available for the given date range
     */
    public function isAvailableForDates($startDate, $endDate)
    {
        if (!$this->is_available) {
            return false;
        }

        // Check for overlapping reservations
        $conflictingReservations = $this->reservations()
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($q) use ($startDate, $endDate) {
                        $q->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                    });
            })->exists();

        // Check for overlapping rentals
        $conflictingRentals = $this->rentals()
            ->where('status', '!=', 'returned')
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($q) use ($startDate, $endDate) {
                        $q->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                    });
            })->exists();

        return !$conflictingReservations && !$conflictingRentals;
    }

    /**
     * Get the full car name
     */
    public function getFullNameAttribute()
    {
        return "{$this->year} {$this->make} {$this->model}";
    }

    /**
     * Get the current status text
     */
    public function getStatusTextAttribute()
    {
        return ucfirst($this->status);
    }

    /**
     * Scope for available cars
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    /**
     * Scope for cars by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }
} 