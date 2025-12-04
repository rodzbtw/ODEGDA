<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Composer Packages Demo</title>
    <link rel="stylesheet" href="/resources/assets/css/main.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <div class="stars"></div>
    <div class="stars2"></div>
    <div class="stars3"></div>

    <?php require_once __DIR__ . '/../includes/nav.php'; renderNav(''); ?>

    <header class="hero">
        <div class="hero-container">
            <h1 class="hero-title">
                <span class="gradient-text">Composer</span>
                Демонстрація PHP пакетів
            </h1>
            <p class="hero-subtitle">
                Monolog, VarDumper та DotEnv в дії
            </p>
        </div>
    </header>

    <main class="container">
        <?php
        // Підключаємо Composer autoload
        require_once __DIR__ . '/../../vendor/autoload.php';
        
        use Odegda\LoggerExample;
        use Odegda\VarDumperExample;
        use Odegda\DotEnvExample;
        ?>

        <section class="card">
            <div class="card-header">
                <div class="card-icon">📦</div>
                <h2>Встановлені пакети</h2>
            </div>
            <div class="card-content">
                <ul class="feature-list">
                    <li><strong>monolog/monolog</strong> - потужна бібліотека для логування</li>
                    <li><strong>symfony/var-dumper</strong> - красивий вивід змінних для дебагу</li>
                    <li><strong>vlucas/phpdotenv</strong> - робота з змінними оточення через .env файли</li>
                </ul>
            </div>
        </section>

        <?php
        // 1. DotEnv демонстрація
        try {
            $dotenvExample = new DotEnvExample();
            echo '<section class="card">';
            echo '<div class="card-header"><div class="card-icon">🔐</div><h2>DotEnv - Змінні оточення</h2></div>';
            echo '<div class="card-content">';
            $dotenvExample->demonstrate();
            echo '</div></section>';
        } catch (Exception $e) {
            echo '<div class="error-message">Помилка DotEnv: ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
        ?>

        <?php
        // 2. VarDumper демонстрація
        try {
            $varDumperExample = new VarDumperExample();
            echo '<section class="card">';
            echo '<div class="card-header"><div class="card-icon">🔍</div><h2>VarDumper - Вивід змінних</h2></div>';
            echo '<div class="card-content">';
            $varDumperExample->demonstrateDumping();
            $varDumperExample->demonstrateWithClasses();
            echo '</div></section>';
        } catch (Exception $e) {
            echo '<div class="error-message">Помилка VarDumper: ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
        ?>

        <?php
        // 3. Monolog демонстрація
        try {
            if (!is_dir(__DIR__ . '/../logs')) {
                mkdir(__DIR__ . '/../logs', 0755, true);
            }
            
            $loggerExample = new LoggerExample();
            echo '<section class="card">';
            echo '<div class="card-header"><div class="card-icon">📝</div><h2>Monolog - Логування</h2></div>';
            echo '<div class="card-content">';
            echo '<p>Logger створено успішно! Логи записуються в файл <code>logs/app.log</code></p>';
            
            $loggerExample->demonstrateLogging();
            
            echo '<p class="success">✓ Всі рівні логування виконано</p>';
            
            // Показуємо останні рядки з лог-файлу
            $logFile = __DIR__ . '/../logs/app.log';
            if (file_exists($logFile)) {
                $lines = file($logFile);
                $lastLines = array_slice($lines, -10);
                echo '<h3>Останні 10 рядків з лог-файлу:</h3>';
                echo '<div class="code-block"><pre>';
                foreach ($lastLines as $line) {
                    echo htmlspecialchars($line);
                }
                echo '</pre></div>';
            }
            echo '</div></section>';
        } catch (Exception $e) {
            echo '<div class="error-message">Помилка Monolog: ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
        ?>

        <section class="card">
            <div class="card-header">
                <div class="card-icon">📚</div>
                <h2>Як використовувати</h2>
            </div>
            <div class="card-content">
                <div class="code-explanation">
                    <h3>1. Встановлення залежностей:</h3>
                    <pre class="code-block"><code>composer install</code></pre>

                    <h3>2. Використання в коді:</h3>
                    <pre class="code-block"><code>require_once 'vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$logger = new Logger('app');
$logger->pushHandler(new StreamHandler('logs/app.log', Logger::DEBUG));
$logger->info('Повідомлення');</code></pre>

                    <h3>3. Робота з .env файлом:</h3>
                    <pre class="code-block"><code>use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dbHost = $_ENV['DB_HOST'];</code></pre>
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

