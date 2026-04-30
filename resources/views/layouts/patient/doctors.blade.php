@extends('layouts.app')

@section('title', 'Наши врачи')

@section('content')
<div class="container" style="padding: 40px 20px;">
    <div class="section-header">
        <h2 class="section-title">Наши врачи</h2>
        <p class="section-subtitle">Выберите специалиста для записи</p>
    </div>
    
    <div class="doctors-grid">
        @forelse($doctors as $doctor)
        <div class="doctor-card" style="background: white; padding: 30px; border-radius: 20px; text-align: center; box-shadow: var(--shadow);">
            <div class="doctor-avatar"><i class="fas fa-user-md" style="font-size: 3rem; color: var(--primary);"></i></div>
            <h3>{{ $doctor->last_name }} {{ $doctor->first_name }}</h3>
            <p class="specialization">{{ $doctor->specialization }}</p>
            <p>Стаж: {{ $doctor->experience_years }} лет</p>
            <a href="/doctor/{{ $doctor->id }}/schedule" class="btn btn-primary">Записаться</a>
        </div>
        @empty
            <div class="doctor-card">Иванова Елена - Терапевт</div>
            <div class="doctor-card">Петров Алексей - Хирург</div>
            <div class="doctor-card">Сидорова Мария - Ортодонт</div>
        @endforelse
    </div>
</div>
@endsection