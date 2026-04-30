@extends('layouts.app')

@section('title', 'Вход')

@section('content')
<div class="container" style="min-height: 80vh; display: flex; align-items: center; justify-content: center; padding: 60px 20px;">
    <div class="auth-form" style="max-width: 450px; width: 100%; background: white; padding: 40px; border-radius: 20px; box-shadow: var(--shadow);">
        <h2 style="text-align: center; color: var(--primary); margin-bottom: 30px;">Вход в личный кабинет</h2>
        
        @if($errors->any())
            <div style="background: #f8d7da; color: #721c24; padding: 12px; border-radius: 10px; margin-bottom: 20px;">
                {{ $errors->first() }}
            </div>
        @endif
        
        <form method="POST" action="/login">
            @csrf
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required>
            </div>
            <div class="form-group">
                <label>Пароль</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Войти</button>
            <p style="text-align: center; margin-top: 20px;">
                Нет аккаунта? <a href="/register" style="color: var(--primary);">Зарегистрироваться</a>
            </p>
        </form>
    </div>
</div>
@endsection