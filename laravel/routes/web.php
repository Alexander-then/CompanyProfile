<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TentangController;
use App\Http\Controllers\FaqsController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VisiMisiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\categoryBeritaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/',[DashboardController::class, 'view'])->middleware('auth');
Route::get('/register', function() {
    abort(404);
});

// Dashboard
Route::get('/dashboard',[DashboardController::class, 'view'])->name('dashboard')->middleware('auth');
Route::get('/dashboard-scorebox',[DashboardController::class, 'scorebox'])->name('dashboard-scorebox')->middleware('auth');
// Tentang Kami
Route::GET('/tentang',[TentangController::class, 'view'])->name('tentang')->middleware('auth');
Route::POST('/tentang-store',[TentangController::class, 'store'])->name('tentang-store')->middleware('auth');
Route::get('/tentang-edit/{id}',[TentangController::class, 'edit'])->name('tentang-edit')->middleware('auth');
Route::post('/tentang-update',[TentangController::class, 'update'])->name('tentang-update')->middleware('auth');
Route::get('/tentang-delete/{id}',[TentangController::class, 'delete'])->name('tentang-delete')->middleware('auth');
// Faqs
Route::get('/faqs',[FaqsController::class, 'view'])->name('faqs')->middleware('auth');
Route::post('/faqs',[FaqsController::class, 'store'])->name('faqs-store')->middleware('auth');
Route::get('/faqs-edit/{id}',[FaqsController::class, 'edit'])->name('faqs-edit')->middleware('auth');
Route::post('/faqs-update',[FaqsController::class, 'update'])->name('faqs-update')->middleware('auth');
Route::get('/faqs-delete/{id}',[FaqsController::class, 'destroy'])->name('faqs-delete')->middleware('auth');

// Mitra
Route::get('/mitra',[MitraController::class, 'view'])->name('mitra')->middleware('auth');
Route::post('/mitra',[MitraController::class, 'store'])->name('mitra-store')->middleware('auth');
Route::get('/mitra-edit/{id}',[MitraController::class, 'edit'])->name('mitra-edit')->middleware('auth');
Route::post('/mitra-update', [MitraController::class, 'update'])->name('mitra-update')->middleware('auth');
Route::get('/mitra-delete/{id}', [MitraController::class, 'destroy'])->name('mitra-delete')->middleware('auth');

// Kontak
Route::get('/kontak',[KontakController::class, 'view'])->name('kontak')->middleware('auth');
Route::post('/kontak-store',[KontakController::class, 'store'])->name('kontak-store')->middleware('auth');
Route::get('/kontak-edit/{id}',[KontakController::class, 'edit'])->name('kontak-edit')->middleware('auth');
Route::post('/kontak-update',[KontakController::class, 'update'])->name('kontak-update')->middleware('auth');
Route::get('/kontak-delete/{id}',[KontakController::class, 'destroy'])->name('kontak-delete')->middleware('auth');

// Gallery
Route::get('/gallery',[GalleryController::class, 'view'])->name('gallery')->middleware('auth');
Route::POST('/Gallery-store',[GalleryController::class, 'store'])->name('Gallery-store')->middleware('auth');
Route::get('/gallery-edit/{id}',[GalleryController::class, 'edit'])->name('gallery-edit')->middleware('auth');
Route::post('/gallery-update',[GalleryController::class, 'update'])->name('gallery-update')->middleware('auth');
Route::get('/gallery-delete/{id}',[GalleryController::class, 'delete'])->name('gallery-delete')->middleware('auth');
Route::get('/gallery/detail/{id}',[GalleryController::class,'detail'])->name('gallery-detail')->middleware('auth');
Route::POST('/gallery-detail-store',[GalleryController::class,'detailStore'])->name('gallery-detail-store')->middleware('auth');
Route::get('/gallery-detail-edit/{id}',[GalleryController::class,'detailEdit'])->name('gallery-detail-edit')->middleware('auth');
Route::post('/gallery-detail-update',[GalleryController::class,'detailUpdate'])->name('gallery-detail-update')->middleware('auth');
Route::get('/gallery-detail-delete/{id}',[GalleryController::class,'detailDelete'])->name('gallery-detail-delete')->middleware('auth');

// Visi Misi
Route::get('/visiMisi',[VisiMisiController::class, 'view'])->name('visiMisi')->middleware('auth');
Route::post('/visiMisitambah',[VisiMisiController::class, 'store'])->name('visiMisitambah')->middleware('auth');
Route::get('/visiMisiedit/{id}',[VisiMisiController::class, 'edit'])->name('visiMisiedit')->middleware('auth');
Route::post('/visiMisiupdate',[VisiMisiController::class, 'update'])->name('visiMisiupdate')->middleware('auth');
Route::get('/visiMisihapus/{id}',[VisiMisiController::class,'destroy'])->name('visiMisihapus')->middleware('auth');

// Karyawan
Route::get('/karyawan',[KaryawanController::class, 'view'])->name('karyawan')->middleware('auth');
Route::post('/karyawanTambah',[KaryawanController::class, 'store'])->name('karyawanTambah')->middleware('auth');
Route::get('/karyawanEdit/{id}',[KaryawanController::class, 'edit'])->name('karyawanEdit')->middleware('auth');
Route::post('/karyawanUpdate',[KaryawanController::class, 'update'])->name('karyawanUpdate')->middleware('auth');
Route::get('/karyawanDelete/{id}',[KaryawanController::class, 'destroy'])->name('karyawanDelete')->middleware('auth');

// Produk
Route::get('/produk',[ProdukController::class, 'view'])->name('produk')->middleware('auth');
Route::post('/produk',[ProdukController::class, 'store'])->name('produk-store')->middleware('auth');
Route::get('/produk-edit/{id}',[ProdukController::class, 'edit'])->name('produk-edit')->middleware('auth');
Route::post('/produk-update',[ProdukController::class, 'update'])->name('produk-update')->middleware('auth');
Route::get('/produk-delete/{id}',[ProdukController::class, 'destroy'])->name('produk-delete')->middleware('auth');

// Berita
Route::get('/berita', [BeritaController::class, 'view'])->name('berita')->middleware('auth');
Route::post('/berita', [BeritaController::class, 'store'])->name('berita-store')->middleware('auth');
Route::get('/berita-edit/{id}', [BeritaController::class, 'edit'])->name('berita-edit')->middleware('auth');
Route::post('/berita-update', [BeritaController::class, 'update'])->name('berita-update')->middleware('auth');
Route::get('/berita-delete/{id}', [BeritaController::class, 'destroy'])->name('berita-delete')->middleware('auth');