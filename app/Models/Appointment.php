<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = 'appointments';
    
    protected $fillable = [
        'patient_id', 'doctor_id', 'service_id',
        'appointment_date', 'appointment_time', 'duration_minutes', 'final_price', 'status', 'patient_comment'
    ];

    protected $casts = [
        'appointment_date' => 'date',
    ];

    public function patient() { return $this->belongsTo(Patient::class); }
    public function doctor() { return $this->belongsTo(Doctor::class); }
    public function service() { return $this->belongsTo(Service::class); }
    public function review() { return $this->hasOne(Review::class); }
    
    public function getStatusTranslatedAttribute()
    {
        return [
            'pending' => 'Ожидает',
            'confirmed' => 'Подтверждена',
            'completed' => 'Завершена',
            'cancelled' => 'Отменена'
        ][$this->status] ?? $this->status;
    }
}