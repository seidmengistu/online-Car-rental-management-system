<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'description',
    ];

    /**
     * Get the users that belong to this role.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Check if the role is customer
     */
    public function isCustomer()
    {
        return $this->name === 'customer';
    }

    /**
     * Check if the role is staff
     */
    public function isStaff()
    {
        return $this->name === 'staff';
    }

    /**
     * Check if the role is manager
     */
    public function isManager()
    {
        return $this->name === 'manager';
    }

    /**
     * Check if the role is super admin
     */
    public function isSuperAdmin()
    {
        return $this->name === 'admin';
    }

    /**
     * Check if the role is admin (staff, manager, or admin)
     */
    public function isAdmin()
    {
        return in_array($this->name, ['staff', 'manager', 'admin']);
    }
}