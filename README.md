<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Laravel RESTful API Server

This is a Laravel project that is designed to work as a RESTful API server, and uses a MySQL database to store records. This project also supports storing photos in its public folder.

## Installation

To install this project, follow these steps:

1. Clone the repository to your local machine:

```bash
git clone https://github.com/YOUR-USERNAME/YOUR-REPOSITORY
```

2. Change directory to the project root:

```bash
cd laravel-restful-api-server
```

3. Install the dependencies:

```bash
composer install
```

4. Create a .env file:

```bash
cp .env.example .env
```

5. Generate an application key:

```bash
php artisan key:generate
```

6. Edit the .env file and set the database connection details:

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

7. Migrate the database:

```bash
php artisan migrate
```

8. Start the development server:

```bash
php artisan serve
```

## Usage

This project provides RESTful API endpoints for performing CRUD operations on users. Here are the available endpoints:

```bash
    GET /api/users: List all users.
    POST /api/users: Create a new user.
    GET /api/users/{id}: Show a specific user by ID.
    PUT /api/users/{id}: Update a specific user by ID.
    DELETE /api/users/{id}: Delete a specific user by ID.
```

All requests and responses are in JSON format.

This project also supports uploading profile pictures for users. To upload a profile picture, use a POST request to the /api/users/{id}/profile-picture endpoint, and include the image file as a multipart/form-data payload with the profile_picture field name.

## License

This project is licensed under the MIT License. See the LICENSE file for details.
