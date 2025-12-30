<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'license_number',
        'status',
        'image_path',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }
}
