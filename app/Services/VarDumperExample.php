<?php

namespace Odegda;

use Symfony\Component\VarDumper\VarDumper;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\VarDumper\Dumper\CliDumper;

/**
 * Приклад використання Symfony VarDumper для красивого виводу змінних
 */
class VarDumperExample {
    
    /**
     * Демонстрація різних способів виводу змінних
     */
    public function demonstrateDumping() {
        echo "<h2>=== VarDumper Демонстрація ===</h2>\n";
        
        // Простий вивід
        $simpleArray = [1, 2, 3, 'test', true];
        echo "<h3>1. Простий масив:</h3>\n";
        dump($simpleArray);
        
        // Асоціативний масив
        $assocArray = [
            'name' => 'Іван Петренко',
            'age' => 25,
            'email' => 'ivan@example.com',
            'courses' => ['PHP', 'JavaScript', 'Python']
        ];
        echo "<h3>2. Асоціативний масив:</h3>\n";
        dump($assocArray);
        
        // Об'єкт
        $user = new \stdClass();
        $user->id = 1;
        $user->name = 'Олена Коваленко';
        $user->role = 'teacher';
        $user->subjects = ['Програмування', 'Веб-розробка'];
        echo "<h3>3. Об'єкт:</h3>\n";
        dump($user);
        
        // Вкладена структура
        $complexData = [
            'users' => [
                [
                    'id' => 1,
                    'name' => 'Студент 1',
                    'grades' => [5, 4, 5, 5]
                ],
                [
                    'id' => 2,
                    'name' => 'Студент 2',
                    'grades' => [4, 4, 5, 4]
                ]
            ],
            'statistics' => [
                'total_users' => 2,
                'average_grade' => 4.5
            ]
        ];
        echo "<h3>4. Складна вкладена структура:</h3>\n";
        dump($complexData);
        
        // Ресурси та закриті ресурси
        $file = fopen(__FILE__, 'r');
        echo "<h3>5. Ресурс:</h3>\n";
        dump($file);
        fclose($file);
        
        // Використання dd() для зупинки виконання
        echo "<h3>6. Використання dd() (зупинить виконання):</h3>\n";
        // dd($complexData); // Розкоментуйте для демонстрації
    }
    
    /**
     * Демонстрація з об'єктами класів
     */
    public function demonstrateWithClasses() {
        require_once __DIR__ . '/../classes/User.php';
        require_once __DIR__ . '/../classes/Student.php';
        require_once __DIR__ . '/../classes/Teacher.php';
        
        $student = new \Student("Іван Петренко", "ivan@example.com", "КН-24");
        $teacher = new \Teacher("Олена Коваленко", "elena@example.com", "Програмування");
        
        echo "<h3>7. Об'єкт Student:</h3>\n";
        dump($student);
        
        echo "<h3>8. Об'єкт Teacher:</h3>\n";
        dump($teacher);
        
        echo "<h3>9. Масив об'єктів:</h3>\n";
        dump([$student, $teacher]);
    }
    
    /**
     * Кастомний вивід з форматуванням
     */
    public function customDump($variable, $label = null) {
        if ($label) {
            echo "<h4>{$label}:</h4>\n";
        }
        dump($variable);
    }
}

