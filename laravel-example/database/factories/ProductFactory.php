<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Фабрика ProductFactory
 * 
 * Фабрика - це клас, який використовується для генерації тестових 
 * або демонстраційних даних. Вона дозволяє швидко створювати 
 * фейкові записи в базі даних з реалістичними значеннями.
 */
class ProductFactory extends Factory
{
    /**
     * Назва моделі, для якої створюється фабрика
     */
    protected $model = Product::class;

    /**
     * Визначення структури даних для генерації
     * 
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true), // Випадкові 3 слова
            'description' => fake()->paragraph(3), // Випадковий параграф з 3 речень
            'price' => fake()->randomFloat(2, 10, 1000), // Випадкова ціна від 10 до 1000
            'quantity' => fake()->numberBetween(0, 100), // Випадкова кількість від 0 до 100
            'is_active' => fake()->boolean(80), // 80% ймовірність бути true
        ];
    }

    /**
     * Приклад стану фабрики - неактивний продукт
     * Використання: Product::factory()->inactive()->create()
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Приклад стану фабрики - продукт з високою ціною
     * Використання: Product::factory()->expensive()->create()
     */
    public function expensive(): static
    {
        return $this->state(fn (array $attributes) => [
            'price' => fake()->randomFloat(2, 500, 5000),
        ]);
    }
}

