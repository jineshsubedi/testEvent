<p>Event Manager</p>

## About Event Manager

Event Manager is a web applcation to track event happening on.

## Technical Specification
    - php 8.1.2 (supports above 8.0)
    - Laravel 9.*
    - mysql 5.1.1
    - vue3
    - Inertia.js

## Installation and Configuration

    - Clone the repository
    - Open Terminal Inside Project Folder and run `composer install`
    - Create database
    - copy .env.example to .env
    - `php artisan key:generate`
    - update database information in .env
    - `php artisan migrate` to install all the required tables
    - set `APP_DEBUG=FALSE` for production
    - set `FILESYSTEM_DISK=public`
    - `php artisan storage:link`
    - To run the project
        - `php artisan serve` in one terminal
        - `npm run dev` in another terminal for local
        - `npm run build` in production