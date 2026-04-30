@extends('layouts.app')

@section('title', 'Главная - Добрый зуб')

@section('content')
<section class="hero" style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1629909613654-28e377c37b09?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80'); background-size: cover; background-position: center; height: 500px; display: flex; align-items: center; justify-content: center; text-align: center; color: white;">
    <div>
        <h1 style="font-size: 3rem;">Добро пожаловать в "Добрый зуб"</h1>
        <p style="font-size: 1.2rem; margin: 20px 0;">Современная стоматология для всей семьи</p>
        <a href="/doctors" class="btn btn-primary">Записаться онлайн</a>
    </div>
</section>

<section id="services" style="padding: 80px 0;">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Наши услуги</h2>
            <p class="section-subtitle">Современные методы лечения и ухода за зубами</p>
        </div>
        <div class="services-grid">
            <div class="service-card">
                <div class="service-icon"><i class="fas fa-tooth"></i></div>
                <h3>Лечение кариеса</h3>
                <p>Качественное лечение с использованием современных материалов</p>
                <div class="service-price">от 3 500 ₽</div>
                <a href="/doctors" class="btn btn-primary">Записаться</a>
            </div>
            <div class="service-card">
                <div class="service-icon"><i class="fas fa-brush"></i></div>
                <h3>Профессиональная чистка</h3>
                <p>Комплексная чистка зубов от налета и камня</p>
                <div class="service-price">от 4 500 ₽</div>
                <a href="/doctors" class="btn btn-primary">Записаться</a>
            </div>
            <div class="service-card">
                <div class="service-icon"><i class="fas fa-star"></i></div>
                <h3>Отбеливание</h3>
                <p>Безопасное отбеливание по системе Zoom</p>
                <div class="service-price">от 15 000 ₽</div>
                <a href="/doctors" class="btn btn-primary">Записаться</a>
            </div>
            <div class="service-card">
                <div class="service-icon"><i class="fas fa-microscope"></i></div>
                <h3>Имплантация</h3>
                <p>Установка имплантов премиум-класса</p>
                <div class="service-price">от 50 000 ₽</div>
                <a href="/doctors" class="btn btn-primary">Записаться</a>
            </div>
        </div>
    </div>
</section>

<section id="doctors" style="padding: 80px 0; background: var(--white);">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Наши врачи</h2>
            <p class="section-subtitle">Опытные специалисты с многолетним стажем</p>
        </div>
        <div class="doctors-grid">
            @forelse($doctors as $doctor)
            <div class="doctor-card">
                <div class="doctor-avatar"><i class="fas fa-user-md"></i></div>
                <h3>{{ $doctor->last_name }} {{ $doctor->first_name }}</h3>
                <p class="specialization">{{ $doctor->specialization }}</p>
                <p>Стаж: {{ $doctor->experience_years }} лет</p>
                <div class="doctor-rating"><i class="fas fa-star"></i> {{ number_format($doctor->average_rating, 1) }}</div>
                <a href="/doctor/{{ $doctor->id }}/schedule" class="btn btn-primary">Записаться</a>
                <button class="btn" style="margin-top: 10px; background: transparent; border: 1px solid var(--primary);" onclick="showDoctorReviews({{ $doctor->id }}, '{{ $doctor->last_name }} {{ $doctor->first_name }}')">Отзывы</button>
            </div>
            @empty
                <div class="doctor-card">
                    <div class="doctor-avatar"><i class="fas fa-user-md"></i></div>
                    <h3>Иванова Елена</h3>
                    <p class="specialization">Терапевт</p>
                    <p>Стаж: 12 лет</p>
                    <div class="doctor-rating"><i class="fas fa-star"></i> 4.8</div>
                    <a href="/doctor/1/schedule" class="btn btn-primary">Записаться</a>
                    <button class="btn" style="margin-top: 10px; background: transparent; border: 1px solid var(--primary);" onclick="alert('Демо-режим')">Отзывы</button>
                </div>
                <div class="doctor-card">
                    <div class="doctor-avatar"><i class="fas fa-user-md"></i></div>
                    <h3>Петров Алексей</h3>
                    <p class="specialization">Хирург-имплантолог</p>
                    <p>Стаж: 15 лет</p>
                    <div class="doctor-rating"><i class="fas fa-star"></i> 4.9</div>
                    <a href="/doctor/2/schedule" class="btn btn-primary">Записаться</a>
                </div>
                <div class="doctor-card">
                    <div class="doctor-avatar"><i class="fas fa-user-md"></i></div>
                    <h3>Сидорова Мария</h3>
                    <p class="specialization">Ортодонт</p>
                    <p>Стаж: 8 лет</p>
                    <div class="doctor-rating"><i class="fas fa-star"></i> 4.7</div>
                    <a href="/doctor/3/schedule" class="btn btn-primary">Записаться</a>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Преимущества -->
