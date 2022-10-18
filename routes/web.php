<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KeuntunganController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MerekController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function(){
        Route::get('/', [DashboardController::class, 'index']);
        Route::resource('/kategori', KategoriController::class);
        Route::resource('/merek', MerekController::class);
        Route::resource('/satuan', SatuanController::class);
        Route::resource('/perusahaan', PerusahaanController::class);

        Route::resource('/barang', BarangController::class);
        Route::get('/barang-tambah', [BarangController::class, 'index2'])->name('barang2');
        Route::post('/barang-tambah', [BarangController::class, 'store']);

        Route::resource('/supplier', SupplierController::class);
        Route::get('/supplier-tambah', [SupplierController::class, 'index2'])->name('supplier2');
        Route::post('/supplier-tambah', [SupplierController::class, 'store']);

        Route::resource('/pelanggan', PelangganController::class);
        Route::get('/pelanggan-tambah', [PelangganController::class, 'index2'])->name('pelanggan2');
        Route::post('/pelanggan-tambah', [PelangganController::class, 'store']);

        Route::resource('/users', UsersController::class);
        Route::get('/users-tambah', [UsersController::class, 'index2'])->name('pegawai2');
        Route::post('/users-tambah', [UsersController::class, 'store']);
        Route::get('/profile', [UsersController::class, 'profile'])->name('profile');
        Route::post('/profile', [UsersController::class, 'profileUpdate']);
        Route::get('/changePW', [UsersController::class, 'changePW'])->name('changePW');
        Route::post('/changePW', [UsersController::class, 'chawngePWUpdate']);

        Route::get('/keuntungan', [KeuntunganController::class, 'index'])->name('keuntungan');
        Route::post('/keuntungan', [KeuntunganController::class, 'store']);

        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


        Route::resource('/penjualan', PenjualanController::class);
    
});

Route::middleware('guest')->group(function(){
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [LoginController::class, 'reg'])->name('reg');
    Route::post('/register', [LoginController::class, 'register'])->name('register');
    Route::get('/success', [LoginController::class, 'regSuccess'])->name('regSuccess');
});