<?php

namespace Classes;

use PDO;
use PDOException;

/**
 * Клас для роботи з базою даних
 * 
 * Надає статичні методи для підключення до бази даних (SQLite або MySQL),
 * виконання запитів SELECT для авторизації та INSERT для реєстрації користувачів.
 * 
 * @package Classes
 * @author Kostiantyn Surkov
 * @version 1.0
 * @since 2024
 */
class Database
{
    /**
     * Змінна для зберігання підключення до бази даних
     * 
     * @var PDO|null Об'єкт PDO підключення або null якщо не підключено
     */
    private static ?PDO $connection = null;

    /**
     * Тип бази даних (sqlite або mysql)
     * 
     * @var string
     */
    private static string $dbType = 'sqlite';

    /**
     * Створює підключення до бази даних (SQLite або MySQL)
     * 
     * Метод підтримує два типи баз даних:
     * - SQLite: використовує файл бази даних
     * - MySQL: використовує параметри підключення з .env або конфігурації
     * 
     * Підключення створюється один раз (Singleton pattern) та перевикористовується
     * при наступних викликах методу.
     * 
     * @param string $type Тип бази даних: 'sqlite' або 'mysql' (за замовчуванням 'sqlite')
     * @param array<string, mixed>|null $config Масив конфігурації для MySQL:
     *                                          ['host', 'dbname', 'username', 'password', 'charset']
     * @return PDO Об'єкт PDO підключення до бази даних
     * @throws PDOException Якщо не вдається підключитися до бази даних
     * 
     * @example
     * <code>
     * // SQLite
     * $pdo = Database::getConnection('sqlite');
     * 
     * // MySQL
     * $pdo = Database::getConnection('mysql', [
     *     'host' => 'localhost',
     *     'dbname' => 'mydb',
     *     'username' => 'root',
     *     'password' => 'password'
     * ]);
     * </code>
     */
    public static function getConnection(string $type = 'sqlite', ?array $config = null): PDO
    {
        // Якщо підключення вже існує, повертаємо його
        if (self::$connection !== null && self::$dbType === $type) {
            return self::$connection;
        }

        self::$dbType = $type;

        try {
            if ($type === 'sqlite') {
                // Підключення до SQLite
                $dbPath = __DIR__ . '/../../database.sqlite';
                
                // Створюємо директорію якщо не існує
                $dbDir = dirname($dbPath);
                if (!is_dir($dbDir)) {
                    mkdir($dbDir, 0755, true);
                }
                
                self::$connection = new PDO('sqlite:' . $dbPath);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                
            } elseif ($type === 'mysql') {
                // Підключення до MySQL
                if ($config === null) {
                    // Спробуємо отримати з .env або використати значення за замовчуванням
                    $host = $_ENV['DB_HOST'] ?? 'localhost';
                    $dbname = $_ENV['DB_NAME'] ?? 'odegda_db';
                    $username = $_ENV['DB_USER'] ?? 'root';
                    $password = $_ENV['DB_PASSWORD'] ?? '';
                    $charset = $_ENV['DB_CHARSET'] ?? 'utf8mb4';
                } else {
                    $host = $config['host'] ?? 'localhost';
                    $dbname = $config['dbname'] ?? 'odegda_db';
                    $username = $config['username'] ?? 'root';
                    $password = $config['password'] ?? '';
                    $charset = $config['charset'] ?? 'utf8mb4';
                }
                
                $dsn = "mysql:host={$host};dbname={$dbname};charset={$charset}";
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ];
                
                self::$connection = new PDO($dsn, $username, $password, $options);
            } else {
                throw new PDOException("Непідтримуваний тип бази даних: {$type}");
            }
            
            return self::$connection;
            
        } catch (PDOException $e) {
            error_log("Database connection error: " . $e->getMessage());
            throw new PDOException("Помилка підключення до бази даних: " . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Ініціалізує таблицю Users якщо вона не існує
     * 
     * Створює таблицю Users з необхідними полями для зберігання
     * інформації про користувачів (id, username, email, password).
     * 
     * @param PDO $pdo Підключення до бази даних
     * @return bool true якщо таблиця створена або вже існує, false при помилці
     * @throws PDOException Якщо не вдається створити таблицю
     */
    public static function initUsersTable(PDO $pdo): bool
    {
        try {
            $sql = "CREATE TABLE IF NOT EXISTS Users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                username VARCHAR(50) NOT NULL UNIQUE,
                email VARCHAR(100) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )";
            
            // Для MySQL використовуємо AUTO_INCREMENT замість AUTOINCREMENT
            if (self::$dbType === 'mysql') {
                $sql = "CREATE TABLE IF NOT EXISTS Users (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    username VARCHAR(50) NOT NULL UNIQUE,
                    email VARCHAR(100) NOT NULL UNIQUE,
                    password VARCHAR(255) NOT NULL,
                    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
            }
            
            $pdo->exec($sql);
            return true;
        } catch (PDOException $e) {
            error_log("Table creation error: " . $e->getMessage());
            throw new PDOException("Помилка створення таблиці: " . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Перевіряє користувача в таблиці Users (авторизація)
     * 
     * Виконує SELECT запит для перевірки наявності користувача з вказаним
     * username та password. Пароль перевіряється через password_verify().
     * 
     * @param string $username Ім'я користувача для перевірки
     * @param string $password Пароль користувача (plain text)
     * @param string $dbType Тип бази даних: 'sqlite' або 'mysql' (за замовчуванням 'sqlite')
     * @return array<string, mixed>|false Масив з даними користувача (id, username, email) 
     *                                    або false якщо користувач не знайдений або пароль невірний
     * @throws PDOException Якщо виникає помилка при виконанні запиту
     * 
     * @example
     * <code>
     * $user = Database::checkUser('admin', 'password123');
     * if ($user) {
     *     echo "Користувач авторизований: " . $user['username'];
     * } else {
     *     echo "Невірний логін або пароль";
     * }
     * </code>
     */
    public static function checkUser(string $username, string $password, string $dbType = 'sqlite'): array|false
    {
        try {
            $pdo = self::getConnection($dbType);
            
            // Ініціалізуємо таблицю якщо не існує
            self::initUsersTable($pdo);
            
            // Підготовлений запит для безпеки
            $stmt = $pdo->prepare("SELECT id, username, email, password FROM Users WHERE username = :username LIMIT 1");
            $stmt->execute([':username' => $username]);
            
            $user = $stmt->fetch();
            
            // Якщо користувач не знайдений
            if (!$user) {
                return false;
            }
            
            // Перевіряємо пароль
            if (password_verify($password, $user['password'])) {
                // Видаляємо пароль з результату перед поверненням
                unset($user['password']);
                return $user;
            }
            
            return false;
            
        } catch (PDOException $e) {
            error_log("User check error: " . $e->getMessage());
            throw new PDOException("Помилка перевірки користувача: " . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Створює нового користувача в таблиці Users (реєстрація)
     * 
     * Виконує INSERT запит для додавання нового користувача в базу даних.
     * Пароль хешується через password_hash() перед збереженням.
     * Перевіряє унікальність username та email.
     * 
     * @param string $username Ім'я користувача (має бути унікальним)
     * @param string $email Email користувача (має бути унікальним)
     * @param string $password Пароль користувача (plain text, буде захешований)
     * @param string $dbType Тип бази даних: 'sqlite' або 'mysql' (за замовчуванням 'sqlite')
     * @return array<string, mixed>|false Масив з даними створеного користувача (id, username, email)
     *                                    або false якщо не вдалося створити (наприклад, дублікат)
     * @throws PDOException Якщо виникає помилка при виконанні запиту
     * 
     * @example
     * <code>
     * $user = Database::createUser('newuser', 'user@example.com', 'password123');
     * if ($user) {
     *     echo "Користувач створено: " . $user['username'];
     * } else {
     *     echo "Помилка створення користувача";
     * }
     * </code>
     */
    public static function createUser(string $username, string $email, string $password, string $dbType = 'sqlite'): array|false
    {
        try {
            $pdo = self::getConnection($dbType);
            
            // Ініціалізуємо таблицю якщо не існує
            self::initUsersTable($pdo);
            
            // Перевіряємо чи не існує вже користувач з таким username або email
            $stmt = $pdo->prepare("SELECT id FROM Users WHERE username = :username OR email = :email LIMIT 1");
            $stmt->execute([
                ':username' => $username,
                ':email' => $email
            ]);
            
            if ($stmt->fetch()) {
                // Користувач з таким username або email вже існує
                return false;
            }
            
            // Хешуємо пароль
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            // Вставляємо нового користувача
            $stmt = $pdo->prepare("INSERT INTO Users (username, email, password) VALUES (:username, :email, :password)");
            $stmt->execute([
                ':username' => $username,
                ':email' => $email,
                ':password' => $hashedPassword
            ]);
            
            // Отримуємо ID створеного користувача
            $userId = $pdo->lastInsertId();
            
            // Повертаємо дані користувача
            return [
                'id' => (int)$userId,
                'username' => $username,
                'email' => $email
            ];
            
        } catch (PDOException $e) {
            error_log("User creation error: " . $e->getMessage());
            throw new PDOException("Помилка створення користувача: " . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Закриває підключення до бази даних
     * 
     * @return void
     */
    public static function closeConnection(): void
    {
        self::$connection = null;
    }

    /**
     * Отримує поточне підключення до бази даних
     * 
     * @return PDO|null Поточне підключення або null якщо не підключено
     */
    public static function getCurrentConnection(): ?PDO
    {
        return self::$connection;
    }
}

