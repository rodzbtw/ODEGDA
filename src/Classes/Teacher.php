<?php
namespace Classes;

/**
 * Класс Teacher
 * 
 * Наследует AbstractUser, представляет преподавателя системы
 * 
 * @package Classes
 * @author Kostiantyn Surkov
 * @version 1.0
 * @since 2024
 */
class Teacher extends AbstractUser
{
    /**
     * Предмет преподавателя
     * 
     * @var string
     */
    private string $subject;

    /**
     * Конструктор класса Teacher
     * 
     * @param string $name Имя преподавателя
     * @param string $email Email преподавателя
     * @param string $subject Предмет преподавателя
     */
    public function __construct(string $name, string $email, string $subject)
    {
        parent::__construct($name, $email);
        $this->subject = $subject;
    }

    /**
     * Реализация абстрактного метода getRole()
     * 
     * @return string Роль "Викладач"
     */
    public function getRole(): string
    {
        return "Викладач";
    }

    /**
     * Получить предмет преподавателя
     * 
     * @return string Предмет преподавателя
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * Установить предмет преподавателя
     * 
     * @param string $subject Предмет преподавателя
     * @return void
     */
    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }
    
    /**
     * Получить информацию о преподавателе
     * 
     * @return array Информация о преподавателе
     */
    public function getInfo(): array
    {
        return array_merge(parent::getInfo(), [
            'subject' => $this->subject
        ]);
    }
}

