# 📚 Документація API та Routes

## 🌐 Огляд проекту

Цей проект є навчальним веб-сайтом з JavaScript завданнями, що демонструє роботу з DOM, подіями, регулярними виразами, Set/Map, API та Canvas.

---

## 📄 Routes (Маршрути сторінок)

| Маршрут | Файл | Опис | Функціональність |
|---------|------|------|------------------|
| `/HTML/index.html` | `index.html` | Головна сторінка | Підрахунок елементів DOM, обробка подій, динамічні зображення |
| `/HTML/login.html` | `login.html` | Завдання 3: Валідація | Регулярні вирази для валідації login, email, phone |
| `/HTML/set-task.html` | `set-task.html` | Завдання 4: Set/Map | Пошук спільних слів між фразами використовуючи Set |
| `/HTML/api-task.html` | `api-task.html` | Завдання 5: API | Робота з зовнішніми API, async/await, fetch |
| `/HTML/game.html` | `game.html` | Завдання 6: Canvas Гра | Космічна гра з Canvas API |

---

## 🔌 Зовнішні API Endpoints

### 1. Dog CEO API

#### Отримати випадкове фото собаки
- **URL:** `https://dog.ceo/api/breeds/image/random`
- **Метод:** `GET`
- **Опис:** Повертає випадкове зображення собаки
- **Авторизація:** Не потрібна
- **Використання:** Використовується в `scripts/api-task.js`
- **Приклад відповіді:**
```json
{
  "status": "success",
  "message": "https://images.dog.ceo/breeds/hound-afghan/n02088094_1003.jpg"
}
```

