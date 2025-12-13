{{-- 
    Шаблон для створення нового продукту
--}}

@extends('layouts.app')

@section('title', 'Створити продукт')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Створити новий продукт</h1>

            <form action="{{ route('products.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Назва продукту *</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Опис</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="4">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Ціна *</label>
                    <input type="number" step="0.01" min="0" 
                           class="form-control @error('price') is-invalid @enderror" 
                           id="price" name="price" value="{{ old('price') }}" required>
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="quantity" class="form-label">Кількість *</label>
                    <input type="number" min="0" 
                           class="form-control @error('quantity') is-invalid @enderror" 
                           id="quantity" name="quantity" value="{{ old('quantity', 0) }}" required>
                    @error('quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="is_active" 
                           name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">
                        Активний продукт
                    </label>
                </div>

                <button type="submit" class="btn btn-primary">Створити</button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Скасувати</a>
            </form>
        </div>
    </div>
</div>
@endsection

