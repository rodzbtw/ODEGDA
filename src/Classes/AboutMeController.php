<?php

namespace Classes;

/**
 * Контролер для сторінки "Про мене"
 * 
 * Відповідає за обробку запитів до сторінки /aboutme та передачу даних у шаблон.
 * Контролер збирає інформацію про користувача та передає її для відображення.
 * 
 * @package Classes
 * @author Kostiantyn Surkov
 * @version 1.0
 * @since 2024
 */
class AboutMeController
{
    /**
     * Основний метод контролера для відображення сторінки "Про мене"
     * 
     * Метод збирає дані про користувача (ім'я, біографія, навички, контакти)
     * та передає їх у шаблон для відображення. Використовується для обробки
     * GET запитів до маршруту /aboutme.
     * 
     * @return void Метод не повертає значення, але виводить HTML контент
     * @throws \Exception Якщо не вдається завантажити дані або шаблон
     * 
     * @see renderAboutMePage() Для деталей рендерингу
     */
    public static function action(): void
    {
        // Збираємо дані про користувача
        $data = self::getAboutMeData();
        
        // Відображаємо сторінку з даними
        self::renderAboutMePage($data);
    }

    /**
     * Збирає дані про користувача для відображення на сторінці "Про мене"
     * 
     * Метод формує масив з інформацією про користувача, включаючи:
     * - Особисті дані (ім'я, вік, місце проживання)
     * - Біографію та опис
     * - Навички та технології
     * - Контактну інформацію
     * - Освіту та досвід
     * 
     * @return array<string, mixed> Асоціативний масив з даними про користувача
     * 
     * @example
     * <code>
     * $data = AboutMeController::getAboutMeData();
     * echo $data['name']; // "Іван Петренко"
     * </code>
     */
    private static function getAboutMeData(): array
    {
        return [
            // Особисті дані
            'name' => 'Kostiantyn Surkov',
            'fullName' => 'Костянтин Сурков',
            'age' => 22,
            'location' => 'Україна',
            'position' => 'Студент / Web Developer',
            
            // Біографія
            'bio' => 'Привіт! Я студент, який захоплюється веб-розробкою та програмуванням. ' .
                     'Працюю з сучасними технологіями та постійно вдосконалюю свої навички. ' .
                     'Цікавлюся backend та frontend розробкою, а також вивчаю нові фреймворки та інструменти.',
            
            'shortBio' => 'Студент з пристрастю до веб-розробки та програмування',
            
            // Навички
            'skills' => [
                [
                    'category' => 'Backend',
                    'items' => ['PHP', 'MySQL', 'REST API', 'Composer']
                ],
                [
                    'category' => 'Frontend',
                    'items' => ['HTML5', 'CSS3', 'JavaScript', 'Canvas API']
                ],
                [
                    'category' => 'Інструменти',
                    'items' => ['Git', 'Composer', 'XAMPP', 'VS Code']
                ],
                [
                    'category' => 'Мови програмування',
                    'items' => ['PHP', 'JavaScript', 'SQL']
                ]
            ],
            
            // Освіта
            'education' => [
                [
                    'institution' => 'Університет',
                    'degree' => 'Студент',
                    'field' => 'Комп\'ютерні науки',
                    'period' => '2022 - дотепер'
                ]
            ],
            
            // Контакти
            'contacts' => [
                'email' => 'kostiantyn.surkov@example.com',
                'github' => 'https://github.com/SurkovKostiantyn',
                'linkedin' => null, // Можна додати посилання
            ],
            
            // Інтереси
            'interests' => [
                'Веб-розробка',
                'Програмування',
                'Навчання нових технологій',
                'Open Source проекти'
            ],
            
            // Проекти
            'projects' => [
                [
                    'name' => 'JavaScript Tasks',
                    'description' => 'Навчальний проект з JavaScript завданнями',
                    'technologies' => ['HTML', 'CSS', 'JavaScript', 'Canvas API']
                ],
                [
                    'name' => 'PHP Router',
                    'description' => 'Простий PHP роутер з динамічною навігацією',
                    'technologies' => ['PHP', 'Composer', 'Monolog', 'VarDumper']
                ]
            ]
        ];
    }

