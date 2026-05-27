<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modyn Database</title>
    <style>
        /* ============================================================
           MODYN — Estilos globales (inline, sin Vite)
        ============================================================ */
        :root {
            --pink:        #f8bbd0;
            --pink-dark:   #f06292;
            --pink-light:  #fff5f8;
            --pink-border: #fce4ec;
            --white:       #ffffff;
            --text:        #4a4a4a;
            --shadow:      0 4px 15px rgba(248, 187, 208, 0.4);
            --radius:      15px;
        }
        *, *::before, *::after { box-sizing: border-box; }
        body {
            font-family: 'Inter', 'Segoe UI', sans-serif;
            background-color: var(--pink-light);
            color: var(--text);
            margin: 0; padding: 0;
        }
        /* Header */
        .site-header {
            background: var(--white);
            padding: 10px 20px;
            display: flex;
            align-items: center;
            gap: 40px;
            box-shadow: var(--shadow);
            border-bottom: 2px solid var(--pink-border);
        }
        .site-header .brand a {
            text-decoration: none;
            color: var(--pink-dark);
            font-size: 1.8rem;
            font-weight: 700;
            letter-spacing: 2px;
        }
        /* Nav */
        .site-nav { display: flex; gap: 10px; }
        .site-nav a {
            text-decoration: none;
            color: var(--pink-dark);
            font-weight: 600;
            padding: 8px 20px;
            border-radius: 20px;
            transition: all 0.3s ease;
            border: 1px solid var(--pink);
        }
        .site-nav a:hover, .site-nav a.active {
            background: var(--pink);
            color: var(--white);
        }
        /* Divider / Footer */
        .site-divider { border: none; border-top: 1px solid var(--pink-border); margin: 0; }
        .site-footer { text-align: center; color: gray; padding: 20px; margin-top: 30px; }
        /* Layout */
        .page-container { padding: 20px; max-width: 1200px; margin: 0 auto; }
        h2.page-title { color: var(--pink-dark); }
        /* Tables */
        .data-table {
            width: 90%; margin: 30px auto;
            border-collapse: separate; border-spacing: 0;
            background: var(--white);
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow);
        }
        .data-table th {
            background-color: var(--pink);
            color: var(--white);
            padding: 15px;
            text-transform: uppercase;
            font-size: 0.85rem;
        }
        .data-table td { padding: 12px 15px; border-bottom: 1px solid var(--pink-border); }
        .data-table tr:hover { background-color: #fffbfd; }
        /* Buttons */
        .btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 20px;
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
            border: none;
            font-size: 14px;
            margin: 3px;
            transition: opacity 0.2s;
        }
        .btn:hover { opacity: 0.85; }
        .btn-primary   { background: var(--pink-dark); color: var(--white); box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .btn-secondary { background: var(--pink-border); color: var(--pink-dark); border: 1px solid var(--pink); }
        .btn-danger    { background: #fff1f2; color: #e11d48; border: 1px solid #fecdd3; }
        .btn-edit      { background: #e0f2fe; color: #0ea5e9; border: 1px solid #bae6fd; }
        .btn-sm        { padding: 5px 12px; font-size: 13px; }
        /* Alerts */
        .alert { padding: 10px 15px; border-radius: 6px; margin-bottom: 15px; font-weight: bold; }
        .alert-success { background: #e8f5e9; color: #2e7d32; }
        .alert-error   { background: #fde8e8; color: #c62828; }
        .alert-info    { background: #e3f2fd; color: #1565c0; border-left: 4px solid #2196F3; font-weight: normal; }
        /* Forms */
        .form-card {
            padding: 20px;
            border: 1px solid #ccc;
            background: #f9f5f1;
            border-radius: 8px;
            max-width: 680px;
        }
        .form-group {
            margin: 10px 0; padding: 10px;
            background: #f9f9f9;
            border-left: 3px solid #2196F3;
            border-radius: 4px;
        }
        .form-group label { font-weight: bold; display: block; margin-bottom: 5px; }
        .form-control {
            width: 100%; padding: 8px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 14px;
            font-family: inherit;
        }
        textarea.form-control { min-height: 80px; }
        /* Catalogue */
        .catalogue-wrapper { max-width: 1100px; margin: 0 auto; padding: 10px 15px 30px; }
        .search-bar { display: flex; justify-content: center; margin-bottom: 28px; }
        .search-bar input {
            width: 100%; max-width: 520px;
            padding: 11px 16px; font-size: 15px;
            border: 1px solid #ccc;
            border-radius: 6px 0 0 6px;
            outline: none;
            transition: border-color 0.2s;
            font-family: inherit;
        }
        .search-bar input:focus { border-color: #888; }
        .search-bar button {
            padding: 11px 20px;
            background: #333; color: #fff;
            border: 1px solid #333;
            border-radius: 0 6px 6px 0;
            cursor: pointer; font-size: 15px;
            font-family: inherit;
            transition: background 0.2s;
        }
        .search-bar button:hover { background: #555; }
        .search-count { text-align: center; color: #666; font-size: 14px; margin-bottom: 20px; }
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
            gap: 20px;
        }
        .product-card {
            background: var(--white);
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 18px 16px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.06);
            transition: transform 0.15s, box-shadow 0.15s;
            display: flex; flex-direction: column; gap: 6px;
        }
        .product-card:hover { transform: translateY(-3px); box-shadow: 0 4px 12px rgba(0,0,0,0.12); }
        .product-card .card-id    { font-size: 11px; color: #aaa; letter-spacing: 0.5px; text-transform: uppercase; }
        .product-card .card-name  { font-size: 15px; font-weight: bold; color: #222; line-height: 1.3; }
        .product-card .card-desc  { font-size: 13px; color: #666; line-height: 1.45; flex-grow: 1; }
        .product-card .card-price { font-size: 17px; font-weight: bold; color: #2a7a2a; margin-top: 6px; }
        .no-results { text-align: center; color: #999; font-size: 15px; padding: 40px 0; grid-column: 1 / -1; }
        /* Responsive */
        @media (max-width: 600px) {
            .products-grid { grid-template-columns: 1fr 1fr; gap: 14px; }
            .search-bar input { font-size: 14px; }
        }
        @media (max-width: 380px) { .products-grid { grid-template-columns: 1fr; } }
    </style>
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
