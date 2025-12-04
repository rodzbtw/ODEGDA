<?php
/**
 * Сторінка управління завданнями
 * 
 * Демонструє використання моделей User та TaskModel
 * для CRUD операцій з завданнями.
 */

// Запускаємо сесію
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../app/Classes/Security.php';
require_once __DIR__ . '/../../app/Classes/Models/User.php';
require_once __DIR__ . '/../../app/Classes/Models/TaskModel.php';

use Classes\Security;
use Classes\Models\User;
use Classes\Models\TaskModel;

$page_title = Security::escape('Управління завданнями');

// Обробка POST запитів
$message = null;
$messageType = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    try {
        switch ($action) {
            case 'create':
                $userId = (int)($_POST['user_id'] ?? 1);
                $title = $_POST['title'] ?? '';
                $description = $_POST['description'] ?? '';
                $status = $_POST['status'] ?? 'pending';
                $priority = $_POST['priority'] ?? 'medium';
                
                $task = TaskModel::create($userId, $title, $description, $status, $priority);
                if ($task) {
                    $message = 'Завдання успішно створено!';
                    $messageType = 'success';
                }
                break;
                
            case 'update':
                $taskId = (int)($_POST['task_id'] ?? 0);
                $task = TaskModel::findById($taskId);
                if ($task) {
                    $task->setTitle($_POST['title'] ?? '');
                    $task->setDescription($_POST['description'] ?? '');
                    $task->setStatus($_POST['status'] ?? 'pending');
                    $task->setPriority($_POST['priority'] ?? 'medium');
                    
                    if ($task->update()) {
                        $message = 'Завдання успішно оновлено!';
                        $messageType = 'success';
                    }
                }
                break;
                
            case 'delete':
                $taskId = (int)($_POST['task_id'] ?? 0);
                $task = TaskModel::findById($taskId);
                if ($task && $task->delete()) {
                    $message = 'Завдання успішно видалено!';
                    $messageType = 'success';
                }
                break;
        }
    } catch (\Exception $e) {
        $message = 'Помилка: ' . $e->getMessage();
        $messageType = 'error';
    }
}

