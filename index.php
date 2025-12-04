<?php
/**
 * Простий PHP роутер
 * Обробляє всі HTTP запити та перенаправляє на відповідні сторінки
 */

// Отримуємо поточний URI та очищаємо його
$request_uri = $_SERVER['REQUEST_URI'];
$request_uri = parse_url($request_uri, PHP_URL_PATH);
$request_uri = trim($request_uri, '/');

// Визначаємо маршрути
$routes = [
    '' => 'home',
    'home' => 'home',
    'login' => 'login',
    'set-task' => 'set-task',
    'api-task' => 'api-task',
    'game' => 'game',
];

// Визначаємо поточну сторінку
$page = '404'; // За замовчуванням 404
if (empty($request_uri)) {
    $page = 'home';
} elseif (isset($routes[$request_uri])) {
    $page = $routes[$request_uri];
}

// Визначаємо title сторінки
$titles = [
    'home' => 'JavaScript Завдання - Головна',
    'login' => 'Завдання 3: Регулярні вирази',
    'set-task' => 'Завдання 4: Робота з Set',
    'api-task' => 'Завдання 5: Робота з API',
    'game' => 'Завдання 6: Canvas - Космічна гра',
    '404' => '404 - Сторінку не знайдено',
];

$page_title = isset($titles[$page]) ? $titles[$page] : 'JavaScript Tasks';

// Визначаємо активний пункт меню
$active_page = $page === 'home' ? '' : $page;

// Перевіряємо чи існує файл сторінки
$page_file = __DIR__ . '/pages/' . $page . '.php';
if (!file_exists($page_file)) {
    $page = '404';
    $page_file = __DIR__ . '/pages/404.php';
    $page_title = $titles['404'];
}

// Підключаємо сторінку
require_once $page_file;
?>