<section class="features" style="padding: 80px 0; background: var(--gray);">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Почему выбирают нас</h2>
            <p class="section-subtitle">8 из 10 пациентов рекомендуют нас своим друзьям</p>
        </div>
        <div class="features-grid">
            <div class="feature-item">
                <div class="feature-icon"><i class="fas fa-user-md"></i></div>
                <h3>Опытные врачи</h3>
                <p>Врачи с опытом работы от 10 лет</p>
            </div>
            <div class="feature-item">
                <div class="feature-icon"><i class="fas fa-clock"></i></div>
                <h3>Без очередей</h3>
                <p>Точное соблюдение времени приема</p>
            </div>
            <div class="feature-item">
                <div class="feature-icon"><i class="fas fa-gem"></i></div>
                <h3>Современные материалы</h3>
                <p>Используем только проверенные материалы</p>
            </div>
            <div class="feature-item">
                <div class="feature-icon"><i class="fas fa-hand-holding-heart"></i></div>
                <h3>Забота о пациентах</h3>
                <p>Индивидуальный подход к каждому</p>
            </div>
            <div class="feature-item">
                <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
                <h3>Стерильность</h3>
                <p>Многоступенчатая система стерилизации</p>
            </div>
            <div class="feature-item">
                <div class="feature-icon"><i class="fas fa-credit-card"></i></div>
                <h3>Доступные цены</h3>
                <p>Гибкая система скидок и акций</p>
            </div>
        </div>
    </div>
</section>

<!-- Контакты -->
<section id="contacts" style="padding: 80px 0;">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Контакты</h2>
            <p class="section-subtitle">Свяжитесь с нами любым удобным способом</p>
        </div>
        <div class="contacts-grid">
            <div>
                <div class="contact-item">
                    <div class="contact-icon"><i class="fas fa-phone-alt"></i></div>
                    <div>
                        <h4>Телефон</h4>
                        <p>+7 (999) 123-45-67</p>
                        <p class="small">Ежедневно с 9:00 до 21:00</p>
                    </div>
                </div>
                <div class="contact-item">
                    <div class="contact-icon"><i class="fas fa-envelope"></i></div>
                    <div>
                        <h4>Email</h4>
                        <p>info@dobryzub.ru</p>
                        <p class="small">Ответим в течение 2 часов</p>
                    </div>
                </div>
                <div class="contact-item">
                    <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div>
                        <h4>Адрес</h4>
                        <p>г. Москва, ул. Примерная, д. 123</p>
                        <p class="small">м. "Центральная", 5 мин пешком</p>
                    </div>
                </div>
                <div class="contact-social">
                    <h4>Мы в соцсетях</h4>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-vk"></i></a>
                        <a href="#"><i class="fab fa-telegram-plane"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="contact-form">
                <h3>Остались вопросы?</h3>
                <p>Заполните форму и мы свяжемся с вами</p>
                <form id="contactForm">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="name" placeholder="Ваше имя" required>
                    </div>
                    <div class="form-group">
                        <input type="tel" name="phone" placeholder="Телефон" required>
                    </div>
                    <div class="form-group">
                        <textarea name="message" placeholder="Ваш вопрос" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Отправить</button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Карта -->
