<?php

namespace Classes\Models;

use Classes\Database;
use Classes\Security;
use PDO;
use PDOException;

/**
 * Модель TaskModel для управління завданнями користувачів
 * 
 * Відповідає за логіку роботи з завданнями в додатку:
 * - Вивантаження завдань з DB
 * - Створення нових завдань
 * - Редагування завдань
 * - Видалення завдань
 * - Пошук та фільтрація завдань
 * 
 * @package Classes\Models
 * @author Kostiantyn Surkov
 * @version 1.0
 * @since 2024
 */
class TaskModel
{
    /**
     * ID завдання
     * 
     * @var int|null
     */
    private ?int $id = null;

    /**
     * ID користувача, який створив завдання
     * 
     * @var int
     */
    private int $userId;

    /**
     * Назва завдання
     * 
     * @var string
     */
    private string $title;

    /**
     * Опис завдання
     * 
     * @var string
     */
    private string $description;

    /**
     * Статус завдання (pending, in_progress, completed)
     * 
     * @var string
     */
    private string $status;

    /**
     * Пріоритет завдання (low, medium, high)
     * 
     * @var string
     */
    private string $priority;

    /**
     * Дата створення завдання
     * 
     * @var string|null
     */
    private ?string $createdAt = null;

    /**
     * Дата оновлення завдання
     * 
     * @var string|null
     */
    private ?string $updatedAt = null;

