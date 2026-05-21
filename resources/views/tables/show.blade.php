@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Datos de la tabla: <span style="color:#333">{{ $tabla }}</span></h2>

    @if(session('success'))
        <p class="alert-success">✔ {{ session('success') }}</p>
    @endif

    <div style="margin-bottom:20px; display:flex; gap:10px; flex-wrap:wrap;">
        <a href="{{ route('tables.index') }}" class="btn btn-secondary">← Volver a lista</a>
        <a href="{{ route('records.create', $tabla) }}" class="btn btn-primary">+ Insertar Nuevo Registro</a>
    </div>

    <p>Registros encontrados: <strong>{{ count($rows) }}</strong></p>

    @if(count($rows) > 0)
    <table>
        <tr>
            @foreach($columns as $col)
                <th>{{ $col }}</th>
            @endforeach
            <th>Acciones</th>
        </tr>
        @foreach($rows as $row)
        <tr>
            @foreach($row as $value)
                <td>{{ $value ?? '' }}</td>
            @endforeach
            <td style="text-align:center; white-space:nowrap;">
                @if($tabla === 'Products')
                    <a href="{{ route('records.edit', [$tabla, $row[$primaryKey]]) }}" class="btn btn-edit" style="padding:5px 10px;">Editar</a>
                @endif
                <form method="POST" action="{{ route('records.destroy', [$tabla, $row[$primaryKey]]) }}" style="display:inline" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este registro?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" style="padding:5px 10px;">Borrar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    @else
        <p style="font-style:italic; color:#999;">Esta tabla no contiene registros actualmente.</p>
    @endif
</div>
@endsection
