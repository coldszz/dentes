<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Добрый зуб - Стоматологическая клиника')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/css/style.css">
    @stack('styles')
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="/" class="logo">
                <i class="fas fa-tooth"></i>
                <span>Добрый зуб</span>
            </a>
            <button class="mobile-menu-btn" id="mobileMenuBtn"><i class="fas fa-bars"></i></button>
            <ul class="nav-menu" id="navMenu">
                <li><a href="/#services" class="nav-link">Услуги</a></li>
                <li><a href="/doctors" class="nav-link">Врачи</a></li>
                <li><a href="/#contacts" class="nav-link">Контакты</a></li>
                @auth
                    @if(auth()->user()->isAdmin())
                        <li><a href="/admin" class="nav-link">Админ-панель</a></li>
                    @elseif(auth()->user()->isDoctor())
                        <li><a href="/doctor/dashboard" class="nav-link">Личный кабинет</a></li>
                    @else
                        <li><a href="/patient/dashboard" class="nav-link">Личный кабинет</a></li>
                    @endif
                    <li>
                        <form action="/logout" method="POST" style="display:inline">
                            @csrf
                            <button type="submit" class="btn-login">Выйти</button>
                        </form>
                    </li>
                @else
                    <li><a href="/login" class="btn-login">Войти</a></li>
                    <li><a href="/register" class="btn-register">Регистрация</a></li>
                @endauth
            </ul>
        </div>
    </nav>

    <main style="margin-top: 80px;">
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div>
                    <div class="footer-logo"><i class="fas fa-tooth"></i> Добрый зуб</div>
                    <p>Забота о вашей улыбке - наша работа</p>
                </div>
                <div>
                    <h4>Контакты</h4>
                    <p><i class="fas fa-phone"></i> +7 (999) 123-45-67</p>
                    <p><i class="fas fa-envelope"></i> info@dobryzub.ru</p>
                </div>
                <div>
                    <h4>Адрес</h4>
                    <p>г. Москва, ул. Примерная, 123</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2026 Добрый зуб. Все права защищены.</p>
            </div>
        </div>
    </footer>

    <script src="/js/script.js"></script>
    @stack('scripts')
</body>
</html>