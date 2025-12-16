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
class Student extends AbstractUser
{
    /**
     * Группа студента
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
     * 
     * @return array Информация о студенте
     */
    public function getInfo(): array
    {
        return array_merge(parent::getInfo(), [
            'group' => $this->group
        ]);
    }
}

