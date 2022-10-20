<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DetailPembelianController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KeuntunganController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MerekController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UsersController;

// Transaksi
use App\Http\Controllers\TransaksiPenjualanController;
use App\Http\Controllers\DetailPenjualanController;

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function(){
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('/kategori', KategoriController::class);
        Route::resource('/merek', MerekController::class);
        Route::resource('/satuan', SatuanController::class);
        Route::resource('/perusahaan', PerusahaanController::class);

        Route::resource('/barang', BarangController::class);
        Route::get('/barang-tambah', [BarangController::class, 'index2'])->name('barang2');
        Route::post('/barang-tambah', [BarangController::class, 'store']);
        Route::post('/barang/data', [BarangController::class, 'data'])->name('barang.data');

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

        Route::resource('/transaksi-pembelian', PembelianController::class);

        // Route::resource('/pembelian_detail', DetailPembelianController::class);
        // Route::get('/show-transaksi-pembelian', [PembelianController::class, 'showTPembelian'])
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
        
        Route::resource('/transaksi-penjualan', TransaksiPenjualanController::class);
        Route::get('/transaksi-penjualan/data', [TransaksiPenjualanController::class, 'data'])->name('transaksi.data');
        Route::get('/list-transaksi', [TransaksiPenjualanController::class, 'listTransaksi'])->name('list-transaksi');
        Route::post('/list-transaksi/data', [TransaksiPenjualanController::class, 'dataTransaksi'])->name('list-transaksi.data');

        Route::resource('/detail-penjualan', DetailPenjualanController::class);
    
});

Route::group(['middleware' => 'auth'], function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('/transaksi-penjualan', TransaksiPenjualanController::class);
});

Route::middleware('guest')->group(function(){
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [LoginController::class, 'reg'])->name('reg');
    Route::post('/register', [LoginController::class, 'register'])->name('register');
    Route::get('/success', [LoginController::class, 'regSuccess'])->name('regSuccess');
});