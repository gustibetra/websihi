# DPRD V3

Aplikasi web Laravel untuk manajemen konten dan modul internal DPRD.

## Tech Stack

- PHP (Laravel)
- Livewire
- Vite
- MySQL/MariaDB (sesuai konfigurasi `.env`)

## Prasyarat

Pastikan environment sudah terpasang:

- PHP 8.2+ (disarankan mengikuti kebutuhan Laravel di `composer.json`)
- Composer
- Database MySQL/MariaDB

## Instalasi

1. Clone repository

```bash
git clone https://github.com/Andhikaaulia/dprd.git
cd dprd
```

2. Install dependency backend

```bash
composer install
```

3. Install dependency frontend

```bash
npm install
```

4. Konfigurasi environment

```bash
cp .env.example .env
php artisan key:generate
```

5. Atur konfigurasi database di file `.env`, lalu jalankan migrasi

```bash
php artisan migrate
```

6. Buat symbolic link storage

```bash
php artisan storage:link
```

## Menjalankan Aplikasi

Jalankan backend:

```bash
php artisan serve
```

Jalankan Vite (frontend assets):

```bash
npm run dev
```

Untuk build production:

```bash
npm run build
```

## Testing

```bash
php artisan test
```

## Struktur Direktori Utama

- `app/` : logika utama aplikasi (Models, Services, Livewire, dll)
- `routes/` : definisi route web/console
- `resources/` : views, assets CSS/JS
- `database/` : migration, seeder, factory
- `docs/` : dokumentasi project

## Catatan

- Folder `vendor/` dan `node_modules/` tidak di-commit.
- File sensitif seperti `.env` tidak di-commit.
