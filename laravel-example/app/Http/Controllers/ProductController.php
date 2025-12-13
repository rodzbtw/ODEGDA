<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

/**
 * Контролер ProductController
 * 
 * Контролер - це клас, який обробляє HTTP-запити від клієнта та повертає відповіді.
 * Він містить методи (actions), які виконують бізнес-логіку, взаємодіють 
 * з моделями та повертають view або JSON-відповіді.
 */
class ProductController extends Controller
{
    /**
     * Відображення списку всіх продуктів
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Отримання всіх активних продуктів з бази даних
        $products = Product::active()->orderBy('created_at', 'desc')->get();

        // Передача даних у view та відображення шаблону
        return view('products.index', compact('products'));
    }

    /**
     * Відображення одного продукту
     * 
     * @param Product $product - модель продукту (Route Model Binding)
     * @return \Illuminate\View\View
     */
    public function show(Product $product)
    {
        // Laravel автоматично знаходить продукт за ID з маршруту
        // Наприклад, для /products/1 знайде продукт з id=1
        return view('products.show', compact('product'));
    }

    /**
     * Відображення форми створення продукту
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Збереження нового продукту в базу даних
     * 
     * @param Request $request - HTTP-запит з даними форми
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Валідація даних
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        // Створення нового продукту
        $product = Product::create($validated);

        // Перенаправлення на сторінку продукту з повідомленням про успіх
        return redirect()->route('products.show', $product)
            ->with('success', 'Продукт успішно створено!');
    }

    /**
     * Відображення форми редагування продукту
     * 
     * @param Product $product
     * @return \Illuminate\View\View
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Оновлення продукту в базі даних
     * 
     * @param Request $request
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $product->update($validated);

        return redirect()->route('products.show', $product)
            ->with('success', 'Продукт успішно оновлено!');
    }

    /**
     * Видалення продукту з бази даних
     * 
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Продукт успішно видалено!');
    }
}

