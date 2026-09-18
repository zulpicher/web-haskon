Bisa. Saya akan jadikan `README.md` ini sebagai **dokumentasi handover/progress project**, jadi saat kita lanjut ke fitur berikutnya kita punya acuan yang jelas: apa yang sudah dibuat, arsitektur sekarang, database, Buku Kas, Docker, dan hal yang masih perlu dibereskan.

Karena ini merupakan file dokumentasi yang akan langsung kamu simpan di project, berikut isi `README.md` yang sudah disusun berdasarkan pekerjaan kita sampai implementasi Docker terakhir.

````markdown
# HASKON

HASKON adalah aplikasi web internal berbasis Laravel yang dirancang sebagai **company management hub**. Aplikasi ini akan menjadi satu platform yang dapat dikembangkan menjadi beberapa modul operasional perusahaan.

Modul pertama yang telah dikembangkan adalah **Buku Kas**, sedangkan modul lain seperti Task Management, Absensi, dan Inventory direncanakan untuk dikembangkan berikutnya.

---

## 1. Informasi Project

| Komponen | Teknologi / Versi |
|---|---|
| Framework | Laravel 13.30.1 |
| PHP | 8.3.x |
| Frontend | Blade |
| CSS | Tailwind CSS 3.4.19 |
| JavaScript | Alpine.js |
| Build Tool | Vite |
| Web Server | Nginx |
| Application Server | PHP-FPM |
| Database | MySQL 8.0 |
| Runtime | Docker |
| Container | Docker Compose |
| Authentication | Laravel Breeze Blade |
| PDF | barryvdh/laravel-dompdf |
| Excel | maatwebsite/excel |
| Repository | Git |

### Root Path

```text
C:\laragon\www\web_haskon
````

---

# 2. Tujuan Aplikasi

HASKON dikembangkan sebagai aplikasi terpusat untuk kebutuhan operasional perusahaan.

Konsep utama:

```text
                    HASKON
                      │
          ┌───────────┴───────────┐
          │                       │
       Dashboard              Modul
          │                       │
          │          ┌────────────┼────────────┐
          │          │            │            │
          ▼          ▼            ▼            ▼
       Beranda   Buku Kas     Task Mgmt     Absensi
                             
                           Future Module
                                │
                             Inventory
```

Saat ini modul yang sudah aktif:

* Authentication
* Company Dashboard
* Buku Kas
* Transaction Management
* Financial Activity
* Report
* PDF Export
* Excel Export
* Profile Management

---

# 3. Arsitektur Aplikasi

Aplikasi menggunakan arsitektur Laravel dengan pemisahan antara:

* Controller
* Request Validation
* Model
* Service
* View
* Export

Struktur sederhananya:

```text
Request
   ↓
Route
   ↓
Controller
   ↓
Request Validation
   ↓
Service / Model
   ↓
Database
   ↓
Blade View
```

Untuk Buku Kas:

```text
Browser
   ↓
Nginx
   ↓
PHP-FPM
   ↓
Laravel
   ├── BukuKasController
   ├── TransactionController
   ├── ReportController
   │
   ├── CashBalanceService
   └── ReportService
          ↓
       MySQL
```

---

# 4. Authentication

Authentication menggunakan:

**Laravel Breeze Blade**

Fitur authentication yang tersedia:

* Login
* Register
* Logout
* Forgot Password
* Reset Password
* Email Verification
* Password Confirmation
* Update Password
* Update Profile
* Delete Account

File authentication berada di:

```text
app/Http/Controllers/Auth/
resources/views/auth/
routes/auth.php
tests/Feature/Auth/
```

---

# 5. Company Dashboard

Route utama aplikasi:

```text
/dashboard
```

Route:

```php
Route::get('/dashboard', [HomeController::class, 'index'])
    ->name('dashboard');
```

Dashboard utama menggunakan:

```text
HomeController
```

dan view:

```text
resources/views/home.blade.php
```

Dashboard utama tidak digunakan untuk menampilkan detail Buku Kas.

Fungsinya sebagai **company hub** untuk menuju berbagai modul.

Konsep:

```text
/dashboard
     │
     ├── Buku Kas
     ├── Task Management
     ├── Absensi
     ├── Inventory
     └── Future Modules
