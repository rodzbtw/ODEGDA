# Інструкція з встановлення

## Крок 1: Встановлення Composer

Якщо Composer ще не встановлено:

### Windows:
1. Завантажте установщик: https://getcomposer.org/Composer-Setup.exe
2. Запустіть установщик та дотримуйтесь інструкцій

### Linux/Mac:
```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

Перевірте встановлення:
```bash
composer --version
```

## Крок 2: Встановлення залежностей

В кореневій директорії проекту виконайте:

```bash
composer install
```

Це встановить всі пакети з `composer.json`:
- monolog/monolog
- symfony/var-dumper
- vlucas/phpdotenv

## Крок 3: Налаштування .env файлу

1. Створіть файл `.env` в кореневій директорії:
```bash
# Windows
copy .env.example .env

# Linux/Mac
cp .env.example .env
```

2. Відредагуйте `.env` файл зі своїми значеннями:
```
APP_NAME="ODEGDA PHP Project"
APP_ENV=development
APP_DEBUG=true
DB_HOST=localhost
DB_NAME=odegda_db
SECRET_KEY=your-secret-key-here
```

## Крок 4: Створення директорії для логів

```bash
mkdir logs
```

Або вона створиться автоматично при першому використанні Monolog.

## Крок 5: Запуск демонстрації

### Варіант 1: Через веб-браузер
```bash
php -S localhost:8000
```
Відкрийте: http://localhost:8000/composer-demo

### Варіант 2: Консольний скрипт
```bash
php composer_demo.php
```

## Перевірка встановлення

Після `composer install` перевірте:
- ✅ Папка `vendor/` створена
- ✅ Файл `vendor/autoload.php` існує
- ✅ Всі пакети встановлені без помилок

## Troubleshooting

### Помилка: "composer: command not found"
- Перевірте, що Composer встановлено та додано в PATH
- Windows: перезапустіть термінал після встановлення

### Помилка: "Your requirements could not be resolved"
- Перевірте версію PHP: `php -v` (потрібна 7.4+)
- Спробуйте: `composer update`

### Помилка: "Class not found"
- Переконайтеся, що виконано `composer install`
- Перевірте, що `require_once 'vendor/autoload.php'` присутній

