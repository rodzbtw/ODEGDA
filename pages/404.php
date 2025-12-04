<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <link rel="stylesheet" href="/CSS/main.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        .error-container {
            min-height: 60vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 2rem;
        }
        .error-code {
            font-size: 8rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
        }
        .error-message {
            font-size: 2rem;
            color: white;
            margin-bottom: 2rem;
        }
        .error-description {
            font-size: 1.2rem;
            color: #94a3b8;
            margin-bottom: 2rem;
            max-width: 600px;
        }
        .error-actions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            justify-content: center;
        }
        .btn-home {
            padding: 1rem 2rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .btn-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
        }
    </style>
</head>
<body>
    <div class="stars"></div>
    <div class="stars2"></div>
    <div class="stars3"></div>

    <?php require_once __DIR__ . '/../includes/nav.php'; renderNav(''); ?>

    <main class="container">
        <div class="error-container">
            <div class="error-code">404</div>
            <h1 class="error-message">Сторінку не знайдено</h1>
            <p class="error-description">
                Вибачте, але сторінка, яку ви шукаєте, не існує або була переміщена.
                Перевірте правильність URL або поверніться на головну сторінку.
            </p>
            <div class="error-actions">
                <a href="/" class="btn-home">
                    <span>🏠</span>
                    Повернутися на головну
                </a>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="footer-content">
            <p>© 2024 JavaScript Course Tasks</p>
            <p class="footer-links">
                <a href="/">Головна</a>
            </p>
        </div>
    </footer>
</body>
</html>

