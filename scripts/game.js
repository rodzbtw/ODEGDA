console.log('=== ЗАВДАННЯ 6: Canvas - Космічна гра ===\n');

// Отримуємо canvas та контекст
const canvas = document.getElementById('gameCanvas');
const ctx = canvas.getContext('2d');

console.log('✓ Canvas ініціалізовано:', canvas.width, 'x', canvas.height);
console.log('✓ 2D Context отримано:', ctx);

// Змінні гри
let gameRunning = false;
let gamePaused = false;
let animationId;
let score = 0;
let highScore = localStorage.getItem('spaceGameHighScore') || 0;
let lives = 3;
let gameSpeed = 2;

// Гравець (ракета)
const player = {
    x: 50,
    y: canvas.height / 2,
    width: 40,
    height: 60,
    speed: 5,
    color: '#6366f1'
};

// Масиви для перешкод та зірок
let obstacles = [];
let stars = [];

// Клавіші керування
const keys = {
    ArrowUp: false,
    ArrowDown: false,
    ArrowLeft: false,
    ArrowRight: false
};

console.log('✓ Ігрові об\'єкти ініціалізовані');

// === ОБРОБНИКИ ПОДІЙ ===

// Натискання клавіші
document.addEventListener('keydown', (e) => {
    if (keys.hasOwnProperty(e.key)) {
        keys[e.key] = true;
        e.preventDefault();
    }
});

// Відпускання клавіші
document.addEventListener('keyup', (e) => {
    if (keys.hasOwnProperty(e.key)) {
        keys[e.key] = false;
        e.preventDefault();
    }
});

console.log('✓ Обробники клавіш додано');

// === ФУНКЦІЇ МАЛЮВАННЯ (Canvas API) ===

/**
 * Малює ракету гравця
 * Використовує fillRect, beginPath, arc
 */
function drawPlayer() {
    // Тіло ракети
    ctx.fillStyle = player.color;
    ctx.fillRect(player.x, player.y, player.width, player.height);
    
    // Вікна ракети
    ctx.fillStyle = '#93c5fd';
    ctx.beginPath();
    ctx.arc(player.x + 20, player.y + 20, 8, 0, Math.PI * 2);
    ctx.fill();
    
    // Вогонь з двигуна
    ctx.fillStyle = '#fbbf24';
    ctx.beginPath();
    ctx.moveTo(player.x, player.y + player.height - 10);
    ctx.lineTo(player.x - 15, player.y + player.height / 2);
    ctx.lineTo(player.x, player.y + 10);
    ctx.closePath();
    ctx.fill();
}

/**
 * Малює перешкоду (астероїд)
 */
function drawObstacle(obstacle) {
    ctx.fillStyle = obstacle.color;
    ctx.beginPath();
    ctx.arc(obstacle.x, obstacle.y, obstacle.radius, 0, Math.PI * 2);
    ctx.fill();
    
    // Тінь
    ctx.strokeStyle = 'rgba(0, 0, 0, 0.5)';
    ctx.lineWidth = 3;
    ctx.stroke();
}

/**
 * Малює зірку (бонус)
 */
function drawStar(star) {
    ctx.fillStyle = star.color;
    ctx.beginPath();
    
    // Малюємо 5-кутну зірку
    for (let i = 0; i < 5; i++) {
        const angle = (Math.PI * 2 * i) / 5 - Math.PI / 2;
        const x = star.x + Math.cos(angle) * star.radius;
        const y = star.y + Math.sin(angle) * star.radius;
        
        if (i === 0) {
            ctx.moveTo(x, y);
        } else {
            ctx.lineTo(x, y);
        }
    }
    
    ctx.closePath();
    ctx.fill();
}

/**
 * Малює фон з анімованими зірками
 */
function drawBackground() {
    // Чорний фон
    ctx.fillStyle = '#000';
    ctx.fillRect(0, 0, canvas.width, canvas.height);
    
    // Білі точки-зірки на фоні
    ctx.fillStyle = 'rgba(255, 255, 255, 0.5)';
    for (let i = 0; i < 50; i++) {
        const x = (i * 30 + Date.now() * 0.05) % canvas.width;
        const y = (i * 47) % canvas.height;
        ctx.fillRect(x, y, 2, 2);
    }
}

