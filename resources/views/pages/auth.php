<?php
/**
 * Сторінка авторизації
 * 
 * Використовує Security::escape() для захисту від XSS
 * при виведенні змінної $page_title та інших даних.
 */

// Запускаємо сесію для CSRF токенів
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../app/Classes/Security.php';
require_once __DIR__ . '/../../app/Classes/AuthController.php';

use Classes\Security;
use Classes\AuthController;

// Встановлюємо title з екрануванням (захист від XSS)
$page_title = Security::escape($page_title ?? 'Авторизація');
$csrfToken = Security::generateCsrfToken();

// Обробка POST запиту
$result = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    $result = AuthController::handleLogin();
    
    // Якщо авторизація успішна, перенаправляємо
    if ($result['success']) {
        header('Location: /?message=login_success');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="/resources/assets/css/auth.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <div class="stars"></div>
    <div class="stars2"></div>
    <div class="stars3"></div>

    <?php require_once __DIR__ . '/../partials/nav.php'; renderNav('auth'); ?>

    <header class="hero">
        <div class="hero-container">
            <h1 class="hero-title">
                <span class="gradient-text">Авторизація</span>
                Вхід в систему
            </h1>
            <p class="hero-subtitle">
                Введіть ваші облікові дані для входу
            </p>
        </div>
    </header>

    <main class="container">
        <section class="card">
            <div class="card-header">
                <div class="card-icon">🔐</div>
                <h2>Форма авторизації</h2>
            </div>
            <div class="card-content">
                <?php if ($result): ?>
                    <div class="result <?php echo $result['success'] ? 'show success' : 'show error'; ?>">
                        <?php echo Security::escape($result['message']); ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="/auth">
                    <input type="hidden" name="action" value="login">
                    <input type="hidden" name="csrf_token" value="<?php echo Security::escape($csrfToken); ?>">

                    <div class="form-group">
                        <label for="username">
                            <span class="label-icon">👤</span>
                            Username:
                        </label>
                        <input 
                            type="text" 
                            id="username" 
                            name="username"
                            placeholder="Введіть username"
                            autocomplete="username"
                            required
                            value="<?php echo isset($_POST['username']) ? Security::escape($_POST['username']) : ''; ?>"
                        >
                    </div>

                    <div class="form-group">
                        <label for="password">
                            <span class="label-icon">🔒</span>
                            Password:
                        </label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password"
                            placeholder="Введіть password"
                            autocomplete="current-password"
                            required
                        >
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <span class="btn-icon">✓</span>
                        Увійти
                    </button>
                </form>

                <div style="margin-top: 1.5rem; text-align: center;">
                    <p>Немає облікового запису? <a href="/register" style="color: var(--primary);">Зареєструватися</a></p>
                </div>
            </div>
        </section>

        <section class="card">
            <div class="card-header">
                <div class="card-icon">🛡️</div>
                <h2>Захист від атак</h2>
            </div>
            <div class="card-content">
                <ul class="feature-list">
                    <li>✅ <strong>Параметризовані запити</strong> - використання PDO prepared statements</li>
                    <li>✅ <strong>Захист від XSS</strong> - фільтрація вхідних даних та екранування виводу</li>
                    <li>✅ <strong>Хешування паролів</strong> - bcrypt через password_hash()</li>
                    <li>✅ <strong>CSRF захист</strong> - перевірка токенів для всіх форм</li>
                </ul>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="footer-content">
            <p>© 2024 JavaScript Course Tasks</p>
            <p class="footer-links">
                <a href="/">Назад до головної</a>
            </p>
        </div>
    </footer>
</body>
</html>

