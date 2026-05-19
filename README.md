## 📌 Tentang Project
Website Desa Kemang adalah platform layanan mandiri dan informasi publik yang dirancang untuk mempermudah administrasi pelayanan surat-menyurat dan penyebaran informasi bagi warga Desa Kemang. 

Aplikasi ini dibangun menggunakan **Laravel Framework** untuk memastikan performa yang andal, aman, dan mudah dikembangkan di kemudian hari.

Project ini dibuat sebagai tugas kuliah dan saya upload disini cuma buat iseng iseng aja, tapi bagi yang mau menggunakan atau mau jadikan ini sebagai refernsi juga gapapa, untuk pemasangannya ikuti langkah - langkah dibawah ini.

## 🛠️ Cara Memasang & Menjalankan Project (Installation Guide)

### 1. Kloning Repositori
Buka terminal atau Git Bash, lalu jalankan perintah berikut:
git clone [https://github.com/aindragt/website-untuk-desa-kemang.git](https://github.com/aindragt/website-untuk-desa-kemang.git)
cd website-untuk-desa-kemang

### 2. Instal Dependency (Package Laravel)
Unduh semua library dan core system Laravel yang dibutuhkan oleh project ini:
composer install

### 3. Konfigurasi File Environment (.env)
Salin file .env.example untuk membuat file konfigurasi .env baru:
cp .env.example .env

> **Catatan:** Buka file .env yang baru dibuat menggunakan Text Editor (seperti VS Code), lalu sesuaikan baris DB_DATABASE, DB_USERNAME, dan DB_PASSWORD dengan database MySQL di komputer Anda.

### 4. Generate Application Key
Buat kunci pengaman enkripsi untuk aplikasi Laravel Anda:
php artisan key:generate

### 5. Migrasi Database
Pastikan Anda sudah membuat database kosong di phpMyAdmin/MySQL dengan nama yang sama seperti di file .env,
Untuk membuat tabel sekaligus mengisi data dummy (seeder) yang sudah disediakan, jalankan perintah berikut:
php artisan migrate --seed

> **💡Info Tambahan:** ika di kemudian hari Anda ingin mengosongkan database dan mengisinya ulang dari awal, Anda bisa menggunakan perintah php artisan migrate:fresh --seed

### 6. Link Storage
jalankan perintah ini agar file yang diunggah bisa diakses oleh publik: 
php artisan storage:link

### 7. Jalankan Aplikasi
Server lokal Anda siap dijalankan dengan perintah:
php artisan serve

Setelah itu, buka browser dan akses tautan: [http://127.0.0.1:8000](http://127.0.0.1:8000)