    /**
     * Відображає сторінку "Про мене" з переданими даними
     * 
     * Метод приймає масив даних та відображає HTML сторінку з інформацією
     * про користувача. Використовує шаблон з навігацією та футером.
     * 
     * @param array<string, mixed> $data Масив з даними про користувача
     * @return void Метод не повертає значення, але виводить HTML
     * 
     * @throws \Exception Якщо дані некоректні або відсутні обов'язкові поля
     * 
     * @see getAboutMeData() Для отримання даних
     */
    private static function renderAboutMePage(array $data): void
    {
        // Валідація даних
        if (empty($data['name'])) {
            throw new \Exception('Ім\'я користувача обов\'язкове для відображення');
        }
        
        // Встановлюємо title сторінки
        $page_title = 'Про мене - ' . htmlspecialchars($data['name']);
        
        // Підключаємо навігацію
        require_once __DIR__ . '/../../includes/nav.php';
        
        // Відображаємо HTML
        ?>
        <!DOCTYPE html>
        <html lang="uk">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php echo htmlspecialchars($page_title); ?></title>
            <link rel="stylesheet" href="/CSS/main.css">
            <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
            <style>
                .about-container {
                    max-width: 1000px;
                    margin: 0 auto;
                }
                .about-header {
                    text-align: center;
                    margin-bottom: 3rem;
                }
                .about-avatar {
                    width: 200px;
                    height: 200px;
                    border-radius: 50%;
                    margin: 0 auto 2rem;
                    background: linear-gradient(135deg, var(--primary), var(--accent));
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 4rem;
                    color: white;
                    box-shadow: 0 10px 40px rgba(99, 102, 241, 0.3);
                }
                .info-grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                    gap: 2rem;
                    margin: 2rem 0;
                }
                .skill-category {
                    background: rgba(30, 41, 59, 0.5);
                    padding: 1.5rem;
                    border-radius: 12px;
                    border-left: 4px solid var(--primary);
                }
                .skill-category h3 {
                    color: var(--primary);
                    margin-bottom: 1rem;
                }
                .skill-tags {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 0.5rem;
                }
                .skill-tag {
                    background: rgba(99, 102, 241, 0.2);
                    color: var(--primary);
                    padding: 0.5rem 1rem;
                    border-radius: 20px;
                    font-size: 0.9rem;
                    border: 1px solid var(--primary);
                }
                .contact-item {
                    display: flex;
                    align-items: center;
                    gap: 1rem;
                    padding: 1rem;
                    background: rgba(30, 41, 59, 0.3);
                    border-radius: 8px;
                    margin-bottom: 1rem;
                }
                .contact-icon {
                    font-size: 1.5rem;
                }
            </style>
        </head>
        <body>
            <div class="stars"></div>
            <div class="stars2"></div>
            <div class="stars3"></div>

            <?php renderNav('aboutme'); ?>

            <header class="hero">
                <div class="hero-container">
                    <h1 class="hero-title">
                        <span class="gradient-text">Про мене</span>
                        <?php echo htmlspecialchars($data['fullName']); ?>
                    </h1>
                    <p class="hero-subtitle">
                        <?php echo htmlspecialchars($data['shortBio']); ?>
                    </p>
                </div>
            </header>

            <main class="container about-container">
                <!-- Особисті дані -->
                <section class="card">
                    <div class="card-header">
                        <div class="card-icon">👤</div>
                        <h2>Особиста інформація</h2>
                    </div>
                    <div class="card-content">
                        <div class="about-avatar">
                            <?php echo strtoupper(substr($data['name'], 0, 2)); ?>
                        </div>
                        <div class="info-grid">
                            <div>
                                <strong>Ім'я:</strong> <?php echo htmlspecialchars($data['fullName']); ?>
                            </div>
                            <div>
                                <strong>Вік:</strong> <?php echo htmlspecialchars($data['age']); ?> років
                            </div>
                            <div>
                                <strong>Місцезнаходження:</strong> <?php echo htmlspecialchars($data['location']); ?>
                            </div>
                            <div>
                                <strong>Позиція:</strong> <?php echo htmlspecialchars($data['position']); ?>
                            </div>
                        </div>
                        <p style="margin-top: 1.5rem; line-height: 1.8;">
                            <?php echo htmlspecialchars($data['bio']); ?>
                        </p>
                    </div>
                </section>

                <!-- Навички -->
                <section class="card">
                    <div class="card-header">
                        <div class="card-icon">💻</div>
                        <h2>Навички та технології</h2>
                    </div>
                    <div class="card-content">
                        <div class="info-grid">
                            <?php foreach ($data['skills'] as $skillCategory): ?>
                                <div class="skill-category">
                                    <h3><?php echo htmlspecialchars($skillCategory['category']); ?></h3>
                                    <div class="skill-tags">
                                        <?php foreach ($skillCategory['items'] as $skill): ?>
                                            <span class="skill-tag"><?php echo htmlspecialchars($skill); ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </section>

                <!-- Освіта -->
                <section class="card">
                    <div class="card-header">
                        <div class="card-icon">🎓</div>
                        <h2>Освіта</h2>
                    </div>
                    <div class="card-content">
                        <?php foreach ($data['education'] as $edu): ?>
                            <div style="margin-bottom: 1.5rem; padding: 1rem; background: rgba(30, 41, 59, 0.3); border-radius: 8px;">
                                <h3><?php echo htmlspecialchars($edu['institution']); ?></h3>
                                <p><strong><?php echo htmlspecialchars($edu['degree']); ?></strong> - <?php echo htmlspecialchars($edu['field']); ?></p>
                                <p style="color: #94a3b8; font-size: 0.9rem;"><?php echo htmlspecialchars($edu['period']); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>

                <!-- Контакти -->
                <section class="card">
                    <div class="card-header">
                        <div class="card-icon">📧</div>
                        <h2>Контакти</h2>
                    </div>
                    <div class="card-content">
                        <?php if (!empty($data['contacts']['email'])): ?>
                            <div class="contact-item">
                                <span class="contact-icon">✉️</span>
                                <a href="mailto:<?php echo htmlspecialchars($data['contacts']['email']); ?>">
                                    <?php echo htmlspecialchars($data['contacts']['email']); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($data['contacts']['github'])): ?>
                            <div class="contact-item">
                                <span class="contact-icon">🐙</span>
                                <a href="<?php echo htmlspecialchars($data['contacts']['github']); ?>" target="_blank">
                                    GitHub Profile
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>

                <!-- Інтереси -->
                <section class="card">
                    <div class="card-header">
                        <div class="card-icon">⭐</div>
                        <h2>Інтереси</h2>
                    </div>
                    <div class="card-content">
                        <div class="skill-tags">
                            <?php foreach ($data['interests'] as $interest): ?>
                                <span class="skill-tag"><?php echo htmlspecialchars($interest); ?></span>
                            <?php endforeach; ?>
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
        <?php
    }
}

