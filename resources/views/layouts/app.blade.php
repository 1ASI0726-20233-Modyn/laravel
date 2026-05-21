<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modyn Database</title>
    @vite('resources/css/app.css')
</head>
<body>

<header class="site-header">
    <div class="brand"><a href="{{ route('home') }}">MODYN</a></div>
    <nav class="site-nav">
        <a href="{{ route('home') }}" @class(['active' => request()->routeIs('home')])>Inicio</a>
        <a href="{{ route('tables.index') }}" @class(['active' => request()->routeIs('tables.*', 'records.*')])>Tablas</a>
        <a href="{{ route('catalogue.index') }}" @class(['active' => request()->routeIs('catalogue.*')])>Catálogo</a>
    </nav>
</header>

<hr class="site-divider">

<main>@yield('content')</main>

<hr class="site-divider">
<footer class="site-footer"><p>MODYN &copy; 2026</p></footer>

</body>
</html>
