@extends('layouts.app')

@section('title', 'Личный кабинет врача')

@section('content')
<div class="container" style="padding: 40px 20px;">
    <div class="dashboard-header" style="background: linear-gradient(135deg, var(--primary), var(--secondary)); color: white; padding: 30px; border-radius: 20px; margin-bottom: 40px;">
        <h1><i class="fas fa-user-md"></i> Личный кабинет врача</h1>
        <p>Добро пожаловать, {{ auth()->user()->name }}!</p>
    </div>
    
    <div class="section-box" style="background: white; border-radius: 20px; padding: 30px; margin-bottom: 30px;">
        <h2 style="color: var(--primary);"><i class="fas fa-calendar-day"></i> Записи на сегодня</h2>
        <p>Нет записей на сегодня</p>
    </div>
    
    <div class="section-box" style="background: white; border-radius: 20px; padding: 30px;">
        <h2 style="color: var(--primary);"><i class="fas fa-calendar-week"></i> Управление расписанием</h2>
        <form method="POST" action="/doctor/schedule">
            @csrf
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px;">
                <input type="date" name="date" class="form-control" required style="padding: 10px; border-radius: 10px;">
                <input type="time" name="start_time" class="form-control" required style="padding: 10px; border-radius: 10px;">
                <input type="time" name="end_time" class="form-control" required style="padding: 10px; border-radius: 10px;">
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </div>
</div>
@endsection