<section class="map" style="padding: 0; height: 450px;">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2245.0!2d37.6!3d55.7!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNTXCsDQyJzAwLjAiTiAzN8KwMzYnMDAuMCJF!5e0!3m2!1sru!2sru!4v1620000000000!5m2!1sru!2sru" 
            width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
</section>
@endsection

@push('styles')
<style>
    .small {
        font-size: 0.85rem;
        color: var(--text-light);
        margin-top: 5px;
    }
    .contact-social {
        margin-top: 30px;
    }
    .contact-social h4 {
        margin-bottom: 15px;
        color: var(--primary);
    }
    .social-links {
        display: flex;
        gap: 15px;
    }
    .social-links a {
        width: 45px;
        height: 45px;
        background: var(--primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
        transition: all 0.3s;
        text-decoration: none;
    }
    .social-links a:hover {
        transform: translateY(-5px);
        background: var(--primary-dark);
    }
    .btn-block {
        display: block;
        width: 100%;
    }
    .features {
        background: var(--gray);
    }
    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px;
    }
    .feature-item {
        text-align: center;
        padding: 30px;
        background: var(--white);
        border-radius: 20px;
        box-shadow: var(--shadow);
        transition: 0.3s;
    }
    .feature-item:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-hover);
    }
    .feature-icon {
        width: 70px;
        height: 70px;
        margin: 0 auto 15px;
        background: var(--primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.8rem;
    }
    .map iframe {
        display: block;
    }
</style>
@endpush

@push('scripts')
<script>
// Обработка формы обратной связи
document.getElementById('contactForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    alert('Спасибо! Мы свяжемся с вами в ближайшее время.');
    this.reset();
});

// Функция показа отзывов
function showDoctorReviews(doctorId, doctorName) {
    fetch(`/doctor/${doctorId}/reviews`)
        .then(response => response.json())
        .then(data => {
            let modal = document.getElementById('reviewsModal');
            if (!modal) {
                modal = createReviewsModal();
            }
            const doctorNameSpan = document.getElementById('doctorName');
            if (doctorNameSpan) doctorNameSpan.innerText = doctorName;
            
            const ratingSpan = document.getElementById('averageRatingText');
            if (ratingSpan) {
                ratingSpan.innerHTML = `<i class="fas fa-star" style="color: gold;"></i> ${data.average_rating.toFixed(1)} (${data.total_reviews} отзывов)`;
            }
            
            const reviewsList = document.getElementById('reviewsList');
            if (reviewsList) {
                let reviewsHtml = '';
                for (const review of data.reviews) {
                    reviewsHtml += `
                        <div class="review-item">
                            <strong>${review.patient.user.name}</strong>
                            <div class="rating">${'★'.repeat(review.rating)}${'☆'.repeat(5 - review.rating)}</div>
                            <p>${review.comment}</p>
                            <small>${new Date(review.created_at).toLocaleDateString()}</small>
                        </div>
                    `;
                }
                reviewsList.innerHTML = reviewsHtml || '<p>Пока нет отзывов</p>';
            }
            modal.classList.add('show');
        })
        .catch(() => {
            alert('Демо-режим: отзывы появятся после настройки базы данных');
        });
}

function createReviewsModal() {
    const modalHtml = `
        <div id="reviewsModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h3>Отзывы о враче <span id="doctorName"></span></h3>
                <div id="averageRatingText"></div>
                <div id="reviewsList" class="reviews-list"></div>
            </div>
        </div>
    `;
    document.body.insertAdjacentHTML('beforeend', modalHtml);
    
    const modal = document.getElementById('reviewsModal');
    const closeBtn = modal.querySelector('.close');
    if (closeBtn) {
        closeBtn.addEventListener('click', () => modal.classList.remove('show'));
    }
    window.addEventListener('click', (e) => {
        if (e.target === modal) modal.classList.remove('show');
    });
    return modal;
}
</script>
@endpush