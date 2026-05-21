# Modyn — Laravel

Migración de la app Modyn a Laravel Framework.

## Estructura

```
app/Http/Controllers/
  TableController.php    ← CRUD dinámico para todas las tablas
  CatalogueController.php ← Buscador de productos

resources/views/
  layouts/app.blade.php  ← Layout principal (header/footer)
  home.blade.php          ← Página de inicio
  tables/
    index.blade.php       ← Lista de tablas
    show.blade.php        ← Datos de una tabla + borrar/editar
    create.blade.php      ← Formulario de inserción
    edit.blade.php        ← Editar producto (solo Products)
  catalogue/
    index.blade.php       ← Catálogo con buscador

routes/web.php            ← Todas las rutas
```

## Setup

```bash
# 1. Instalar dependencias
composer install

# 2. Copiar .env y configurar contraseña de BD
cp .env.example .env
# Edita .env: pon DB_PASSWORD con tu contraseña real

# 3. Generar clave de app
php artisan key:generate

# 4. Correr el servidor
php artisan serve
```

## Rutas principales

| Ruta | Descripción |
|------|-------------|
| `/` | Inicio |
| `/tables` | Lista de tablas |
| `/tables/{tabla}` | Ver datos de una tabla |
| `/tables/{tabla}/create` | Insertar registro |
| `/tables/{tabla}/{id}/edit` | Editar producto |
| `/catalogue` | Catálogo de productos con búsqueda |
