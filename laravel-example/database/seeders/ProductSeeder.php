<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/**
 * Сідер ProductSeeder
 * 
 * Сідер - це клас, який заповнює базу даних початковими або тестовими даними.
 * Він використовує фабрики для створення записів та дозволяє ініціалізувати 
 * базу даних необхідними даними для роботи додатку.
 */
class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Метод run() виконується при запуску сідера (php artisan db:seed)
     */
    public function run(): void
    {
        // Створення 10 випадкових продуктів за допомогою фабрики
        Product::factory()->count(10)->create();

        // Створення конкретного продукту з заданими параметрами
        Product::create([
            'name' => 'Ноутбук Dell XPS 15',
            'description' => 'Потужний ноутбук для роботи та ігор з екраном 15.6 дюймів',
            'price' => 45999.99,
            'quantity' => 5,
            'is_active' => true,
        ]);

        // Створення неактивних продуктів
        Product::factory()->count(3)->inactive()->create();

        // Створення дорогих продуктів
        Product::factory()->count(2)->expensive()->create();

        $this->command->info('Створено ' . Product::count() . ' продуктів!');
    }
}

