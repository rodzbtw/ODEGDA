<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <link rel="stylesheet" href="/resources/assets/css/auth.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <div class="stars"></div>
    <div class="stars2"></div>
    <div class="stars3"></div>

    <?php require_once __DIR__ . '/../partials/nav.php'; renderNav('login'); ?>

    <header class="hero">
        <div class="hero-container">
            <h1 class="hero-title">
                <span class="gradient-text">Завдання 3</span>
                Регулярні вирази та валідація
            </h1>
            <p class="hero-subtitle">
                Перевірка даних за допомогою RegExp, методів match/search та replace
            </p>
        </div>
    </header>

    <main class="container">
        <section class="card">
            <div class="card-header">
                <div class="card-icon">🔐</div>
                <h2>Форма валідації даних</h2>
            </div>
            <div class="card-content">
                <p>Введіть дані для автоматичної валідації регулярними виразами</p>

                <form id="validationForm">
                    <div class="form-group">
                        <label for="login">
                            <span class="label-icon">👤</span>
                            Login (літери, цифри, підкреслення):
                        </label>
                        <input 
                            type="text" 
                            id="login" 
                            name="login"
                            placeholder="Введіть login (наприклад: user_123)"
                            autocomplete="off"
                        >
                        <span class="help-text">✓ Від 3 до 20 символів | ✓ Автоматичне очищення (replace)</span>
                    </div>

                    <div class="form-group">
                        <label for="email">
                            <span class="label-icon">✉️</span>
                            Email адреса:
                        </label>
                        <input 
                            type="email" 
                            id="email"
                            placeholder="Введіть email (example@mail.com)"
                            autocomplete="off"
                        >
                        <span class="help-text">✓ Правильний формат email@domain.com</span>
                    </div>

                    <div class="form-group">
                        <label for="phone">
                            <span class="label-icon">📱</span>
                            Телефон:
                        </label>
                        <input 
                            type="tel" 
                            id="phone"
                            placeholder="Введіть телефон (наприклад: +380123456789)"
                            autocomplete="off"
                        >
                        <span class="help-text">✓ Може починатися з + | ✓ Тільки цифри</span>
                    </div>

                    <button type="button" class="btn btn-primary" onclick="validateAll()">
                        <span class="btn-icon">✓</span>
                        Перевірити всі поля
                    </button>
                </form>

                <div class="result" id="result"></div>
            </div>
        </section>

        <section class="card">
            <div class="card-header">
                <div class="card-icon">📚</div>
                <h2>Використані регулярні вирази</h2>
            </div>
            <div class="card-content">
                <div class="regex-item">
                    <h3>Login:</h3>
                    <code class="regex-code">/^[a-zA-Z0-9_]{3,20}$/</code>
                    <p>Літери, цифри та підкреслення, від 3 до 20 символів</p>
                </div>

                <div class="regex-item">
                    <h3>Email:</h3>
                    <code class="regex-code">/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/</code>
                    <p>Стандартний формат електронної пошти</p>
                </div>

                <div class="regex-item">
                    <h3>Phone:</h3>
                    <code class="regex-code">/^[\+]?[1-9][\d]{0,15}$/</code>
                    <p>Опціональний +, починається з цифри 1-9</p>
                </div>

                <div class="methods-info">
                    <h3>Методи:</h3>
                    <ul class="methods-list">
                        <li><code>test()</code> / <code>match()</code> - перевірка на відповідність</li>
                        <li><code>replace()</code> - заміна недозволених символів</li>
                        <li><code>search()</code> - пошук відповідності в рядку</li>
                    </ul>
                </div>

                <div class="info-box">
                    💡 Відкрийте консоль (F12) щоб побачити детальні логи валідації
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="footer-content">
            <p>© 2024 JavaScript Course Tasks</p>
            <p class="footer-links">
                <a href="/">Назад до головної</a>
                <span>•</span>
                <a href="/set-task">Наступне завдання →</a>
            </p>
        </div>
    </footer>

    <script src="/resources/assets/js/login.js"></script>
</body>
</html>

