<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $table = 'doctors';
    
    protected $fillable = [
        'user_id', 'last_name', 'first_name', 'patronymic',
        'specialization', 'description', 'experience_years', 'photo', 'default_appointment_duration'
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function appointments() { return $this->hasMany(Appointment::class); }
    public function schedules() { return $this->hasMany(Schedule::class); }
    public function vacations() { return $this->hasMany(DoctorVacation::class); }
    public function reviews() { return $this->hasMany(Review::class); }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }
    
    public function getFullNameAttribute()
    {
        return "{$this->last_name} {$this->first_name} {$this->patronymic}";
    }
}