<?php

namespace Classes;

/**
 * Клас для захисту від різних типів атак
 * 
 * Надає методи для захисту від XSS, фільтрації вхідних даних
 * та екранування виводу в шаблонах.
 * 
 * @package Classes
 * @author Kostiantyn Surkov
 * @version 1.0
 * @since 2024
 */
class Security
{
    /**
     * Екранує спеціальні символи для безпечного виводу в HTML
     * 
     * Використовується для захисту від XSS атак при виведенні
     * даних користувача в шаблонах. Конвертує спеціальні символи
     * HTML в їх HTML-сутності.
     * 
     * @param string|null $value Значення для екранування
     * @param int $flags Прапори для htmlspecialchars (за замовчуванням ENT_QUOTES | ENT_HTML5)
     * @param string $encoding Кодування (за замовчуванням 'UTF-8')
     * @return string Екрановане значення або порожній рядок якщо null
     * 
     * @example
     * <code>
     * $title = Security::escape('<script>alert("XSS")</script>');
     * echo $title; // Виведе: &lt;script&gt;alert(&quot;XSS&quot;)&lt;/script&gt;
     * </code>
     */
    public static function escape(?string $value, int $flags = ENT_QUOTES | ENT_HTML5, string $encoding = 'UTF-8'): string
    {
        if ($value === null) {
            return '';
        }
        
        return htmlspecialchars($value, $flags, $encoding);
    }

    /**
     * Фільтрує та очищає вхідні дані від потенційно небезпечного контенту
     * 
     * Видаляє HTML теги, обрізає пробіли та перевіряє на наявність
     * потенційно небезпечних символів. Використовується для обробки
     * даних з форм перед збереженням в БД.
     * 
     * @param string $input Вхідні дані для фільтрації
     * @param bool $allowHtml Чи дозволити HTML теги (за замовчуванням false)
     * @return string Очищене значення
     * 
     * @example
     * <code>
     * $username = Security::filterInput($_POST['username']);
     * // Видалить всі HTML теги та очистить від пробілів
     * </code>
     */
    public static function filterInput(string $input, bool $allowHtml = false): string
    {
        // Обрізаємо пробіли
        $input = trim($input);
        
        // Видаляємо зайві пробіли
        $input = preg_replace('/\s+/', ' ', $input);
        
        if (!$allowHtml) {
            // Видаляємо всі HTML теги
            $input = strip_tags($input);
        }
        
        // Видаляємо NULL байти (захист від null byte injection)
        $input = str_replace("\0", '', $input);
        
        return $input;
    }

    /**
     * Валідує та фільтрує username
     * 
     * Перевіряє username на відповідність правилам:
     * - Тільки літери, цифри та підкреслення
     * - Довжина від 3 до 20 символів
     * 
     * @param string $username Username для валідації
     * @return string|false Очищений username або false якщо невалідний
     */
    public static function filterUsername(string $username): string|false
    {
        $username = self::filterInput($username);
        
        // Перевірка формату: тільки літери, цифри та підкреслення, 3-20 символів
        if (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
            return false;
        }
        
        return $username;
    }

    /**
     * Валідує та фільтрує email
     * 
     * Перевіряє email на коректність формату та фільтрує
     * від потенційно небезпечного контенту.
     * 
     * @param string $email Email для валідації
     * @return string|false Очищений email або false якщо невалідний
     */
    public static function filterEmail(string $email): string|false
    {
        $email = self::filterInput($email);
        
        // Використовуємо вбудовану функцію PHP для валідації email
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        
        return $email;
    }

    /**
     * Фільтрує пароль (без валідації формату)
     * 
     * Пароль не обрізається та не обмежується, оскільки може містити
     * спеціальні символи. Тільки видаляємо потенційно небезпечні символи.
     * 
     * @param string $password Пароль для фільтрації
     * @return string Очищений пароль
     */
    public static function filterPassword(string $password): string
    {
        // Видаляємо NULL байти
        $password = str_replace("\0", '', $password);
        
        // Обмежуємо максимальну довжину (захист від DoS)
        if (strlen($password) > 255) {
            $password = substr($password, 0, 255);
        }
        
        return $password;
    }

    /**
     * Генерує CSRF токен для захисту форм
     * 
     * @return string CSRF токен
     */
    public static function generateCsrfToken(): string
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        
        return $_SESSION['csrf_token'];
    }

    /**
     * Перевіряє CSRF токен
     * 
     * @param string $token Токен для перевірки
     * @return bool true якщо токен валідний, false інакше
     */
    public static function verifyCsrfToken(string $token): bool
    {
        if (!isset($_SESSION['csrf_token'])) {
            return false;
        }
        
        return hash_equals($_SESSION['csrf_token'], $token);
    }
}

