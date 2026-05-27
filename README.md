<div align="center">
  <img src="public/logo.jpeg" alt="Modyn Logo" width="200"/>

  <br>

  ![Laravel](https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
  ![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php&logoColor=white)
  ![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
  ![Composer](https://img.shields.io/badge/Composer-2.9-885630?style=for-the-badge&logo=composer&logoColor=white)

  <h3>Modyn Fashion</h3>

  <p>
    <a href="https://github.com/1ASI0726-20233-Modyn/Modyn-fashion">📁 Repositorio</a> ·
    <a href="#-instalación">🚀 Instalación</a> ·
    <a href="#funcionalidades">✨ Funcionalidades</a>
  </p>
</div>

---

## Descripción

**Modyn** es una aplicación web desarrollada con **Laravel 13** que permite gestionar la base de datos `Modyn_DB` de forma visual e intuitiva. Permite explorar tablas, insertar, editar y eliminar registros, además de contar con un catálogo de productos con búsqueda en tiempo real.

Este proyecto es la migración del sistema original desarrollado en **PHP puro**, ahora estructurado bajo el patrón **MVC** de Laravel.

---

## Funcionalidades

| Módulo | Descripción |
|---|---|
| **Inicio** | Bienvenida con logo y accesos rápidos |
| **Tablas** | Explora todas las tablas de `Modyn_DB` |
| **Ver datos** | Visualiza los registros de cualquier tabla |
| **Insertar** | Formulario dinámico adaptado al tipo de dato y claves foráneas |
| **Editar** | Edición de productos (nombre, descripción, precio) |
| **Eliminar** | Eliminación con confirmación |
| **Catálogo** | Vista en cards con búsqueda por ID, nombre o descripción |

---

## Tecnologías

- **Backend:** Laravel 13, PHP 8.3
- **Base de datos:** MySQL 8.x
- **Frontend:** Blade Templates, CSS personalizado (sin dependencias de Node/Vite)
- **Herramientas:** Composer, Git

---

## Estructura del proyecto

```
laravel/
├── app/
│   └── Http/
│       └── Controllers/
│           ├── DatabaseTableController.php    # CRUD genérico de tablas
│           └── ProductCatalogueController.php # Catálogo con búsqueda
├── resources/
│   └── views/
│       ├── layouts/app.blade.php              # Layout principal con CSS inline
│       ├── home.blade.php                     # Página de inicio
│       ├── tables/
│       │   ├── table-list.blade.php           # Lista de tablas
│       │   ├── table-records.blade.php        # Registros de tabla
│       │   ├── record-create.blade.php        # Formulario insertar
│       │   └── record-edit.blade.php          # Formulario editar
│       └── catalogue/
│           └── index.blade.php                # Catálogo de productos
├── routes/
│   └── web.php                                # Definición de rutas
├── public/
│   └── logo.jpeg                              # Logo de Modyn
└── .env                                       # Variables de entorno
```

---

## Rutas

| Método | Ruta | Descripción |
|---|---|---|
| `GET` | `/` | Inicio |
| `GET` | `/catalogue` | Catálogo de productos |
| `GET` | `/tables` | Lista de tablas |
| `GET` | `/tables/{tabla}` | Datos de una tabla |
| `GET` | `/tables/{tabla}/create` | Formulario de inserción |
| `POST` | `/tables/{tabla}` | Guardar registro |
| `GET` | `/tables/{tabla}/{id}/edit` | Formulario de edición |
| `PUT` | `/tables/{tabla}/{id}` | Actualizar registro |
| `DELETE` | `/tables/{tabla}/{id}` | Eliminar registro |

---

## 🚀 Instalación

### Requisitos previos

- PHP 8.3+ con extensiones: `mbstring` `openssl` `pdo_mysql` `fileinfo` `curl` `zip`
- Composer 2.x
- MySQL 8.x
- Git

### Paso a paso

**1. Clonar el repositorio**
```bash
git clone https://github.com/1ASI0726-20233-Modyn/Modyn-fashion.git
cd Modyn-fashion
```

**2. Instalar dependencias**
```bash
composer install
```

**3. Configurar el entorno**
```bash
cp .env.example .env
php artisan key:generate
```

Edita el `.env` con tus datos de base de datos:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=Modyn_DB
DB_USERNAME=root
DB_PASSWORD=tu_contraseña
```

**4. Crear la base de datos**

En MySQL Workbench o cualquier cliente MySQL:
```sql
CREATE DATABASE Modyn_DB;
```

**5. Importar el esquema**

Si tienes el archivo `.sql`:
```
MySQL Workbench → Server → Data Import → Import from Self-Contained File
```

**6. Iniciar el servidor**
```bash
php artisan serve
```

Abre **http://localhost:8000** en tu navegador. 🎉

---

## Solución de problemas

<details>
<summary><strong>❌ composer install falla por extensión faltante</strong></summary>

Abre tu `php.ini` y activa las extensiones quitando el `;` del inicio:

```ini
extension=fileinfo
extension=zip
extension=pdo_mysql
extension=mbstring
extension=openssl
extension=curl
```

</details>

<details>
<summary><strong>❌ La página sale sin estilos</strong></summary>

El proyecto usa CSS inline en el layout, **no necesita Vite ni `npm run dev`**. Asegúrate de usar el archivo `layouts/app.blade.php` incluido en este repositorio y de solo correr `php artisan serve`.

</details>

<details>
<summary><strong>❌ Error de conexión a la base de datos</strong></summary>

Verifica que:
- El servicio MySQL esté corriendo
- Las credenciales en `.env` sean correctas
- La base de datos `Modyn_DB` exista

</details>

<details>
<summary><strong>❌ php o composer no se reconocen en PowerShell</strong></summary>

Asegúrate de que la carpeta de PHP (ej. `C:\php`) esté agregada al **PATH** del sistema:

1. Busca **"Variables de entorno"** en Windows
2. En **Variables del sistema** → doble clic en **Path**
3. Agrega la ruta de tu PHP (ej. `C:\php`)
4. Reinicia PowerShell

</details>

---

## Equipo

<table>
  <tr>
    <td align="center"><b>Brianna Cristina Salinas Guzmán</b></td>
    <td align="center"><b>Mathias Alejandro Castillo Guevara</b></td>
  </tr>
  <tr>
    <td align="center"><b>Guillermo Arturo Howard Robles</b></td>
    <td align="center"><b>Luis Alberto Flores Centeno</b></td>
  </tr>
</table>

---

<div align="center">
  <sub>Desarrollado por los mas pros de UPC</sub>
</div>