```

---

# 6. Modul Buku Kas

Buku Kas merupakan modul pertama yang telah selesai dikembangkan.

Route utama:

```text
/buku-kas
```

Route:

```php
Route::prefix('buku-kas')
    ->name('buku-kas.')
    ->group(function () {

        Route::get('/', [BukuKasController::class, 'index'])
            ->name('dashboard');

        Route::resource('transactions', TransactionController::class)
            ->only(['store', 'update', 'destroy']);

        Route::get('/reports', [ReportController::class, 'index'])
            ->name('reports.index');

        Route::get('/reports/generate', [ReportController::class, 'generate'])
            ->name('reports.generate');

        Route::get('/reports/pdf', [ReportController::class, 'pdf'])
            ->name('reports.pdf');

        Route::get('/reports/excel', [ReportController::class, 'excel'])
            ->name('reports.excel');
    });
```

---

# 7. Buku Kas Dashboard

Halaman:

```text
/buku-kas
```

View utama:

```text
resources/views/buku-kas/dashboard.blade.php
```

Dashboard terdiri dari beberapa component:

```text
resources/views/buku-kas/
└── components/
    ├── summary.blade.php
    ├── recent-transactions.blade.php
    ├── financial-activity.blade.php
    └── modals/
        ├── add.blade.php
        ├── detail.blade.php
        ├── edit.blade.php
        ├── history.blade.php
        └── delete.blade.php
```

---

# 8. Ringkasan Keuangan

Dashboard Buku Kas menampilkan:

### Saldo Saat Ini

Saldo dihitung berdasarkan seluruh transaksi:

```text
Saldo =
Total Pemasukan
-
Total Pengeluaran
```

Saldo negatif ditampilkan menggunakan warna merah.

---

### Pemasukan Bulan Ini

Menampilkan total transaksi:

```text
type = income
```

pada bulan berjalan.

---

### Pengeluaran Bulan Ini

Menampilkan total transaksi:

```text
type = expense
```

pada bulan berjalan.

---

# 9. Aktivitas Keuangan

Component:

```text
resources/views/buku-kas/components/financial-activity.blade.php
```

Menggunakan donut chart berbasis CSS:

```css
conic-gradient()
```

Tidak menggunakan Chart.js.

Data yang ditampilkan:

* Persentase pemasukan
* Persentase pengeluaran
* Total aktivitas
* Selisih pemasukan dan pengeluaran

Rumus:

```text
Total Aktivitas =
Pemasukan + Pengeluaran
```

```text
Selisih =
Pemasukan - Pengeluaran
```

---

# 10. Transaction Management

Model:

```text
app/Models/Transaction.php
```

Transaction menggunakan:

```php
SoftDeletes
```

Field:

```text
id
user_id
transaction_date
type
description
amount
created_at
updated_at
deleted_at
```

Jenis transaksi:

```text
income
expense
```

---

# 11. Relasi User dan Transaction

User mempunyai banyak transaksi:

```php
public function transactions(): HasMany
{
    return $this->hasMany(Transaction::class);
}
```

Transaction memiliki relasi ke User:

```php
public function user(): BelongsTo
{
    return $this->belongsTo(User::class);
}
```

`user_id` digunakan untuk mengetahui **siapa yang mencatat transaksi**.

---

# 12. Aturan Data Transaction

Transaction menggunakan:

```text
transaction_date
type
description
amount
```

Validation menggunakan:

```text
app/Http/Requests/TransactionRequest.php
```

Aturan:

### transaction_date

```text
required
date
```

### type

```text
required
income / expense
```

### description

```text
required
string
max 1000
```

### amount

```text
required
numeric
greater than 0
```

---

# 13. Transaction CRUD

CRUD transaction menggunakan modal pada dashboard Buku Kas.

Tidak menggunakan halaman terpisah untuk:

```text
create.blade.php
edit.blade.php
show.blade.php
index.blade.php
```

View transaction terpisah tersebut tidak digunakan.

CRUD dilakukan melalui modal:

```text
Add
Detail
Edit
Delete
History
```

Route CRUD yang aktif:

```text
POST   /buku-kas/transactions
PUT    /buku-kas/transactions/{transaction}
DELETE /buku-kas/transactions/{transaction}
```

---

# 14. Alpine.js

State dan interaksi modal Buku Kas menggunakan Alpine.js.

File:

```text
resources/js/modules/buku-kas.js
```

Module didaftarkan pada:

```text
resources/js/app.js
```

Alpine digunakan untuk:

* Open Add Modal
* Open Detail Modal
* Open Edit Modal
* Open Delete Modal
* Open History Modal
* Close Modal
* History Filter State
* Delete Confirmation State

Root Buku Kas menggunakan:

```blade
<div
    x-data="bukuKas()"
    data-transaction-url="{{ url('/buku-kas/transactions') }}"
