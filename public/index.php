<?php
require_once '../vendor/autoload.php';

use Pecee\SimpleRouter\SimpleRouter;

// Настройка маршрутизации
SimpleRouter::get('/', function() {
    $controller = new \Classes\HomePageController();
    return $controller->index();
});

SimpleRouter::get('/login', function() {
    $controller = new \Classes\LoginController();
    return $controller->show();
});

SimpleRouter::post('/login', function() {
    $controller = new \Classes\LoginController();
    return $controller->show();
});

SimpleRouter::get('/logout', function() {
    session_start();
    session_destroy();
    header('Location: /login');
    exit;
});

// Обработка ошибок
SimpleRouter::error(function(\Pecee\Http\Request $request, \Exception $exception) {
    $controller = new \Classes\ErrorController();
    
    if ($exception instanceof \Pecee\SimpleRouter\Exceptions\NotFoundHttpException) {
        return $controller->notFound();
    }
    
    return $controller->serverError();
});

// Запуск маршрутизации
SimpleRouter::start();
