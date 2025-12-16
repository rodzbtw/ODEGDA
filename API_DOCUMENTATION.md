# API Documentation

## Опис всіх API ендпоінтів та маршрутів сайту

### Основні маршрути (GET/POST)

| Метод | Маршрут | Опис | Параметри |
|-------|---------|------|-----------|
| GET | `/` | Головна сторінка | - |
| GET | `/login` | Сторінка входу | - |
| POST | `/login` | Обробка форми входу | `username`, `password` |
| GET | `/logout` | Вихід користувача | - |
| GET | `/aboutme` | Сторінка "Про мене" | - |

### Маршрути завдань (JavaScript)

| Метод | Маршрут | Опис |
|-------|---------|------|
| GET | `/set-task.html` | Завдання 4: Робота з Set/Map |
| GET | `/api-task.html` | Завдання 5: Робота з API |
| GET | `/game.html` | Завдання 6: Canvas гра |

### API ендпоінти

#### Зовнішні API

| API | Опис | Метод |
|-----|------|-------|
| `https://dog.ceo/api/breeds/image/random` | Отримання випадкового фото собаки | GET |

#### Внутрішні API (для майбутнього розширення)

| Метод | Маршрут | Опис | Параметри |
|-------|---------|------|-----------|
| GET | `/api/users` | Отримати всіх користувачів | - |
| GET | `/api/users/{id}` | Отримати користувача за ID | `id` |
| POST | `/api/users` | Створити нового користувача | `username`, `email`, `password` |
| GET | `/api/tasks` | Отримати всі завдання | - |
| POST | `/api/tasks` | Створити нове завдання | `title`, `description`, `user_id` |
| GET | `/api/tasks/{id}` | Отримати завдання за ID | `id` |
| PUT | `/api/tasks/{id}` | Оновити завдання | `id`, `title`, `description` |
| DELETE | `/api/tasks/{id}` | Видалити завдання | `id` |

### Структура MVC

#### Models (Моделі)
- `User` - модель користувача
- `MyModel` - модель завдань
- `Database` - робота з базою даних

#### Views (Представлення)
- `home.latte` - головна сторінка
- `login.latte` - форма входу
- `error*.latte` - сторінки помилок

#### Controllers (Контролери)
- `HomePageController` - головна сторінка
- `LoginController` - авторизація
- `ErrorController` - обробка помилок
- `AboutMeController` - сторінка "Про мене"

### Безпека

- **Параметризовані запити**: всі SQL запити через PDO prepared statements
- **Захист від XSS**: фільтрація вхідних даних через `Security::escape()`
- **Хешування паролів**: використання `password_hash()` з `PASSWORD_DEFAULT`
- **CSRF захист**: генерація та перевірка CSRF токенів

### База даних

#### Таблиця Users
```sql
CREATE TABLE Users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

#### Таблиця Tasks
```sql
CREATE TABLE Tasks (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    user_id INTEGER,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME,
    FOREIGN KEY (user_id) REFERENCES Users(id)
);
```

### Приклади використання API

#### Авторизація
```javascript
// POST /login
fetch('/login', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: 'username=admin&password=password'
})
.then(response => response.text())
.then(data => console.log(data));
```

#### Робота з зовнішнім API
```javascript
// Отримання фото собаки
async function getDogImage() {
    const response = await fetch('https://dog.ceo/api/breeds/image/random');
    const data = await response.json();
    
    if (data.status === 'success') {
        document.getElementById('dogImage').src = data.message;
    }
}
```

### Коди відповідей

| Код | Опис |
|-----|------|
| 200 | OK |
| 302 | Redirect (після входу/виходу) |
| 404 | Not Found |
| 403 | Forbidden |
| 500 | Internal Server Error |

---

**Версія API**: 1.0  
**Останнє оновлення**: 2024