>
```

---

# 15. Delete Transaction

Delete menggunakan Laravel HTTP method:

```text
DELETE
```

Form menggunakan:

```blade
@csrf
@method('DELETE')
```

URL delete dibuat dari Laravel:

```php
'deleteUrl' => route(
    'buku-kas.transactions.destroy',
    $transaction
),
```

Delete confirmation menggunakan Alpine state:

```text
modal = delete
```

---

# 16. Financial Balance Service

File:

```text
app/Services/CashBalanceService.php
```

Service bertanggung jawab terhadap perhitungan saldo.

Method yang tersedia:

```text
getCurrentBalance()
getBalanceBeforeDate()
getBalanceAtDate()
```

Konsep:

```text
income  → +amount
expense → -amount
```

Contoh:

```text
Saldo Awal     +5.000.000
Pengeluaran       -50.000
-------------------------
Saldo           4.950.000
```

---

# 17. Company-Wide Buku Kas

Aplikasi dirancang agar **Admin dan Akuntan memiliki akses yang sama terhadap Buku Kas perusahaan**.

Karena itu:

```text
Saldo
Report
Transaksi
```

bersifat **company-wide**, bukan saldo pribadi setiap user.

`user_id` pada transaction berfungsi sebagai:

```text
recorded_by / pencatat transaksi
```

bukan sebagai pemisah saldo.

Jika suatu saat aplikasi membutuhkan multi-company, pendekatan yang disarankan adalah menambahkan:

```text
company_id
```

atau:

```text
organization_id
```

bukan menggunakan `user_id` sebagai pemisah perusahaan.

---

# 18. Report System

Controller:

```text
app/Http/Controllers/ReportController.php
```

Service:

```text
app/Services/ReportService.php
```

View:

```text
resources/views/reports/index.blade.php
resources/views/reports/pdf.blade.php
```

---

# 19. Jenis Report

Report mendukung:

### Monthly Report

Input:

```text
YYYY-MM
```

Contoh:

```text
2026-09
```

### Custom Report

Input:

```text
start_date
end_date
```

Contoh:

```text
01/09/2026 - 30/09/2026
```

---

# 20. Saldo Awal Report

Saldo awal tidak dimasukkan secara manual pada halaman report.

Saldo awal dihitung berdasarkan saldo sebelum tanggal awal laporan.

Contoh:

```text
Report:
01/09/2026 - 30/09/2026
```

maka:

```text
Saldo Awal =
Saldo sampai dengan 31/08/2026
```

Service menggunakan:

```php
getBalanceBeforeDate($startDate)
```

---

# 21. Konsep Saldo Awal

Jika terdapat transaksi:

```text
31/08/2026
Saldo Awal
Rp5.000.000
```

maka ketika membuat report:

```text
01/09/2026 - 30/09/2026
```

saldo awal report:

```text
Rp5.000.000
```

Sebaliknya jika transaksi:

```text
01/09/2026
Saldo Awal
Rp5.000.000
```

maka transaksi tersebut berada di dalam periode September dan akan dianggap sebagai:

```text
Kas Masuk
Rp5.000.000
```

bukan opening balance sebelum September.

---

# 22. Report Data

Report menghasilkan:

```text
start_date
end_date
opening_balance
rows
total_income
total_expense
closing_balance
is_negative
```

Setiap row transaction berisi:

```text
date
description
income
expense
balance
```

---

# 23. PDF Export

Package:

```text
barryvdh/laravel-dompdf
```

Route:

```text
GET /buku-kas/reports/pdf
```

File PDF view:

```text
resources/views/reports/pdf.blade.php
```

Nama file:

```text
laporan-buku-kas-YYYYMMDD-HHMMSS.pdf
```

---

# 24. Excel Export

Package:

```text
maatwebsite/excel
```

Export class:

```text
app/Exports/TransactionReportExport.php
```

Implementasi:

```text
FromArray
WithHeadings
WithStyles
```

Kolom Excel:

```text
No
Tanggal
Keterangan
Kas Masuk
Kas Keluar
Saldo
```

Route:

```text
GET /buku-kas/reports/excel
```

Nama file:

```text
laporan-buku-kas-YYYYMMDD-HHMMSS.xlsx
```

---

# 25. UI / Design System

Desain aplikasi menggunakan konsep:

```text
Black + White
```

Gold hanya digunakan sebagai accent.

Warna utama:

| Token       | Hex     | Penggunaan            |
| ----------- | ------- | --------------------- |
| Background  | #ffffff | Base                  |
| Surface     | #f8f9fa | Background halaman    |
| Dark        | #212529 | Primary               |
| Primary     | #212529 | Button / heading      |
| Accent      | #c9a84c | Accent terbatas       |
| Accent Soft | #fff3dc | Highlight             |
| Text        | #212529 | Main text             |
| Muted       | #6c757d | Secondary text        |
| Border      | #e9ecef | Border                |
| Success     | #2b8a3e | Income                |
| Danger      | #c92a2a | Expense / destructive |

Prinsip desain:

* Primary button menggunakan hitam
* Card menggunakan putih
* Border tipis
* Shadow sangat ringan
* Gold tidak digunakan sebagai warna dominan
* Hijau hanya untuk pemasukan/success
* Merah hanya untuk pengeluaran/error/delete
* Background halaman menggunakan `#f8f9fa`
* Navbar tetap putih

