console.log('=== Script.js завантажено ===\n');

// Завдання 1.2: Підрахунок елементів
document.addEventListener('DOMContentLoaded', function() {
    console.log('=== ЗАВДАННЯ 1.2: Підрахунок елементів ===');
    
    // Кількість параграфів <p>
    const paragraphs = document.querySelectorAll('p');
    console.log('✓ Кількість параграфів <p>:', paragraphs.length);
    
    // Кількість заголовків <h2>
    const h2Elements = document.querySelectorAll('h2');
    console.log('✓ Кількість заголовків <h2>:', h2Elements.length);
    
    // Background-color елементу <body>
    const body = document.querySelector('body');
    const bodyBgColor = window.getComputedStyle(body).backgroundColor;
    console.log('✓ Background-color елементу <body>:', bodyBgColor);
    
    // Font-size елементу <h1>
    const h1Element = document.querySelector('h1');
    if (h1Element) {
        const h1FontSize = window.getComputedStyle(h1Element).fontSize;
        console.log('✓ Font-size елементу <h1>:', h1FontSize);
    }
    
    console.log('=== Завдання 1.2 виконано ===\n');
});

// Завдання 1.3: Зміна фону при наведенні миші
document.addEventListener('DOMContentLoaded', function() {
    console.log('=== ЗАВДАННЯ 1.3: Обробники подій ===');
    
    const allElements = document.querySelectorAll('*');
    let handlerCount = 0;
    
    allElements.forEach(function(element) {
        const originalBgColor = window.getComputedStyle(element).backgroundColor;
        
        element.addEventListener('mouseenter', function() {
            this.style.backgroundColor = 'red';
        });
        
        element.addEventListener('mouseleave', function() {
            this.style.backgroundColor = originalBgColor;
        });
        
        handlerCount++;
    });
    
    console.log('✓ Обробники подій додано до', handlerCount, 'елементів');
    console.log('✓ Події: mouseenter, mouseleave');
    console.log('=== Завдання 1.3 виконано ===\n');
});

// Завдання 2: setTimeout та динамічні зображення
let countdownInterval;
let timeLeft = 5;

// Таймер зворотного відліку
document.addEventListener('DOMContentLoaded', function() {
    const countdownDiv = document.getElementById('countdown');
    const timerSpan = document.getElementById('timer');
    
    if (countdownDiv && timerSpan) {
        countdownInterval = setInterval(() => {
            timeLeft--;
            timerSpan.textContent = timeLeft;
            
            if (timeLeft <= 0) {
                clearInterval(countdownInterval);
                countdownDiv.innerHTML = '🎉 Зображення додаються...';
            }
        }, 1000);
    }
});

setTimeout(function() {
    console.log('=== ЗАВДАННЯ 2: Динамічні зображення ===');
    console.log('⏰ Запуск через 5 секунд після завантаження сторінки');
    
    // Масив з URL зображень (використовуємо Picsum Photos - завжди працюють)
    let imagesUrl = [
        "https://picsum.photos/400/300?random=1",
        "https://picsum.photos/400/300?random=2",
        "https://picsum.photos/400/300?random=3",
        "https://picsum.photos/400/300?random=4"
    ];
    
    console.log('📦 Масив зображень:', imagesUrl);
    console.log('📦 Кількість зображень:', imagesUrl.length);
    
    // Знаходимо батьківський елемент (не body)
    const parentElement = document.querySelector('main');
    
    if (parentElement) {
        console.log('✓ Батьківський елемент знайдено:', parentElement.tagName);
        
        // Створюємо контейнер для зображень
        const imagesSection = document.createElement('section');
        imagesSection.className = 'card';
        imagesSection.innerHTML = `
            <div class="card-header">
                <div class="card-icon">🖼️</div>
                <h2>Динамічно додані зображення</h2>
            </div>
            <div class="card-content">
                <div id="dynamicImages" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-top: 1.5rem;"></div>
            </div>
        `;
        
        parentElement.appendChild(imagesSection);
        const imagesGrid = document.getElementById('dynamicImages');
        
        console.log('✓ Контейнер створено');
        console.log('⏳ Завдання з зірочкою: кожне зображення через 1 секунду\n');
        
        // Завдання з зірочкою: кожне зображення з'являється через 1 секунду
        imagesUrl.forEach(function(url, index) {
            setTimeout(function() {
                // Використовуємо createDocumentFragment
                const fragment = document.createDocumentFragment();
                
                const imageWrapper = document.createElement('div');
                imageWrapper.style.cssText = `
                    position: relative;
                    overflow: hidden;
                    border-radius: 12px;
                    box-shadow: 0 4px 15px rgba(0,0,0,0.3);
                    transition: all 0.3s;
                    animation: slideIn 0.5s ease;
                `;
                
                const img = document.createElement('img');
                img.src = url;
                img.alt = `Динамічне зображення ${index + 1}`;
                img.style.cssText = `
                    width: 100%;
                    height: 250px;
                    object-fit: cover;
                    transition: transform 0.3s;
                    display: block;
                `;
                
                const overlay = document.createElement('div');
                overlay.style.cssText = `
                    position: absolute;
                    bottom: 0;
                    left: 0;
                    right: 0;
                    background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
                    padding: 1rem;
                    color: white;
                    font-weight: 600;
                `;
                overlay.textContent = `Зображення #${index + 1}`;
                
                imageWrapper.addEventListener('mouseenter', function() {
                    img.style.transform = 'scale(1.1)';
                    imageWrapper.style.boxShadow = '0 8px 25px rgba(99, 102, 241, 0.4)';
                });
                
                imageWrapper.addEventListener('mouseleave', function() {
                    img.style.transform = 'scale(1)';
                    imageWrapper.style.boxShadow = '0 4px 15px rgba(0,0,0,0.3)';
                });
                
                imageWrapper.appendChild(img);
                imageWrapper.appendChild(overlay);
                fragment.appendChild(imageWrapper);
                imagesGrid.appendChild(fragment);
                
                console.log(`✅ Зображення ${index + 1}/${imagesUrl.length} додано через ${index + 1} секунд`);
                
                if (index === imagesUrl.length - 1) {
                    console.log('🎉 Всі зображення успішно додані!');
                    console.log('=== Завдання 2 виконано ===\n');
                }
            }, (index + 1) * 1000);
        });
        
    } else {
        console.error('❌ Батьківський елемент не знайдено!');
    }
}, 5000);

// Додаємо анімацію для динамічних зображень
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
`;
document.head.appendChild(style);

console.log('✅ Script.js готовий до роботи!\n');
