<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <link rel="stylesheet" href="/CSS/auth.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        .input-container {
            margin-bottom: 1.5rem;
        }

        .buttons {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            flex-wrap: wrap;
        }

        .btn {
            padding: 1rem 1.5rem;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
            flex: 1;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
        }

        .btn-secondary {
            background: rgba(30, 41, 59, 0.5);
            color: var(--light);
            border: 2px solid var(--border);
        }

        .btn-secondary:hover {
            border-color: var(--primary);
            background: rgba(99, 102, 241, 0.1);
        }

        .results {
            margin-top: 2rem;
            padding: 2rem;
            background: rgba(30, 41, 59, 0.3);
            border-radius: 12px;
            border: 2px solid var(--border);
            display: none;
            animation: fadeIn 0.3s ease;
        }

        .results.show {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .phrase-display {
            background: rgba(15, 23, 42, 0.8);
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            border-left: 4px solid var(--primary);
        }

        .phrase-display strong {
            color: var(--primary);
            display: block;
            margin-bottom: 0.5rem;
        }

        .phrase-display span {
            color: #cbd5e1;
        }

        .results h3 {
            color: white;
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }

        .common-words {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-top: 1rem;
        }

        .word-tag {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 1.1rem;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
            animation: scaleIn 0.3s ease;
        }

        @keyframes scaleIn {
            from { transform: scale(0); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .no-common {
            color: #94a3b8;
            text-align: center;
            padding: 2rem;
            font-size: 1.1rem;
            font-style: italic;
        }

        .set-feature {
            background: rgba(30, 41, 59, 0.3);
            padding: 1.5rem;
            border-radius: 12px;
            border-left: 4px solid var(--accent);
            margin-bottom: 1rem;
        }

        .set-feature h3 {
            color: var(--accent);
            margin-bottom: 0.75rem;
        }

        .set-feature code {
            background: rgba(236, 72, 153, 0.1);
            color: var(--accent);
        }
    </style>
</head>
<body>
    <div class="stars"></div>
    <div class="stars2"></div>
    <div class="stars3"></div>

    <?php require_once __DIR__ . '/../includes/nav.php'; renderNav('set-task'); ?>

    <header class="hero">
        <div class="hero-container">
            <h1 class="hero-title">
                <span class="gradient-text">Завдання 4</span>
                Робота з Set та Map
            </h1>
            <p class="hero-subtitle">
                Пошук спільних слів між фразами використовуючи структуру даних Set
            </p>
        </div>
    </header>

    <main class="container">
        <section class="card">
            <div class="card-header">
                <div class="card-icon">📝</div>
                <h2>Знайти спільні слова</h2>
            </div>
            <div class="card-content">
                <p>Введіть дві фрази, і програма знайде всі спільні слова за допомогою Set</p>

                <div class="input-container">
                    <label for="phrase1">
                        <span class="label-icon">💬</span>
                        Перша фраза:
                    </label>
                    <input 
                        type="text" 
                        id="phrase1" 
                        placeholder='Наприклад: "Привіт, світ!"'
                        autocomplete="off"
                    >
                </div>

                <div class="input-container">
                    <label for="phrase2">
                        <span class="label-icon">💭</span>
                        Друга фраза:
                    </label>
                    <input 
                        type="text" 
                        id="phrase2" 
                        placeholder='Наприклад: "Привіт, як справи?"'
                        autocomplete="off"
                    >
                </div>

                <div class="buttons">
                    <button class="btn btn-primary" onclick="findCommonWords()">
                        <span class="btn-icon">🔍</span>
                        Знайти спільні слова
                    </button>
                    <button class="btn btn-secondary" onclick="clearAll()">
                        <span class="btn-icon">🗑️</span>
                        Очистити
                    </button>
                </div>

                <div class="results" id="results">
                    <h3>📊 Результат аналізу:</h3>
                    <div class="phrase-display">
                        <strong>Фраза 1:</strong>
                        <span id="displayPhrase1"></span>
                    </div>
                    <div class="phrase-display">
                        <strong>Фраза 2:</strong>
                        <span id="displayPhrase2"></span>
                    </div>
                    <h3>✨ Спільні слова:</h3>
                    <div class="common-words" id="commonWords"></div>
                </div>
            </div>
        </section>

        <section class="card">
            <div class="card-header">
                <div class="card-icon">📚</div>
                <h2>Що таке Set?</h2>
            </div>
            <div class="card-content">
                <p>Set - це колекція унікальних значень. Кожне значення може зустрічатися лише один раз.</p>

                <div class="set-feature">
                    <h3>new Set()</h3>
                    <p>Створення нового Set: <code>const mySet = new Set()</code></p>
                </div>

                <div class="set-feature">
                    <h3>add(value)</h3>
                    <p>Додавання елементів: <code>mySet.add('привіт')</code></p>
                </div>

                <div class="set-feature">
                    <h3>has(value)</h3>
                    <p>Перевірка наявності: <code>mySet.has('привіт')</code> → true/false</p>
                </div>

                <div class="set-feature">
                    <h3>size</h3>
                    <p>Кількість елементів: <code>mySet.size</code></p>
                </div>

                <div class="set-feature">
                    <h3>forEach()</h3>
                    <p>Ітерація: <code>mySet.forEach(value => console.log(value))</code></p>
                </div>

                <div class="info-box">
                    💡 Відкрийте консоль (F12) щоб побачити детальну роботу з Set
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="footer-content">
            <p>© 2024 JavaScript Course Tasks</p>
            <p class="footer-links">
                <a href="/login">← Попереднє завдання</a>
                <span>•</span>
                <a href="/api-task">Наступне завдання →</a>
            </p>
        </div>
    </footer>

    <script src="/scripts/set-task.js"></script>
</body>
</html>

