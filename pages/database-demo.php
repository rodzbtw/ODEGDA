<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Demo</title>
    <link rel="stylesheet" href="/CSS/main.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        .success { color: #10b981; }
        .error { color: #ef4444; }
        .warning { color: #f59e0b; }
        .demo-section {
            background: rgba(30, 41, 59, 0.5);
            padding: 1.5rem;
            border-radius: 12px;
            margin: 1rem 0;
            border-left: 4px solid var(--primary);
        }
        .demo-section h3 {
            color: var(--primary);
            margin-top: 0;
        }
    </style>
</head>
<body>
    <div class="stars"></div>
    <div class="stars2"></div>
    <div class="stars3"></div>

    <?php require_once __DIR__ . '/../includes/nav.php'; renderNav(''); ?>

    <header class="hero">
        <div class="hero-container">
            <h1 class="hero-title">
                <span class="gradient-text">Database</span>
                Демонстрація роботи з БД
            </h1>
            <p class="hero-subtitle">
                SQLite та MySQL підключення, авторизація та реєстрація
            </p>
        </div>
    </header>

    <main class="container">
        <?php
        require_once __DIR__ . '/../vendor/autoload.php';
        require_once __DIR__ . '/../src/Classes/Database.php';
        require_once __DIR__ . '/../src/Classes/DatabaseTest.php';

        use Classes\Database;
        use Classes\DatabaseTest;

        // Визначаємо тип БД з параметра або використовуємо SQLite за замовчуванням
        $dbType = $_GET['db'] ?? 'sqlite';
        if (!in_array($dbType, ['sqlite', 'mysql'])) {
            $dbType = 'sqlite';
        }
        ?>

        <section class="card">
            <div class="card-header">
                <div class="card-icon">🗄️</div>
                <h2>Демонстрація Database класу</h2>
            </div>
            <div class="card-content">
                <div style="margin-bottom: 2rem;">
                    <p>Виберіть тип бази даних:</p>
                    <a href="?db=sqlite" class="btn btn-primary" style="display: inline-block; margin-right: 1rem;">
                        SQLite
                    </a>
                    <a href="?db=mysql" class="btn btn-secondary" style="display: inline-block;">
                        MySQL
                    </a>
                </div>

                <div class="demo-section">
                    <?php DatabaseTest::demonstrate($dbType); ?>
                </div>
            </div>
        </section>

        <section class="card">
            <div class="card-header">
                <div class="card-icon">📚</div>
                <h2>Методи класу Database</h2>
            </div>
            <div class="card-content">
                <div class="code-explanation">
                    <h3>1. getConnection() - Підключення до БД</h3>
                    <pre class="code-block"><code>// SQLite
$pdo = Database::getConnection('sqlite');

// MySQL
$pdo = Database::getConnection('mysql', [
    'host' => 'localhost',
    'dbname' => 'mydb',
    'username' => 'root',
    'password' => 'password'
]);</code></pre>

                    <h3>2. checkUser() - Авторизація</h3>
                    <pre class="code-block"><code>$user = Database::checkUser('username', 'password');
if ($user) {
    // Користувач авторизований
    echo $user['username'];
}</code></pre>

                    <h3>3. createUser() - Реєстрація</h3>
                    <pre class="code-block"><code>$user = Database::createUser('username', 'email@example.com', 'password');
if ($user) {
    // Користувач створено
    echo "ID: " . $user['id'];
}</code></pre>
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

