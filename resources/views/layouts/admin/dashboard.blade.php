@extends('layouts.app')

@section('title', 'Админ-панель')

@section('content')
<div class="container" style="padding: 40px 20px;">
    <div class="dashboard-header" style="background: linear-gradient(135deg, var(--primary), var(--secondary)); color: white; padding: 30px; border-radius: 20px; margin-bottom: 40px;">
        <h1><i class="fas fa-shield-alt"></i> Админ-панель</h1>
        <p>Управление клиникой "Добрый зуб"</p>
    </div>
    
    <div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 40px;">
        <div class="stat-card" style="background: white; padding: 25px; border-radius: 20px;">
            <h3>Пациентов</h3>
            <p style="font-size: 2rem; color: var(--primary);">{{ $totalPatients ?? 0 }}</p>
        </div>
        <div class="stat-card" style="background: white; padding: 25px; border-radius: 20px;">
            <h3>Врачей</h3>
            <p style="font-size: 2rem; color: var(--primary);">{{ $totalDoctors ?? 0 }}</p>
        </div>
        <div class="stat-card" style="background: white; padding: 25px; border-radius: 20px;">
            <h3>Записей</h3>
            <p style="font-size: 2rem; color: var(--primary);">{{ $totalAppointments ?? 0 }}</p>
        </div>
    </div>
    
    <div class="section-box" style="background: white; border-radius: 20px; padding: 30px;">
        <h2 style="color: var(--primary);"><i class="fas fa-user-md"></i> Врачи</h2>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr><th style="text-align: left; padding: 12px;">ID</th><th>ФИО</th><th>Специализация</th><th>Email</th></tr>
            </thead>
            <tbody>
                @forelse($doctors ?? [] as $doctor)
                <tr><td style="padding: 12px;">{{ $doctor->id }}</td>
                    <td>{{ $doctor->last_name }} {{ $doctor->first_name }}</td>
                    <td>{{ $doctor->specialization }}</td>
                    <td>{{ $doctor->user->email ?? '-' }}</td>
                </tr>
                @empty
                    <tr><td colspan="4" style="padding: 12px; text-align: center;">Нет врачей</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection