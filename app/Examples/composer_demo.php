<?php
/**
 * Демонстрація використання Composer пакетів
 * 
 * Пакети:
 * 1. monolog/monolog - логування
 * 2. symfony/var-dumper - красивий вивід змінних
 * 3. vlucas/phpdotenv - робота з .env файлами
 */

require_once __DIR__ . '/vendor/autoload.php';

use Odegda\LoggerExample;
use Odegda\VarDumperExample;
use Odegda\DotEnvExample;

// Встановлюємо обробку помилок
error_reporting(E_ALL);
ini_set('display_errors', 1);

?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Composer Packages Demo</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background: #1e1e1e;
            color: #e0e0e0;
        }
        h1 {
            color: #4CAF50;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 10px;
        }
        h2 {
            color: #2196F3;
            margin-top: 30px;
        }
        h3 {
            color: #FF9800;
        }
        .section {
            background: #2d2d2d;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
            border-left: 4px solid #4CAF50;
        }
        .code {
            background: #1a1a1a;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
            margin: 10px 0;
        }
        .success {
            color: #4CAF50;
        }
        .error {
            color: #f44336;
        }
        ul {
            line-height: 1.8;
        }
    </style>
</head>
<body>
    <h1>🚀 Демонстрація Composer Пакетів</h1>
    
    <div class="section">
        <h2>📦 Встановлені пакети:</h2>
        <ul>
            <li><strong>monolog/monolog</strong> - потужна бібліотека для логування</li>
            <li><strong>symfony/var-dumper</strong> - красивий вивід змінних для дебагу</li>
            <li><strong>vlucas/phpdotenv</strong> - робота з змінними оточення через .env файли</li>
        </ul>
    </div>

    <?php
    // 1. Демонстрація DotEnv
    try {
        $dotenvExample = new DotEnvExample();
        $dotenvExample->demonstrate();
    } catch (Exception $e) {
        echo "<div class='error'>Помилка DotEnv: " . $e->getMessage() . "</div>";
    }
    
    echo "<hr style='margin: 30px 0; border-color: #444;'>";
    
    // 2. Демонстрація VarDumper
    try {
        $varDumperExample = new VarDumperExample();
        $varDumperExample->demonstrateDumping();
        $varDumperExample->demonstrateWithClasses();
    } catch (Exception $e) {
        echo "<div class='error'>Помилка VarDumper: " . $e->getMessage() . "</div>";
    }
    
    echo "<hr style='margin: 30px 0; border-color: #444;'>";
    
    // 3. Демонстрація Monolog
    try {
        // Створюємо директорію для логів якщо її немає
        if (!is_dir(__DIR__ . '/logs')) {
            mkdir(__DIR__ . '/logs', 0755, true);
        }
        
        $loggerExample = new LoggerExample();
        echo "<h2>=== Monolog Демонстрація ===</h2>";
        echo "<p class='success'>✓ Logger створено успішно</p>";
        echo "<p>Логи записуються в файл: <code>logs/app.log</code></p>";
        
        $loggerExample->demonstrateLogging();
        
        echo "<p class='success'>✓ Всі рівні логування виконано</p>";
        echo "<p>Перевірте файл <code>logs/app.log</code> для перегляду логів</p>";
        
        // Показуємо останні рядки з лог-файлу
        $logFile = __DIR__ . '/logs/app.log';
        if (file_exists($logFile)) {
            $lines = file($logFile);
            $lastLines = array_slice($lines, -5);
            echo "<h3>Останні 5 рядків з лог-файлу:</h3>";
            echo "<div class='code'>";
            foreach ($lastLines as $line) {
                echo htmlspecialchars($line) . "<br>";
            }
            echo "</div>";
        }
    } catch (Exception $e) {
        echo "<div class='error'>Помилка Monolog: " . $e->getMessage() . "</div>";
    }
    ?>
    
    <div class="section">
        <h2>📝 Інструкції:</h2>
        <ol>
            <li>Встановіть залежності: <code>composer install</code></li>
            <li>Скопіюйте <code>.env.example</code> в <code>.env</code> та налаштуйте</li>
            <li>Запустіть демо: <code>php composer_demo.php</code></li>
            <li>Перевірте логи в <code>logs/app.log</code></li>
        </ol>
    </div>
</body>
</html>

