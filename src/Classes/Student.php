<?php
namespace Classes;

/**
 * Класс Student
 * 
 * Наследует AbstractUser, представляет студента системы
 * 
 * @package Classes
 * @author Kostiantyn Surkov
 * @version 1.0
 * @since 2024
 */
/**
 * Класс Student
 * 
 * Демонстрирует наследование (extends AbstractUser) и полиморфизм
 * (переопределение методов родительского класса)
 */
class Student extends AbstractUser
{
    /**
     * Группа студента (инкапсуляция - свойство приватное)
     * 
     * @var string
     */
    private string $group;

    /**
     * Конструктор класса Student
     * 
     * @param string $name Имя студента
     * @param string $email Email студента
     * @param string $group Группа студента
     */
    public function __construct(string $name, string $email, string $group)
    {
        parent::__construct($name, $email);
        $this->group = $group;
    }

    /**
     * Реализация абстрактного метода getRole()
     * (полиморфизм - переопределение абстрактного метода)
     * 
     * @return string Роль "Студент"
     */
    public function getRole(): string
    {
        return "Студент";
    }

    /**
     * Получить группу студента
     * 
     * @return string Группа студента
     */
    public function getGroup(): string
    {
        return $this->group;
    }

    /**
     * Установить группу студента
     * 
     * @param string $group Группа студента
     * @return void
     */
    public function setGroup(string $group): void
    {
        $this->group = $group;
    }
    
    /**
     * Получить информацию о студенте
     * (полиморфизм - переопределение метода родительского класса)
     * 
     * @return array Информация о студенте
     */
    public function getInfo(): array
    {
        // Наследование - вызов метода родительского класса
        $parentInfo = parent::getInfo();
        // Полиморфизм - расширение функциональности
        return array_merge($parentInfo, [
            'group' => $this->group,
            'type' => 'student'
        ]);
    }
}

