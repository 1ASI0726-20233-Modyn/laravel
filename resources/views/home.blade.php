@extends('layouts.app')

@section('content')
<div class="page-container" style="text-align:center; padding-top: 40px;">
    <img src="/logo.jpeg" alt="Modyn Logo" style="max-height: 100px; margin-bottom: 20px; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
    <h2 class="page-title">Bienvenido a Modyn Database</h2>
    <p style="color:#888; margin-bottom: 30px;">Panel de administración de la base de datos Modyn_DB.</p>
    <div style="display:flex; gap:15px; justify-content:center; flex-wrap:wrap;">
        <a href="{{ route('tables.index') }}" class="btn btn-primary">📋 Ver Tablas</a>
        <a href="{{ route('catalogue.index') }}" class="btn btn-secondary">🛍️ Catálogo de Productos</a>
    </div>
</div>
@endsection
