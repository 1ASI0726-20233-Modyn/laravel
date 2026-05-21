@extends('layouts.app')

@section('content')
<div class="page-container">
    <h2 class="page-title">Bienvenido</h2>
    <p>Selecciona <a href="{{ route('tables.index') }}">Tablas</a> para explorar la base de datos Modyn_DB.</p>
</div>
@endsection
