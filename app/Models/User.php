<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'date_of_birth',
        'gender',
        'address',
        'profile_photo',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_of_birth' => 'date',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the user's full name.
     */
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Get the name attribute (for compatibility with Laravel's default auth)
     */
    public function getNameAttribute()
    {
        return $this->getFullNameAttribute();
    }

    /**
     * Get the patient record associated with the user.
     */
    public function patient()
    {
        return $this->hasOne(Patient::class);
    }

    /**
     * Get the doctor record associated with the user.
     */
    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    /**
     * Check if user is a patient
     */
    public function isPatient()
    {
        return $this->hasRole('patient');
    }

    /**
     * Check if user is a doctor
     */
    public function isDoctor()
    {
        return $this->hasRole('doctor');
    }

    /**
     * Check if user is an admin
     */
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    /**
     * Check if user is a nurse
     */
    public function isNurse()
    {
        return $this->hasRole('nurse');
    }

    /**
     * Check if user is a receptionist
     */
    public function isReceptionist()
    {
        return $this->hasRole('receptionist');
    }

    /**
     * Scope to get active users
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get users by role
     */
    public function scopeWithRole($query, $role)
    {
        return $query->role($role);
    }
}