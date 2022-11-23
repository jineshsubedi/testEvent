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
        - update database information in .env
        - set `APP_DEBUG=FALSE` for production
        - set `FILESYSTEM_DISK=public`
    - `php artisan key:generate`
    - `php artisan migrate` to install all the required tables
    - `php artisan storage:link` for storing the event images
    - To run the project
        - `php artisan serve` in one terminal
        - `npm run dev` in another terminal for local
        - `npm run build` in production
    - to run test `php artisan test` 

## Guideline
    - Change the Admin credential from UserSeeder inside Seeders folder.
    - Either Register as a new User or Run `php artisan db:seed`.
    - In Dashboard select Event menu tab and perform crud operation.
    - Event Testing can be found inside test/Feature.