@extends('layouts.app')

@section('content')
<div class="page-container">
    <h2 class="page-title">Insertar en: <strong>{{ $tabla }}</strong></h2>

    <div style="margin-bottom:15px;">
        <a href="{{ route('tables.show', $tabla) }}" class="btn btn-secondary">← Ver datos</a>
    </div>

    @if($nextId)
        <div class="alert alert-info">
            <strong>Próximo ID:</strong> <span style="font-size:18px;">{{ $nextId }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            @foreach($errors->all() as $error)<p style="margin:4px 0;">{{ $error }}</p>@endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('records.store', $tabla) }}" class="form-card">
        @csrf
        @foreach($columnsInfo as $col => $info)
            @if($info['Key'] === 'PRI') @continue @endif
            <div class="form-group">
                <label for="{{ $col }}">{{ $col }}</label>
                @if(isset($foreignKeys[$col]))
                    <select name="{{ $col }}" id="{{ $col }}" class="form-control" {{ $info['Null'] === 'NO' ? 'required' : '' }}>
                        <option value="">-- Selecciona --</option>
                        @foreach($foreignKeys[$col]['values'] as $fkVal)
                            <option value="{{ $fkVal }}">{{ $fkVal }}</option>
                        @endforeach
                    </select>
                @elseif(str_contains($info['Type'], 'text'))
                    <textarea name="{{ $col }}" id="{{ $col }}" class="form-control" placeholder="Descripción..." {{ $info['Null'] === 'NO' ? 'required' : '' }}></textarea>
                @elseif(str_contains($info['Type'], 'datetime'))
                    <input type="datetime-local" name="{{ $col }}" id="{{ $col }}" class="form-control" {{ $info['Null'] === 'NO' ? 'required' : '' }}>
                @elseif(str_contains($info['Type'], 'date'))
                    <input type="date" name="{{ $col }}" id="{{ $col }}" class="form-control" {{ $info['Null'] === 'NO' ? 'required' : '' }}>
                @elseif(str_contains($info['Type'], 'int'))
                    <input type="number" name="{{ $col }}" id="{{ $col }}" class="form-control" placeholder="Ej: 5" {{ $info['Null'] === 'NO' ? 'required' : '' }}>
                @elseif(str_contains($info['Type'], 'double') || str_contains($info['Type'], 'float') || str_contains($info['Type'], 'decimal'))
                    <input type="number" step="0.01" name="{{ $col }}" id="{{ $col }}" class="form-control" placeholder="Ej: 99.99" {{ $info['Null'] === 'NO' ? 'required' : '' }}>
                @else
                    <input type="text" name="{{ $col }}" id="{{ $col }}" class="form-control" placeholder="Ingresa un valor" {{ $info['Null'] === 'NO' ? 'required' : '' }}>
                @endif
            </div>
        @endforeach

        <div style="margin-top:20px;">
            <button type="submit" class="btn btn-primary">Insertar Registro</button>
            <a href="{{ route('tables.show', $tabla) }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
