<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Product Management API

A REST API for managing products, images, and comments with role-based authentication.

## Tech Stack

- Laravel 11
- MySQL
- JWT Authentication (tymon/jwt-auth)
- PHP 8.2+

## Setup Instructions

### 1. Install Dependencies

```bash
composer install
```

### 2. Environment Setup

Copy .env.example to .env and update database credentials

### 3. Generate Keys

```bash
php artisan key:generate
php artisan jwt:secret
```

### 4. Database Setup

Create database backend-task, then run:

```bash
php artisan migrate
```

### 5. Storage Link (for images)

```bash
php artisan storage:link
```

### 6. Start Server

```bash
php artisan serve
```

API runs at http://localhost:8000

### 7. Create Admin User

Register a user via API, then update the role manually in the database

## Project Structure

```
app/
├── Http/
│   ├── Controllers/      # AuthController, ProductController, CommentController, ImageController
│   ├── Middleware/       # Authenticate, IsAdmin
│   └── Requests/         # Form validation
└── Models/              # User, Product, ProductImage, Comment

database/migrations/     # Database schema
routes/api.php          # API routes
```

## Assumptions Made

- New users default to 'user' role (admin must be set manually in database)
- Images stored in products
- Max 5 images per upload, 2MB each (jpg, jpeg, png, gif only)
- Products viewable by everyone (including guests)
- Comments can only be modified by their owner

## Architecture Overview

### Request Flow:

- User authenticates → Receives JWT token
- Request includes token in Authorization header
- Middleware validates token and permissions
- Form request validates input data
- Controller processes business logic
- Response returned as JSON

### Security:

- Passwords hashed with bcrypt
- JWT token authentication
- Role-based access control (admin vs user)
- Owner-based authorization for comments
- Input validation on all requests

### Database:

- Users (with role: admin/user)
- Products (title, description, price, stock_count)
- Product Images (linked to products)
- Comments (linked to products and users)
- Cascade delete on foreign keys

