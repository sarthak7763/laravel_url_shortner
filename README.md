# UrlShortnerLaravel

This repository contains a Laravel-based URL shortener application with company/user role management.

## Local Setup for Testing

### Prerequisites

- PHP 8.1 or later
- Composer
- MySQL or another supported database
- Node.js and npm (for frontend assets)
- A local web server environment (Laragon, Valet, Homestead, or built-in PHP server)

### Install dependencies

```bash
composer install
npm install
```

### Environment setup

1. Copy the example environment file:

```bash
cp .env.example .env
```

2. Update `.env` with your database credentials and application settings.

3. Generate the application key:

```bash
php artisan key:generate
```

### Database setup

Run migrations and seeders:

```bash
php artisan migrate --seed
```

If you only want the database schema without seeding, use:

```bash
php artisan migrate
```

### Frontend build

For local development:

```bash
npm run dev
```

For production-style assets:

```bash
npm run build
```

### Running the application

Start the Laravel development server:

```bash
php artisan serve
```

Then visit:

```text
http://127.0.0.1:8000
```

### Notes

- If you use Laragon, make sure the project folder is opened inside its `www` or `public` path and the local database service is running.
- If you need a fresh database state during testing, run:

```bash
php artisan migrate:fresh --seed
```

## Project structure

- `app/` - application logic and controllers
- `database/` - migrations and seeders
- `resources/views/` - Blade templates
- `routes/web.php` - web routes

## License

This project is released under the MIT License.
