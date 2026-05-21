@extends('layouts.app')

@section('content')
<div class="catalogue-wrapper">
    <h2 class="page-title">Catálogo de Productos</h2>

    <form method="GET" action="{{ route('catalogue.index') }}">
        <div class="search-bar">
            <input type="text" name="q"
                   placeholder="Buscar por ID, nombre o descripción..."
                   value="{{ $search }}" autocomplete="off">
            <button type="submit">Buscar</button>
        </div>
    </form>

    <p class="search-count">
        @if($search !== '')
            {{ $total }} resultado{{ $total !== 1 ? 's' : '' }} para "<strong>{{ $search }}</strong>"
            &mdash; <a href="{{ route('catalogue.index') }}">Limpiar búsqueda</a>
        @else
            {{ $total }} producto{{ $total !== 1 ? 's' : '' }} en catálogo
        @endif
    </p>

    <div class="products-grid">
        @forelse($products as $product)
            <div class="product-card">
                <span class="card-id"># {{ $product->PRO_id }}</span>
                <span class="card-name">{{ $product->PRO_name }}</span>
                <span class="card-desc">{{ $product->PRO_description }}</span>
                <span class="card-price">S/ {{ number_format($product->PRO_price, 2) }}</span>
            </div>
        @empty
            <p class="no-results">No se encontraron productos.</p>
        @endforelse
    </div>
</div>
@endsection
