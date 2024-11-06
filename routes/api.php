<?php

use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\BarangController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\LevelController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// praktikum 1 js 10
Route::post('/register', App\Http\Controllers\Api\RegisterController::class)->name('register');
// praktikum 1 js 11
Route::post('/register1', App\Http\Controllers\Api\RegisterController::class)->name('register1');
// praktikum 2 js 10
Route::post('/login', App\Http\Controllers\Api\LoginController::class)->name('login');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//praktikum 3 js 10
Route::post('/logout', App\Http\Controllers\Api\LogoutController::class)->name('logout');

//praktikum 4 js 10

// Level
Route::get('level', [LevelController::class, 'index']);
Route::post('levels', [LevelController::class, 'store']);
Route::get('levels/{level}', [LevelController::class, 'show']);
Route::put('levels/{level}', [LevelController::class, 'update']);
Route::delete('levels/{level}', [LevelController::class, 'destroy']);

// User
Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);

// Kategori
Route::get('kategoris', [KategoriController::class, 'index']);
Route::post('kategoris', [KategoriController::class, 'store']);
Route::get('kategoris/{kategori}', [KategoriController::class, 'show']);
Route::put('kategoris/{kategori}', [KategoriController::class, 'update']);
Route::delete('kategoris/{kategori}', [KategoriController::class, 'destroy']);

//Barang
Route::get('barangs', [BarangController::class, 'index']);
Route::post('barangs', [BarangController::class, 'store']);
Route::get('barangs/{barang}', [BarangController::class, 'show']);
Route::put('barangs/{barang}', [BarangController::class, 'update']);
Route::delete('barangs/{barang}', [BarangController::class, 'destroy']);