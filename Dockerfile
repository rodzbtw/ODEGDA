FROM php:8.1-apache

# Установка зависимостей
RUN apt-get update && apt-get install -y \
    unzip \
    libzip-dev \
    && docker-php-ext-install zip

# Включение mod_rewrite
RUN a2enmod rewrite

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Копирование файлов проекта
COPY . /var/www/html

# Установка зависимостей Composer
RUN composer install --no-dev --optimize-autoloader

# Настройка прав доступа
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 777 /var/www/html/temp

# Настройка Apache
RUN sed -i 's/DocumentRoot \/var\/www\/html/DocumentRoot \/var\/www\/html\/public/' /etc/apache2/sites-available/000-default.conf

EXPOSE 80

CMD ["apache2-foreground"]
