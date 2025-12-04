<?php

namespace Classes\Models;

use Classes\Database;
use Classes\Security;
use PDO;
use PDOException;

/**
 * Модель User для роботи з користувачами
 * 
 * Надає методи для роботи з користувачами в базі даних:
 * - Отримання користувача за ID
 * - Отримання всіх користувачів
 * - Оновлення даних користувача
 * - Видалення користувача
 * 
 * @package Classes\Models
 * @author Kostiantyn Surkov
 * @version 1.0
 * @since 2024
 */
class User
{
    /**
     * ID користувача
     * 
     * @var int|null
     */
    private ?int $id = null;

    /**
     * Username користувача
     * 
     * @var string
     */
    private string $username;

    /**
     * Email користувача
     * 
     * @var string
     */
    private string $email;

    /**
     * Хешований пароль користувача
     * 
     * @var string|null
     */
    private ?string $password = null;

    /**
     * Дата створення облікового запису
     * 
     * @var string|null
     */
    private ?string $createdAt = null;

    /**
     * Конструктор моделі User
     * 
     * @param string $username Username користувача
     * @param string $email Email користувача
     * @param int|null $id ID користувача (опціонально)
     * @param string|null $createdAt Дата створення (опціонально)
     */
    public function __construct(string $username, string $email, ?int $id = null, ?string $createdAt = null)
    {
        $this->username = $username;
        $this->email = $email;
        $this->id = $id;
        $this->createdAt = $createdAt;
    }

