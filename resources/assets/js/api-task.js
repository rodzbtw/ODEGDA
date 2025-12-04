console.log('=== ЗАВДАННЯ 5: Робота з API та асинхронні функції ===\n');

// Статистика запитів
let stats = {
    total: 0,
    success: 0,
    errors: 0
};

/**
 * АСИНХРОННА ФУНКЦІЯ для отримання випадкового фото собаки
 * Використовує: async/await, fetch, try/catch, promises
 */
async function fetchRandomDog() {
    console.log('\n🚀 Початок запиту до Dog CEO API...');
    
    // Показуємо індикатор завантаження
    showLoading();
    
    // URL API (без авторизації)
    const API_URL = 'https://dog.ceo/api/breeds/image/random';
    
    try {
        console.log('📡 Виконуємо fetch запит:', API_URL);
        
        // Асинхронний запит до API
        const response = await fetch(API_URL);
        
        console.log('📥 Отримано відповідь від сервера');
        console.log('Статус:', response.status, response.statusText);
        
        // Перевіряємо чи запит успішний
        if (!response.ok) {
            throw new Error(`HTTP помилка! Статус: ${response.status}`);
        }
        
        // Парсимо JSON (теж асинхронна операція)
        const data = await response.json();
        
        console.log('✅ Дані успішно отримані:', data);
        
        // Перевіряємо статус відповіді API
        if (data.status === 'success') {
            // Відображаємо зображення
            displayDogImage(data.message);
            
            // Оновлюємо статистику
            stats.success++;
            stats.total++;
            updateStats();
            
            console.log('🎉 Зображення успішно відображено!');
        } else {
            throw new Error('API повернуло невдалий статус');
        }
        
    } catch (error) {
        // Обробка помилок
        console.error('❌ Помилка при запиті до API:', error);
        console.error('Деталі помилки:', error.message);
        
        // Показуємо повідомлення про помилку
        showError(error.message);
        
        // Оновлюємо статистику
        stats.errors++;
        stats.total++;
        updateStats();
        
    } finally {
        // Ховаємо індикатор завантаження в будь-якому випадку
        hideLoading();
        console.log('🏁 Запит завершено\n');
    }
}

/**
 * АСИНХРОННА ФУНКЦІЯ для отримання кількох фото
 * Демонструє роботу з Promise.all()
 */
async function fetchMultipleDogs() {
    console.log('\n🚀 Запит на отримання 3 собак одночасно...');
    
    showLoading();
    
    const API_URL = 'https://dog.ceo/api/breeds/image/random';
    
    try {
        console.log('📡 Створюємо 3 паралельних запити...');
        
        // Створюємо масив промісів
        const promises = [
            fetch(API_URL),
            fetch(API_URL),
            fetch(API_URL)
        ];
        
        console.log('⏳ Чекаємо на всі промісі (Promise.all)...');
        
        // Чекаємо на всі запити одночасно
        const responses = await Promise.all(promises);
        
        console.log('📥 Всі відповіді отримані!');
        
        // Парсимо всі відповіді
        const dataPromises = responses.map(response => {
            if (!response.ok) {
                throw new Error(`HTTP помилка! Статус: ${response.status}`);
            }
            return response.json();
        });
        
        const allData = await Promise.all(dataPromises);
        
        console.log('✅ Всі дані отримані:', allData);
        
        // Очищаємо попередні результати
        document.getElementById('results').innerHTML = '';
        
        // Відображаємо всі зображення
        allData.forEach((data, index) => {
            if (data.status === 'success') {
                displayDogImage(data.message, index + 1);
            }
        });
        
        // Оновлюємо статистику
        stats.success += allData.length;
        stats.total += allData.length;
        updateStats();
        
        console.log('🎉 Всі зображення успішно відображені!');
        
    } catch (error) {
        console.error('❌ Помилка при множинному запиті:', error);
        showError(error.message);
        
        stats.errors++;
        stats.total++;
        updateStats();
        
    } finally {
        hideLoading();
        console.log('🏁 Множинний запит завершено\n');
    }
}

/**
 * Функція для відображення зображення собаки
 */