/**
 * Відображає інформацію на екрані
 * Використовує fillText
 */
function drawUI() {
    ctx.fillStyle = '#fff';
    ctx.font = 'bold 24px Inter';
    ctx.fillText(`Очки: ${score}`, 20, 40);
    ctx.fillText(`Життя: ${'❤️'.repeat(lives)}`, 20, 80);
    ctx.fillText(`Рекорд: ${highScore}`, canvas.width - 200, 40);
    
    if (gamePaused) {
        ctx.fillStyle = 'rgba(0, 0, 0, 0.7)';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        
        ctx.fillStyle = '#fff';
        ctx.font = 'bold 48px Inter';
        ctx.textAlign = 'center';
        ctx.fillText('ПАУЗА', canvas.width / 2, canvas.height / 2);
        ctx.textAlign = 'left';
    }
}

// === ЛОГІКА ГРИ ===

/**
 * Оновлює позицію гравця
 */
function updatePlayer() {
    if (keys.ArrowUp && player.y > 0) {
        player.y -= player.speed;
    }
    if (keys.ArrowDown && player.y < canvas.height - player.height) {
        player.y += player.speed;
    }
    if (keys.ArrowLeft && player.x > 0) {
        player.x -= player.speed;
    }
    if (keys.ArrowRight && player.x < canvas.width - player.width) {
        player.x += player.speed;
    }
}

/**
 * Створює нову перешкоду
 */
function createObstacle() {
    const radius = Math.random() * 30 + 20;
    obstacles.push({
        x: canvas.width + radius,
        y: Math.random() * (canvas.height - radius * 2) + radius,
        radius: radius,
        speed: gameSpeed + Math.random() * 2,
        color: '#ef4444'
    });
}

/**
 * Створює нову зірку (бонус)
 */
function createStar() {
    stars.push({
        x: canvas.width + 20,
        y: Math.random() * (canvas.height - 40) + 20,
        radius: 15,
        speed: gameSpeed,
        color: '#10b981'
    });
}

/**
 * Оновлює перешкоди
 */
function updateObstacles() {
    obstacles = obstacles.filter(obstacle => obstacle.x + obstacle.radius > 0);
    
    obstacles.forEach(obstacle => {
        obstacle.x -= obstacle.speed;
    });
    
    // Створюємо нову перешкоду випадково
    if (Math.random() < 0.02) {
        createObstacle();
        console.log('🪨 Створено нову перешкоду');
    }
}

/**
 * Оновлює зірки
 */
function updateStars() {
    stars = stars.filter(star => star.x + star.radius > 0);
    
    stars.forEach(star => {
        star.x -= star.speed;
    });
    
    // Створюємо нову зірку випадково
    if (Math.random() < 0.01) {
        createStar();
        console.log('⭐ Створено нову зірку');
    }
}

/**
 * Перевірка колізій (зіткнень)
 * Використовує математику для перевірки перетину кругів
 */
function checkCollisions() {
    // Перевірка зіткнення з перешкодами
    obstacles.forEach((obstacle, index) => {
        const dx = (player.x + player.width / 2) - obstacle.x;
        const dy = (player.y + player.height / 2) - obstacle.y;
        const distance = Math.sqrt(dx * dx + dy * dy);
        
        if (distance < obstacle.radius + 20) {
            console.warn('💥 ЗІТКНЕННЯ з астероїдом!');
            obstacles.splice(index, 1);
            lives--;
            updateLivesDisplay();
            
            // Перевірка програшу
            if (lives <= 0) {
                gameOver();
            }
        }
    });
    
    // Перевірка збору зірок
    stars.forEach((star, index) => {
        const dx = (player.x + player.width / 2) - star.x;
        const dy = (player.y + player.height / 2) - star.y;
        const distance = Math.sqrt(dx * dx + dy * dy);
        
        if (distance < star.radius + 20) {
            console.log('✨ Зірку зібрано! +10 очок');
            stars.splice(index, 1);
            score += 10;
            updateScoreDisplay();
        }
    });
}

