@extends('layouts.app')

@section('content')
<div class="page-container">
    <h2 class="page-title">Tabla: {{ $tabla }}</h2>

    @if(session('success'))
        <p class="alert alert-success">✔ {{ session('success') }}</p>
    @endif

    <div style="display:flex; gap:8px; flex-wrap:wrap; margin-bottom:20px;">
        <a href="{{ route('tables.index') }}" class="btn btn-secondary">← Volver a lista</a>
        <a href="{{ route('records.create', $tabla) }}" class="btn btn-primary">+ Insertar Registro</a>
    </div>

    <p>Registros encontrados: <strong>{{ count($rows) }}</strong></p>

    @if(count($rows) > 0)
    <table class="data-table">
        <tr>
            @foreach($columns as $col)<th>{{ $col }}</th>@endforeach
            <th>Acciones</th>
        </tr>
        @foreach($rows as $row)
        <tr>
            @foreach($row as $value)<td>{{ $value ?? '' }}</td>@endforeach
            <td style="white-space:nowrap;">
                @if($tabla === 'Products')
                    <a href="{{ route('records.edit', [$tabla, $row[$primaryKey]]) }}" class="btn btn-edit btn-sm">Editar</a>
                @endif
                <form method="POST" action="{{ route('records.destroy', [$tabla, $row[$primaryKey]]) }}" style="display:inline"
                      onsubmit="return confirm('¿Eliminar este registro?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Borrar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    @else
        <p style="font-style:italic; color:#999;">Esta tabla no tiene registros.</p>
    @endif
</div>
@endsection