---

# 26. CSS Structure

Global CSS:

```text
resources/css/app.css
```

Module-specific CSS:

```text
resources/css/modules/buku-kas.css
```

`app.css` mengimport:

```css
@import "./modules/buku-kas.css";
```

CSS khusus Buku Kas saat ini menangani:

```css
[x-cloak] {
    display: none !important;
}
```

---

# 27. JavaScript Structure

Global JavaScript:

```text
resources/js/app.js
```

Module Buku Kas:

```text
resources/js/modules/buku-kas.js
```

Registrasi Alpine:

```js
window.Alpine = Alpine;

Alpine.data('bukuKas', bukuKas);

Alpine.start();
```

---

# 28. Tailwind CSS

Tailwind yang digunakan:

```text
Tailwind CSS 3.4.19
```

Config:

```text
tailwind.config.js
```

Custom color:

```text
haskon-background
haskon-surface
haskon-dark
haskon-primary
haskon-accent
haskon-accent-soft
haskon-text
haskon-muted
haskon-inverted
haskon-border
haskon-success
haskon-danger
```

---

# 29. Logo

Logo HASKON:

```text
resources/images/logo_haskon.svg
```

Digunakan melalui:

```blade
<x-application-logo />
```

atau:

```blade
<img
    src="{{ Vite::asset('resources/images/logo_haskon.svg') }}"
    alt="HASKON"
>
```

---

# 30. Navigation

Navigation utama berada di:

```text
resources/views/layouts/navigation.blade.php
```

Menu utama:

```text
Beranda
Buku Kas
```

Beranda:

```text
/dashboard
```

Buku Kas:

```text
/buku-kas
```

Active state Buku Kas menggunakan:

```text
buku-kas.*
```

---

# 31. Laravel Layout

Layout utama:

```text
resources/views/layouts/app.blade.php
```

Aplikasi menggunakan:

```blade
<x-app-layout>
```

bukan:

```blade
@extends('layouts.app')
```

Layout menggunakan:

```text
Navbar
Main content
Footer / layout content
```

Kesalahan `$slot` sebelumnya terjadi karena penggunaan layout Blade yang tidak sesuai. Struktur saat ini menggunakan component layout Breeze dengan benar.

---

# 32. Database Migration

Migration utama:

```text
database/migrations/
```

Migration Laravel:

```text
0001_01_01_000000_create_users_table.php
0001_01_01_000001_create_cache_table.php
0001_01_01_000002_create_jobs_table.php
```

Migration Buku Kas:

```text
2026_09_09_012257_create_transactions_table.php
```

---

# 33. Database Transactions

Transaction migration memiliki konsep:

```text
user_id
transaction_date
type
description
amount
timestamps
softDeletes
```

`user_id` menggunakan foreign key ke:

```text
users.id
```

dengan perilaku:

```text
restrictOnDelete
```

Tujuannya agar user yang masih memiliki transaction tidak dapat dihapus sembarangan.

---

# 34. Docker Migration

Project sebelumnya berjalan menggunakan:

```text
Laragon
PHP
MySQL
```

Kemudian dipindahkan ke Docker.

Sekarang architecture development:

```text
Docker Compose
│
├── app
│   └── PHP-FPM + Laravel
│
├── db
│   └── MySQL 8.0
│
├── nginx
│   └── Nginx
│
└── node
    └── Node.js + Vite
```

---

# 35. Docker Services

## App

Container:

```text
haskon_app
```

Service:

```text
app
```

Runtime:

```text
PHP 8.3
PHP-FPM
Laravel
Composer
```

Port internal:

```text
9000
```

---

## MySQL

Container:

```text
haskon_db
```

Image:

```text
mysql:8.0
```

Port:

```text
3307:3306
```

Artinya:

```text
Windows localhost:3307
        ↓
Docker MySQL:3306
```

Database:

```text
haskon_db
```

Username:

```text
root
```

Password development:

```text
secret
```

---

