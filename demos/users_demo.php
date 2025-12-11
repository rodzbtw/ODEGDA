<?php
/**
 * Демонстрація використання ієрархії класів користувачів
 */

// Підключаємо класи
require_once 'classes/User.php';
require_once 'classes/Student.php';
require_once 'classes/Teacher.php';

// Створюємо об'єкт Student
$student = new Student("Іван Петренко", "ivan.petrenko@example.com", "КН-24");

// Створюємо об'єкт Teacher
$teacher = new Teacher("Олена Коваленко", "elena.kovalenko@example.com", "Програмування");

// Виводимо інформацію про студента
echo "=== ІНФОРМАЦІЯ ПРО СТУДЕНТА ===\n";
echo "Ім'я: " . $student->getName() . "\n";
echo "Email: " . $student->getEmail() . "\n";
echo "Роль: " . $student->getRole() . "\n";
echo "Група: " . $student->getGroup() . "\n";
echo "\n";

// Виводимо інформацію про викладача
echo "=== ІНФОРМАЦІЯ ПРО ВИКЛАДАЧА ===\n";
echo "Ім'я: " . $teacher->getName() . "\n";
echo "Email: " . $teacher->getEmail() . "\n";
echo "Роль: " . $teacher->getRole() . "\n";
echo "Предмет: " . $teacher->getSubject() . "\n";
echo "\n";

// Демонстрація використання сетерів
echo "=== ДЕМОНСТРАЦІЯ ЗМІНИ ДАНИХ ===\n";
$student->setGroup("КН-25");
echo "Нова група студента: " . $student->getGroup() . "\n";

$teacher->setSubject("Веб-програмування");
echo "Новий предмет викладача: " . $teacher->getSubject() . "\n";
?>

