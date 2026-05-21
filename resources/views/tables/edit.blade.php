@extends('layouts.app')

@section('content')
<div class="container" style="max-width:500px;">
    <h2 style="text-align:center;">Editar Producto #{{ $product['PRO_id'] }}</h2>

    @if($errors->any())
        <div class="alert-error">
            @foreach($errors->all() as $error) <p>{{ $error }}</p> @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('records.update', ['Products', $product['PRO_id']]) }}" style="padding:20px; border:1px solid #ccc; background:#f9f5f1; border-radius:8px;">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nombre del Producto:</label>
            <input type="text" name="PRO_name" class="form-control" value="{{ old('PRO_name', $product['PRO_name']) }}" required>
        </div>

        <div class="form-group">
            <label>Descripción:</label>
            <textarea name="PRO_description" class="form-control" required>{{ old('PRO_description', $product['PRO_description']) }}</textarea>
        </div>

        <div class="form-group">
            <label>Precio (S/):</label>
            <input type="number" step="0.01" name="PRO_price" class="form-control" value="{{ old('PRO_price', $product['PRO_price']) }}" required>
        </div>

        <div style="text-align:center; margin-top:15px;">
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="{{ route('tables.show', 'Products') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
