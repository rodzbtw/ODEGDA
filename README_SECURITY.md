# Методи захисту в додатку - Документація

## 🛡️ Реалізовані методи захисту

### 1. ✅ Параметризовані запити в DB (через PDO)

Всі запити до бази даних використовують **PDO prepared statements** для захисту від SQL ін'єкцій.

**Реалізація в `Database.php`:**

```php
// SELECT запит (авторизація)
$stmt = $pdo->prepare("SELECT id, username, email, password FROM Users WHERE username = :username LIMIT 1");
$stmt->execute([':username' => $username]);

// INSERT запит (реєстрація)
$stmt = $pdo->prepare("INSERT INTO Users (username, email, password) VALUES (:username, :email, :password)");
$stmt->execute([
    ':username' => $username,
    ':email' => $email,
    ':password' => $hashedPassword
]);
```

**Переваги:**
- ✅ Параметри автоматично екрануються
- ✅ Неможливо виконати SQL ін'єкцію
- ✅ Підтримка різних типів даних

### 2. ✅ Захист від XSS через фільтр в формах авторизації

Всі дані з форм фільтруються перед обробкою через клас `Security`.

**Реалізація в `AuthController.php`:**

```php
// Фільтрація username
$username = Security::filterUsername($username);

// Фільтрація email
$email = Security::filterEmail($email);

// Фільтрація password
$password = Security::filterPassword($password);
```

**Методи фільтрації в `Security.php`:**

- `filterInput()` - видаляє HTML теги, обрізає пробіли
- `filterUsername()` - валідація формату username
- `filterEmail()` - валідація та очищення email
- `filterPassword()` - видалення небезпечних символів

**Приклад використання:**
```php
// В формі авторизації
$username = Security::filterUsername($_POST['username']);
if ($username === false) {
    // Невірний формат
}
```

### 3. ✅ Захист від XSS через екранування символів в шаблонах

Всі виводи в шаблонах екрануються через `Security::escape()` або `htmlspecialchars()`.

**Реалізація:**

#### В `index.php` (головний роутер):
```php
require_once __DIR__ . '/src/Classes/Security.php';
use Classes\Security;

$page_title = Security::escape($page_title); // Захист від XSS
```

#### В шаблонах (наприклад `pages/auth.php`):
```php
<title><?php echo Security::escape($page_title); ?></title>

<!-- Або для інших змінних -->
<?php echo Security::escape($result['message']); ?>
```

**Метод `Security::escape()`:**
```php
public static function escape(?string $value, int $flags = ENT_QUOTES | ENT_HTML5, string $encoding = 'UTF-8'): string
{
    if ($value === null) {
        return '';
    }
    return htmlspecialchars($value, $flags, $encoding);
}
```

**Приклад захисту title:**
```php
// Без захисту (небезпечно):
<title><?php echo $page_title; ?></title>

// З захистом (безпечно):
<title><?php echo Security::escape($page_title); ?></title>
```

### 4. ✅ Хешування паролю користувача (bcrypt)

Паролі хешуються через `password_hash()` з алгоритмом `PASSWORD_DEFAULT` (bcrypt).

**Реалізація в `Database.php`:**

```php
// Хешування пароля при створенні користувача
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Перевірка пароля при авторизації
if (password_verify($password, $user['password'])) {
    // Пароль вірний
}
```

**Особливості bcrypt:**
- ✅ Автоматична генерація salt
- ✅ Адаптивний алгоритм (можна змінювати cost)
- ✅ Захист від rainbow tables
- ✅ Повільний алгоритм (захист від brute force)

**Приклад:**
```php
// Хешування
$hash = password_hash('myPassword123', PASSWORD_DEFAULT);
// Результат: $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi

// Перевірка
if (password_verify('myPassword123', $hash)) {
    echo "Пароль вірний!";
}
```

## 📁 Структура файлів

### Класи безпеки:
- **`src/Classes/Security.php`** - методи фільтрації та екранування
- **`src/Classes/AuthController.php`** - обробка форм з захистом
- **`src/Classes/Database.php`** - параметризовані запити та хешування

### Сторінки:
- **`pages/auth.php`** - форма авторизації з захистом
- **`pages/register.php`** - форма реєстрації з захистом

## 🔒 Додаткові методи захисту

### CSRF Protection

```php
// Генерація токену
$csrfToken = Security::generateCsrfToken();

// Перевірка токену
if (!Security::verifyCsrfToken($_POST['csrf_token'])) {
    // Помилка безпеки
}
```

### Валідація даних

```php
// Username: тільки літери, цифри, підкреслення, 3-20 символів
$username = Security::filterUsername($input);

// Email: стандартний формат email
$email = Security::filterEmail($input);

// Password: видалення небезпечних символів
$password = Security::filterPassword($input);
```

## ✅ Перевірка реалізації

### 1. Параметризовані запити:
- ✅ `Database::checkUser()` - використовує prepared statements
- ✅ `Database::createUser()` - використовує prepared statements
- ✅ Всі параметри передаються через `:parameter` синтаксис

### 2. Захист від XSS в формах:
- ✅ `AuthController::handleLogin()` - фільтрує всі вхідні дані
- ✅ `AuthController::handleRegister()` - фільтрує всі вхідні дані
- ✅ Використовується `Security::filterInput()`, `filterUsername()`, `filterEmail()`

### 3. Екранування в шаблонах:
- ✅ `index.php` - екранує `$page_title` через `Security::escape()`
- ✅ `pages/auth.php` - екранує всі виводи
- ✅ `pages/register.php` - екранує всі виводи
- ✅ Всі шаблони використовують `Security::escape()` або `htmlspecialchars()`

### 4. Хешування паролів:
- ✅ `Database::createUser()` - використовує `password_hash($password, PASSWORD_DEFAULT)`
- ✅ `Database::checkUser()` - використовує `password_verify()`
- ✅ PASSWORD_DEFAULT використовує bcrypt алгоритм

## 🧪 Тестування захисту

### Тест SQL ін'єкції:
```sql
-- Спроба ін'єкції (не спрацює через prepared statements)
username: admin' OR '1'='1
password: anything
```

### Тест XSS:
```html
<!-- Спроба XSS (не спрацює через фільтрацію та екранування) -->
<script>alert('XSS')</script>
```

### Тест хешування:
```php
// Пароль зберігається як хеш
$hash = password_hash('test123', PASSWORD_DEFAULT);
// Результат: $2y$10$... (bcrypt формат)
```

## 📚 Посилання

- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
- [PHP Security Best Practices](https://www.php.net/manual/en/security.php)
- [PDO Prepared Statements](https://www.php.net/manual/en/pdo.prepared-statements.php)
- [password_hash() Documentation](https://www.php.net/manual/en/function.password-hash.php)

