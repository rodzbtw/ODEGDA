<?php
/**
 * Конфігурація шляхів проекту
 * 
 * Централізоване визначення шляхів для легкого оновлення
 */

// Базові шляхи
define('BASE_PATH', dirname(__DIR__));
define('PUBLIC_PATH', BASE_PATH . '/public');
define('APP_PATH', BASE_PATH . '/app');
define('RESOURCES_PATH', BASE_PATH . '/resources');
define('CONFIG_PATH', BASE_PATH . '/config');
define('DATABASE_PATH', BASE_PATH . '/database');

// Шляхи до ресурсів
define('ASSETS_PATH', RESOURCES_PATH . '/assets');
define('CSS_PATH', ASSETS_PATH . '/css');
define('JS_PATH', ASSETS_PATH . '/js');
define('IMAGES_PATH', ASSETS_PATH . '/images');

// Шляхи до views
define('VIEWS_PATH', RESOURCES_PATH . '/views');
define('PAGES_PATH', VIEWS_PATH . '/pages');
define('PARTIALS_PATH', VIEWS_PATH . '/partials');

// URL шляхи (для використання в HTML)
define('ASSETS_URL', '/resources/assets');
define('CSS_URL', ASSETS_URL . '/css');
define('JS_URL', ASSETS_URL . '/js');
define('IMAGES_URL', ASSETS_URL . '/images');

