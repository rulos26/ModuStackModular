<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development/)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
 # ModuStackModular
 
 ## Descripción General
 
 **ModuStackModular** es una aplicación web moderna construida sobre el framework **Laravel 12**. El nombre del proyecto sugiere una arquitectura modular, diseñada para ser escalable y fácil de mantener. La aplicación está configurada para un entorno de desarrollo local robusto (posiblemente XAMPP o Laravel Sail) y utiliza herramientas estándar de la industria para la gestión de dependencias, pruebas y calidad de código.
 
 El uso extensivo de la librería `FakerPHP` para múltiples idiomas (español, portugués, francés, etc.) indica que el proyecto maneja una base de datos con datos complejos y probablemente está diseñado con capacidades de **internacionalización (multi-idioma)**.
 
 ## Características Técnicas
 
 *   **Framework Backend**: Laravel 12
 *   **Versión de PHP**: `^8.2`
 *   **Gestor de Dependencias**: Composer
 *   **Frontend**: La configuración de scripts (`npm run dev`) sugiere el uso de Vite para la compilación de assets (JavaScript, CSS, etc.).
 *   **Base de Datos**: La configuración inicial crea una base de datos SQLite, pero es compatible con MySQL, PostgreSQL, etc., a través de la configuración de Laravel.
 *   **Entorno de Desarrollo**:
    *   Compatible con **XAMPP**.
    *   Preparado para **Laravel Sail**, una interfaz de línea de comandos para interactuar con el entorno de desarrollo Docker de Laravel.
 *   **Calidad de Código**: Uso de **Laravel Pint** para formateo y estandarización del código.
 *   **Testing**:
    *   Framework de pruebas **PHPUnit**.
    *   Librería de mocks **Mockery**.
 *   **Generación de Datos de Prueba**: **FakerPHP** para poblar la base de datos con datos de prueba realistas.
 *   **Manejo de Colas (Queues)**: El script de desarrollo (`dev`) incluye un listener de colas (`php artisan queue:listen`), lo que indica que la aplicación maneja tareas en segundo plano (como envío de correos, procesamiento de trabajos pesados, etc.).
 *   **Logging**: Uso de **Laravel Pail** para una visualización amigable de los logs en tiempo real.
 
 ## Instalación y Puesta en Marcha
 
 Sigue estos pasos para configurar el entorno de desarrollo.
 
 1.  **Clonar el repositorio** (si aplica)
 
 2.  **Instalar dependencias de PHP**:
     ```bash
     composer install
     ```
 
 3.  **Configurar el entorno**:
     *   Copia el archivo de entorno de ejemplo:
         ```bash
         cp .env.example .env
         ```
     *   Genera la clave de la aplicación:
         ```bash
         php artisan key:generate
         ```
     *   Configura las credenciales de tu base de datos en el archivo `.env`.
 
 4.  **Base de Datos**:
     *   Crea la base de datos (ej. `modustack_db` en MySQL/MariaDB).
     *   Ejecuta las migraciones para crear las tablas:
         ```bash
         php artisan migrate
         ```
     *   (Opcional) Puebla la base de datos con datos de prueba:
         ```bash
         php artisan db:seed
         ```
 
 5.  **Instalar dependencias de Frontend**:
     ```bash
     npm install
     ```
 
 6.  **Ejecutar el servidor de desarrollo**:
     Puedes usar el script `dev` personalizado que lanza todos los servicios necesarios concurrentemente.
     ```bash
     composer run dev
     ```
     Este comando ejecutará:
     *   El servidor de desarrollo de Laravel (`php artisan serve`).
     *   El listener de colas (`php artisan queue:listen`).
     *   El visor de logs en tiempo real (`php artisan pail`).
     *   El compilador de assets de Vite (`npm run dev`).
 
 ## Scripts Útiles
 
 *   **Ejecutar tests**:
     ```bash
     composer test
     ```
 *   **Formatear código (Linting)**:
     ```bash
     ./vendor/bin/pint
     ```
