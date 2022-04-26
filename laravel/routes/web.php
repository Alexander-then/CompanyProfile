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

// Dashboard
Route::get('/dashboard',[DashboardController::class, 'view'])->name('dashboard');

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

// Kontak
Route::get('/kontak',[KontakController::class, 'view'])->name('kontak')->middleware('auth');

// Gallery
Route::get('/gallery',[GalleryController::class, 'view'])->name('gallery')->middleware('auth');

// Visi Misi
Route::get('/visiMisi',[VisiMisiController::class, 'view'])->name('visiMisi')->middleware('auth');
Route::post('/visiMisitambah',[VisiMisiController::class, 'store'])->name('visiMisitambah')->middleware('auth');
Route::get('/visiMisiedit/{id}',[VisiMisiController::class, 'edit'])->name('visiMisiedit')->middleware('auth');
Route::post('/visiMisiupdate',[VisiMisiController::class, 'update'])->name('visiMisiupdate')->middleware('auth');
Route::get('/visiMisihapus/{id}',[VisiMisiController::class,'destroy'])->name('visiMisihapus')->middleware('auth');
