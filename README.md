## 1. Pendahuluan

### 1.1 Tujuan

Manual book ini digunakan sebagai panduan untuk melakukan instalasi, konfigurasi, dan menjalankan aplikasi **HASKON** pada komputer development.

Aplikasi HASKON menggunakan beberapa komponen utama:

| Komponen | Teknologi |
|---|---|
| Backend | Laravel 13 |
| Bahasa pemrograman | PHP 8.3 |
| Database | MySQL 8.0 |
| Web Server | Nginx |
| Frontend | Blade, Tailwind CSS, JavaScript |
| Asset Development | Vite |
| Containerization | Docker |
| Orchestration | Docker Compose |
| Version Control | Git |

Seluruh komponen aplikasi yang diperlukan untuk menjalankan sistem disediakan melalui **Docker Compose**, sehingga developer tidak perlu melakukan instalasi PHP, MySQL, Nginx, atau Node.js secara manual untuk menjalankan aplikasi.

---

# 2. Persyaratan Sistem

Sebelum melakukan instalasi HASKON, pastikan komputer memenuhi persyaratan berikut.

### 2.1 Sistem Operasi

HASKON dapat dijalankan pada sistem operasi yang mendukung Docker, antara lain:

- Windows 10/11
- Linux
- macOS

Untuk Windows, disarankan menggunakan **Docker Desktop** atau lingkungan Docker yang kompatibel.

### 2.2 Software yang Dibutuhkan

Software yang perlu tersedia pada komputer:

1. **Git**
2. **Docker**
3. **Docker Compose**

Tidak diperlukan instalasi manual:

- PHP
- Composer
- MySQL
- Nginx
- Node.js
- npm

karena komponen tersebut telah disediakan oleh container project.

---

# 3. Instalasi Software Prasyarat

## 3.1 Instalasi Git

Git digunakan untuk mengambil source code HASKON dari repository.

Download Git melalui website resmi:

