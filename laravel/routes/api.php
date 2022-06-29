<?php

use App\Http\Controllers\API\BeritaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\VisiMisiController;
use App\Http\Controllers\API\TentangController;
use App\Http\Controllers\API\FaqsController;
use App\Http\Controllers\API\GalleryController;
use App\Http\Controllers\API\KaryawanController;
use App\Http\Controllers\API\KontakController;
use App\Http\Controllers\API\MitraController;
use App\Http\Controllers\API\ProdukController;
use App\Http\Controllers\API\MeetingManagementController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Visi misi
Route::get('visi_misi', [VisiMisiController::class, 'index']);

//tentang kami
Route::get('tentang_kami', [TentangController::class, 'index']);

//Faqs
Route::get('faq', [FaqsController::class, 'index']);
Route::post('faq/add', [FaqsController::class, 'store']);

//karyawan
Route::get('karyawan', [KaryawanController::class, 'index']);
Route::get('getCarouselKaryawan', [KaryawanController::class, 'getCarouselKaryawan']);
Route::get('team', [KaryawanController::class, 'getTeam']);
Route::get('detailTeam', [KaryawanController::class, 'getDetailTeam']);

//kontak
Route::get('kontak', [KontakController::class, 'index']);

//mitra
Route::get('mitra', [MitraController::class, 'index']);

//produk
Route::get('produk', [ProdukController::class, 'index']);

//berita
Route::get('berita', [BeritaController::class, 'index']);
Route::get('get-berita/{name}', [BeritaController::class, 'getBerita']);
Route::get('kategori-berita/{kategori}', [BeritaController::class, 'getKategori']);
Route::get('berita/{id}', [BeritaController::class, 'getDetail']);
Route::put('berita/{id}', [BeritaController::class, 'updateViews']);

//gallery
Route::get('gallery', [GalleryController::class, 'index']);
Route::get('albums', [GalleryController::class, 'ShowAlbums']);
Route::get('albums/{name}', [GalleryController::class, 'GetAlbum']);
Route::get('album/{id}', [GalleryController::class, 'getDetailAlbum']);

//Management Meeting
Route::get('meeting_management', [MeetingManagementController::class, 'index']);
Route::get('meeting_management_count/{id}', [MeetingManagementController::class, 'startTimer']);