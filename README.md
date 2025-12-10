<div align="center">

# Sidowaras App

![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![React](https://img.shields.io/badge/React-19-61DAFB?style=for-the-badge&logo=react&logoColor=black)
![TypeScript](https://img.shields.io/badge/TypeScript-5.9-3178C6?style=for-the-badge&logo=typescript&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind-3.4-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-7-646CFF?style=for-the-badge&logo=vite&logoColor=white)
![Status](https://img.shields.io/badge/Status-Production_Ready-success?style=for-the-badge)

**Tugas Besar Mata Kuliah Proyek Teknologi Informasi**  
Institut Teknologi Sumatera

</div>

---

Aplikasi web modern yang dibangun dengan Laravel 12 dan React, memanfaatkan Inertia.js untuk routing server-side dan rendering client-side yang mulus.

## 📋 Daftar Isi

- [Tentang](#tentang)
- [Teknologi](#teknologi)
- [Fitur](#fitur)
- [Prasyarat](#prasyarat)
- [Instalasi](#instalasi)
- [Konfigurasi](#konfigurasi)
- [Pengembangan](#pengembangan)
- [Pengujian](#pengujian)
- [Deployment](#deployment)
- [Tim Pengembang](#tim-pengembang)

## 🎯 Tentang

Sidowaras App adalah aplikasi web full-stack yang menggabungkan kekuatan backend Laravel yang elegan dengan frontend React yang dinamis. Dibangun dengan praktik pengembangan web modern, aplikasi ini menyediakan fondasi yang kokoh untuk aplikasi yang dapat diskalakan.

## 🛠️ Teknologi

### Backend
- **Laravel 12** - Framework PHP modern
- **PHP 8.2+** - Versi PHP terbaru dengan peningkatan performa
- **MySQL/PostgreSQL** - Dukungan database relasional
- **Redis** - Caching dan manajemen session
- **Doctrine DBAL** - Database abstraction layer

### Frontend
- **React 19** - React terbaru dengan fitur concurrent
- **Inertia.js 2.0** - Arsitektur monolith modern
- **TypeScript** - JavaScript dengan type-safe
- **TailwindCSS 3.4** - Framework CSS utility-first
- **HeroUI** - Library komponen React yang indah
- **Framer Motion** - Animasi tingkat lanjut
- **Vite 7** - Build tool frontend generasi terbaru

### Tools Tambahan
- **Maatwebsite/Excel** - Fungsi import/export Excel
- **Ziggy** - Generasi route untuk JavaScript
- **HTML5 QRCode** - Kemampuan scanning QR code
- **Pest/PHPUnit** - Framework testing

## ✨ Fitur

- 🔐 **Autentikasi & Otorisasi** - Manajemen user yang aman
- 📊 **Manajemen Data** - Operasi CRUD tingkat lanjut
- 📈 **Integrasi Excel** - Import dan export data
- 📱 **Desain Responsif** - Pendekatan mobile-first
- 🎨 **UI/UX Modern** - Interface yang indah dengan TailwindCSS dan HeroUI
- ⚡ **Performa Tinggi** - Dioptimalkan dengan Vite dan Redis caching
- 🧪 **Testing Komprehensif** - Unit dan feature test dengan Pest
- 🔄 **Update Real-time** - Background processing berbasis queue

## 📦 Prasyarat

Sebelum memulai, pastikan Anda telah menginstal:

- **PHP** >= 8.2
- **Composer** >= 2.x
- **Node.js** >= 18.x
- **NPM** atau **Yarn**
- **MySQL** >= 8.0 atau **PostgreSQL** >= 13
- **Redis** (opsional, untuk caching dan queue)

## 🚀 Instalasi

### 1. Clone Repository

```bash
git clone <repository-url>
cd sidowaras-app
```

### 2. Install Dependensi PHP

```bash
composer install
```

### 3. Install Dependensi JavaScript

```bash
npm install
```

### 4. Setup Environment

```bash
# Salin file environment
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 5. Setup Database

```bash
# Buat database
# Update .env dengan kredensial database Anda

# Jalankan migrasi
php artisan migrate

# (Opsional) Seed database
php artisan db:seed
```

### 6. Storage Link

```bash
php artisan storage:link
```

## ⚙️ Konfigurasi

### Environment Variables

Konfigurasi file `.env`

## 💻 Pengembangan

### Menjalankan Aplikasi

#### Opsi 1: Menggunakan Composer Script (Direkomendasikan)

Perintah ini menjalankan semua layanan development secara bersamaan:

```bash
composer dev
```

Perintah ini akan menjalankan:
- Laravel server (http://localhost:8000)
- Queue listener
- Application logs (Pail)
- Vite dev server

#### Opsi 2: Setup Manual

Jalankan setiap layanan di terminal terpisah:

```bash
# Terminal 1: Laravel server
php artisan serve

# Terminal 2: Vite dev server
npm run dev

# Terminal 3: Queue worker (jika menggunakan queue)
php artisan queue:listen

# Terminal 4: Logs (opsional)
php artisan pail
```

### Build untuk Production

```bash
# Build frontend assets
npm run build

# Optimasi Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 🧪 Pengujian

### Jalankan Semua Test

```bash
composer test
```

Atau menggunakan Artisan:

```bash
php artisan test
```

### Jalankan Test Suite Spesifik

```bash
# Jalankan feature tests
php artisan test --testsuite=Feature

# Jalankan unit tests
php artisan test --testsuite=Unit

# Jalankan dengan coverage
php artisan test --coverage
```

### Kualitas Kode

```bash
# Format kode dengan Laravel Pint
./vendor/bin/pint

# Jalankan static analysis (jika dikonfigurasi)
./vendor/bin/phpstan analyse
```

## 🚢 Deployment

### Checklist Production

1. ✅ Set `APP_ENV=production` di `.env`
2. ✅ Set `APP_DEBUG=false` di `.env`
3. ✅ Jalankan `composer install --optimize-autoloader --no-dev`
4. ✅ Jalankan `npm run build`
5. ✅ Jalankan `php artisan config:cache`
6. ✅ Jalankan `php artisan route:cache`
7. ✅ Jalankan `php artisan view:cache`
8. ✅ Setup permission file yang tepat
9. ✅ Konfigurasi web server (Apache/Nginx)
10. ✅ Setup SSL certificate
11. ✅ Konfigurasi queue workers
12. ✅ Setup scheduled tasks

### Kebutuhan Server

- PHP >= 8.2 dengan ekstensi: BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML
- Web server (Nginx atau Apache)
- Database server (MySQL/PostgreSQL)
- Redis server (direkomendasikan)
- Supervisor (untuk queue workers)

## 👥 Tim Pengembang

| No | Nama | NIM |
|:--:|:-----|:----:|
| 1 | Adi Sulaksono | 120140038 |
| 2 | Aziz Kurniawan | 122140097 |
| 3 | Harisya Miranti | 122140049 |
| 4 | Elma Nurul Fatika | 122140069 |
| 5 | Rizki Alfariz Ramadhan | 122140061 |
| 6 | Putri Diana Sari Rambe | 122140052 |
| 7 | Shafa Aulia | 122140062 |
| 8 | Fathan Andi Kartagama | 122140055 |

---

Dibuat dengan ❤️ kelompok 4 PTI
