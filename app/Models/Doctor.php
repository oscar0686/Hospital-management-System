<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'user_id', 'doctor_id', 'specialization', 'qualification',
        'experience_years', 'license_number', 'consultation_fee',
        'working_hours', 'is_available'
    ];

    protected $casts = [
        'working_hours' => 'array',
        'consultation_fee' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }
}