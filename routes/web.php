<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\AuthController;

// ============================================================
// RUTE PUBLIK (Website Desa)
// ============================================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profil', [HomeController::class, 'profil'])->name('profil');
Route::get('/statistik', [HomeController::class, 'statistik'])->name('statistik');
Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri');
Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{slug}', [BeritaController::class, 'show'])->name('berita.show');
Route::get('/kontak', [HomeController::class, 'kontak'])->name('kontak');
Route::post('/kontak/kirim', [HomeController::class, 'kirimPesan'])->name('kontak.kirim');

// Layanan Surat
Route::get('/layanan',                      [LayananController::class, 'index'])->name('layanan.index');
Route::get('/layanan/cek-status',           [LayananController::class, 'cekStatus'])->name('layanan.cek-status');
Route::get('/layanan/{jenis}',              [LayananController::class, 'form'])->name('layanan.form');
Route::post('/layanan/{jenis}/submit',      [LayananController::class, 'submit'])->name('layanan.submit');
Route::get('/layanan/sukses/{nomor}',       [LayananController::class, 'sukses'])->name('layanan.sukses');

// ============================================================
// AUTH (Login/Logout — satu pintu untuk semua role)
// ============================================================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ============================================================
// ADMIN — hanya role 'admin'
// ============================================================
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminBeritaController;
use App\Http\Controllers\Admin\AdminGaleriController;
use App\Http\Controllers\Admin\AdminPesanController;
use App\Http\Controllers\Admin\AdminStatistikController;
use App\Http\Controllers\Admin\AdminLayananController;
use App\Http\Controllers\Admin\AdminOperatorController;

Route::prefix('admin')->name('admin.')->middleware('auth.admin')->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Berita
    Route::get('/berita',                   [AdminBeritaController::class, 'index'])->name('berita.index');
    Route::get('/berita/buat',              [AdminBeritaController::class, 'create'])->name('berita.create');
    Route::post('/berita',                  [AdminBeritaController::class, 'store'])->name('berita.store');
    Route::get('/berita/{berita}/edit',     [AdminBeritaController::class, 'edit'])->name('berita.edit');
    Route::put('/berita/{berita}',          [AdminBeritaController::class, 'update'])->name('berita.update');
    Route::delete('/berita/{berita}',       [AdminBeritaController::class, 'destroy'])->name('berita.destroy');
    Route::patch('/berita/{berita}/toggle', [AdminBeritaController::class, 'togglePublish'])->name('berita.toggle');

    // Galeri
    Route::get('/galeri',                   [AdminGaleriController::class, 'index'])->name('galeri.index');
    Route::post('/galeri',                  [AdminGaleriController::class, 'store'])->name('galeri.store');
    Route::delete('/galeri/{galeri}',       [AdminGaleriController::class, 'destroy'])->name('galeri.destroy');
    Route::patch('/galeri/{galeri}/toggle', [AdminGaleriController::class, 'toggleActive'])->name('galeri.toggle');

    // Statistik
    Route::get('/statistik',                    [AdminStatistikController::class, 'index'])->name('statistik.index');
    Route::put('/statistik',                    [AdminStatistikController::class, 'update'])->name('statistik.update');
    Route::post('/statistik',                   [AdminStatistikController::class, 'store'])->name('statistik.store');
    Route::delete('/statistik/{statistik}',     [AdminStatistikController::class, 'destroy'])->name('statistik.destroy');

    // Pesan
    Route::get('/pesan',            [AdminPesanController::class, 'index'])->name('pesan.index');
    Route::get('/pesan/{pesan}',    [AdminPesanController::class, 'show'])->name('pesan.show');
    Route::delete('/pesan/{pesan}', [AdminPesanController::class, 'destroy'])->name('pesan.destroy');

    // Layanan Surat
    Route::get('/layanan',                        [AdminLayananController::class, 'index'])->name('layanan.index');
    Route::get('/layanan/{layanan}/cetak',        [AdminLayananController::class, 'cetak'])->name('layanan.cetak');
    Route::get('/layanan/{layanan}',              [AdminLayananController::class, 'show'])->name('layanan.show');
    Route::patch('/layanan/{layanan}/status',     [AdminLayananController::class, 'updateStatus'])->name('layanan.status');
    Route::delete('/layanan/{layanan}',           [AdminLayananController::class, 'destroy'])->name('layanan.destroy');

    // Kelola Operator
    Route::get('/operator',                             [AdminOperatorController::class, 'index'])->name('operator.index');
    Route::post('/operator',                            [AdminOperatorController::class, 'store'])->name('operator.store');
    Route::patch('/operator/{operator}/toggle',         [AdminOperatorController::class, 'toggleActive'])->name('operator.toggle');
    Route::patch('/operator/{operator}/reset-password', [AdminOperatorController::class, 'resetPassword'])->name('operator.reset-password');
    Route::delete('/operator/{operator}',               [AdminOperatorController::class, 'destroy'])->name('operator.destroy');
});

// ============================================================
// OPERATOR — role 'operator' (akses terbatas)
// ============================================================
use App\Http\Controllers\Operator\OperatorDashboardController;
use App\Http\Controllers\Operator\OperatorBeritaController;
use App\Http\Controllers\Operator\OperatorGaleriController;
use App\Http\Controllers\Operator\OperatorLayananController;
use App\Http\Controllers\Operator\OperatorPesanController;

Route::prefix('operator')->name('operator.')->middleware('auth.user')->group(function () {

    Route::get('/dashboard', [OperatorDashboardController::class, 'index'])->name('dashboard');

    // Berita (tanpa delete)
    Route::get('/berita',                   [OperatorBeritaController::class, 'index'])->name('berita.index');
    Route::get('/berita/buat',              [OperatorBeritaController::class, 'create'])->name('berita.create');
    Route::post('/berita',                  [OperatorBeritaController::class, 'store'])->name('berita.store');
    Route::get('/berita/{berita}/edit',     [OperatorBeritaController::class, 'edit'])->name('berita.edit');
    Route::put('/berita/{berita}',          [OperatorBeritaController::class, 'update'])->name('berita.update');
    Route::patch('/berita/{berita}/toggle', [OperatorBeritaController::class, 'togglePublish'])->name('berita.toggle');

    // Galeri (tanpa delete)
    Route::get('/galeri',   [OperatorGaleriController::class, 'index'])->name('galeri.index');
    Route::post('/galeri',  [OperatorGaleriController::class, 'store'])->name('galeri.store');

    // Layanan Surat (tanpa delete)
    Route::get('/layanan',                      [OperatorLayananController::class, 'index'])->name('layanan.index');
    Route::get('/layanan/{layanan}/cetak',      [OperatorLayananController::class, 'cetak'])->name('layanan.cetak');
    Route::get('/layanan/{layanan}',            [OperatorLayananController::class, 'show'])->name('layanan.show');
    Route::patch('/layanan/{layanan}/status',   [OperatorLayananController::class, 'updateStatus'])->name('layanan.status');

    // Pesan (hanya baca, tanpa delete)
    Route::get('/pesan',         [OperatorPesanController::class, 'index'])->name('pesan.index');
    Route::get('/pesan/{pesan}', [OperatorPesanController::class, 'show'])->name('pesan.show');
});
