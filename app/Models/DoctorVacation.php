<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorVacation extends Model
{
    protected $table = 'doctor_vacations';
    
    protected $fillable = ['doctor_id', 'start_date', 'end_date'];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function doctor() { return $this->belongsTo(Doctor::class); }
}