## Nginx

Container:

```text
haskon_nginx
```

Image:

```text
nginx:alpine
```

Port:

```text
8000:80
```

Website:

```text
http://localhost:8000
```

---

## Node / Vite

Container:

```text
haskon_node
```

Image:

```text
node:20
```

Port:

```text
5173:5173
```

Vite:

```text
http://localhost:5173
```

Vite digunakan untuk development asset.

---

# 36. Docker Files

Docker configuration:

```text
Dockerfile
docker-compose.yml
.dockerignore
docker/
└── nginx/
    └── default.conf
```

---

# 37. Dockerfile

Dockerfile menggunakan:

```text
php:8.3-fpm
```

PHP extensions yang dipasang:

```text
pdo_mysql
mbstring
exif
pcntl
bcmath
gd
intl
zip
```

Composer diambil dari:

```text
composer:2
```

---

# 38. Docker Compose

Service utama:

```yaml
services:
    app:
    db:
    nginx:
    node:
```

Network:

```text
haskon
```

Database volume:

```text
haskon_db_data
```

Node modules volume:

```text
haskon_node_modules
```

---

# 39. Docker Volume Database

MySQL menggunakan named volume:

```text
haskon_db_data
```

Tujuannya agar data MySQL tetap ada walaupun container dihentikan.

Jangan menjalankan:

```bash
docker compose down -v
```

secara sembarangan.

Perintah tersebut dapat menghapus volume database Docker.

---

# 40. Environment Docker

`.env` saat ini menggunakan:

```env
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=haskon_db
DB_USERNAME=root
DB_PASSWORD=secret
```

Hal penting:

```text
DB_HOST=db
```

bukan:

```text
DB_HOST=localhost
```

Karena Laravel berada di container Docker dan MySQL berada di service:

```text
db
```

Port internal MySQL:

```text
3306
```

bukan `3307`.

`3307` hanya digunakan dari Windows host.

---

# 41. Vite Configuration

File:

```text
vite.config.js
```

Vite dikonfigurasi agar dapat diakses dari host:

```text
0.0.0.0:5173
```

HMR menggunakan:

```text
localhost
```

---

# 42. Docker Verification

Docker berhasil dijalankan dengan:

```bash
docker compose up -d --build
```

Status terakhir:

```text
haskon_app      Up
haskon_db       Up (healthy)
haskon_nginx    Up
haskon_node     Up
```

Command:

```bash
docker compose ps
```

menghasilkan seluruh service berjalan.

---

# 43. Laravel Verification

Laravel berhasil dijalankan dari dalam container:

```bash
docker compose exec app php artisan --version
```

Output:

```text
Laravel Framework 13.30.1
```

PHP:

```bash
docker compose exec app php -v
```

Output:

```text
PHP 8.3.33
```

---

# 44. Database Verification

Laravel berhasil membaca konfigurasi MySQL Docker:

```text
Host: db
Port: 3306
Database: haskon_db
Username: root
Password: secret
```

Konfigurasi diverifikasi menggunakan:

```bash
docker compose exec app php artisan config:show database
```

---

# 45. Database Docker vs Database Laragon

Penting untuk dipahami:

Database Laragon lama dan database Docker adalah **dua database yang berbeda**.

Sebelumnya:

```text
Laragon MySQL
localhost:3306
     │
     └── database lama
```

Sekarang:

```text
Docker MySQL
localhost:3307
     │
     └── haskon_db
```

Migration Docker hanya membuat struktur database.

Migration tidak otomatis memindahkan data lama dari Laragon.

---

# 46. Data Lama

Jika database Laragon masih memiliki data Buku Kas lama:

```text
users
transactions
```

data tersebut belum otomatis masuk ke:

```text
Docker MySQL
```

Proses yang perlu dilakukan jika data lama ingin digunakan:

```text
Laragon MySQL
      │
      ▼
Export .sql
      │
      ▼
Docker MySQL
      │
      ▼
haskon_db
```

Data database Laragon **jangan dihapus sebelum proses backup/import selesai dan diverifikasi**.

---

# 47. Current Database State

Database Docker telah dibuat menggunakan:

```text
haskon_db
```

Migration Laravel telah digunakan untuk membuat struktur tabel.

Karena database Docker merupakan database baru, user dan transaction lama tidak otomatis tersedia.

Akibatnya:

```text
Login akun lama
```

dapat gagal karena user lama masih berada di database Laragon.

Dan:

```text
Saldo Buku Kas
```

dapat menunjukkan:

```text
Rp0
```

jika belum ada transaction pada database Docker.

---

# 48. Nginx Issue yang Ditemukan

