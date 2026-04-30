<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table = 'patients';
    
    protected $fillable = ['user_id', 'last_name', 'first_name', 'patronymic', 'birth_date'];

    public function user() { return $this->belongsTo(User::class); }
    public function appointments() { return $this->hasMany(Appointment::class); }
    public function reviews() { return $this->hasMany(Review::class); }
    
    public function getFullNameAttribute()
    {
        return "{$this->last_name} {$this->first_name} {$this->patronymic}";
    }
}