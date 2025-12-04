<?php

namespace Classes;

/**
 * Тестовий клас для демонстрації роботи з класом Database
 * 
 * @package Classes
 */
class DatabaseTest
{
    /**
     * Демонстрація роботи з базою даних
     * 
     * @param string $dbType Тип бази даних: 'sqlite' або 'mysql'
     * @return void
     */
    public static function demonstrate(string $dbType = 'sqlite'): void
    {
        echo "<h2>=== Демонстрація роботи з Database ===</h2>\n";
        echo "<p>Тип бази даних: <strong>{$dbType}</strong></p>\n";
        
        try {
            // 1. Створення підключення
            echo "<h3>1. Створення підключення</h3>\n";
            $pdo = Database::getConnection($dbType);
            echo "<p class='success'>✓ Підключення до бази даних успішне</p>\n";
            
            // 2. Ініціалізація таблиці
            echo "<h3>2. Ініціалізація таблиці Users</h3>\n";
            Database::initUsersTable($pdo);
            echo "<p class='success'>✓ Таблиця Users створена/перевірена</p>\n";
            
            // 3. Створення користувача
            echo "<h3>3. Створення тестового користувача</h3>\n";
            $user = Database::createUser('testuser', 'test@example.com', 'testpass123', $dbType);
            if ($user) {
                echo "<p class='success'>✓ Користувач створено:</p>\n";
                echo "<ul>\n";
                echo "<li>ID: {$user['id']}</li>\n";
                echo "<li>Username: {$user['username']}</li>\n";
                echo "<li>Email: {$user['email']}</li>\n";
                echo "</ul>\n";
            } else {
                echo "<p class='warning'>⚠ Користувач вже існує або помилка створення</p>\n";
            }
            
            // 4. Перевірка користувача (авторизація)
            echo "<h3>4. Перевірка користувача (авторизація)</h3>\n";
            $authUser = Database::checkUser('testuser', 'testpass123', $dbType);
            if ($authUser) {
                echo "<p class='success'>✓ Авторизація успішна:</p>\n";
                echo "<ul>\n";
                echo "<li>ID: {$authUser['id']}</li>\n";
                echo "<li>Username: {$authUser['username']}</li>\n";
                echo "<li>Email: {$authUser['email']}</li>\n";
                echo "</ul>\n";
            } else {
                echo "<p class='error'>✗ Авторизація невдала</p>\n";
            }
            
            // 5. Перевірка з невірним паролем
            echo "<h3>5. Перевірка з невірним паролем</h3>\n";
            $wrongAuth = Database::checkUser('testuser', 'wrongpassword', $dbType);
            if ($wrongAuth === false) {
                echo "<p class='success'>✓ Невірний пароль правильно відхилено</p>\n";
            } else {
                echo "<p class='error'>✗ Помилка: невірний пароль прийнято</p>\n";
            }
            
        } catch (\Exception $e) {
            echo "<p class='error'>✗ Помилка: " . htmlspecialchars($e->getMessage()) . "</p>\n";
        }
    }
}

