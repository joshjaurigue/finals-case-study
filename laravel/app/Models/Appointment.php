<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $fillable = [
        'patient_id', // Foreign key from patients table
        'doctor_id', // Foreign key from doctors table
        'appointment_date',
        'status',
    ];

    // Relationships
    public function patient()
    {
        return $this->belongsTo(Patient::class); // Belongs to a patient
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class); // Belongs to a doctor
    }

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class); // Has many medical records
    }
}
