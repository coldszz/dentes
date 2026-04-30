// ========== МОБИЛЬНОЕ МЕНЮ ==========
const mobileMenuBtn = document.getElementById('mobileMenuBtn');
const navMenu = document.getElementById('navMenu');

if (mobileMenuBtn) {
    mobileMenuBtn.addEventListener('click', () => {
        navMenu.classList.toggle('show');
        const icon = mobileMenuBtn.querySelector('i');
        if (icon) {
            icon.classList.toggle('fa-bars');
            icon.classList.toggle('fa-times');
        }
    });
}

// ========== ПЛАВНАЯ ПРОКРУТКА ==========
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// ========== АНИМАЦИЯ ПРИ СКРОЛЛЕ ==========
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

document.querySelectorAll('.service-card, .feature-item, .blog-card, .doctor-card, .contact-item').forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(30px)';
    el.style.transition = 'all 0.6s ease-out';
    observer.observe(el);
});

// ========== ЗАПИСЬ К ВРАЧУ (AJAX) ==========
function getAvailableSlots(doctorId, date, serviceId) {
    fetch(`/get-available-slots?doctor_id=${doctorId}&date=${date}&service_id=${serviceId}`)
        .then(response => response.json())
        .then(data => {
            const timeSelect = document.getElementById('timeSelect');
            if (timeSelect) {
                timeSelect.innerHTML = '<option value="">Выберите время</option>';
                if (data.slots && data.slots.length > 0) {
                    data.slots.forEach(slot => {
                        timeSelect.innerHTML += `<option value="${slot}">${slot}</option>`;
                    });
                    timeSelect.disabled = false;
                } else {
                    timeSelect.innerHTML = '<option value="">Нет свободных слотов</option>';
                    timeSelect.disabled = true;
                }
            }
        });
}

// ========== ОТЗЫВЫ ВРАЧА (МОДАЛЬНОЕ ОКНО) ==========
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

// ========== ЗАКРЫТИЕ МОДАЛЬНЫХ ОКОН ==========
document.querySelectorAll('.modal .close').forEach(btn => {
    btn.addEventListener('click', function() {
        this.closest('.modal').classList.remove('show');
    });
});

// ========== ОБРАБОТКА ФОРМ ==========
document.getElementById('contactForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    alert('Спасибо! Мы свяжемся с вами.');
    this.reset();
});

// ========== ВАЛИДАЦИЯ ТЕЛЕФОНА ==========
const phoneInputs = document.querySelectorAll('input[type="tel"]');
phoneInputs.forEach(input => {
    input.addEventListener('input', (e) => {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 0 && value.length <= 11) {
            if (value.length <= 1) {
                value = `+7 (${value}`;
            } else if (value.length <= 4) {
                value = `+7 (${value.substring(0, 3)}) ${value.substring(3)}`;
            } else if (value.length <= 7) {
                value = `+7 (${value.substring(0, 3)}) ${value.substring(3, 6)}-${value.substring(6)}`;
            } else {
                value = `+7 (${value.substring(0, 3)}) ${value.substring(3, 6)}-${value.substring(6, 8)}-${value.substring(8, 10)}`;
            }
        }
        e.target.value = value;
    });
});

// ========== ПОДСВЕТКА АКТИВНОГО МЕНЮ ==========
window.addEventListener('scroll', () => {
    const sections = document.querySelectorAll('section');
    const navLinks = document.querySelectorAll('.nav-link');
    
    let current = '';
    sections.forEach(section => {
        const sectionTop = section.offsetTop - 100;
        if (scrollY >= sectionTop && scrollY < sectionTop + section.clientHeight) {
            current = section.getAttribute('id');
        }
    });
    
    navLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href') === `#${current}`) {
            link.classList.add('active');
        }
    });
});

// ========== ИЗМЕНЕНИЕ НАВИГАЦИИ ПРИ СКРОЛЛЕ ==========
window.addEventListener('scroll', () => {
    const navbar = document.querySelector('.navbar');
    if (window.scrollY > 100) {
        navbar.style.background = 'rgba(255, 255, 255, 0.98)';
        navbar.style.boxShadow = '0 2px 20px rgba(43, 108, 148, 0.15)';
    } else {
        navbar.style.background = 'rgba(255, 255, 255, 0.95)';
        navbar.style.boxShadow = '0 2px 20px rgba(43, 108, 148, 0.1)';
    }
});