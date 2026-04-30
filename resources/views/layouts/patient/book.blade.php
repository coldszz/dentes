@extends('layouts.app')

@section('title', 'Запись к врачу')

@section('content')
<div class="container" style="padding: 40px 20px; max-width: 600px;">
    <div class="booking-form" style="background: white; border-radius: 20px; padding: 40px; box-shadow: var(--shadow);">
        <h2 style="color: var(--primary); margin-bottom: 10px;">Запись к врачу</h2>
        <p><strong>{{ $doctor->last_name }} {{ $doctor->first_name }}</strong> - {{ $doctor->specialization }}</p>
        
        <form method="POST" action="{{ route('patient.appointment.store') }}">
            @csrf
            <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">
            
            <div class="form-group">
                <label>Услуга</label>
                <select name="service_id" class="form-control" required style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #ddd;">
                    <option value="">Выберите услугу</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}">{{ $service->name }} - от {{ number_format($service->base_price, 0, ',', ' ') }} ₽</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label>Дата</label>
                <input type="date" name="appointment_date" class="form-control" required style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #ddd;">
            </div>
            
            <div class="form-group">
                <label>Время</label>
                <select name="appointment_time" class="form-control" required style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #ddd;">
                    <option value="">Выберите время</option>
                    <option value="09:00">09:00</option>
                    <option value="10:00">10:00</option>
                    <option value="11:00">11:00</option>
                    <option value="12:00">12:00</option>
                    <option value="13:00">13:00</option>
                    <option value="14:00">14:00</option>
                    <option value="15:00">15:00</option>
                    <option value="16:00">16:00</option>
                    <option value="17:00">17:00</option>
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary btn-block">Записаться</button>
        </form>
    </div>
</div>
@endsection