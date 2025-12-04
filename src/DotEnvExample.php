<?php

namespace Odegda;

use Dotenv\Dotenv;

/**
 * Приклад використання vlucas/phpdotenv для роботи з .env файлами
 */
class DotEnvExample {
    private $dotenv;
    
    public function __construct() {
        // Завантажуємо .env файл з кореневої директорії
        $this->dotenv = Dotenv::createImmutable(__DIR__ . '/..');
        $this->dotenv->load();
    }
    
    /**
     * Демонстрація роботи з змінними оточення
     */
    public function demonstrate() {
        echo "<h2>=== DotEnv Демонстрація ===</h2>\n";
        
        // Отримуємо змінні оточення
        $appName = $_ENV['APP_NAME'] ?? 'Не встановлено';
        $appEnv = $_ENV['APP_ENV'] ?? 'Не встановлено';
        $debug = $_ENV['APP_DEBUG'] ?? 'Не встановлено';
        $dbHost = $_ENV['DB_HOST'] ?? 'Не встановлено';
        $dbName = $_ENV['DB_NAME'] ?? 'Не встановлено';
        
        echo "<h3>Змінні оточення:</h3>\n";
        echo "<ul>\n";
        echo "<li><strong>APP_NAME:</strong> {$appName}</li>\n";
        echo "<li><strong>APP_ENV:</strong> {$appEnv}</li>\n";
        echo "<li><strong>APP_DEBUG:</strong> {$debug}</li>\n";
        echo "<li><strong>DB_HOST:</strong> {$dbHost}</li>\n";
        echo "<li><strong>DB_NAME:</strong> {$dbName}</li>\n";
        echo "</ul>\n";
        
        // Використання getenv() для безпечного отримання значень
        $safeValue = $_ENV['SECRET_KEY'] ?? 'Не встановлено';
        echo "<p><strong>SECRET_KEY:</strong> " . (strlen($safeValue) > 20 ? substr($safeValue, 0, 20) . '...' : $safeValue) . "</p>\n";
        
        // Перевірка наявності змінної
        if (isset($_ENV['APP_NAME'])) {
            echo "<p style='color: green;'>✓ APP_NAME встановлено</p>\n";
        } else {
            echo "<p style='color: red;'>✗ APP_NAME не встановлено</p>\n";
        }
    }
    
    /**
     * Отримати значення змінної оточення
     */
    public function getEnv($key, $default = null) {
        return $_ENV[$key] ?? $default;
    }
}

