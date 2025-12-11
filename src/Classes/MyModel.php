<?php
namespace Classes;

use PDO;
use PDOException;

/**
 * Модель MyModel для логіки застосунку
 * 
 * Відповідає за роботу з завданнями системи:
 * - Отримання всіх завдань
 * - Створення нового завдання
 * - Редагування завдання
 * - Видалення завдання
 * 
 * @package Classes
 * @author Kostiantyn Surkov
 * @version 1.0
 * @since 2024
 */
class MyModel
{
    /**
     * Отримати всі завдання з бази даних
     * 
     * @param string $dbType Тип бази даних (за замовчуванням 'sqlite')
     * @return array Масив завдань
     * @throws PDOException Якщо виникає помилка при виконанні запиту
     */
    public static function getAllTasks(string $dbType = 'sqlite'): array
    {
        try {
            $pdo = Database::getConnection($dbType);
            
            $stmt = $pdo->query("SELECT * FROM tasks ORDER BY created_at DESC");
            $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $tasks;
            
        } catch (PDOException $e) {
            error_log("MyModel getAllTasks error: " . $e->getMessage());
            throw new PDOException("Помилка отримання завдань: " . $e->getMessage(), 0, $e);
        }
    }
    
    /**
     * Створити нове завдання
     * 
     * @param string $title Назва завдання
     * @param string $description Опис завдання
     * @param int $userId ID користувача
     * @param string $dbType Тип бази даних (за замовчуванням 'sqlite')
     * @return bool true якщо успішно створено
     * @throws PDOException Якщо виникає помилка при виконанні запиту
     */
    public static function createTask(string $title, string $description, int $userId, string $dbType = 'sqlite'): bool
    {
        try {
            $pdo = Database::getConnection($dbType);
            
            $stmt = $pdo->prepare("INSERT INTO tasks (title, description, user_id, created_at) VALUES (:title, :description, :user_id, datetime('now'))");
            $result = $stmt->execute([
                ':title' => Security::escape($title),
                ':description' => Security::escape($description),
                ':user_id' => $userId
            ]);
            
            return $result;
            
        } catch (PDOException $e) {
            error_log("MyModel createTask error: " . $e->getMessage());
            throw new PDOException("Помилка створення завдання: " . $e->getMessage(), 0, $e);
        }
    }
    
    /**
     * Оновити завдання
     * 
     * @param int $taskId ID завдання
     * @param string $title Назва завдання
     * @param string $description Опис завдання
     * @param string $dbType Тип бази даних (за замовчуванням 'sqlite')
     * @return bool true якщо успішно оновлено
     * @throws PDOException Якщо виникає помилка при виконанні запиту
     */
    public static function updateTask(int $taskId, string $title, string $description, string $dbType = 'sqlite'): bool
    {
        try {
            $pdo = Database::getConnection($dbType);
            
            $stmt = $pdo->prepare("UPDATE tasks SET title = :title, description = :description, updated_at = datetime('now') WHERE id = :id");
            $result = $stmt->execute([
                ':title' => Security::escape($title),
                ':description' => Security::escape($description),
                ':id' => $taskId
            ]);
            
            return $result && $stmt->rowCount() > 0;
            
        } catch (PDOException $e) {
            error_log("MyModel updateTask error: " . $e->getMessage());
            throw new PDOException("Помилка оновлення завдання: " . $e->getMessage(), 0, $e);
        }
    }
    
    /**
     * Видалити завдання
     * 
     * @param int $taskId ID завдання
     * @param string $dbType Тип бази даних (за замовчуванням 'sqlite')
     * @return bool true якщо успішно видалено
     * @throws PDOException Якщо виникає помилка при виконанні запиту
     */
    public static function deleteTask(int $taskId, string $dbType = 'sqlite'): bool
    {
        try {
            $pdo = Database::getConnection($dbType);
            
            $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = :id");
            $result = $stmt->execute([':id' => $taskId]);
            
            return $result && $stmt->rowCount() > 0;
            
        } catch (PDOException $e) {
            error_log("MyModel deleteTask error: " . $e->getMessage());
            throw new PDOException("Помилка видалення завдання: " . $e->getMessage(), 0, $e);
        }
    }
    
    /**
     * Отримати завдання за ID
     * 
     * @param int $taskId ID завдання
     * @param string $dbType Тип бази даних (за замовчуванням 'sqlite')
     * @return array|null Дані завдання або null
     * @throws PDOException Якщо виникає помилка при виконанні запиту
     */
    public static function getTaskById(int $taskId, string $dbType = 'sqlite'): ?array
    {
        try {
            $pdo = Database::getConnection($dbType);
            
            $stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = :id LIMIT 1");
            $stmt->execute([':id' => $taskId]);
            
            $task = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $task ?: null;
            
        } catch (PDOException $e) {
            error_log("MyModel getTaskById error: " . $e->getMessage());
            throw new PDOException("Помилка отримання завдання: " . $e->getMessage(), 0, $e);
        }
    }
    
    /**
     * Отримати завдання користувача
     * 
     * @param int $userId ID користувача
     * @param string $dbType Тип бази даних (за замовчуванням 'sqlite')
     * @return array Масив завдань користувача
     * @throws PDOException Якщо виникає помилка при виконанні запиту
     */
    public static function getTasksByUser(int $userId, string $dbType = 'sqlite'): array
    {
        try {
            $pdo = Database::getConnection($dbType);
            
            $stmt = $pdo->prepare("SELECT * FROM tasks WHERE user_id = :user_id ORDER BY created_at DESC");
            $stmt->execute([':user_id' => $userId]);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("MyModel getTasksByUser error: " . $e->getMessage());
            throw new PDOException("Помилка отримання завдань користувача: " . $e->getMessage(), 0, $e);
        }
    }
}
