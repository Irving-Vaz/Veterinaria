<h1 align="center">🐾 Sistema de Gestión Veterinaria</h1>

<p align="center">
  Aplicación web para la gestión de una clínica veterinaria, desarrollada con Laravel 12 y el tema SB Admin 2.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-red?logo=laravel" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.3-blue?logo=php" alt="PHP">
  <img src="https://img.shields.io/badge/DB-SQLite-lightgrey?logo=sqlite" alt="SQLite">
  <img src="https://img.shields.io/badge/UI-SB%20Admin%202-informational" alt="SB Admin 2">
  <img src="https://img.shields.io/badge/licencia-MIT-green" alt="MIT">
</p>

---

## 📋 Descripción

Sistema web para administrar una clínica veterinaria con autenticación de usuarios y **control de acceso por roles**. El sistema diferencia dos tipos de usuarios:

- **Administrador** — accede a un panel de administración exclusivo con gestión de usuarios, reportes y configuración del sistema.
- **Veterinario** — accede al dashboard clínico con gestión de pacientes, citas y propietarios.

---

## ✨ Funcionalidades implementadas

- [x] Sistema de autenticación (login / logout)
- [x] Redirección automática post-login según rol
- [x] Layout y partials exclusivos para **Veterinario** (sidebar azul)
- [x] Layout y partials exclusivos para **Administrador** (sidebar rojo)
- [x] Dashboard del Veterinario (pacientes, citas, propietarios, pendientes)
- [x] Dashboard del Administrador (usuarios, veterinarios, ingresos, reportes)
- [x] Campo `rol` tipo `ENUM` en la tabla `users` (`administrador` / `veterinario`)
- [x] Seeders de usuarios por defecto (admin + veterinario)
- [x] Fondo de video en la pantalla de login
- [x] Plantilla SB Admin 2 integrada desde `public/startbootstrap/`

---

## 🛠 Stack tecnológico

| Tecnología | Versión |
|---|---|
| PHP | 8.3 |
| Laravel | 12.x |
| Base de datos | SQLite |
| UI Template | SB Admin 2 (Bootstrap 4) |
| Sesiones | Driver `database` |

---

## 🚀 Instalación y configuración

### 1. Clonar el repositorio

```bash
git clone <url-del-repositorio>
cd Veterinaria
```

### 2. Instalar dependencias PHP

```bash
composer install
```

### 3. Configurar el entorno

```bash
cp .env.example .env
php artisan key:generate
```

> El proyecto usa **SQLite** por defecto. No requiere configuración adicional de base de datos.

### 4. Ejecutar migraciones y seeders

```bash
php artisan migrate:fresh --seed
```

Esto crea las tablas y genera los usuarios de prueba:

| Rol | Email | Contraseña |
|---|---|---|
| Administrador | `admin@gmail.com` | `admin` |
| Veterinario | `veterinario@gmail.com` | `veterinario` |

### 5. Iniciar el servidor de desarrollo

```bash
php artisan serve
```

Accede en: [http://localhost:8000](http://localhost:8000)

---

## 🗂 Estructura de vistas

```
resources/views/
├── layouts/
│   ├── auth.blade.php              # Layout para login
│   ├── main.blade.php              # Layout del Veterinario
│   ├── partials/                   # Partials del Veterinario
│   │   ├── sidebar.blade.php       # Sidebar azul
│   │   ├── topbar.blade.php
│   │   ├── footer.blade.php
│   │   └── logout_modal.blade.php
│   ├── admin.blade.php             # Layout del Administrador
│   └── admin_partials/             # Partials del Administrador
│       ├── sidebar.blade.php       # Sidebar rojo
│       ├── topbar.blade.php        # Topbar con badge "Administrador"
│       ├── footer.blade.php
│       └── logout_modal.blade.php
└── modules/
    ├── auth/
    │   └── login.blade.php
    ├── dashboard/
    │   └── home.blade.php          # Dashboard del Veterinario
    └── admin/
        └── dashboard.blade.php     # Dashboard del Administrador
```

---

## 🔀 Rutas disponibles

| Método | URI | Nombre | Descripción | Middleware |
|---|---|---|---|---|
| GET | `/` | `login` | Formulario de login | `guest` |
| POST | `/logear` | `logear` | Procesar login | `guest` |
| GET | `/home` | `home` | Dashboard Veterinario | `auth` |
| GET | `/admin/dashboard` | `admin.dashboard` | Dashboard Administrador | `auth` |
| GET | `/logout` | `logout` | Cerrar sesión | `auth` |

---

## 🗄 Migraciones

### `users`

| Campo | Tipo | Detalle |
|---|---|---|
| `id` | bigint | PK autoincrement |
| `name` | varchar | Nombre del usuario |
| `email` | varchar | Único |
| `email_verified_at` | timestamp | Nullable |
| `password` | varchar | Hasheada con bcrypt |
| `rol` | enum | `administrador` \| `veterinario` — default `veterinario` |
| `remember_token` | varchar | Nullable |
| `created_at / updated_at` | timestamp | — |

---

## 🌱 Seeders

| Seeder | Descripción |
|---|---|
| `AdminUserSeeder` | Crea el usuario administrador y el usuario veterinario por defecto |

---

## 📁 Assets de la plantilla

La plantilla **SB Admin 2** se encuentra en `public/startbootstrap/` y se referencia directamente desde las vistas Blade. No requiere compilación.

Incluye:
- Bootstrap 4
- Font Awesome
- jQuery + jQuery Easing
- Chart.js

---

## 📄 Licencia

Este proyecto está bajo la licencia [MIT](https://opensource.org/licenses/MIT).
