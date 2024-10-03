<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\ManajerController;
use App\Http\Controllers\LoginController;

// Login Route
Route::post('/login', [LoginController::class, 'login']);

// Admin routes
Route::prefix('admin')->middleware(['auth:api', 'role:admin'])->group(function () {
    // User Management
    Route::get('/users', [AdminController::class, 'indexUsers']);
    Route::post('/users', [AdminController::class, 'createUser']);
    Route::put('/users/{id}', [AdminController::class, 'updateUser']);
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser']);

    // Menu Management
    Route::get('/menu', [AdminController::class, 'indexMenu']);
    Route::post('/menu', [AdminController::class, 'createMenu']);
    Route::put('/menu/{id}', [AdminController::class, 'updateMenu']);
    Route::delete('/menu/{id}', [AdminController::class, 'deleteMenu']);

    // Table Management
    Route::get('/tables', [AdminController::class, 'indexTables']);
    Route::post('/tables', [AdminController::class, 'createTable']);
    Route::put('/tables/{id}', [AdminController::class, 'updateTable']);
    Route::delete('/tables/{id}', [AdminController::class, 'deleteTable']);
}); // <-- Closing the admin group

// Kasir routes
Route::prefix('kasir')->middleware(['auth:api', 'role:kasir'])->group(function () {
    Route::post('/transaksis', [KasirController::class, 'createTransaksi']);
    Route::get('/transaksis', [KasirController::class, 'indexTransaksis']);
    Route::post('/transaksis/{id}/print', [KasirController::class, 'printTransaksi']);
    Route::get('/menu', [KasirController::class, 'getMenu']); 
    Route::get('/meja', [KasirController::class, 'getMeja']);
}); // <-- Closing the kasir group

// Manajer routes
Route::prefix('manajer')->middleware(['auth:api', 'role:manajer'])->group(function () {
    Route::get('/transaksis', [ManajerController::class, 'indexTransaksis']);
    Route::get('/transaksis/filter', [ManajerController::class, 'filterTransaksis']);
    Route::get('/transaksis/{id}', [ManajerController::class, 'showTransaksi']);
}); // <-- Closing the manajer group

// Default route for web interface
Route::get('/', function () {
    return view('welcome');
});
