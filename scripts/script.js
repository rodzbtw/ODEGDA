// Script.js - код для выполнения заданий
console.log('Script.js загружен успешно!');

// Задание 3: Подсчет элементов и вывод в консоль
document.addEventListener('DOMContentLoaded', function() {
    // Количество параграфов <p> на странице
    const paragraphs = document.querySelectorAll('p');
    console.log('Количество параграфов <p>:', paragraphs.length);
    
    // Количество заголовков <h2> на странице
    const h2Elements = document.querySelectorAll('h2');
    console.log('Количество заголовков <h2>:', h2Elements.length);
    
    // Значение background-color элемента <body>
    const body = document.querySelector('body');
    const bodyBgColor = window.getComputedStyle(body).backgroundColor;
    console.log('Background-color элемента <body>:', bodyBgColor);
    
    // Значение font-size элемента <h1>
    const h1Element = document.querySelector('h1');
    if (h1Element) {
        const h1FontSize = window.getComputedStyle(h1Element).fontSize;
        console.log('Font-size элемента <h1>:', h1FontSize);
    } else {
        console.log('Элемент <h1> не найден на странице');
    }
    
    // Задание 4: Обработчики событий для изменения фона элементов
    console.log('Добавление обработчиков событий для изменения фона...');
    
    // Получаем все элементы на странице
    const allElements = document.querySelectorAll('*');
    
    allElements.forEach(function(element) {
        // Сохраняем оригинальный цвет фона
        const originalBgColor = window.getComputedStyle(element).backgroundColor;
        
        // Обработчик события onmouseenter - меняем фон на красный
        element.addEventListener('mouseenter', function() {
            this.style.backgroundColor = 'red';
        });
        
        // Обработчик события onmouseleave - возвращаем оригинальный цвет
        element.addEventListener('mouseleave', function() {
            this.style.backgroundColor = originalBgColor;
        });
    });
    
    console.log('Обработчики событий успешно добавлены ко всем элементам!');
});