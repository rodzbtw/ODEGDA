<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ієрархія класів користувачів</title>
    <link rel="stylesheet" href="/resources/assets/css/main.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        .user-card {
            background: rgba(30, 41, 59, 0.7);
            border: 2px solid var(--border);
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            transition: all 0.3s;
        }
        .user-card:hover {
            border-color: var(--primary);
            transform: translateY(-2px);
        }
        .user-info {
            display: grid;
            gap: 1rem;
        }
        .info-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.75rem;
            background: rgba(15, 23, 42, 0.5);
            border-radius: 8px;
        }
        .info-label {
            font-weight: 600;
            color: var(--primary);
            min-width: 100px;
        }
        .info-value {
            color: #cbd5e1;
        }
        .code-block {
            background: rgba(15, 23, 42, 0.9);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 1.5rem;
            overflow-x: auto;
            margin: 1rem 0;
        }
        .code-block pre {
            margin: 0;
            color: #cbd5e1;
            font-family: 'Courier New', monospace;
            font-size: 0.9rem;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="stars"></div>
    <div class="stars2"></div>
    <div class="stars3"></div>

    <?php require_once __DIR__ . '/../partials/nav.php'; renderNav(''); ?>

    <header class="hero">
        <div class="hero-container">
            <h1 class="hero-title">
                <span class="gradient-text">ООП Завдання</span>
                Ієрархія класів користувачів
            </h1>
            <p class="hero-subtitle">
                Демонстрація абстрактних класів, наслідування та поліморфізму в PHP
            </p>
        </div>
    </header>

    <main class="container">
        <?php
        // Підключаємо класи
        require_once __DIR__ . '/../../app/Models/Legacy/User.php';
        require_once __DIR__ . '/../../app/Models/Legacy/Student.php';
        require_once __DIR__ . '/../../app/Models/Legacy/Teacher.php';

        // Створюємо об'єкт Student
        $student = new Student("Іван Петренко", "ivan.petrenko@example.com", "КН-24");

        // Створюємо об'єкт Teacher
        $teacher = new Teacher("Олена Коваленко", "elena.kovalenko@example.com", "Програмування");
        ?>

        <section class="card">
            <div class="card-header">
                <div class="card-icon">👤</div>
                <h2>Інформація про користувачів</h2>
            </div>
            <div class="card-content">
                <!-- Інформація про студента -->
                <div class="user-card">
                    <h3 style="color: var(--primary); margin-bottom: 1.5rem;">📚 Студент</h3>
                    <div class="user-info">
                        <div class="info-item">
                            <span class="info-label">Ім'я:</span>
                            <span class="info-value"><?php echo htmlspecialchars($student->getName()); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Email:</span>
                            <span class="info-value"><?php echo htmlspecialchars($student->getEmail()); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Роль:</span>
                            <span class="info-value"><?php echo htmlspecialchars($student->getRole()); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Група:</span>
                            <span class="info-value"><?php echo htmlspecialchars($student->getGroup()); ?></span>
                        </div>
                    </div>
                </div>

                <!-- Інформація про викладача -->
                <div class="user-card">
                    <h3 style="color: var(--accent); margin-bottom: 1.5rem;">👨‍🏫 Викладач</h3>
                    <div class="user-info">
                        <div class="info-item">
                            <span class="info-label">Ім'я:</span>
                            <span class="info-value"><?php echo htmlspecialchars($teacher->getName()); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Email:</span>
                            <span class="info-value"><?php echo htmlspecialchars($teacher->getEmail()); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Роль:</span>
                            <span class="info-value"><?php echo htmlspecialchars($teacher->getRole()); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Предмет:</span>
                            <span class="info-value"><?php echo htmlspecialchars($teacher->getSubject()); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="card">
            <div class="card-header">
                <div class="card-icon">📚</div>
                <h2>Структура класів</h2>
            </div>
            <div class="card-content">
                <h3>1. Абстрактний клас User</h3>
                <div class="code-block">
                    <pre>abstract class User {
    private $name;
    private $email;
    
    public function __construct($name, $email) {
        $this->name = $name;
        $this->email = $email;
    }
    
    abstract public function getRole();
    
    // Гетери та сетери
    public function getName() { ... }
    public function getEmail() { ... }
    public function setName($name) { ... }
    public function setEmail($email) { ... }
}</pre>
                </div>

                <h3>2. Клас Student extends User</h3>
                <div class="code-block">
                    <pre>class Student extends User {
    private $group;
    
    public function __construct($name, $email, $group) {
        parent::__construct($name, $email);
        $this->group = $group;
    }
    
    public function getRole() {
        return "Студент";
    }
    
    public function getGroup() { ... }
    public function setGroup($group) { ... }
}</pre>
                </div>

                <h3>3. Клас Teacher extends User</h3>
                <div class="code-block">
                    <pre>class Teacher extends User {
    private $subject;
    
    public function __construct($name, $email, $subject) {
        parent::__construct($name, $email);
        $this->subject = $subject;
    }
    
    public function getRole() {
        return "Викладач";
    }
    
    public function getSubject() { ... }
    public function setSubject($subject) { ... }
}</pre>
                </div>

                <div class="info-box">
                    💡 Всі класи використовують принципи ООП: інкапсуляцію, наслідування та поліморфізм
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="footer-content">
            <p>© 2024 JavaScript Course Tasks</p>
            <p class="footer-links">
                <a href="/">Назад до головної</a>
            </p>
        </div>
    </footer>
</body>
</html>

