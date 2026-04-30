<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('last_name');
            $table->string('first_name');
            $table->string('patronymic')->nullable();
            $table->string('specialization');
            $table->text('description')->nullable();
            $table->integer('experience_years')->default(0);
            $table->string('photo')->nullable();
            $table->integer('default_appointment_duration')->default(60);
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('doctors');
    }
};