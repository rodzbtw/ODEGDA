<?php
require_once 'User.php';

/**
 * Клас Teacher
 * Наслідує клас User, представляє викладача
 */
class Teacher extends User {
    // Приватне поле для предмета
    private $subject;

    /**
     * Конструктор класу Teacher
     * @param string $name Ім'я викладача
     * @param string $email Email викладача
     * @param string $subject Предмет викладача
     */
    public function __construct($name, $email, $subject) {
        parent::__construct($name, $email);
        $this->subject = $subject;
    }

    /**
     * Реалізація абстрактного методу getRole()
     * @return string Роль "Викладач"
     */
    public function getRole() {
        return "Викладач";
    }

    // Гетер для предмета
    /**
     * Отримати предмет викладача
     * @return string
     */
    public function getSubject() {
        return $this->subject;
    }

    // Сетер для предмета
    /**
     * Встановити предмет викладача
     * @param string $subject
     */
    public function setSubject($subject) {
        $this->subject = $subject;
    }
}
?>