/**
 * Оновлює очки
 */
function updateScore() {
    score++;
    if (score % 10 === 0) {
        updateScoreDisplay();
        
        // Збільшуємо складність
        if (score % 100 === 0) {
            gameSpeed += 0.5;
            console.log('⚡ Швидкість збільшено до:', gameSpeed);
        }
    }
}

/**
 * Головний ігровий цикл
 * Використовує requestAnimationFrame
 */
function gameLoop() {
    if (!gameRunning || gamePaused) return;
    
    // Очищаємо canvas
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    
    // Малюємо все
    drawBackground();
    drawPlayer();
    obstacles.forEach(drawObstacle);
    stars.forEach(drawStar);
    drawUI();
    
    // Оновлюємо логіку
    updatePlayer();
    updateObstacles();
    updateStars();
    checkCollisions();
    updateScore();
    
    // Продовжуємо цикл
    animationId = requestAnimationFrame(gameLoop);
}

// === КЕРУВАННЯ ГРОЮ ===

/**
 * Початок гри
 */
function startGame() {
    if (gameRunning) return;
    
    console.log('\n🚀 === ГРА ПОЧАЛАСЯ ===');
    gameRunning = true;
    gamePaused = false;
    
    document.getElementById('startBtn').disabled = true;
    
    gameLoop();
}

/**
 * Пауза/Продовження
 */
function togglePause() {
    if (!gameRunning) return;
    
    gamePaused = !gamePaused;
    console.log(gamePaused ? '⏸️ ПАУЗА' : '▶️ ПРОДОВЖЕННЯ');
    
    if (!gamePaused) {
        gameLoop();
    }
}

/**
 * Перезапуск гри
 */
function restartGame() {
    console.log('\n🔄 === ПЕРЕЗАПУСК ГРИ ===');
    
    // Зупиняємо поточну гру
    gameRunning = false;
    gamePaused = false;
    cancelAnimationFrame(animationId);
    
    // Скидаємо значення
    score = 0;
    lives = 3;
    gameSpeed = 2;
    obstacles = [];
    stars = [];
    
    // Скидаємо позицію гравця
    player.x = 50;
    player.y = canvas.height / 2;
    
    // Ховаємо екран програшу
    document.getElementById('gameOverScreen').classList.remove('show');
    document.getElementById('startBtn').disabled = false;
    
    // Оновлюємо UI
    updateScoreDisplay();
    updateLivesDisplay();
    
    // Очищаємо canvas
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    drawBackground();
    drawPlayer();
    
    console.log('✅ Гра перезапущена');
}

/**
 * Кінець гри
 */
function gameOver() {
    console.log('\n💀 === GAME OVER ===');
    console.log('Фінальний рахунок:', score);
    
    gameRunning = false;
    cancelAnimationFrame(animationId);
    
    // Оновлюємо рекорд
    if (score > highScore) {
        highScore = score;
        localStorage.setItem('spaceGameHighScore', highScore);
        console.log('🏆 НОВИЙ РЕКОРД:', highScore);
    }
    
    // Показуємо екран програшу
    document.getElementById('finalScore').textContent = score;
    document.getElementById('gameOverScreen').classList.add('show');
    document.getElementById('startBtn').disabled = false;
    
    updateHighScoreDisplay();
}

// === ОНОВЛЕННЯ UI ===

function updateScoreDisplay() {
    document.getElementById('currentScore').textContent = score;
}

function updateHighScoreDisplay() {
    document.getElementById('highScore').textContent = highScore;
}

function updateLivesDisplay() {
    document.getElementById('livesCount').textContent = lives;
}

// === ІНІЦІАЛІЗАЦІЯ ===

// Відображаємо початковий екран
drawBackground();
drawPlayer();
updateHighScoreDisplay();

console.log('\n📋 === ІНСТРУКЦІЇ ===');
console.log('🎮 Використовуйте стрілки для керування');
console.log('🪨 Уникайте червоних астероїдів');
console.log('⭐ Збирайте зелені зірки (+10 очок)');
console.log('💚 У вас є 3 життя');
console.log('\n✅ Гра готова! Натисніть "Почати гру"');


