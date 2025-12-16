<?php
namespace Classes;

/**
 * Абстрактный класс User
 * 
 * Базовый класс для иерархии пользователей системы
 * 
 * @package Classes
 * @author Kostiantyn Surkov
 * @version 1.0
 * @since 2024
 */
abstract class AbstractUser
{
    /**
     * Имя пользователя (инкапсуляция - свойство приватное)
     * 
     * @var string
     */
    private string $name;
    
    /**
     * Email пользователя (инкапсуляция - свойство приватное)
     * 
     * @var string
     */
    private string $email;
    
    /**
     * Конструктор класса User
     * 
     * @param string $name Имя пользователя
     * @param string $email Email пользователя
     */
    public function __construct(string $name, string $email)
    {
        $this->name = $name;
        $this->email = $email;
    }
    
    /**
     * Абстрактный метод для получения роли пользователя
     * (абстракция - определяем интерфейс без реализации)
     * 
     * @return string Роль пользователя
     */
    abstract public function getRole(): string;
    
    /**
     * Получить имя пользователя
     * 
     * @return string Имя пользователя
     */
    public function getName(): string
    {
        return $this->name;
    }
    
    /**
     * Установить имя пользователя
     * 
     * @param string $name Имя пользователя
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
    
    /**
     * Получить email пользователя
     * 
     * @return string Email пользователя
     */
    public function getEmail(): string
    {
        return $this->email;
    }
    
    /**
     * Установить email пользователя
     * 
     * @param string $email Email пользователя
     * @return void
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
    
    /**
     * Получить информацию о пользователе
     * 
     * @return array Информация о пользователе
     */
    public function getInfo(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->getRole()
        ];
    }
}
