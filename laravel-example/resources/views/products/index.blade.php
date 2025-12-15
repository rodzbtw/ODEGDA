@extends('layouts.app')
@section('title', 'РЎРїРёСЃРѕРє РїСЂРѕРґСѓРєС‚С–РІ')
@php use Illuminate\Support\Str; @endphp

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3">РџСЂРѕРґСѓРєС‚Рё</h1>
    <a href="{{ route('products.create') }}" class="btn btn-primary">Р”РѕРґР°С‚Рё</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($products->isEmpty())
    <div class="alert alert-info">РќРµРјР°С” РїСЂРѕРґСѓРєС‚С–РІ. РЎС‚РІРѕСЂС–С‚СЊ РїРµСЂС€РёР№.</div>
@else
    <div class="row">
        @foreach($products as $product)
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($product->description, 100) }}</p>
                        <p class="card-text"><strong>Р¦С–РЅР°:</strong> {{ $product->formatted_price }}</p>
                        <p class="card-text"><strong>РљС–Р»СЊРєС–СЃС‚СЊ:</strong> {{ $product->quantity }}</p>
                        <span class="badge {{ $product->is_active ? 'bg-success' : 'bg-secondary' }}">
                            {{ $product->is_active ? 'РђРєС‚РёРІРЅРёР№' : 'РќРµР°РєС‚РёРІРЅРёР№' }}
                        </span>
                    </div>
                    <div class="card-footer d-flex gap-2">
                        <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-outline-primary">РџРµСЂРµРіР»СЏРЅСѓС‚Рё</a>
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-outline-warning">Р РµРґР°РіСѓРІР°С‚Рё</a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="ms-auto">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Р’РёРґР°Р»РёС‚Рё?')">Р’РёРґР°Р»РёС‚Рё</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection

