console.log('Script.js загружен успешно!');

document.addEventListener('DOMContentLoaded', function() {
    const paragraphs = document.querySelectorAll('p');
    console.log('Количество параграфов <p>:', paragraphs.length);
    
    const h2Elements = document.querySelectorAll('h2');
    console.log('Количество заголовков <h2>:', h2Elements.length);
    
    const body = document.querySelector('body');
    const bodyBgColor = window.getComputedStyle(body).backgroundColor;
    console.log('Background-color элемента <body>:', bodyBgColor);
    
    const h1Element = document.querySelector('h1');
    if (h1Element) {
        const h1FontSize = window.getComputedStyle(h1Element).fontSize;
        console.log('Font-size элемента <h1>:', h1FontSize);
    } else {
        console.log('Элемент <h1> не найден на странице');
    }
    
    console.log('Добавление обработчиков событий для изменения фона...');
    
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
    
    console.log('Обработчики событий успешно добавлены ко всем элементам!');
});

setTimeout(function() {
    console.log('Запуск функции добавления изображений через 5 секунд...');
    
    let imagesUrl = [
        "https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=400&q=80",
        "https://images.unsplash.com/photo-1571945153237-4929e783af4a?auto=format&fit=crop&w=400&q=80",
        "https://images.unsplash.com/photo-1555966523-caa5b5ca1414?auto=format&fit=crop&w=400&q=80",
        "https://images.unsplash.com/photo-1517466787929-bc90951d0974?auto=format&fit=crop&w=400&q=80",
        "https://images.unsplash.com/photo-1556906781-9a412961c28c?auto=format&fit=crop&w=400&q=80"
    ];
    
    const fragment = document.createDocumentFragment();
    
    const parentElement = document.querySelector('.featured');
    
    if (parentElement) {
        console.log('Родительский элемент найден:', parentElement);
        
        const imagesContainer = document.createElement('div');
        imagesContainer.className = 'dynamic-images';
        imagesContainer.style.cssText = `
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
        `;
        
        const title = document.createElement('h3');
        title.textContent = 'Динамически добавленные изображения:';
        title.style.cssText = `
            width: 100%;
            margin-bottom: 20px;
            color: #333;
            font-size: 1.5rem;
        `;
        imagesContainer.appendChild(title);
        
        imagesUrl.forEach(function(url, index) {
            setTimeout(function() {
                const img = document.createElement('img');
                img.src = url;
                img.alt = `Динамическое изображение ${index + 1}`;
                img.style.cssText = `
                    width: 200px;
                    height: 200px;
                    object-fit: cover;
                    border-radius: 10px;
                    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
                    transition: transform 0.3s ease;
                `;
                
                img.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.05)';
                });
                
                img.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                });
                
                imagesContainer.appendChild(img);
                
                console.log(`Изображение ${index + 1} добавлено через ${index + 1} секунд`);
                
                if (index === imagesUrl.length - 1) {
                    parentElement.appendChild(imagesContainer);
                    console.log('Все изображения успешно добавлены!');
                }
            }, (index + 1) * 1000);
        });
        
    } else {
        console.error('Родительский элемент .featured не найден!');
    }
    
}, 5000);