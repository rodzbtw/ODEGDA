{{-- 
    Шаблон для відображення одного продукту
--}}

@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>{{ $product->name }}</h1>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Детальна інформація</h5>
                    
                    <p><strong>Опис:</strong></p>
                    <p>{{ $product->description ?? 'Опис відсутній' }}</p>
                    
                    <p><strong>Ціна:</strong> {{ $product->formatted_price }}</p>
                    <p><strong>Кількість на складі:</strong> {{ $product->quantity }}</p>
                    <p><strong>Статус:</strong> 
                        <span class="badge {{ $product->is_active ? 'bg-success' : 'bg-secondary' }}">
                            {{ $product->is_active ? 'Активний' : 'Неактивний' }}
                        </span>
                    </p>
                    <p><strong>Створено:</strong> {{ $product->created_at->format('d.m.Y H:i') }}</p>
                    <p><strong>Оновлено:</strong> {{ $product->updated_at->format('d.m.Y H:i') }}</p>

                    <div class="mt-3">
                        <a href="{{ route('products.index') }}" class="btn btn-secondary">
                            Назад до списку
                        </a>
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">
                            Редагувати
                        </a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" 
                                    onclick="return confirm('Ви впевнені, що хочете видалити цей продукт?')">
                                Видалити
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