Nginx awalnya menggunakan:

```nginx
root /var/www/html/public;
```

sedangkan project di-mount ke:

```text
/var/www
```

dan public Laravel berada di:

```text
/var/www/public
```

Konfigurasi yang benar:

```nginx
root /var/www/public;
```

Ini diperlukan agar:

```text
http://localhost:8000
```

dapat menemukan:

```text
/var/www/public/index.php
```

---

# 49. Current Nginx Architecture

```text
Browser
   │
   │ localhost:8000
   ▼
Nginx
   │
   │ /var/www/public
   ▼
index.php
   │
   ▼
PHP-FPM
   │
   ▼
Laravel
```

---

# 50. Vite vs Laravel

Port:

```text
5173
```

adalah Vite development server.

Port:

```text
8000
```

adalah Laravel melalui Nginx + PHP-FPM.

Sehingga:

```text
http://localhost:5173
```

tidak sama dengan:

```text
http://localhost:8000
```

Vite hanya bertanggung jawab terhadap asset development seperti:

```text
CSS
JavaScript
HMR
```

Laravel tetap diakses melalui:

```text
http://localhost:8000
```

---

# 51. Performance Observation

Setelah migrasi ke Docker, terdapat observasi bahwa Laravel terasa lebih lambat dibanding aplikasi Go/Gin sebelumnya.

Hal ini belum dianggap sebagai masalah hardware.

Kemungkinan yang perlu diperiksa:

```text
Laravel bootstrap
PHP-FPM
Database query
Eloquent
Blade rendering
Docker filesystem bind mount
Windows + Docker Desktop
Development mode
```

Laravel memiliki lebih banyak layer request dibanding aplikasi Go/Gin sederhana.

Belum dilakukan optimasi performance secara khusus.

---

# 52. Performance Test yang Disiapkan

Untuk mengisolasi masalah performance dapat dibuat route sederhana:

```php
Route::get('/test-speed', function () {
    return 'Laravel OK';
});
```

Jika route sederhana cepat tetapi Buku Kas lambat, maka bottleneck kemungkinan berada pada:

```text
Controller
Database Query
Service
Blade
```

Buku Kas saat ini juga mengambil seluruh transaction:

```php
$allTransactions = $user->transactions()
    ->latest('transaction_date')
    ->latest('id')
    ->get();
```

Jika jumlah transaction meningkat besar, bagian ini perlu dioptimalkan menggunakan:

```text
pagination
lazy loading
query optimization
```

---

# 53. Current Known Improvement

Buku Kas dirancang untuk company-wide data.

Namun beberapa query dashboard sebelumnya masih menggunakan:

```php
$user->transactions()
```

sementara keputusan arsitektur saat ini adalah:

```text
Buku Kas = company-wide
```

Sehingga query berikut perlu ditinjau kembali:

```text
monthlyIncome
monthlyExpense
recentTransactions
allTransactions
```

Jika memang seluruh user harus melihat Buku Kas perusahaan yang sama, query tersebut sebaiknya menggunakan:

```php
Transaction::query()
```

dan bukan transaksi milik user tertentu.

`user_id` tetap dipertahankan sebagai informasi siapa yang mencatat transaksi.

---

# 54. Testing

Testing Laravel menggunakan:

```text
Pest / PHPUnit
```

Test yang tersedia:

```text
tests/
├── Feature/
│   ├── Auth/
│   ├── ExampleTest.php
│   └── ProfileTest.php
│
├── Unit/
│   └── ExampleTest.php
│
├── Pest.php
└── TestCase.php
```

Authentication sudah memiliki feature test untuk:

* Authentication
* Registration
* Email Verification
* Password Confirmation
* Password Reset
* Password Update

Testing Buku Kas dan transaction belum dikembangkan secara lengkap.

---

# 55. Project Structure

Struktur utama:

