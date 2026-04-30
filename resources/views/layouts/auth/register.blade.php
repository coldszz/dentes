@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')
<div class="container" style="min-height: 80vh; display: flex; align-items: center; justify-content: center; padding: 60px 20px;">
    <div class="auth-form" style="max-width: 500px; width: 100%; background: white; padding: 40px; border-radius: 20px; box-shadow: var(--shadow);">
        <h2 style="text-align: center; color: var(--primary); margin-bottom: 30px;">Регистрация</h2>
        
        @if($errors->any())
            <div style="background: #f8d7da; color: #721c24; padding: 12px; border-radius: 10px; margin-bottom: 20px;">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
        
        <form method="POST" action="/register">
            @csrf
            <div class="form-group">
                <label>ФИО</label>
                <input type="text" name="name" value="{{ old('name') }}" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required>
            </div>
            <div class="form-group">
                <label>Телефон</label>
                <input type="tel" name="phone" value="{{ old('phone') }}">
            </div>
            <div class="form-group">
                <label>Пароль</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <label>Подтверждение пароля</label>
                <input type="password" name="password_confirmation" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Зарегистрироваться</button>
            <p style="text-align: center; margin-top: 20px;">
                Уже есть аккаунт? <a href="/login" style="color: var(--primary);">Войти</a>
            </p>
        </form>
    </div>
</div>
@endsection