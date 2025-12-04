<?php

namespace Odegda;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;
use Monolog\Formatter\LineFormatter;

/**
 * Приклад використання Monolog для логування
 */
class LoggerExample {
    private $logger;

    public function __construct() {
        // Створюємо logger
        $this->logger = new Logger('odegda_app');
        
        // Додаємо handler для запису в файл
        $fileHandler = new StreamHandler(__DIR__ . '/../logs/app.log', Logger::DEBUG);
        $fileHandler->setFormatter(new LineFormatter(
            "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n",
            'Y-m-d H:i:s'
        ));
        $this->logger->pushHandler($fileHandler);
        
        // Додаємо handler для виводу в браузер (FirePHP)
        $firephpHandler = new FirePHPHandler();
        $this->logger->pushHandler($firephpHandler);
    }

    /**
     * Демонстрація різних рівнів логування
     */
    public function demonstrateLogging() {
        // Debug - детальна інформація для розробки
        $this->logger->debug('Це debug повідомлення', ['user_id' => 123]);
        
        // Info - загальна інформація
        $this->logger->info('Користувач успішно авторизувався', [
            'username' => 'ivan.petrenko',
            'ip' => '192.168.1.1'
        ]);
        
        // Notice - важлива інформація
        $this->logger->notice('Новий користувач зареєструвався', [
            'email' => 'newuser@example.com'
        ]);
        
        // Warning - попередження
        $this->logger->warning('Спроба доступу до захищеної сторінки', [
            'page' => '/admin',
            'user' => 'guest'
        ]);
        
        // Error - помилка
        $this->logger->error('Помилка підключення до бази даних', [
            'database' => 'main_db',
            'error_code' => 5001
        ]);
        
        // Critical - критична помилка
        $this->logger->critical('Система недоступна', [
            'service' => 'payment_gateway',
            'status' => 'down'
        ]);
        
        // Alert - тривога
        $this->logger->alert('Виявлено підозрілу активність', [
            'type' => 'brute_force',
            'attempts' => 50
        ]);
        
        // Emergency - надзвичайна ситуація
        $this->logger->emergency('Система потребує негайної уваги!', [
            'issue' => 'disk_space_full',
            'free_space' => '0 MB'
        ]);
    }

    /**
     * Логування з контекстом
     */
    public function logWithContext($message, $context = []) {
        $this->logger->info($message, $context);
    }

    public function getLogger() {
        return $this->logger;
    }
}

