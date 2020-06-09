# Template Provided by
<p align="center"><h2>Ghost Enterprise</h2></p>

Este template proporciona:
Laravel 7, VueJS 2.5.17 y Vuetify 2.2.28.
La implementación de Laravel Passport.
Laravel Material Dashboard.
Componente Vue para Gestión de Usuarios.

## Designado para el desarrollo del proyecto "Gestium"

<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
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

Poner en marcha el template:

1. Clona o descarga el proyecto
2. Entra al directorio raiz y ejecuta la terminal de comandos, mantenla activa durante todo el proceso
3. Ejecuta: composer install
4. Copia el archivo .env.example en el directorio raiz y renombralo a .env
5. Crea una base de datos en tu SGBD MySQL
6. Abre el archivo .env y asigna el nombre de la base de datos que acabas de crear a DB_DATABASE
7. El nombre de usuario DB_USERNAME y contraseña DB_PASSWORD, corresponden a las configuraciones de tu SGBD,
   modifícalos si es necesario.
8. Ejecuta: php artisan key:generate
9. Ejecuta: npm install
10. Ejecuta: php artisan migrate --seed
11. Ejecuta: php artisan serve
12. Abre una nueva terminal dentro del mismo directorio y ejecuta: npm run watch
13. Ve a Chrome y accede a localhost:8000 