[Git SCM](https://git-scm.com/?utm_source=chatgpt.com)

Setelah instalasi selesai, buka terminal dan jalankan:

```bash
git --version
```

Jika berhasil, akan muncul versi Git, misalnya:

```text
git version 2.x.x
```

---

# 4. Instalasi Docker

Docker digunakan untuk menjalankan seluruh environment HASKON dalam container.

Untuk Windows dan macOS, gunakan:

[Docker Desktop](https://www.docker.com/products/docker-desktop/?utm_source=chatgpt.com)

Untuk Linux, Docker Engine dapat digunakan secara langsung.

Setelah Docker terpasang, periksa:

```bash
docker --version
```

Contoh:

```text
Docker version 29.x.x
```

Kemudian periksa Docker Compose:

```bash
docker compose version
```

Contoh:

```text
Docker Compose version v5.x.x
```

Jika kedua perintah tersebut berhasil, Docker sudah siap digunakan.

---

# 5. Mengambil Source Code HASKON

Buka terminal atau command prompt, kemudian tentukan lokasi penyimpanan project.

Contoh:

```bash
git clone https://github.com/zulpicher/web-haskon.git
```

Setelah proses selesai, masuk ke folder project:

```bash
cd web-haskon
```

Periksa isi project:

```bash
ls
```

Pada Windows Command Prompt dapat menggunakan:

```cmd
dir
```

Project seharusnya memiliki file/folder seperti:

```text
app/
bootstrap/
config/
database/
docker/
Dockerfile
docker-compose.yml
composer.json
composer.lock
package.json
package-lock.json
.env.example
artisan
```

---

# 6. Konfigurasi Environment

Laravel menggunakan file `.env` untuk menyimpan konfigurasi environment aplikasi.

Buat file `.env` berdasarkan `.env.example`.

Linux/macOS:

```bash
cp .env.example .env
```

Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

Windows Command Prompt:

```cmd
copy .env.example .env
```

Kemudian buka file `.env`.

---

# 7. Konfigurasi Database

HASKON menggunakan MySQL yang dijalankan melalui Docker.

Pada file `.env`, konfigurasi database harus disesuaikan dengan service `db` pada `docker-compose.yml`.

Gunakan:

```env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=haskon_db
DB_USERNAME=root
DB_PASSWORD=secret
```

### Penjelasan

| Konfigurasi | Nilai | Keterangan |
|---|---|---|
| `DB_CONNECTION` | `mysql` | Database yang digunakan |
| `DB_HOST` | `db` | Nama service MySQL pada Docker Compose |
| `DB_PORT` | `3306` | Port MySQL di dalam Docker network |
| `DB_DATABASE` | `haskon_db` | Nama database |
| `DB_USERNAME` | `root` | User database |
| `DB_PASSWORD` | `secret` | Password database |

**Catatan penting:**

Jangan menggunakan:

```env
DB_HOST=localhost
```

atau:

```env
DB_HOST=127.0.0.1
```

untuk konfigurasi Laravel di dalam container.

Karena Laravel berada di container `app`, sedangkan MySQL berada di container `db`. Docker Compose menyediakan DNS internal sehingga Laravel dapat menemukan MySQL melalui:

```text
db
```

---

# 8. Struktur Docker HASKON

HASKON menggunakan beberapa container yang didefinisikan pada `docker-compose.yml`.

Secara umum arsitekturnya:

```text
                    Browser
                       │
                       │ HTTP :8000
                       ▼
                ┌──────────────┐
                │    Nginx     │
                │    :80       │
                └──────┬───────┘
                       │
                       │ FastCGI
                       ▼
                ┌──────────────┐
                │ Laravel App  │
                │ PHP 8.3-FPM │
                └──────┬───────┘
                       │
                       │ MySQL :3306
                       ▼
                ┌──────────────┐
                │    MySQL     │
                │     8.0      │
                └──────────────┘


                ┌──────────────┐
                │ Node / Vite  │
                │   :5173      │
                └──────────────┘
```

Container yang digunakan:

| Container | Fungsi |
|---|---|
| `app` | Menjalankan Laravel dan PHP-FPM |
| `db` | Menjalankan MySQL |
| `nginx` | Web server dan menerima request HTTP |
| `node` | Menjalankan Node.js dan Vite |

---

# 9. Build Docker Image

Setelah source code dan `.env` siap, lakukan build Docker.

Jalankan:

```bash
docker compose build
```

Perintah tersebut akan membuat image berdasarkan `Dockerfile`.

Dockerfile akan menyiapkan antara lain:

- PHP 8.3
- PHP-FPM
- `pdo_mysql`
- `mbstring`
- `gd`
- `zip`
- `intl`
- Composer

Sehingga developer **tidak perlu menginstal PHP atau Composer secara manual** pada host.

Jika berhasil, proses akan berakhir tanpa pesan `ERROR`.

---

# 10. Menjalankan Container

Setelah build berhasil:

```bash
docker compose up -d
```

Parameter `-d` berarti container dijalankan di background.

Periksa status container:

```bash
docker compose ps
```

Kurang lebih akan terdapat:

```text
haskon_app
haskon_db
haskon_nginx
haskon_node
```

Status yang diharapkan adalah:

```text
Up
```

atau status aktif yang sesuai dengan versi Docker Compose.

---

# 11. Membuat Application Key Laravel

Laravel membutuhkan `APP_KEY` untuk enkripsi aplikasi.

Setelah container `app` aktif, jalankan:

```bash
docker compose exec app php artisan key:generate
```

Jika berhasil, Laravel akan menampilkan:

```text
INFO  Application key set successfully.
```

Perintah ini akan mengisi:

```env
APP_KEY=
```

menjadi key yang dihasilkan Laravel.

---

# 12. Membersihkan Cache Laravel

Setelah konfigurasi environment selesai, jalankan:

```bash
docker compose exec app php artisan optimize:clear
```

Perintah ini membersihkan cache Laravel seperti:

- configuration cache
- route cache
- view cache
- application cache

Tujuannya agar Laravel membaca konfigurasi `.env` terbaru.

---

# 13. Menjalankan Database Migration

Database MySQL telah dibuat oleh container `db`, tetapi tabel Laravel belum tentu tersedia.

Jalankan:

```bash
docker compose exec app php artisan migrate
```

Jika migration berhasil, Laravel akan membuat tabel-tabel yang diperlukan oleh aplikasi.

Contoh tabel Laravel dapat meliputi:

```text
users
cache
jobs
sessions
migrations
```

serta tabel khusus yang digunakan oleh aplikasi HASKON.

---

# 14. Menjalankan Aplikasi

Setelah seluruh container aktif dan migration berhasil, aplikasi dapat diakses melalui browser:

```text
http://localhost:8000
```

Jika menggunakan komputer lain, gunakan alamat IP komputer yang menjalankan Docker sesuai konfigurasi jaringan.

---

# 15. Menjalankan dan Memeriksa Vite

Frontend development HASKON menggunakan Vite.

Container `node` menjalankan:

```text
npm run dev -- --host 0.0.0.0
```

Port Vite:

```text
5173
```

Periksa container:

```bash
docker compose ps
```

Jika container Node berjalan, Vite dapat diakses pada:

```text
http://localhost:5173
```

Dalam penggunaan normal, developer cukup membuka:

```text
http://localhost:8000
```

karena aplikasi Laravel menggunakan asset yang dilayani oleh Vite selama development.

---

# 16. Perintah Docker yang Sering Digunakan

## Melihat container

```bash
docker compose ps
```

## Melihat log seluruh service

```bash
docker compose logs
```

## Melihat log Laravel

```bash
docker compose logs app
```

## Melihat log MySQL

```bash
docker compose logs db
```

## Melihat log Nginx

```bash
docker compose logs nginx
```

## Melihat log Node/Vite

```bash
docker compose logs node
```

Untuk mengikuti log secara realtime:

```bash
docker compose logs -f
```

---

# 17. Menjalankan Perintah Laravel

Karena Laravel berjalan di container, perintah Artisan dijalankan melalui:

```bash
docker compose exec app php artisan
```

Contoh:

### Melihat versi Laravel

```bash
docker compose exec app php artisan --version
```

### Migration

```bash
docker compose exec app php artisan migrate
```

### Membersihkan cache

```bash
docker compose exec app php artisan optimize:clear
```

### Melihat daftar route

```bash
docker compose exec app php artisan route:list
```

### Membuat migration

```bash
docker compose exec app php artisan make:migration nama_migration
```

### Membuat controller

```bash
docker compose exec app php artisan make:controller NamaController
```

---

# 18. Menghentikan Aplikasi

Untuk menghentikan container:

```bash
docker compose stop
```

Perintah ini menghentikan container tetapi tidak menghapusnya.

Untuk menjalankan kembali:

```bash
docker compose start
```

---

# 19. Mematikan dan Menghapus Container

Jika ingin menghentikan sekaligus menghapus container:

```bash
docker compose down
```

Perintah ini menghapus container dan network yang dibuat Compose.

**Data database tetap aman** selama volume database tidak ikut dihapus.

---

# 20. Menghapus Database Volume

Perintah berikut:

```bash
docker compose down -v
```

akan menghapus volume Docker, termasuk:

```text
haskon_db_data
```

Akibatnya **database MySQL akan kembali kosong**.

Oleh karena itu, perintah ini **jangan digunakan sembarangan**, terutama jika database development sudah berisi data penting.

---

# 21. Workflow Development

Setelah instalasi selesai, workflow developer sehari-hari cukup seperti berikut:

```text
1. Masuk ke folder project
          │
          ▼
2. docker compose up -d
          │
          ▼
3. Buka localhost:8000
          │
          ▼
4. Coding
          │
          ▼
5. Perubahan source code
   langsung tersedia melalui bind mount
          │
          ▼
6. Jika perlu menjalankan Laravel command:
   docker compose exec app php artisan ...
          │
          ▼
7. Setelah selesai:
   docker compose stop
```

Tidak perlu menjalankan:

```text
php artisan serve
```

karena Laravel sudah dijalankan oleh **PHP-FPM + Nginx**.

Tidak perlu menjalankan:

```text
php artisan serve
```

bersamaan dengan Docker.

Demikian juga tidak perlu menjalankan MySQL secara manual.

---

# 22. Troubleshooting

## 22.1 Container tidak berjalan

Periksa:

```bash
docker compose ps
```

Kemudian lihat log:

```bash
docker compose logs
```

---

## 22.2 Website menampilkan 502 Bad Gateway

Periksa container:

```bash
docker compose ps
```

Kemudian:

```bash
docker compose logs app
```

dan:

```bash
docker compose logs nginx
```

502 biasanya menunjukkan Nginx tidak dapat berkomunikasi dengan PHP-FPM.

---

## 22.3 Database tidak dapat terhubung

Pastikan `.env` menggunakan:

```env
DB_HOST=db
DB_PORT=3306
DB_DATABASE=haskon_db
DB_USERNAME=root
DB_PASSWORD=secret
```

Kemudian periksa:

```bash
docker compose ps
```

Pastikan container `db` berjalan.

Lihat log:

```bash
docker compose logs db
```

---

## 22.4 Migration gagal

Jalankan:

```bash
docker compose exec app php artisan optimize:clear
```

Kemudian ulangi:

```bash
docker compose exec app php artisan migrate
```

Jika masih gagal, periksa error yang diberikan Laravel.

---

## 22.5 Perubahan `.env` tidak terbaca

Jalankan:

```bash
docker compose exec app php artisan optimize:clear
```

Kemudian restart container jika diperlukan:

```bash
docker compose restart app
```

---

# 23. Update Source Code dari Git

Sebelum mengambil perubahan terbaru:

```bash
git pull origin main
```

Setelah mendapatkan perubahan:

```bash
docker compose build
docker compose up -d
```

Jika terdapat perubahan migration:

```bash
docker compose exec app php artisan migrate
```

---

# 24. Pemeriksaan Instalasi

Instalasi dianggap berhasil apabila seluruh kondisi berikut terpenuhi:

| Pemeriksaan | Hasil yang diharapkan |
|---|---|
| Git | Terinstall |
| Docker | Terinstall |
| Docker Compose | Terinstall |
| Repository | Berhasil di-clone |
| `.env` | Tersedia |
| Database config | Mengarah ke service `db` |
| Docker build | Berhasil |
| Container `app` | Aktif |
| Container `db` | Aktif |
| Container `nginx` | Aktif |
| Container `node` | Aktif |
| `APP_KEY` | Sudah dibuat |
| Migration | Berhasil |
| HASKON | Dapat dibuka melalui `localhost:8000` |

---

# 25. Ringkasan Instalasi

Untuk instalasi baru, alurnya secara sederhana adalah:

```text
INSTALL
  │
  ├── Git
  └── Docker
       │
       ▼
CLONE PROJECT
       │
       ▼
BUAT .env
       │
       ▼
KONFIGURASI DATABASE
       │
       ▼
docker compose build
       │
       ▼
docker compose up -d
       │
       ▼
docker compose exec app php artisan key:generate
       │
       ▼
docker compose exec app php artisan optimize:clear
       │
       ▼
docker compose exec app php artisan migrate
       │
       ▼
http://localhost:8000
       │
       ▼
     HASKON
```

### Prinsip utama setup HASKON

> **Host hanya menyediakan Git dan Docker. Environment aplikasi dijalankan oleh Docker Compose.**

Dengan pendekatan ini, developer baru tidak perlu menyesuaikan versi PHP, Composer, MySQL, Nginx, atau Node.js secara manual. Versi dan konfigurasi utama sudah ditentukan oleh `Dockerfile` dan `docker-compose.yml` project.
