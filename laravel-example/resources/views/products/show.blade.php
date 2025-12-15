@extends('layouts.app')
@section('title', $product->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3">{{ $product->name }}</h1>
    <div class="d-flex gap-2">
        <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">Р РµРґР°РіСѓРІР°С‚Рё</a>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Р”Рѕ СЃРїРёСЃРєСѓ</a>
        <form action="{{ route('products.destroy', $product) }}" method="POST">
            @csrf @method('DELETE')
            <button class="btn btn-danger" onclick="return confirm('Р’РёРґР°Р»РёС‚Рё?')">Р’РёРґР°Р»РёС‚Рё</button>
        </form>
    </div>
</div>

@if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

<div class="card">
    <div class="card-body">
        <p><strong>РћРїРёСЃ:</strong><br>{{ $product->description ?? 'вЂ”' }}</p>
        <p><strong>Р¦С–РЅР°:</strong> {{ $product->formatted_price }}</p>
        <p><strong>РљС–Р»СЊРєС–СЃС‚СЊ:</strong> {{ $product->quantity }}</p>
        <p><strong>РЎС‚Р°С‚СѓСЃ:</strong>
            <span class="badge {{ $product->is_active ? 'bg-success' : 'bg-secondary' }}">
                {{ $product->is_active ? 'РђРєС‚РёРІРЅРёР№' : 'РќРµР°РєС‚РёРІРЅРёР№' }}
            </span>
        </p>
        <p><strong>РЎС‚РІРѕСЂРµРЅРѕ:</strong> {{ $product->created_at->format('d.m.Y H:i') }}</p>
        <p><strong>РћРЅРѕРІР»РµРЅРѕ:</strong> {{ $product->updated_at->format('d.m.Y H:i') }}</p>
    </div>
</div>
@endsection

