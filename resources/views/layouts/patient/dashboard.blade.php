@extends('layouts.app')

@section('title', 'Личный кабинет пациента')

@section('content')
<div class="container" style="padding: 40px 20px;">
    <div class="dashboard-header" style="background: linear-gradient(135deg, var(--primary), var(--secondary)); color: white; padding: 30px; border-radius: 20px; margin-bottom: 40px;">
        <h1><i class="fas fa-user-circle"></i> Личный кабинет</h1>
        <p>Здравствуйте, {{ auth()->user()->name }}!</p>
    </div>

    <div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 40px;">
        <div class="stat-card" style="background: white; padding: 25px; border-radius: 20px; display: flex; align-items: center; gap: 20px;">
            <i class="fas fa-calendar-check" style="font-size: 2rem; color: var(--primary);"></i>
            <div><h3>{{ $appointments->where('status', 'confirmed')->count() }}</h3><p>Предстоящих визитов</p></div>
        </div>
        <div class="stat-card" style="background: white; padding: 25px; border-radius: 20px; display: flex; align-items: center; gap: 20px;">
            <i class="fas fa-clock" style="font-size: 2rem; color: var(--primary);"></i>
            <div><h3>{{ $appointments->where('status', 'pending')->count() }}</h3><p>Ожидают подтверждения</p></div>
        </div>
        <div class="stat-card" style="background: white; padding: 25px; border-radius: 20px; display: flex; align-items: center; gap: 20px;">
            <i class="fas fa-check-circle" style="font-size: 2rem; color: var(--primary);"></i>
            <div><h3>{{ $appointments->where('status', 'completed')->count() }}</h3><p>Завершено визитов</p></div>
        </div>
    </div>

    <div class="section-box" style="background: white; border-radius: 20px; padding: 30px; margin-bottom: 40px;">
        <h2 style="color: var(--primary); margin-bottom: 25px;"><i class="fas fa-calendar-alt"></i> Мои записи</h2>
        
        @if($appointments->whereIn('status', ['pending', 'confirmed'])->count() > 0)
            @foreach($appointments->whereIn('status', ['pending', 'confirmed']) as $appointment)
            <div class="appointment-card" style="border: 1px solid #e0e7ed; border-radius: 15px; padding: 20px; margin-bottom: 15px;">
                <div><strong>Врач:</strong> {{ $appointment->doctor->last_name }} {{ $appointment->doctor->first_name }}</div>
                <div><strong>Услуга:</strong> {{ $appointment->service->name }}</div>
                <div><strong>Дата:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d.m.Y') }}</div>
                <div><strong>Время:</strong> {{ $appointment->appointment_time }}</div>
                <div><strong>Статус:</strong> {{ $appointment->status == 'pending' ? 'Ожидает' : 'Подтверждена' }}</div>
                <div style="margin-top: 15px;">
                    @if($appointment->status == 'confirmed' && !$appointment->review)
                        <button class="btn btn-primary" onclick="alert('Оставить отзыв (демо)')">Оставить отзыв</button>
                    @endif
                    <button class="btn" style="background: #dc3545; color: white;" onclick="if(confirm('Отменить запись?')) alert('Отмена (демо)')">Отменить</button>
                </div>
            </div>
            @endforeach
        @else
            <p>У вас нет активных записей. <a href="/doctors">Записаться к врачу</a></p>
        @endif
    </div>
</div>
@endsection