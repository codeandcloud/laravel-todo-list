# About Todo List Project

## Introduction

This is a hobby project to learn the MVC implementation of PHP using the Laravel Framework in a *Windows 11 machine*. This project use both sqlite3 and MySQL as database(and adminer to manage the database table data). Things to install before starting with the project

- PHP and Composer
- Laravel
- SQLite
- Docker Desktop (I have installed MySQL using Docker Desktop in this project)

Please ensure that these extensions are enabled in the *php.ini* file in your machine

- extension=curl
- extension=fileinfo
- extension=mbstring
- extension=mysqli
- extension=openssl
- extension=pdo_mysql
- extension=pdo_sqlite
- extension=sqlite3

## Steps

Please follow these steps to create the project and run

1. ```composer create-project laravel/laravel laravel-todo-list```
2. ```php artisan serve```
3. ```docker compose up``` *(to run the docker-compose.yml in the root)*
[What is Artisan Console?](https://laravel.com/docs/11.x/artisan)

## Important Commands

Some of the commands that I have come across while working with the project

### General

- ```php artisan serve``` *(runs the project)*
- ```php artisan tinker``` *(tinker with the functions in shell. Stuff like db query)*

### Routing

- ```php artisan route:list``` *(List all routes)*

### Database

- ```php artisan make:model Task -m``` *(Creates a model)*
- ```php artisan make:factory TaskFactory --model=Task``` *(Creates a factory class for seeding)*
- ```php artisan db:seed``` *(To seed database with dummy data)*
- ```php artisan migrate``` *(Migrate DB changes to database)*
- ```php artisan migrate:refresh --seed``` *(Reset data and starts seeding afresh. Shouldn't use in production)*

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
