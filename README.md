# Modul 3 - Laravel Basic

## Instalasi
- **PHP**: 8.5.10
- **Composer**: 2.10.3
- **Framework**: Laravel 13.32.0
- **Database**: SQLite (default)

## Cara Menjalankan Proyek

1. **Clone repository:**
git clone https://github.com/Ariannn19/251511034_ArianDwiPutra_Project_Modul3-6.git
cd activity-manager

2. **Install dependency:**
composer install

3. **Setup environment:**
cp .env.example .env
php artisan key:generate

4. **Migrasi database dan seeder data awal:**
php artisan migrate:fresh --seed --seeder=ActivitySeeder

5. **Jalankan server:**
php artisan serve

Akses melalui browser di: http://127.0.0.1:8000/activities
