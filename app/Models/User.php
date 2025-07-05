<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'phone',
        'address',
        'city',
        'state',
        'zip_code',
        'country',
        'date_of_birth',
        'driving_license_number',
        'driving_license_expiry',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_of_birth' => 'date',
            'driving_license_expiry' => 'date',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the role that belongs to the user.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the reservations for this user.
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Get the rentals for this user.
     */
    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    /**
     * Check if the user is a customer
     */
    public function isCustomer()
    {
        return $this->role && $this->role->isCustomer();
    }

    /**
     * Check if the user is staff
     */
    public function isStaff()
    {
        return $this->role && $this->role->isStaff();
    }

    /**
     * Check if the user is a manager
     */
    public function isManager()
    {
        return $this->role && $this->role->isManager();
    }

    /**
     * Check if the user is admin (staff or manager)
     */
    public function isAdmin()
    {
        return $this->role && $this->role->isAdmin();
    }

    /**
     * Check if the user has a specific role
     */
    public function hasRole($role)
    {
        return $this->role && $this->role->name === $role;
    }

    /**
     * Check if the user has any of the given roles
     */
    public function hasAnyRole($roles)
    {
        return $this->role && in_array($this->role->name, (array) $roles);
    }

    /**
     * Get the user's full address
     */
    public function getFullAddressAttribute()
    {
        $parts = array_filter([
            $this->address,
            $this->city,
            $this->state,
            $this->zip_code,
            $this->country
        ]);

        return implode(', ', $parts);
    }

    /**
     * Check if user's driving license is expired
     */
    public function isDrivingLicenseExpired()
    {
        return $this->driving_license_expiry && $this->driving_license_expiry->isPast();
    }

    /**
     * Check if user's driving license expires soon (within 30 days)
     */
    public function isDrivingLicenseExpiringSoon()
    {
        return $this->driving_license_expiry && 
               $this->driving_license_expiry->diffInDays(now()) <= 30;
    }
}