```text
web_haskon/
│
├── app/
│   ├── Exports/
│   │   └── TransactionReportExport.php
│   │
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   ├── BukuKasController.php
│   │   │   ├── HomeController.php
│   │   │   ├── ProfileController.php
│   │   │   ├── ReportController.php
│   │   │   └── TransactionController.php
│   │   │
│   │   └── Requests/
│   │       ├── Auth/
│   │       ├── ProfileUpdateRequest.php
│   │       └── TransactionRequest.php
│   │
│   ├── Models/
│   │   ├── Transaction.php
│   │   └── User.php
│   │
│   ├── Services/
│   │   ├── CashBalanceService.php
│   │   └── ReportService.php
│   │
│   └── View/
│
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
│
├── docker/
│   └── nginx/
│       └── default.conf
│
├── resources/
│   ├── css/
│   │   ├── modules/
│   │   │   └── buku-kas.css
│   │   └── app.css
│   │
│   ├── images/
│   │   └── logo_haskon.svg
│   │
│   ├── js/
│   │   ├── modules/
│   │   │   └── buku-kas.js
│   │   └── app.js
│   │
│   └── views/
│       ├── auth/
│       ├── buku-kas/
│       ├── components/
│       ├── layouts/
│       ├── profile/
│       ├── reports/
│       ├── home.blade.php
│       └── welcome.blade.php
│
├── routes/
│   ├── auth.php
│   ├── console.php
│   └── web.php
│
├── tests/
│
├── .dockerignore
├── .env
├── .env.example
├── Dockerfile
├── docker-compose.yml
├── composer.json
├── package.json
├── package-lock.json
├── tailwind.config.js
├── vite.config.js
└── README.md
```

---

# 56. Development Commands

## Start Docker

```bash
docker compose up -d
```

Jika ada perubahan Dockerfile:

```bash
docker compose up -d --build
```

---

## Stop Docker

```bash
docker compose down
```

Perintah ini tidak menghapus named volume.

---

## Check Container

```bash
docker compose ps
```

---

## Laravel Artisan

```bash
docker compose exec app php artisan
```

Contoh:

```bash
docker compose exec app php artisan migrate
```

```bash
docker compose exec app php artisan migrate:status
```

```bash
docker compose exec app php artisan route:list
```

```bash
docker compose exec app php artisan config:clear
```

```bash
docker compose exec app php artisan view:clear
```

---

## Composer

```bash
docker compose exec app composer install
```

Untuk package baru:

```bash
docker compose exec app composer require nama/package
```

---

## NPM

NPM dijalankan melalui container Node:

```bash
docker compose exec node npm install
```

Development Vite sudah dijalankan oleh service Node.

---

# 57. Logs

App:

```bash
docker compose logs app
```

Nginx:

```bash
docker compose logs nginx
```

Database:

```bash
docker compose logs db
```

Node:

```bash
docker compose logs node
```

Tail logs:

```bash
docker compose logs -f app
```

---

# 58. Important Docker Rules

Jangan menjalankan:

```bash
docker compose down -v
```

kecuali memang ingin menghapus database Docker.

Jangan mengubah:

```env
DB_HOST=db
DB_PORT=3306
```

menjadi:

```env
DB_HOST=localhost
DB_PORT=3307
```

untuk koneksi Laravel → MySQL Docker.

Gunakan:

```text
localhost:3307
```

hanya jika mengakses MySQL Docker dari Windows/host.

---

# 59. Current Status

## Completed

* [x] Laravel project
* [x] Laravel Breeze Blade
* [x] Authentication
* [x] Company Dashboard
* [x] Custom HASKON navigation
* [x] HASKON logo
* [x] Buku Kas module
* [x] Transaction model
* [x] Transaction migration
* [x] Transaction validation
* [x] Transaction CRUD
* [x] Modal-based transaction UI
* [x] Detail transaction modal
* [x] Edit transaction modal
* [x] Delete confirmation modal
* [x] History modal
* [x] Financial summary
* [x] Financial activity donut chart
* [x] Cash balance service
* [x] Report service
* [x] Monthly report
* [x] Custom date report
* [x] PDF export
* [x] Excel export
* [x] Black/white HASKON design
* [x] Tailwind custom colors
* [x] Docker PHP-FPM
* [x] Docker MySQL
* [x] Docker Nginx
* [x] Docker Node/Vite
* [x] Docker Compose network
* [x] Docker database volume
* [x] Vite development server
* [x] Laravel running inside Docker
* [x] MySQL connection from Laravel verified
* [x] Nginx root path identified/fixed

---

# 60. Pending / Next Development

Hal-hal yang masih perlu dikerjakan:

### Database

* [ ] Backup database Laragon lama
* [ ] Import data lama ke MySQL Docker
* [ ] Verify users
* [ ] Verify transactions
* [ ] Verify Buku Kas balance

### Buku Kas

* [ ] Verify company-wide transaction query
* [ ] Optimize dashboard queries
* [ ] Improve transaction history
* [ ] Add pagination if transaction count grows
* [ ] Add authorization policy if role system is introduced
* [ ] Add automated feature tests

### Performance

* [ ] Benchmark Laravel route
* [ ] Benchmark database query
* [ ] Check Docker filesystem performance
* [ ] Optimize Eloquent queries
* [ ] Review `allTransactions` query
* [ ] Production optimization later

