<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'schedules';
    
    protected $fillable = ['doctor_id', 'date', 'start_time', 'end_time', 'is_working'];

    protected $casts = [
        'date' => 'date',
        'is_working' => 'boolean',
    ];

    public function doctor() { return $this->belongsTo(Doctor::class); }
}