@extends('layouts.app')
@section('title', 'Р РµРґР°РіСѓРІР°С‚Рё: ' . $product->name)

@section('content')
<h1 class="h3 mb-3">Р РµРґР°РіСѓРІР°С‚Рё РїСЂРѕРґСѓРєС‚: {{ $product->name }}</h1>
<form action="{{ route('products.update', $product) }}" method="POST" class="card card-body">
    @csrf @method('PUT')

    <div class="mb-3">
        <label class="form-label">РќР°Р·РІР° *</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $product->name) }}" required>
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">РћРїРёСЃ</label>
        <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description) }}</textarea>
        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label">Р¦С–РЅР° *</label>
            <input type="number" step="0.01" min="0" name="price" class="form-control @error('price') is-invalid @enderror"
                   value="{{ old('price', $product->price) }}" required>
            @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-4">
            <label class="form-label">РљС–Р»СЊРєС–СЃС‚СЊ *</label>
            <input type="number" min="0" name="quantity" class="form-control @error('quantity') is-invalid @enderror"
                   value="{{ old('quantity', $product->quantity) }}" required>
            @error('quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                <label class="form-check-label">РђРєС‚РёРІРЅРёР№</label>
            </div>
        </div>
    </div>

    <div class="mt-3 d-flex gap-2">
        <button class="btn btn-primary" type="submit">РћРЅРѕРІРёС‚Рё</button>
        <a href="{{ route('products.show', $product) }}" class="btn btn-secondary">РЎРєР°СЃСѓРІР°С‚Рё</a>
    </div>
</form>
@endsection