**Документація:** [Dog CEO API Documentation](https://dog.ceo/dog-api/)

---

### 2. Picsum Photos API

#### Отримати випадкове зображення
- **URL:** `https://picsum.photos/400/300?random={number}`
- **Метод:** `GET`
- **Параметри:**
  - `400` - ширина зображення
  - `300` - висота зображення
  - `random={number}` - унікальний ідентифікатор для різних зображень
- **Опис:** Повертає випадкове зображення з Lorem Picsum
- **Авторизація:** Не потрібна
- **Використання:** Використовується в `scripts/script.js` для динамічного додавання зображень
- **Приклад використання:**
  - `https://picsum.photos/400/300?random=1`
  - `https://picsum.photos/400/300?random=2`
  - `https://picsum.photos/400/300?random=3`
  - `https://picsum.photos/400/300?random=4`

**Документація:** [Picsum Photos API](https://picsum.photos/)

---

## 🎯 JavaScript Функції (Внутрішні "Endpoints")

### API Task (`scripts/api-task.js`)

| Функція | Опис | Параметри | Повертає |
|---------|------|-----------|----------|
| `fetchRandomDog()` | Отримує випадкове фото собаки з API | - | `Promise<void>` |
| `fetchMultipleDogs()` | Отримує 3 фото собак одночасно (Promise.all) | - | `Promise<void>` |
| `displayDogImage(imageUrl, number)` | Відображає зображення собаки на сторінці | `imageUrl: string`, `number?: number` | `void` |
| `downloadImage(url, name)` | Завантажує зображення на пристрій | `url: string`, `name: string` | `Promise<void>` |
| `clearResults()` | Очищає результати на сторінці | - | `void` |
| `copyToClipboard(text)` | Копіює текст в буфер обміну | `text: string` | `Promise<void>` |
| `showLoading()` | Показує індикатор завантаження | - | `void` |
| `hideLoading()` | Ховає індикатор завантаження | - | `void` |
| `showError(message)` | Показує повідомлення про помилку | `message: string` | `void` |
| `updateStats()` | Оновлює статистику запитів | - | `void` |

---

### Login/Validation (`scripts/login.js`)

| Функція | Опис | Параметри | Повертає |
|---------|------|-----------|----------|
| `validateLogin(login)` | Валідує login за допомогою regex | `login: string` | `boolean` |
| `validateEmail(email)` | Валідує email за допомогою regex | `email: string` | `boolean` |
| `validatePhone(phone)` | Валідує телефон за допомогою regex | `phone: string` | `boolean` |
| `cleanLogin(login)` | Очищає login від недозволених символів | `login: string` | `string` |
| `validateAll()` | Перевіряє всі поля форми | - | `void` |

**Регулярні вирази:**
- **Login:** `/^[a-zA-Z0-9_]{3,20}$/`
- **Email:** `/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/`
- **Phone:** `/^[\+]?[1-9][\d]{0,15}$/`

---

### Set Task (`scripts/set-task.js`)

| Функція | Опис | Параметри | Повертає |
|---------|------|-----------|----------|
| `findCommonWords()` | Знаходить спільні слова між двома фразами | - | `void` |
| `getWordsSet(phrase)` | Створює Set зі слів фрази | `phrase: string` | `Set<string>` |
| `normalizeText(text)` | Нормалізує текст (видаляє пунктуацію) | `text: string` | `string` |
| `displayResults(phrase1, phrase2, commonWordsSet)` | Відображає результати аналізу | `phrase1: string`, `phrase2: string`, `commonWordsSet: Set<string>` | `void` |
| `clearAll()` | Очищає поля вводу та результати | - | `void` |

---

### Game (`scripts/game.js`)

| Функція | Опис | Параметри | Повертає |
|---------|------|-----------|----------|
| `startGame()` | Починає гру | - | `void` |
| `togglePause()` | Ставить гру на паузу/продовжує | - | `void` |
| `restartGame()` | Перезапускає гру | - | `void` |
| `gameOver()` | Завершує гру та показує екран програшу | - | `void` |
| `gameLoop()` | Головний ігровий цикл (requestAnimationFrame) | - | `void` |
| `drawPlayer()` | Малює ракету гравця на canvas | - | `void` |
| `drawObstacle(obstacle)` | Малює перешкоду (астероїд) | `obstacle: Object` | `void` |
| `drawStar(star)` | Малює зірку (бонус) | `star: Object` | `void` |
| `checkCollisions()` | Перевіряє колізії між гравцем та об'єктами | - | `void` |
| `updatePlayer()` | Оновлює позицію гравця | - | `void` |
| `updateObstacles()` | Оновлює перешкоди | - | `void` |
| `updateStars()` | Оновлює зірки | - | `void` |

**LocalStorage:**
- `spaceGameHighScore` - зберігає рекорд гри

---

### Main Script (`scripts/script.js`)

| Функція | Опис | Параметри | Повертає |
|---------|------|-----------|----------|
| DOM підрахунок | Автоматично підраховує елементи при завантаженні | - | `void` |
| Обробники подій | Додає mouseenter/mouseleave до всіх елементів | - | `void` |
| Динамічні зображення | Додає зображення через 5 секунд після завантаження | - | `void` |

---

## 📊 Статистика API використання

Проект відстежує статистику запитів до API:
- **Всього запитів:** Загальна кількість виконаних запитів
- **Успішних:** Кількість успішних запитів
- **Помилок:** Кількість невдалих запитів

---

## 🔗 Посилання на документацію

### Swagger
- **Swagger.io:** [https://swagger.io/](https://swagger.io/)
- **Swagger Editor:** [https://editor.swagger.io/](https://editor.swagger.io/)
- **Swagger UI:** [https://swagger.io/tools/swagger-ui/](https://swagger.io/tools/swagger-ui/)

### Зовнішні API
- **Dog CEO API:** [https://dog.ceo/dog-api/](https://dog.ceo/dog-api/)
- **Picsum Photos:** [https://picsum.photos/](https://picsum.photos/)

### JavaScript Документація
- **MDN Web Docs:** [https://developer.mozilla.org/](https://developer.mozilla.org/)
- **Fetch API:** [https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API](https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API)
- **Async/Await:** [https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Statements/async_function](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Statements/async_function)
- **Canvas API:** [https://developer.mozilla.org/en-US/docs/Web/API/Canvas_API](https://developer.mozilla.org/en-US/docs/Web/API/Canvas_API)

---

## 📝 Приклади використання

### Приклад 1: Отримання випадкового фото собаки

```javascript
async function fetchRandomDog() {
    try {
        const response = await fetch('https://dog.ceo/api/breeds/image/random');
        const data = await response.json();
        
        if (data.status === 'success') {
            console.log('Зображення:', data.message);
        }
    } catch (error) {
        console.error('Помилка:', error);
    }
}
```

### Приклад 2: Множинні запити (Promise.all)

```javascript
async function fetchMultipleDogs() {
    const promises = [
        fetch('https://dog.ceo/api/breeds/image/random'),
        fetch('https://dog.ceo/api/breeds/image/random'),
        fetch('https://dog.ceo/api/breeds/image/random')
    ];
    
    const responses = await Promise.all(promises);
    const data = await Promise.all(responses.map(r => r.json()));
    console.log('Всі зображення:', data);
}
```

### Приклад 3: Валідація email

```javascript
const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
const isValid = emailRegex.test('user@example.com'); // true
```

---

## 🛠️ Технології

- **HTML5** - структура сторінок
- **CSS3** - стилізація
- **JavaScript (ES6+)** - логіка та API запити
- **Fetch API** - HTTP запити
- **Canvas API** - малювання в грі
- **LocalStorage** - збереження даних
- **Regular Expressions** - валідація даних

---

## 📅 Версія документації

**Версія:** 1.0  
**Дата створення:** 2024  
**Останнє оновлення:** 2024

---

## 👤 Автор

JavaScript Course Tasks Project

---

## 📄 Ліцензія

Цей проект створено в навчальних цілях.

