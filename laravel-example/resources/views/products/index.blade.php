{{-- 
    Шаблон (View) для відображення списку продуктів
    
    View (Шаблон) - це файл, який містить HTML-розмітку та Blade-синтаксис 
    для відображення даних користувачу. Він отримує дані від контролера 
    та відображає їх у зручному форматі.
--}}

@extends('layouts.app')

@section('title', 'Список продуктів')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Список продуктів</h1>

            {{-- Відображення повідомлення про успіх --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Посилання на створення нового продукту --}}
            <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">
                Додати новий продукт
            </a>

            {{-- Перевірка наявності продуктів --}}
            @if($products->count() > 0)
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text">
                                        {{ Str::limit($product->description, 100) }}
                                    </p>
                                    <p class="card-text">
                                        <strong>Ціна:</strong> {{ $product->formatted_price }}
                                    </p>
                                    <p class="card-text">
                                        <strong>Кількість:</strong> {{ $product->quantity }}
                                    </p>
                                    <p class="card-text">
                                        <span class="badge {{ $product->is_active ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $product->is_active ? 'Активний' : 'Неактивний' }}
                                        </span>
                                    </p>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-info">
                                            Переглянути
                                        </a>
                                        <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning">
                                            Редагувати
                                        </a>
                                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Ви впевнені?')">
                                                Видалити
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info">
                    Продуктів не знайдено. <a href="{{ route('products.create') }}">Створити перший продукт?</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

