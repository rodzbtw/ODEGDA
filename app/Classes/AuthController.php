<?php

namespace Classes;

use Classes\Database;
use Classes\Security;

/**
 * Контролер для обробки авторизації та реєстрації
 * 
 * Обробляє форми авторизації та реєстрації з захистом від XSS,
 * використовує параметризовані запити через Database клас.
 * 
 * @package Classes
 * @author Kostiantyn Surkov
 * @version 1.0
 * @since 2024
 */
class AuthController
{
    /**
     * Обробляє форму авторизації (POST запит)
     * 
     * Отримує дані з POST запиту, фільтрує їх від XSS,
     * виконує авторизацію через Database::checkUser()
     * з використанням параметризованих запитів.
     * 
     * @return array<string, mixed> Масив з результатом:
     *                              ['success' => bool, 'message' => string, 'user' => array|null]
     * @throws \Exception Якщо виникає помилка при обробці
     * 
     * @example
     * <code>
     * $result = AuthController::handleLogin();
     * if ($result['success']) {
     *     // Користувач авторизований
     *     $_SESSION['user'] = $result['user'];
     * }
     * </code>
     */
    public static function handleLogin(): array
    {
        // Перевірка CSRF токену
        if (!isset($_POST['csrf_token']) || !Security::verifyCsrfToken($_POST['csrf_token'])) {
            return [
                'success' => false,
                'message' => 'Помилка безпеки: невалідний CSRF токен',
                'user' => null
            ];
        }

        // Отримуємо та фільтруємо дані з форми (захист від XSS)
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        // Фільтрація вхідних даних від XSS
        $username = Security::filterUsername($username);
        if ($username === false) {
            return [
                'success' => false,
                'message' => 'Невірний формат username',
                'user' => null
            ];
        }

        $password = Security::filterPassword($password);

        // Перевірка на порожні значення
        if (empty($username) || empty($password)) {
            return [
                'success' => false,
                'message' => 'Будь ласка, заповніть всі поля',
                'user' => null
            ];
        }

        try {
            // Використовуємо параметризовані запити через Database::checkUser()
            // Метод checkUser() використовує PDO prepared statements
            $user = Database::checkUser($username, $password);

            if ($user) {
                // Зберігаємо дані користувача в сесії (без пароля)
                $_SESSION['user'] = $user;
                $_SESSION['logged_in'] = true;

                return [
                    'success' => true,
                    'message' => 'Авторизація успішна!',
                    'user' => $user
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Невірний username або password',
                    'user' => null
                ];
            }
        } catch (\Exception $e) {
            error_log("Login error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Помилка сервера. Спробуйте пізніше.',
                'user' => null
            ];
        }
    }

    /**
     * Обробляє форму реєстрації (POST запит)
     * 
     * Отримує дані з POST запиту, фільтрує їх від XSS,
     * виконує реєстрацію через Database::createUser()
     * з використанням параметризованих запитів та bcrypt хешування.
     * 
     * @return array<string, mixed> Масив з результатом:
     *                              ['success' => bool, 'message' => string, 'user' => array|null]
     * @throws \Exception Якщо виникає помилка при обробці
     * 
     * @example
     * <code>
     * $result = AuthController::handleRegister();
     * if ($result['success']) {
     *     // Користувач зареєстрований
     *     echo $result['message'];
     * }
     * </code>
     */
    public static function handleRegister(): array
    {
        // Перевірка CSRF токену
        if (!isset($_POST['csrf_token']) || !Security::verifyCsrfToken($_POST['csrf_token'])) {
            return [
                'success' => false,
                'message' => 'Помилка безпеки: невалідний CSRF токен',
                'user' => null
            ];
        }

        // Отримуємо та фільтруємо дані з форми (захист від XSS)
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $passwordConfirm = $_POST['password_confirm'] ?? '';

        // Фільтрація вхідних даних від XSS
        $username = Security::filterUsername($username);
        if ($username === false) {
            return [
                'success' => false,
                'message' => 'Невірний формат username (тільки літери, цифри, підкреслення, 3-20 символів)',
                'user' => null
            ];
        }

        $email = Security::filterEmail($email);
        if ($email === false) {
            return [
                'success' => false,
                'message' => 'Невірний формат email',
                'user' => null
            ];
        }

        $password = Security::filterPassword($password);
        $passwordConfirm = Security::filterPassword($passwordConfirm);

        // Перевірка на порожні значення
        if (empty($username) || empty($email) || empty($password)) {
            return [
                'success' => false,
                'message' => 'Будь ласка, заповніть всі поля',
                'user' => null
            ];
        }

        // Перевірка співпадіння паролів
        if ($password !== $passwordConfirm) {
            return [
                'success' => false,
                'message' => 'Паролі не співпадають',
                'user' => null
            ];
        }

        // Перевірка мінімальної довжини пароля
        if (strlen($password) < 6) {
            return [
                'success' => false,
                'message' => 'Пароль повинен містити мінімум 6 символів',
                'user' => null
            ];
        }

        try {
            // Використовуємо параметризовані запити через Database::createUser()
            // Метод createUser() використовує:
            // 1. PDO prepared statements (захист від SQL ін'єкцій)
            // 2. password_hash() з PASSWORD_DEFAULT (bcrypt хешування)
            $user = Database::createUser($username, $email, $password);

            if ($user) {
                return [
                    'success' => true,
                    'message' => 'Реєстрація успішна! Тепер ви можете увійти.',
                    'user' => $user
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Користувач з таким username або email вже існує',
                    'user' => null
                ];
            }
        } catch (\Exception $e) {
            error_log("Registration error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Помилка сервера. Спробуйте пізніше.',
                'user' => null
            ];
        }
    }

    /**
     * Відображає сторінку авторизації
     * 
     * @return void
     */
    public static function showLoginPage(): void
    {
        $page_title = 'Авторизація';
        $csrfToken = Security::generateCsrfToken();
        
        // Обробка POST запиту
        $result = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
            $result = self::handleLogin();
        }

        require_once __DIR__ . '/../../pages/auth.php';
    }

    /**
     * Відображає сторінку реєстрації
     * 
     * @return void
     */
    public static function showRegisterPage(): void
    {
        $page_title = 'Реєстрація';
        $csrfToken = Security::generateCsrfToken();
        
        // Обробка POST запиту
        $result = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'register') {
            $result = self::handleRegister();
        }

        require_once __DIR__ . '/../../pages/register.php';
    }

    /**
     * Виконує вихід користувача
     * 
     * @return void
     */
    public static function logout(): void
    {
        session_start();
        session_destroy();
        header('Location: /auth?message=logged_out');
        exit;
    }
}