function displayDogImage(imageUrl, number = null) {
    const resultsDiv = document.getElementById('results');
    
    // Отримуємо породу з URL (якщо можливо)
    const urlParts = imageUrl.split('/');
    const breed = urlParts[urlParts.length - 2] || 'Unknown breed';
    const breedName = breed.charAt(0).toUpperCase() + breed.slice(1);
    
    // Створюємо картку з зображенням
    const dogCard = document.createElement('div');
    dogCard.className = 'dog-card';
    dogCard.innerHTML = `
        <div class="dog-image-container">
            <img src="${imageUrl}" alt="${breedName}" class="dog-image" loading="lazy">
        </div>
        <div class="dog-info">
            <h3 class="dog-breed">${number ? `#${number} - ` : ''}${breedName}</h3>
            <p class="dog-timestamp">Завантажено: ${new Date().toLocaleTimeString('uk-UA')}</p>
            <button class="btn download-btn" onclick="downloadImage('${imageUrl}', '${breedName}')">
                <span class="btn-icon">⬇️</span>
                Завантажити фото
            </button>
        </div>
    `;
    
    resultsDiv.appendChild(dogCard);
    
    console.log(`🖼️ Додано зображення: ${breedName}`);
}

/**
 * Показати індикатор завантаження
 */
function showLoading() {
    document.getElementById('loading').classList.add('show');
}

/**
 * Сховати індикатор завантаження
 */
function hideLoading() {
    document.getElementById('loading').classList.remove('show');
}

/**
 * Показати повідомлення про помилку
 */
function showError(message) {
    const resultsDiv = document.getElementById('results');
    resultsDiv.innerHTML = `
        <div class="error-message">
            <div class="error-icon">⚠️</div>
            <h3>Виникла помилка</h3>
            <p>${message}</p>
            <p style="margin-top: 1rem; font-size: 0.9rem; opacity: 0.8;">
                Спробуйте ще раз або перевірте підключення до інтернету
            </p>
        </div>
    `;
}

/**
 * Очистити результати
 */
function clearResults() {
    document.getElementById('results').innerHTML = '';
    console.log('🧹 Результати очищено');
}

/**
 * Оновити статистику
 */
function updateStats() {
    const statsDiv = document.getElementById('stats');
    statsDiv.style.display = 'grid';
    
    document.getElementById('totalRequests').textContent = stats.total;
    document.getElementById('successRequests').textContent = stats.success;
    document.getElementById('errorRequests').textContent = stats.errors;
    
    console.log('📊 Статистика оновлена:', stats);
}

/**
 * Завантажити зображення
 */
async function downloadImage(url, name) {
    try {
        console.log('⬇️ Завантаження зображення:', url);
        
        const response = await fetch(url);
        const blob = await response.blob();
        const blobUrl = window.URL.createObjectURL(blob);
        
        const link = document.createElement('a');
        link.href = blobUrl;
        link.download = `${name}-${Date.now()}.jpg`;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        
        window.URL.revokeObjectURL(blobUrl);
        
        console.log('✅ Зображення завантажено');
    } catch (error) {
        console.error('❌ Помилка завантаження:', error);
        alert('Не вдалося завантажити зображення');
    }
}

/**
 * Копіювати текст в буфер обміну
 */
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        console.log('📋 Скопійовано в буфер:', text);
        
        // Показуємо повідомлення
        const btn = event.target;
        const originalText = btn.textContent;
        btn.textContent = '✓ Скопійовано!';
        btn.style.background = 'var(--success)';
        btn.style.color = 'white';
        btn.style.borderColor = 'var(--success)';
        
        setTimeout(() => {
            btn.textContent = originalText;
            btn.style.background = '';
            btn.style.color = '';
            btn.style.borderColor = '';
        }, 2000);
    }).catch(err => {
        console.error('❌ Помилка копіювання:', err);
    });
}

// Демонстрація різних способів роботи з промісами
console.log('📚 Демонстрація концепцій JavaScript:\n');

// 1. Promise
console.log('1️⃣ Promise приклад:');
const simplePromise = new Promise((resolve, reject) => {
    setTimeout(() => resolve('Promise виконано!'), 1000);
});
console.log('Promise створено:', simplePromise);

// 2. Async/Await
console.log('\n2️⃣ Async/Await - функція автоматично повертає Promise');

// 3. Fetch
console.log('\n3️⃣ Fetch API - сучасний спосіб HTTP запитів');
console.log('Замість XMLHttpRequest використовуємо fetch()');

// 4. Try/Catch
console.log('\n4️⃣ Try/Catch - обробка помилок в async функціях');
console.log('Без try/catch помилки можуть "проковзнути"\n');

console.log('✅ API Task готовий до роботи!');
console.log('💡 Натисніть кнопку щоб отримати собаку з API\n');


