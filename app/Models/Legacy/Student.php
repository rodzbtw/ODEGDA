<?php
require_once 'User.php';

/**
 * Клас Student
 * Наслідує клас User, представляє студента
 */
class Student extends User {
    // Приватне поле для групи
    private $group;

    /**
     * Конструктор класу Student
     * @param string $name Ім'я студента
     * @param string $email Email студента
     * @param string $group Група студента
     */
    public function __construct($name, $email, $group) {
        parent::__construct($name, $email);
        $this->group = $group;
    }

    /**
     * Реалізація абстрактного методу getRole()
     * @return string Роль "Студент"
     */
    public function getRole() {
        return "Студент";
    }

    // Гетер для групи
    /**
     * Отримати групу студента
     * @return string
     */
    public function getGroup() {
        return $this->group;
    }

    // Сетер для групи
    /**
     * Встановити групу студента
     * @param string $group
     */
    public function setGroup($group) {
        $this->group = $group;
    }
}
?>

