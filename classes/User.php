<?php
/**
 * Абстрактний клас User
 * Базовий клас для всіх користувачів системи
 */
abstract class User {
    // Приватні поля
    private $name;
    private $email;

    /**
     * Конструктор класу User
     * @param string $name Ім'я користувача
     * @param string $email Email користувача
     */
    public function __construct($name, $email) {
        $this->name = $name;
        $this->email = $email;
    }

    /**
     * Абстрактний метод для отримання ролі користувача
     * Повинен бути реалізований у дочірніх класах
     * @return string Роль користувача
     */
    abstract public function getRole();

    // Гетери
    /**
     * Отримати ім'я користувача
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Отримати email користувача
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    // Сетери
    /**
     * Встановити ім'я користувача
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * Встановити email користувача
     * @param string $email
     */
    public function setEmail($email) {
        $this->email = $email;
    }
}
?>

