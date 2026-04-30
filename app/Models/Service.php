<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';
    
    protected $fillable = ['name', 'category_id', 'description', 'base_price', 'duration_minutes', 'icon'];

    public function category() { return $this->belongsTo(ServiceCategory::class); }
    public function appointments() { return $this->hasMany(Appointment::class); }
}