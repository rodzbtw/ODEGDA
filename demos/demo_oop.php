<?php
require_once 'src/Classes/AbstractUser.php';
require_once 'src/Classes/Student.php';
require_once 'src/Classes/Teacher.php';

use Classes\Student;
use Classes\Teacher;

echo "<h2>Завдання 3: ООП ієрархія класів</h2>\n";

// Создаем объект Student
$student = new Student("Іван Петренко", "ivan@student.edu", "КН-24");
echo "<h3>Студент:</h3>\n";
echo "<p>Ім'я: " . $student->getName() . "</p>\n";
echo "<p>Email: " . $student->getEmail() . "</p>\n";
echo "<p>Роль: " . $student->getRole() . "</p>\n";
echo "<p>Група: " . $student->getGroup() . "</p>\n";

echo "<hr>\n";

// Создаем объект Teacher
$teacher = new Teacher("Марія Коваль", "maria@teacher.edu", "Програмування");
echo "<h3>Викладач:</h3>\n";
echo "<p>Ім'я: " . $teacher->getName() . "</p>\n";
echo "<p>Email: " . $teacher->getEmail() . "</p>\n";
echo "<p>Роль: " . $teacher->getRole() . "</p>\n";
echo "<p>Предмет: " . $teacher->getSubject() . "</p>\n";

echo "<hr>\n";

// Демонстрация работы с сеттерами
echo "<h3>Зміна даних:</h3>\n";

$student->setName("Олександр Сидоренко");
$student->setGroup("КН-25");
echo "<p>Оновлений студент: " . $student->getName() . ", група: " . $student->getGroup() . "</p>\n";

$teacher->setSubject("Бази даних");
echo "<p>Оновлений викладач: предмет " . $teacher->getSubject() . "</p>\n";

echo "<hr>\n";

// Вывод полной информации
echo "<h3>Повна інформація:</h3>\n";
echo "<h4>Студент:</h4>\n";
echo "<pre>" . print_r($student->getInfo(), true) . "</pre>\n";

echo "<h4>Викладач:</h4>\n";
echo "<pre>" . print_r($teacher->getInfo(), true) . "</pre>\n";
?>
