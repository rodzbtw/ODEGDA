console.log('Script.js завантажено успішно!');

// Завдання 1.2: Підрахунок елементів
document.addEventListener('DOMContentLoaded', function() {
    console.log('=== ЗАВДАННЯ 1.2: Підрахунок елементів ===');
    
    // Кількість параграфів <p>
    const paragraphs = document.querySelectorAll('p');
    console.log('Кількість параграфів <p>:', paragraphs.length);
    
    // Кількість заголовків <h2>
    const h2Elements = document.querySelectorAll('h2');
    console.log('Кількість заголовків <h2>:', h2Elements.length);
    
    // Background-color елементу <body>
    const body = document.querySelector('body');
    const bodyBgColor = window.getComputedStyle(body).backgroundColor;
    console.log('Background-color елементу <body>:', bodyBgColor);
    
    // Font-size елементу <h1>
    const h1Element = document.querySelector('h1');
    if (h1Element) {
        const h1FontSize = window.getComputedStyle(h1Element).fontSize;
        console.log('Font-size елементу <h1>:', h1FontSize);
    }
    
    console.log('=== Завдання 1.2 виконано ===\n');
});

// Завдання 1.3: Зміна фону при наведенні миші
document.addEventListener('DOMContentLoaded', function() {
    console.log('=== ЗАВДАННЯ 1.3: Обробники подій ===');
    
    const allElements = document.querySelectorAll('*');
    
    allElements.forEach(function(element) {
        const originalBgColor = window.getComputedStyle(element).backgroundColor;
        
        element.addEventListener('mouseenter', function() {
            this.style.backgroundColor = 'red';
        });
        
        element.addEventListener('mouseleave', function() {
            this.style.backgroundColor = originalBgColor;
        });
    });
    
    console.log('Обробники подій додано до', allElements.length, 'елементів');
    console.log('=== Завдання 1.3 виконано ===\n');
});

// Завдання 2: setTimeout та динамічні зображення
setTimeout(function() {
    console.log('=== ЗАВДАННЯ 2: Динамічні зображення ===');
    console.log('Запуск через 5 секунд після завантаження сторінки');
    
    // Масив з URL зображень
    let imagesUrl = [
        "https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=300&q=80",
        "https://images.unsplash.com/photo-1571945153237-4929e783af4a?auto=format&fit=crop&w=300&q=80",
        "https://images.unsplash.com/photo-1555966523-caa5b5ca1414?auto=format&fit=crop&w=300&q=80",
        "https://images.unsplash.com/photo-1517466787929-bc90951d0974?auto=format&fit=crop&w=300&q=80"
    ];
    
    console.log('Масив зображень:', imagesUrl);
    
    // Знаходимо батьківський елемент (не body)
    const parentElement = document.querySelector('main');
    
    if (parentElement) {
        // Створюємо контейнер для зображень
        const imagesContainer = document.createElement('section');
        imagesContainer.style.cssText = `
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid #667eea;
            margin-top: 20px;
        `;
        
        const title = document.createElement('h2');
        title.textContent = '📸 Динамічно додані зображення';
        title.style.cssText = 'color: #667eea; margin-bottom: 15px;';
        imagesContainer.appendChild(title);
        
        const imagesGrid = document.createElement('div');
        imagesGrid.style.cssText = `
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 15px;
        `;
        
        // Завдання з зірочкою: кожне зображення з'являється через 1 секунду
        imagesUrl.forEach(function(url, index) {
            setTimeout(function() {
                // Використовуємо createDocumentFragment
                const fragment = document.createDocumentFragment();
                
                const img = document.createElement('img');
                img.src = url;
                img.alt = `Зображення ${index + 1}`;
                img.style.cssText = `
                    width: 100%;
                    height: 200px;
                    object-fit: cover;
                    border-radius: 8px;
                    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
                    transition: transform 0.3s;
                `;
                
                img.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.05)';
                });
                
                img.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                });
                
                fragment.appendChild(img);
                imagesGrid.appendChild(fragment);
                
                console.log(`✅ Зображення ${index + 1} додано через ${index + 1} секунд`);
                
                if (index === 0) {
                    imagesContainer.appendChild(imagesGrid);
                    parentElement.appendChild(imagesContainer);
                }
            }, (index + 1) * 1000);
        });
        
        console.log('=== Завдання 2 виконано ===\n');
    } else {
        console.error('Батьківський елемент не знайдено!');
    }
}, 5000);
