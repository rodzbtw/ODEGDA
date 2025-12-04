<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <link rel="stylesheet" href="/resources/assets/css/main.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        .game-container {
            max-width: 900px;
            margin: 0 auto;
        }

        #gameCanvas {
            display: block;
            margin: 2rem auto;
            border: 3px solid var(--primary);
            border-radius: 12px;
            box-shadow: 0 0 40px rgba(99, 102, 241, 0.5);
            background: #000;
        }

        .game-controls {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin: 2rem 0;
            flex-wrap: wrap;
        }

        .game-btn {
            padding: 1rem 2rem;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            font-family: 'Inter', sans-serif;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .game-btn-start {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
        }

        .game-btn-start:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.6);
        }

        .game-btn-pause {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.4);
        }

        .game-btn-pause:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.6);
        }

        .game-btn-restart {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.4);
        }

        .game-btn-restart:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.6);
        }

        .game-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }

        .stat-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(20px);
            border: 2px solid var(--border);
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s;
        }

        .stat-card:hover {
            border-color: var(--primary);
            transform: translateY(-2px);
        }

        .stat-label {
            font-size: 0.9rem;
            color: #94a3b8;
            margin-bottom: 0.5rem;
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .game-instructions {
            background: rgba(30, 41, 59, 0.5);
            border-left: 4px solid var(--primary);
            padding: 1.5rem;
            border-radius: 8px;
            margin: 2rem 0;
        }

        .game-instructions h3 {
            color: white;
            margin-bottom: 1rem;
        }

        .controls-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .control-item {
            background: rgba(15, 23, 42, 0.8);
            padding: 1rem;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .key-btn {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-weight: 700;
            min-width: 50px;
            text-align: center;
        }

        .game-over-screen {
            display: none;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(20px);
            border: 3px solid var(--primary);
            border-radius: 20px;
            padding: 3rem;
            text-align: center;
            z-index: 100;
            min-width: 400px;
        }

        .game-over-screen.show {
            display: block;
            animation: gameOverAppear 0.5s ease;
        }

        @keyframes gameOverAppear {
            from {
                opacity: 0;
                transform: translate(-50%, -50%) scale(0.8);
            }
            to {
                opacity: 1;
                transform: translate(-50%, -50%) scale(1);
            }
        }

        .game-over-title {
            font-size: 3rem;
            color: #ef4444;
            margin-bottom: 1rem;
        }

        .final-score {
            font-size: 2rem;
            color: var(--primary);
            margin: 1rem 0;
        }

        .canvas-wrapper {
            position: relative;
        }
    </style>
</head>
<body>
    <div class="stars"></div>
    <div class="stars2"></div>
    <div class="stars3"></div>

    <?php require_once __DIR__ . '/../partials/nav.php'; renderNav('game'); ?>

    <header class="hero">
        <div class="hero-container">
            <h1 class="hero-title">
                <span class="gradient-text">Завдання 6</span>
                Canvas - Космічна гра
            </h1>
            <p class="hero-subtitle">
                Гра з системою очок, перешкодами та Canvas API
            </p>
        </div>
    </header>

    <main class="container game-container">
        <section class="card">
            <div class="card-header">
                <div class="card-icon">🎮</div>
                <h2>Космічний уникач</h2>
            </div>
            <div class="card-content">
                <p>Керуйте ракетою, уникайте астероїдів та збирайте очки!</p>

                <div class="game-stats">
                    <div class="stat-card">
                        <div class="stat-label">🏆 Поточні очки</div>
                        <div class="stat-value" id="currentScore">0</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">⭐ Рекорд</div>
                        <div class="stat-value" id="highScore">0</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">💚 Життя</div>
                        <div class="stat-value" id="livesCount">3</div>
                    </div>
                </div>

                <div class="canvas-wrapper">
                    <canvas id="gameCanvas" width="800" height="600"></canvas>
                    <div class="game-over-screen" id="gameOverScreen">
                        <div class="game-over-title">💥 GAME OVER 💥</div>
                        <div class="final-score">
                            Ваш рахунок: <span id="finalScore">0</span>
                        </div>
                        <button class="game-btn game-btn-restart" onclick="restartGame()">
                            🔄 Грати знову
                        </button>
                    </div>
                </div>

                <div class="game-controls">
                    <button class="game-btn game-btn-start" id="startBtn" onclick="startGame()">
                        ▶️ Почати гру
                    </button>
                    <button class="game-btn game-btn-pause" id="pauseBtn" onclick="togglePause()">
                        ⏸️ Пауза
                    </button>
                    <button class="game-btn game-btn-restart" onclick="restartGame()">
                        🔄 Перезапустити
                    </button>
                </div>

                <div class="game-instructions">
                    <h3>🎯 Як грати:</h3>
                    <p>Використовуйте клавіші для керування ракетою. Уникайте червоних астероїдів та збирайте зелені зірки для отримання очок!</p>
                    
                    <div class="controls-list">
                        <div class="control-item">
                            <div class="key-btn">↑</div>
                            <span>Вгору</span>
                        </div>
                        <div class="control-item">
                            <div class="key-btn">↓</div>
                            <span>Вниз</span>
                        </div>
                        <div class="control-item">
                            <div class="key-btn">←</div>
                            <span>Вліво</span>
                        </div>
                        <div class="control-item">
                            <div class="key-btn">→</div>
                            <span>Вправо</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="card">
            <div class="card-header">
                <div class="card-icon">📚</div>
                <h2>Використані технології Canvas</h2>
            </div>
            <div class="card-content">
                <div class="feature-list">
                    <ul>
                        <li><code>canvas.getContext('2d')</code> - отримання 2D контексту</li>
                        <li><code>fillRect()</code>, <code>strokeRect()</code> - малювання фігур</li>
                        <li><code>beginPath()</code>, <code>arc()</code> - малювання кругів</li>
                        <li><code>fillText()</code> - відображення тексту</li>
                        <li><code>clearRect()</code> - очищення canvas</li>
                        <li><code>requestAnimationFrame()</code> - анімація</li>
                        <li><code>addEventListener('keydown')</code> - керування клавішами</li>
                        <li>Система колізій (перевірка зіткнень)</li>
                        <li>Генерація випадкових перешкод</li>
                        <li>LocalStorage для збереження рекорду</li>
                    </ul>
                </div>

                <div class="info-box">
                    💡 Відкрийте консоль (F12) щоб побачити логи гри та системи очок
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="footer-content">
            <p>© 2024 JavaScript Course Tasks</p>
            <p class="footer-links">
                <a href="/api-task">← Попереднє завдання</a>
                <span>•</span>
                <a href="/">Назад до головної</a>
            </p>
        </div>
    </footer>

    <script src="/resources/assets/js/game.js"></script>
</body>
</html>