### Company System

Planned modules:

```text
[ ] Task Management
[ ] masih belum kepikiran
```

---

# 61. Recommended Development Direction

Pengembangan selanjutnya sebaiknya tidak langsung membuat banyak modul sekaligus.

Urutan yang disarankan:

```text
Current
  │
  ▼
Database Migration / Data Recovery
  │
  ▼
Buku Kas Stabil
  │
  ├── Authorization
  ├── Testing
  ├── Performance
  └── UX refinement
  │
  ▼
Task Management
  │
  ▼
Absensi
  │
  ▼
Inventory
  │
  ▼
Company-wide Integration
```

---

# 62. Current Development Environment

Aplikasi sekarang dijalankan sepenuhnya melalui Docker.

Start:

```bash
docker compose up -d
```

Website:

```text
http://localhost:8000
```

Vite:

```text
http://localhost:5173
```

MySQL dari host:

```text
localhost:3307
```

Laravel container:

```text
haskon_app
```

MySQL container:

```text
haskon_db
```

Nginx container:

```text
haskon_nginx
```

Node container:

```text
haskon_node
```

---

# 63. Final Architecture

```text
                         HASKON
                           │
                           ▼
                    Browser / Client
                           │
                           │ :8000
                           ▼
                    ┌─────────────┐
                    │    Nginx    │
                    │ haskon_nginx│
                    └──────┬──────┘
                           │
                           │ FastCGI :9000
                           ▼
                    ┌─────────────┐
                    │  PHP-FPM    │
                    │  Laravel    │
                    │  haskon_app │
                    └──────┬──────┘
                           │
             ┌─────────────┴─────────────┐
             │                           │
             ▼                           ▼
      ┌─────────────┐             ┌─────────────┐
      │    MySQL    │             │   Storage   │
      │  haskon_db  │             │   Laravel   │
      └─────────────┘             └─────────────┘


                    Development Assets
                           │
                           ▼
                    ┌─────────────┐
                    │ Node + Vite │
                    │ haskon_node │
                    │    :5173    │
                    └─────────────┘
```

---

# 64. Project Principle

HASKON dikembangkan dengan prinsip:

```text
Modular
Maintainable
Secure
Testable
Scalable
```

Struktur aplikasi dibuat agar setiap module dapat dikembangkan secara terpisah tanpa membuat seluruh aplikasi menjadi satu bagian yang sulit dipelihara.

Buku Kas menjadi module pertama dan menjadi referensi struktur untuk module berikutnya.

---

# 65. Next Session Starting Point

Jika melanjutkan development dari dokumentasi ini, kondisi terakhir adalah:

```text
Laravel 13.30.1
PHP 8.3.33
MySQL 8.0
Docker Compose
Nginx
PHP-FPM
Node/Vite
Buku Kas
Reports
Authentication
```

Semua service Docker sudah berhasil berjalan.

Hal yang perlu diperhatikan sebelum fitur baru:

1. Database Docker adalah database baru.
2. Data lama Laragon belum otomatis dipindahkan.
3. Jangan menghapus database Laragon sebelum backup.
4. Jangan menggunakan `docker compose down -v` sembarangan.
5. Buku Kas secara konsep menggunakan data company-wide.
6. `user_id` transaction digunakan untuk mencatat siapa yang melakukan input.
7. Performance Laravel/Docker belum dioptimalkan secara khusus.
8. Modul berikutnya dapat dikembangkan di atas arsitektur HASKON yang sudah ada.

---

## Status

**HASKON — Development**

Current milestone:

```text
Laravel Application
        ↓
Buku Kas Module
        ↓
Reporting System
        ↓
Docker Migration
        ↓
READY FOR NEXT MODULE
```

````

### Catatan penting sebelum kita lanjut

Ada **dua hal yang saya sengaja tandai sebagai pending**, karena dari kondisi terakhir memang belum benar-benar selesai:

1. **Data MySQL Laragon lama belum dipindahkan ke MySQL Docker.** Jadi akun/transaksi lama jangan dianggap hilang. Kita masih bisa backup dan import.
2. **Query Buku Kas masih perlu disesuaikan dengan keputusan company-wide.** Jadi nanti sebelum membuat modul berikutnya, kita sebaiknya rapikan bagian itu supaya fondasinya benar.

Untuk sekarang, simpan isi di atas sebagai:

```text
C:\laragon\www\web_haskon\README.md
````

Setelah itu kita bisa menjadikan README ini sebagai **baseline project**, sehingga pengembangan berikutnya tidak perlu mengulang pembahasan arsitektur yang sudah kita selesaikan.
