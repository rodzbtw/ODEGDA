<?php
/**
 * Сторінка реєстрації
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
$page_title = Security::escape($page_title ?? 'Реєстрація');
$csrfToken = Security::generateCsrfToken();

// Обробка POST запиту
$result = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'register') {
    $result = AuthController::handleRegister();
    
    // Якщо реєстрація успішна, перенаправляємо на авторизацію
    if ($result['success']) {
        header('Location: /auth?message=registration_success');
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

    <?php require_once __DIR__ . '/../partials/nav.php'; renderNav('register'); ?>

    <header class="hero">
        <div class="hero-container">
            <h1 class="hero-title">
                <span class="gradient-text">Реєстрація</span>
                Створення облікового запису
            </h1>
            <p class="hero-subtitle">
                Заповніть форму для створення нового облікового запису
            </p>
        </div>
    </header>

    <main class="container">
        <section class="card">
            <div class="card-header">
                <div class="card-icon">📝</div>
                <h2>Форма реєстрації</h2>
            </div>
            <div class="card-content">
                <?php if ($result): ?>
                    <div class="result <?php echo $result['success'] ? 'show success' : 'show error'; ?>">
                        <?php echo Security::escape($result['message']); ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="/register">
                    <input type="hidden" name="action" value="register">
                    <input type="hidden" name="csrf_token" value="<?php echo Security::escape($csrfToken); ?>">

                    <div class="form-group">
                        <label for="username">
                            <span class="label-icon">👤</span>
                            Username (3-20 символів, тільки літери, цифри, підкреслення):
                        </label>
                        <input 
                            type="text" 
                            id="username" 
                            name="username"
                            placeholder="Введіть username"
                            autocomplete="username"
                            required
                            pattern="[a-zA-Z0-9_]{3,20}"
                            value="<?php echo isset($_POST['username']) ? Security::escape($_POST['username']) : ''; ?>"
                        >
                    </div>

                    <div class="form-group">
                        <label for="email">
                            <span class="label-icon">✉️</span>
                            Email:
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email"
                            placeholder="Введіть email"
                            autocomplete="email"
                            required
                            value="<?php echo isset($_POST['email']) ? Security::escape($_POST['email']) : ''; ?>"
                        >
                    </div>

                    <div class="form-group">
                        <label for="password">
                            <span class="label-icon">🔒</span>
                            Password (мінімум 6 символів):
                        </label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password"
                            placeholder="Введіть password"
                            autocomplete="new-password"
                            required
                            minlength="6"
                        >
                    </div>

                    <div class="form-group">
                        <label for="password_confirm">
                            <span class="label-icon">🔒</span>
                            Підтвердження password:
                        </label>
                        <input 
                            type="password" 
                            id="password_confirm" 
                            name="password_confirm"
                            placeholder="Повторіть password"
                            autocomplete="new-password"
                            required
                            minlength="6"
                        >
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <span class="btn-icon">✓</span>
                        Зареєструватися
                    </button>
                </form>

                <div style="margin-top: 1.5rem; text-align: center;">
                    <p>Вже маєте обліковий запис? <a href="/auth" style="color: var(--primary);">Увійти</a></p>
                </div>
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

