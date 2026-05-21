@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tablas de Modyn_DB</h2>
    <p>Tablas encontradas: <strong>{{ count($tables) }}</strong></p>

    <table>
        <tr>
            <th>#</th>
            <th>Nombre de la Tabla</th>
            <th>Acción</th>
        </tr>
        @foreach($tables as $i => $tabla)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td><strong>{{ $tabla }}</strong></td>
            <td>
                <a href="{{ route('tables.show', $tabla) }}" class="btn btn-edit" style="padding:5px 14px;">Ver Datos</a>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
