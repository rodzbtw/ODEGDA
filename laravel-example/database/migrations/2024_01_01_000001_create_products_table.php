<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Міграція для створення таблиці products
 * 
 * Міграція - це файл, який описує структуру таблиці в базі даних.
 * Вона дозволяє версіонувати схему БД та легко відкочувати зміни.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Метод up() виконується при запуску міграції (php artisan migrate)
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Автоматичний первинний ключ (BIGINT UNSIGNED)
            $table->string('name'); // Назва продукту (VARCHAR 255)
            $table->text('description')->nullable(); // Опис продукту (TEXT, може бути NULL)
            $table->decimal('price', 8, 2); // Ціна (DECIMAL 8,2)
            $table->integer('quantity')->default(0); // Кількість на складі
            $table->boolean('is_active')->default(true); // Чи активний продукт
            $table->timestamps(); // created_at та updated_at (TIMESTAMP)
        });
    }

    /**
     * Reverse the migrations.
     * 
     * Метод down() виконується при відкаті міграції (php artisan migrate:rollback)
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

