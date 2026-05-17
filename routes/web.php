<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\LayananController;

// ------- RUTE PUBLIK -------
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profil', [HomeController::class, 'profil'])->name('profil');
Route::get('/statistik', [HomeController::class, 'statistik'])->name('statistik');
Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri');
Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{slug}', [BeritaController::class, 'show'])->name('berita.show');
Route::get('/kontak', [HomeController::class, 'kontak'])->name('kontak');
Route::post('/kontak/kirim', [HomeController::class, 'kirimPesan'])->name('kontak.kirim');

// Layanan Surat — urutan PENTING: cek-status & sukses harus sebelum /{jenis}
Route::get('/layanan',                      [LayananController::class, 'index'])->name('layanan.index');
Route::get('/layanan/cek-status',           [LayananController::class, 'cekStatus'])->name('layanan.cek-status');
Route::get('/layanan/{jenis}',              [LayananController::class, 'form'])->name('layanan.form');
Route::post('/layanan/{jenis}/submit',      [LayananController::class, 'submit'])->name('layanan.submit');
Route::get('/layanan/sukses/{nomor}',       [LayananController::class, 'sukses'])->name('layanan.sukses');


// ------- RUTE ADMIN -------
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminBeritaController;
use App\Http\Controllers\Admin\AdminGaleriController;
use App\Http\Controllers\Admin\AdminPesanController;
use App\Http\Controllers\Admin\AdminStatistikController;
use App\Http\Controllers\Admin\AdminLayananController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
});

Route::prefix('admin')->name('admin.')->middleware('admin.auth')->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Berita
    Route::get('/berita', [AdminBeritaController::class, 'index'])->name('berita.index');
    Route::get('/berita/buat', [AdminBeritaController::class, 'create'])->name('berita.create');
    Route::post('/berita', [AdminBeritaController::class, 'store'])->name('berita.store');
    Route::get('/berita/{berita}/edit', [AdminBeritaController::class, 'edit'])->name('berita.edit');
    Route::put('/berita/{berita}', [AdminBeritaController::class, 'update'])->name('berita.update');
    Route::delete('/berita/{berita}', [AdminBeritaController::class, 'destroy'])->name('berita.destroy');
    Route::patch('/berita/{berita}/toggle', [AdminBeritaController::class, 'togglePublish'])->name('berita.toggle');

    // Galeri
    Route::get('/galeri', [AdminGaleriController::class, 'index'])->name('galeri.index');
    Route::post('/galeri', [AdminGaleriController::class, 'store'])->name('galeri.store');
    Route::delete('/galeri/{galeri}', [AdminGaleriController::class, 'destroy'])->name('galeri.destroy');
    Route::patch('/galeri/{galeri}/toggle', [AdminGaleriController::class, 'toggleActive'])->name('galeri.toggle');

    // Statistik
    Route::get('/statistik', [AdminStatistikController::class, 'index'])->name('statistik.index');
    Route::put('/statistik', [AdminStatistikController::class, 'update'])->name('statistik.update');
    Route::post('/statistik', [AdminStatistikController::class, 'store'])->name('statistik.store');
    Route::delete('/statistik/{statistik}', [AdminStatistikController::class, 'destroy'])->name('statistik.destroy');

    // Pesan Kontak
    Route::get('/pesan', [AdminPesanController::class, 'index'])->name('pesan.index');
    Route::get('/pesan/{pesan}', [AdminPesanController::class, 'show'])->name('pesan.show');
    Route::delete('/pesan/{pesan}', [AdminPesanController::class, 'destroy'])->name('pesan.destroy');

    // Layanan Surat — urutan PENTING: rute spesifik sebelum wildcard
    Route::get('/layanan', [AdminLayananController::class, 'index'])->name('layanan.index');
    Route::get('/layanan/{layanan}/cetak', [AdminLayananController::class, 'cetak'])->name('layanan.cetak');
    Route::get('/layanan/{layanan}', [AdminLayananController::class, 'show'])->name('layanan.show');
    Route::patch('/layanan/{layanan}/status', [AdminLayananController::class, 'updateStatus'])->name('layanan.status');
    Route::delete('/layanan/{layanan}', [AdminLayananController::class, 'destroy'])->name('layanan.destroy');

});