    /**
     * Отримує користувача за ID з бази даних
     * 
     * Виконує SELECT запит з використанням параметризованих запитів
     * для безпечного отримання даних користувача.
     * 
     * @param int $userId ID користувача
     * @param string $dbType Тип бази даних: 'sqlite' або 'mysql' (за замовчуванням 'sqlite')
     * @return self|null Об'єкт User або null якщо не знайдено
     * @throws PDOException Якщо виникає помилка при виконанні запиту
     * 
     * @example
     * <code>
     * $user = User::findById(1);
     * if ($user) {
     *     echo $user->getUsername();
     * }
     * </code>
     */
    public static function findById(int $userId, string $dbType = 'sqlite'): ?self
    {
        try {
            $pdo = Database::getConnection($dbType);
            
            // Параметризований запит для захисту від SQL ін'єкцій
            $stmt = $pdo->prepare("SELECT id, username, email, created_at FROM Users WHERE id = :id LIMIT 1");
            $stmt->execute([':id' => $userId]);
            
            $data = $stmt->fetch();
            
            if (!$data) {
                return null;
            }
            
            return new self(
                $data['username'],
                $data['email'],
                (int)$data['id'],
                $data['created_at'] ?? null
            );
            
        } catch (PDOException $e) {
            error_log("User findById error: " . $e->getMessage());
            throw new PDOException("Помилка отримання користувача: " . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Отримує користувача за username з бази даних
     * 
     * @param string $username Username користувача
     * @param string $dbType Тип бази даних (за замовчуванням 'sqlite')
     * @return self|null Об'єкт User або null якщо не знайдено
     * @throws PDOException Якщо виникає помилка при виконанні запиту
     */
    public static function findByUsername(string $username, string $dbType = 'sqlite'): ?self
    {
        try {
            $pdo = Database::getConnection($dbType);
            
            // Параметризований запит
            $stmt = $pdo->prepare("SELECT id, username, email, created_at FROM Users WHERE username = :username LIMIT 1");
            $stmt->execute([':username' => $username]);
            
            $data = $stmt->fetch();
            
            if (!$data) {
                return null;
            }
            
            return new self(
                $data['username'],
                $data['email'],
                (int)$data['id'],
                $data['created_at'] ?? null
            );
            
        } catch (PDOException $e) {
            error_log("User findByUsername error: " . $e->getMessage());
            throw new PDOException("Помилка отримання користувача: " . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Отримує всіх користувачів з бази даних
     * 
     * @param string $dbType Тип бази даних (за замовчуванням 'sqlite')
     * @param int|null $limit Обмеження кількості результатів (опціонально)
     * @param int $offset Зміщення для пагінації (за замовчуванням 0)
     * @return array<self> Масив об'єктів User
     * @throws PDOException Якщо виникає помилка при виконанні запиту
     * 
     * @example
     * <code>
     * $users = User::getAll();
     * foreach ($users as $user) {
     *     echo $user->getUsername() . "\n";
     * }
     * </code>
     */
    public static function getAll(string $dbType = 'sqlite', ?int $limit = null, int $offset = 0): array
    {
        try {
            $pdo = Database::getConnection($dbType);
            
            $sql = "SELECT id, username, email, created_at FROM Users ORDER BY id DESC";
            
            if ($limit !== null) {
                $sql .= " LIMIT :limit OFFSET :offset";
            }
            
            $stmt = $pdo->prepare($sql);
            
            if ($limit !== null) {
                $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
                $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            }
            
            $stmt->execute();
            
            $users = [];
            while ($data = $stmt->fetch()) {
                $users[] = new self(
                    $data['username'],
                    $data['email'],
                    (int)$data['id'],
                    $data['created_at'] ?? null
                );
            }
            
            return $users;
            
        } catch (PDOException $e) {
            error_log("User getAll error: " . $e->getMessage());
            throw new PDOException("Помилка отримання користувачів: " . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Зберігає користувача в базу даних
     * 
     * Якщо користувач має ID, виконує UPDATE, інакше - INSERT.
     * 
     * @param string $dbType Тип бази даних (за замовчуванням 'sqlite')
     * @return bool true якщо успішно збережено, false інакше
     * @throws PDOException Якщо виникає помилка при виконанні запиту
     */
    public function save(string $dbType = 'sqlite'): bool
    {
        try {
            $pdo = Database::getConnection($dbType);
            
            if ($this->id === null) {
                // INSERT - створення нового користувача
                if ($this->password === null) {
                    throw new \Exception("Пароль обов'язковий для створення користувача");
                }
                
                $stmt = $pdo->prepare("INSERT INTO Users (username, email, password) VALUES (:username, :email, :password)");
                $stmt->execute([
                    ':username' => $this->username,
                    ':email' => $this->email,
                    ':password' => $this->password
                ]);
                
                $this->id = (int)$pdo->lastInsertId();
            } else {
                // UPDATE - оновлення існуючого користувача
                $sql = "UPDATE Users SET username = :username, email = :email";
                $params = [
                    ':username' => $this->username,
                    ':email' => $this->email,
                    ':id' => $this->id
                ];
                
                if ($this->password !== null) {
                    $sql .= ", password = :password";
                    $params[':password'] = $this->password;
                }
                
                $sql .= " WHERE id = :id";
                
                $stmt = $pdo->prepare($sql);
                $stmt->execute($params);
            }
            
            return true;
            
        } catch (PDOException $e) {
            error_log("User save error: " . $e->getMessage());
            throw new PDOException("Помилка збереження користувача: " . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Видаляє користувача з бази даних
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
            
            // Параметризований запит для видалення
            $stmt = $pdo->prepare("DELETE FROM Users WHERE id = :id");
            $stmt->execute([':id' => $this->id]);
            
            return $stmt->rowCount() > 0;
            
        } catch (PDOException $e) {
            error_log("User delete error: " . $e->getMessage());
            throw new PDOException("Помилка видалення користувача: " . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Отримує кількість користувачів в базі даних
     * 
     * @param string $dbType Тип бази даних (за замовчуванням 'sqlite')
     * @return int Кількість користувачів
     * @throws PDOException Якщо виникає помилка при виконанні запиту
     */
    public static function count(string $dbType = 'sqlite'): int
    {
        try {
            $pdo = Database::getConnection($dbType);
            
            $stmt = $pdo->query("SELECT COUNT(*) as count FROM Users");
            $result = $stmt->fetch();
            
            return (int)($result['count'] ?? 0);
            
        } catch (PDOException $e) {
            error_log("User count error: " . $e->getMessage());
            throw new PDOException("Помилка підрахунку користувачів: " . $e->getMessage(), 0, $e);
        }
    }

    // Гетери
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    // Сетери
    public function setUsername(string $username): void
    {
        $this->username = Security::filterUsername($username) ?: $username;
    }

    public function setEmail(string $email): void
    {
        $this->email = Security::filterEmail($email) ?: $email;
    }

    public function setPassword(string $password): void
    {
        // Хешуємо пароль перед збереженням
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }
}