    /**
     * Конструктор моделі TaskModel
     * 
     * @param int $userId ID користувача
     * @param string $title Назва завдання
     * @param string $description Опис завдання
     * @param string $status Статус завдання (за замовчуванням 'pending')
     * @param string $priority Пріоритет завдання (за замовчуванням 'medium')
     * @param int|null $id ID завдання (опціонально)
     * @param string|null $createdAt Дата створення (опціонально)
     * @param string|null $updatedAt Дата оновлення (опціонально)
     */
    public function __construct(
        int $userId,
        string $title,
        string $description,
        string $status = 'pending',
        string $priority = 'medium',
        ?int $id = null,
        ?string $createdAt = null,
        ?string $updatedAt = null
    ) {
        $this->userId = $userId;
        $this->title = $title;
        $this->description = $description;
        $this->status = $status;
        $this->priority = $priority;
        $this->id = $id;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    /**
     * Ініціалізує таблицю Tasks якщо вона не існує
     * 
     * @param PDO $pdo Підключення до бази даних
     * @return bool true якщо таблиця створена або вже існує
     * @throws PDOException Якщо не вдається створити таблицю
     */
    public static function initTable(PDO $pdo): bool
    {
        try {
            $sql = "CREATE TABLE IF NOT EXISTS Tasks (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                user_id INTEGER NOT NULL,
                title VARCHAR(255) NOT NULL,
                description TEXT,
                status VARCHAR(20) DEFAULT 'pending',
                priority VARCHAR(20) DEFAULT 'medium',
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES Users(id) ON DELETE CASCADE
            )";
            
            // Для MySQL
            if (Database::getCurrentConnection() && strpos($pdo->getAttribute(PDO::ATTR_DRIVER_NAME), 'mysql') !== false) {
                $sql = "CREATE TABLE IF NOT EXISTS Tasks (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    user_id INT NOT NULL,
                    title VARCHAR(255) NOT NULL,
                    description TEXT,
                    status VARCHAR(20) DEFAULT 'pending',
                    priority VARCHAR(20) DEFAULT 'medium',
                    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    FOREIGN KEY (user_id) REFERENCES Users(id) ON DELETE CASCADE
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
            }
            
            $pdo->exec($sql);
            return true;
        } catch (PDOException $e) {
            error_log("Tasks table creation error: " . $e->getMessage());
            throw new PDOException("Помилка створення таблиці Tasks: " . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Отримує завдання за ID з бази даних
     * 
     * @param int $taskId ID завдання
     * @param string $dbType Тип бази даних (за замовчуванням 'sqlite')
     * @return self|null Об'єкт TaskModel або null якщо не знайдено
     * @throws PDOException Якщо виникає помилка при виконанні запиту
     */
    public static function findById(int $taskId, string $dbType = 'sqlite'): ?self
    {
        try {
            $pdo = Database::getConnection($dbType);
            self::initTable($pdo);
            
            // Параметризований запит
            $stmt = $pdo->prepare("SELECT id, user_id, title, description, status, priority, created_at, updated_at FROM Tasks WHERE id = :id LIMIT 1");
            $stmt->execute([':id' => $taskId]);
            
            $data = $stmt->fetch();
            
            if (!$data) {
                return null;
            }
            
            return new self(
                (int)$data['user_id'],
                $data['title'],
                $data['description'],
                $data['status'],
                $data['priority'],
                (int)$data['id'],
                $data['created_at'] ?? null,
                $data['updated_at'] ?? null
            );
            
        } catch (PDOException $e) {
            error_log("Task findById error: " . $e->getMessage());
            throw new PDOException("Помилка отримання завдання: " . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Отримує всі завдання користувача з бази даних
     * 
     * Виконує SELECT запит для отримання всіх завдань конкретного користувача
     * з можливістю фільтрації за статусом та пріоритетом.
     * 
     * @param int $userId ID користувача
     * @param string|null $status Фільтр за статусом (опціонально)
     * @param string|null $priority Фільтр за пріоритетом (опціонально)
     * @param string $dbType Тип бази даних (за замовчуванням 'sqlite')
     * @param int|null $limit Обмеження кількості результатів (опціонально)
     * @param int $offset Зміщення для пагінації (за замовчуванням 0)
     * @return array<self> Масив об'єктів TaskModel
     * @throws PDOException Якщо виникає помилка при виконанні запиту
     * 
     * @example
     * <code>
     * // Отримати всі завдання користувача
     * $tasks = TaskModel::getAllByUserId(1);
     * 
     * // Отримати тільки завершені завдання
     * $completedTasks = TaskModel::getAllByUserId(1, 'completed');
     * </code>
     */
    public static function getAllByUserId(
        int $userId,
        ?string $status = null,
        ?string $priority = null,
        string $dbType = 'sqlite',
        ?int $limit = null,
        int $offset = 0
    ): array {
        try {
            $pdo = Database::getConnection($dbType);
            self::initTable($pdo);
            
            // Побудова запиту з фільтрами
            $sql = "SELECT id, user_id, title, description, status, priority, created_at, updated_at 
                    FROM Tasks 
                    WHERE user_id = :user_id";
            
            $params = [':user_id' => $userId];
            
            if ($status !== null) {
                $sql .= " AND status = :status";
                $params[':status'] = $status;
            }
            
            if ($priority !== null) {
                $sql .= " AND priority = :priority";
                $params[':priority'] = $priority;
            }
            
            $sql .= " ORDER BY created_at DESC";
            
            if ($limit !== null) {
                $sql .= " LIMIT :limit OFFSET :offset";
            }
            
            $stmt = $pdo->prepare($sql);
            
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
            }
            
            if ($limit !== null) {
                $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
                $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            }
            
            $stmt->execute();
            
            $tasks = [];
            while ($data = $stmt->fetch()) {
                $tasks[] = new self(
                    (int)$data['user_id'],
                    $data['title'],
                    $data['description'],
                    $data['status'],
                    $data['priority'],
                    (int)$data['id'],
                    $data['created_at'] ?? null,
                    $data['updated_at'] ?? null
                );
            }
            
            return $tasks;
            
        } catch (PDOException $e) {
            error_log("Task getAllByUserId error: " . $e->getMessage());
            throw new PDOException("Помилка отримання завдань: " . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Створює нове завдання в базі даних
     * 
     * Виконує INSERT запит для створення нового завдання.
     * 
     * @param int $userId ID користувача
     * @param string $title Назва завдання
     * @param string $description Опис завдання
     * @param string $status Статус завдання (за замовчуванням 'pending')
     * @param string $priority Пріоритет завдання (за замовчуванням 'medium')
     * @param string $dbType Тип бази даних (за замовчуванням 'sqlite')
     * @return self|null Створене завдання або null при помилці
     * @throws PDOException Якщо виникає помилка при виконанні запиту
     */
    public static function create(
        int $userId,
        string $title,
        string $description,
        string $status = 'pending',
        string $priority = 'medium',
        string $dbType = 'sqlite'
    ): ?self {
        try {
            $pdo = Database::getConnection($dbType);
            self::initTable($pdo);
            
            // Фільтрація вхідних даних від XSS
            $title = Security::filterInput($title);
            $description = Security::filterInput($description);
            
            // Параметризований INSERT запит
            $stmt = $pdo->prepare("INSERT INTO Tasks (user_id, title, description, status, priority) 
                                    VALUES (:user_id, :title, :description, :status, :priority)");
            $stmt->execute([
                ':user_id' => $userId,
                ':title' => $title,
                ':description' => $description,
                ':status' => $status,
                ':priority' => $priority
            ]);
            
            $taskId = (int)$pdo->lastInsertId();
            
            // Повертаємо створене завдання
            return self::findById($taskId, $dbType);
            
        } catch (PDOException $e) {
            error_log("Task create error: " . $e->getMessage());
            throw new PDOException("Помилка створення завдання: " . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Оновлює завдання в базі даних
     * 
     * Виконує UPDATE запит для оновлення даних завдання.
     * 
     * @param string $dbType Тип бази даних (за замовчуванням 'sqlite')
     * @return bool true якщо успішно оновлено, false інакше
     * @throws PDOException Якщо виникає помилка при виконанні запиту
     */
    public function update(string $dbType = 'sqlite'): bool
    {
        if ($this->id === null) {
            return false;
        }
        
        try {
            $pdo = Database::getConnection($dbType);
            
            // Фільтрація даних від XSS
            $title = Security::filterInput($this->title);
            $description = Security::filterInput($this->description);
            
            // Параметризований UPDATE запит
            $stmt = $pdo->prepare("UPDATE Tasks 
                                    SET title = :title, 
                                        description = :description, 
                                        status = :status, 
                                        priority = :priority,
                                        updated_at = CURRENT_TIMESTAMP
                                    WHERE id = :id");
            $stmt->execute([
                ':title' => $title,
                ':description' => $description,
                ':status' => $this->status,
                ':priority' => $this->priority,
                ':id' => $this->id
            ]);
            
            return $stmt->rowCount() > 0;
            
        } catch (PDOException $e) {
            error_log("Task update error: " . $e->getMessage());
            throw new PDOException("Помилка оновлення завдання: " . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Видаляє завдання з бази даних
     * 
     * Виконує DELETE запит для видалення завдання.
     * 
     * @param string $dbType Тип бази даних (за замовчуванням 'sqlite')
     * @return bool true якщо успішно видалено, false інакше
     * @throws PDOException Якщо виникає помилка при виконанні запиту
     */
    public function delete(string $dbType = 'sqlite'): bool
    {
        if ($this->id === null) {
            return false;
        }
        
        try {
            $pdo = Database::getConnection($dbType);
            
            // Параметризований DELETE запит
            $stmt = $pdo->prepare("DELETE FROM Tasks WHERE id = :id");
            $stmt->execute([':id' => $this->id]);
            
            return $stmt->rowCount() > 0;
            
        } catch (PDOException $e) {
            error_log("Task delete error: " . $e->getMessage());
            throw new PDOException("Помилка видалення завдання: " . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Отримує кількість завдань користувача
     * 
     * @param int $userId ID користувача
     * @param string|null $status Фільтр за статусом (опціонально)
     * @param string $dbType Тип бази даних (за замовчуванням 'sqlite')
     * @return int Кількість завдань
     * @throws PDOException Якщо виникає помилка при виконанні запиту
     */
    public static function countByUserId(int $userId, ?string $status = null, string $dbType = 'sqlite'): int
    {
        try {
            $pdo = Database::getConnection($dbType);
            self::initTable($pdo);
            
            $sql = "SELECT COUNT(*) as count FROM Tasks WHERE user_id = :user_id";
            $params = [':user_id' => $userId];
            
            if ($status !== null) {
                $sql .= " AND status = :status";
                $params[':status'] = $status;
            }
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            
            $result = $stmt->fetch();
            return (int)($result['count'] ?? 0);
            
        } catch (PDOException $e) {
            error_log("Task countByUserId error: " . $e->getMessage());
            throw new PDOException("Помилка підрахунку завдань: " . $e->getMessage(), 0, $e);
        }
    }

    // Гетери
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getPriority(): string
    {
        return $this->priority;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    // Сетери
    public function setTitle(string $title): void
    {
        $this->title = Security::filterInput($title);
    }

    public function setDescription(string $description): void
    {
        $this->description = Security::filterInput($description);
    }

    public function setStatus(string $status): void
    {
        $allowedStatuses = ['pending', 'in_progress', 'completed'];
        if (in_array($status, $allowedStatuses)) {
            $this->status = $status;
        }
    }

    public function setPriority(string $priority): void
    {
        $allowedPriorities = ['low', 'medium', 'high'];
        if (in_array($priority, $allowedPriorities)) {
            $this->priority = $priority;
        }
    }
}

