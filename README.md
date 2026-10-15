# Lending App

Laravel 9 + Vue 3 + Vite application for managing loans, payments, and related settings.

## Requirements

- PHP 8.0+ (tested with PHP 8.2)
- Composer
- Node.js & npm
- MySQL

### PHP extensions

Enable these in `php.ini` (XAMPP: `C:\xampp\php\php.ini`):

```ini
extension=gd
extension=zip
```

## Setup

```bash
# Clone the repo
git clone https://github.com/jandales/lending-app.git
cd lending-app

# Install PHP dependencies
composer install

# Install JS dependencies
npm install

# Environment
cp .env.example .env          # Windows: copy .env.example .env
php artisan key:generate
```

### Database

1. Create a MySQL database.
2. Update `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=root
DB_PASSWORD=your_password
```

3. Run migrations (and optional seeders):

```bash
php artisan migrate
php artisan db:seed
```

## Run locally

Use two terminals:

```bash
# Terminal 1 — Laravel backend
php artisan serve
```

```bash
# Terminal 2 — Vite frontend
npm run dev
```

Open [http://127.0.0.1:8000](http://127.0.0.1:8000).

## Production build

```bash
npm run build
```

## Troubleshooting

### `composer install` fails — lock file out of date / missing package

If you see that `phpoffice/phpspreadsheet` (or another package) is in `composer.json` but not in the lock file:

```bash
composer update
```

### Missing `ext-gd` or `ext-zip`

Enable `extension=gd` and `extension=zip` in `php.ini`, then restart the terminal and retry.

### Composer blocks install due to security advisories (dompdf)

This project uses `barryvdh/laravel-dompdf` with `dompdf` 2.x, which Composer may block. The repo config allows install for local development. To check advisories:

```bash
composer audit
```
