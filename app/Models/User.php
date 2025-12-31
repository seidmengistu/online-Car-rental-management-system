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
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'phone',
        'city',
        'state',
        'country',
        'driving_license_number',
        'driving_license_expiry',
        'is_active',
        'id_document_path',
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
     * Payments made by the user
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get the complaints for this user.
     */
    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }

    /**
     * Get the complaints resolved by this user.
     */
    public function resolvedComplaints()
    {
        return $this->hasMany(Complaint::class, 'resolved_by');
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
     * Check if the user is super admin
     */
    public function isSuperAdmin()
    {
        return $this->role && $this->role->isSuperAdmin();
    }

    /**
     * Check if the user is admin (staff, manager, or admin)
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
            $this->city,
            $this->state,
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
