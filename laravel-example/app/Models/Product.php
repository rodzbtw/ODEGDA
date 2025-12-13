<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Модель Product
 * 
 * Модель - це клас, який представляє таблицю бази даних та дозволяє 
 * працювати з даними без написання SQL-запитів вручну.
 * 
 * Вона використовує ORM (Object-Relational Mapping) для взаємодії з БД.
 */
class Product extends Model
{
    use HasFactory;

    /**
     * Назва таблиці в базі даних
     * Якщо не вказано, Laravel автоматично використовує множину назви класу
     */
    protected $table = 'products';

    /**
     * Масив полів, які можна масово заповнювати (Mass Assignment)
     * Захист від небезпечного заповнення полів
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity',
        'is_active',
    ];

    /**
     * Масив полів, які НЕ можна масово заповнювати
     * Альтернатива fillable - використовується замість fillable
     */
    // protected $guarded = ['id'];

    /**
     * Типи даних для автоматичного приведення типів
     */
    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Приклад scope-методу для отримання тільки активних продуктів
     * Використання: Product::active()->get()
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Приклад accessor (геттера) для форматування ціни
     * Використання: $product->formatted_price
     */
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 2, '.', ' ') . ' грн';
    }
}

