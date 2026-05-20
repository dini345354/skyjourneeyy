# SkyJourney - Aplikasi Reservasi Tiket Pesawat
### UAS Web Programming | Laravel 12 + Bootstrap 5

## AKUN DEFAULT
- Admin : admin@skyjourney.com / admin123
- User  : budi@example.com / password

## LANGKAH INSTALASI

### 1. Install dependencies
composer install

### 2. Setup environment
cp .env.example .env
php artisan key:generate

### 3. Edit .env - sesuaikan database
DB_DATABASE=skyjourney_6a
DB_USERNAME=root
DB_PASSWORD=

### 4. Buat database di MySQL/phpMyAdmin
CREATE DATABASE skyjourney_6a;

### 5. Migrasi + seed data dummy
php artisan migrate --seed

### 6. Storage link (untuk gambar)
php artisan storage:link

### 7. Jalankan server
php artisan serve

Buka: http://localhost:8000

## IMPORT SQL MANUAL
File: database/skyjourney_6a.sql
Import via phpMyAdmin (alternatif migrate --seed)

## TROUBLESHOOTING
- Error 419: php artisan cache:clear && php artisan config:clear
- Error DB: pastikan MySQL aktif dan database skyjourney_6a sudah dibuat
- Reset DB: php artisan migrate:fresh --seed