// Отримуємо дані для відображення
$users = User::getAll();
$tasks = TaskModel::getAllByUserId(1); // Завдання першого користувача
$taskCount = TaskModel::countByUserId(1);
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="/resources/assets/css/main.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        .task-card {
            background: rgba(30, 41, 59, 0.7);
            border: 2px solid var(--border);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.3s;
        }
        .task-card:hover {
            border-color: var(--primary);
            transform: translateY(-2px);
        }
        .task-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 1rem;
        }
        .task-status {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
        }
        .status-pending { background: rgba(245, 158, 11, 0.2); color: #f59e0b; }
        .status-in_progress { background: rgba(59, 130, 246, 0.2); color: #3b82f6; }
        .status-completed { background: rgba(16, 185, 129, 0.2); color: #10b981; }
        .task-priority {
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .priority-low { background: rgba(156, 163, 175, 0.2); color: #9ca3af; }
        .priority-medium { background: rgba(245, 158, 11, 0.2); color: #f59e0b; }
        .priority-high { background: rgba(239, 68, 68, 0.2); color: #ef4444; }
        .task-actions {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
        }
        .btn-small {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
    <div class="stars"></div>
    <div class="stars2"></div>
    <div class="stars3"></div>

    <?php require_once __DIR__ . '/../partials/nav.php'; renderNav('tasks'); ?>

    <header class="hero">
        <div class="hero-container">
            <h1 class="hero-title">
                <span class="gradient-text">Управління завданнями</span>
                CRUD операції з моделями
            </h1>
            <p class="hero-subtitle">
                Демонстрація роботи з моделями User та TaskModel
            </p>
        </div>
    </header>

    <main class="container">
        <?php if ($message): ?>
            <div class="result show <?php echo $messageType; ?>" style="margin-bottom: 2rem;">
                <?php echo Security::escape($message); ?>
            </div>
        <?php endif; ?>

        <!-- Статистика -->
        <section class="card">
            <div class="card-header">
                <div class="card-icon">📊</div>
                <h2>Статистика</h2>
            </div>
            <div class="card-content">
                <p>Всього користувачів: <strong><?php echo User::count(); ?></strong></p>
                <p>Всього завдань: <strong><?php echo $taskCount; ?></strong></p>
            </div>
        </section>

        <!-- Створення завдання -->
        <section class="card">
            <div class="card-header">
                <div class="card-icon">➕</div>
                <h2>Створити нове завдання</h2>
            </div>
            <div class="card-content">
                <form method="POST" action="/tasks">
                    <input type="hidden" name="action" value="create">
                    
                    <div class="form-group">
                        <label for="user_id">Користувач:</label>
                        <select name="user_id" id="user_id" required style="width: 100%; padding: 1rem; background: rgba(30, 41, 59, 0.5); border: 2px solid var(--border); border-radius: 12px; color: white;">
                            <?php foreach ($users as $user): ?>
                                <option value="<?php echo $user->getId(); ?>">
                                    <?php echo Security::escape($user->getUsername()); ?> (<?php echo Security::escape($user->getEmail()); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="title">Назва завдання:</label>
                        <input type="text" name="title" id="title" required placeholder="Введіть назву завдання">
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Опис:</label>
                        <textarea name="description" id="description" rows="4" required placeholder="Введіть опис завдання" style="width: 100%; padding: 1rem; background: rgba(30, 41, 59, 0.5); border: 2px solid var(--border); border-radius: 12px; color: white; font-family: inherit;"></textarea>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label for="status">Статус:</label>
                            <select name="status" id="status" required style="width: 100%; padding: 1rem; background: rgba(30, 41, 59, 0.5); border: 2px solid var(--border); border-radius: 12px; color: white;">
                                <option value="pending">Pending</option>
                                <option value="in_progress">In Progress</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="priority">Пріоритет:</label>
                            <select name="priority" id="priority" required style="width: 100%; padding: 1rem; background: rgba(30, 41, 59, 0.5); border: 2px solid var(--border); border-radius: 12px; color: white;">
                                <option value="low">Low</option>
                                <option value="medium" selected>Medium</option>
                                <option value="high">High</option>
                            </select>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <span class="btn-icon">➕</span>
                        Створити завдання
                    </button>
                </form>
            </div>
        </section>

        <!-- Список завдань -->
        <section class="card">
            <div class="card-header">
                <div class="card-icon">📋</div>
                <h2>Список завдань</h2>
            </div>
            <div class="card-content">
                <?php if (empty($tasks)): ?>
                    <p style="text-align: center; color: #94a3b8;">Завдань поки немає. Створіть перше завдання!</p>
                <?php else: ?>
                    <?php foreach ($tasks as $task): ?>
                        <div class="task-card">
                            <div class="task-header">
                                <div>
                                    <h3 style="margin: 0 0 0.5rem 0; color: white;">
                                        <?php echo Security::escape($task->getTitle()); ?>
                                    </h3>
                                    <p style="color: #94a3b8; margin: 0;">
                                        <?php echo Security::escape($task->getDescription()); ?>
                                    </p>
                                </div>
                                <div style="text-align: right;">
                                    <span class="task-status status-<?php echo $task->getStatus(); ?>">
                                        <?php echo Security::escape(ucfirst(str_replace('_', ' ', $task->getStatus()))); ?>
                                    </span>
                                    <br>
                                    <span class="task-priority priority-<?php echo $task->getPriority(); ?>" style="margin-top: 0.5rem; display: inline-block;">
                                        <?php echo Security::escape(ucfirst($task->getPriority())); ?>
                                    </span>
                                </div>
                            </div>
                            
                            <div style="font-size: 0.875rem; color: #64748b; margin-top: 1rem;">
                                Створено: <?php echo Security::escape($task->getCreatedAt() ?? 'N/A'); ?>
                                <?php if ($task->getUpdatedAt()): ?>
                                    | Оновлено: <?php echo Security::escape($task->getUpdatedAt()); ?>
                                <?php endif; ?>
                            </div>
                            
                            <div class="task-actions">
                                <form method="POST" action="/tasks" style="display: inline;">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="task_id" value="<?php echo $task->getId(); ?>">
                                    <button type="submit" class="btn btn-secondary btn-small" onclick="return confirm('Ви впевнені?')">
                                        🗑️ Видалити
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
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

