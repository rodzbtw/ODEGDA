<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Маршрут (Route) - це правило, яке визначає зв'язок між URL-адресою 
| та методом контролера. Він вказує, який контролер та який його метод 
| обробляють певний HTTP-запит (GET, POST, PUT, DELETE тощо).
|
*/

// Головна сторінка
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Маршрути для продуктів (Resource Routes)
|--------------------------------------------------------------------------
|
| Laravel надає метод Route::resource(), який автоматично створює 
| всі необхідні маршрути для CRUD операцій:
|
| GET    /products           -> index()   - список продуктів
| GET    /products/create    -> create()  - форма створення
| POST   /products           -> store()   - збереження нового
| GET    /products/{id}      -> show()    - перегляд одного
| GET    /products/{id}/edit -> edit()    - форма редагування
| PUT    /products/{id}      -> update()  - оновлення
| DELETE /products/{id}      -> destroy() - видалення
|
*/

// Варіант 1: Використання resource маршрутів (рекомендовано)
Route::resource('products', ProductController::class);

// Варіант 2: Окремі маршрути (для кращого розуміння)
/*
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
*/

