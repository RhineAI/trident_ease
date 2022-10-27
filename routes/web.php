<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DetailPembelianController;
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

// Informasi Kas
use App\Http\Controllers\KasMasukController;
use App\Http\Controllers\KasKeluarController;

// Transaksi
use App\Http\Controllers\TransaksiPenjualanController;
use App\Http\Controllers\ListTransaksiPenjualanController;
use App\Http\Controllers\DetailPenjualanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\ListTransaksiPembelianController;

use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PembayaranPembelianController;
use App\Http\Controllers\ReturPenjualanController;
use App\Http\Controllers\StokOpnameController;
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
        // Route::get('/list-pembelian', [PembelianController::class, 'listPembelian'])->name('list-pembelian');
        // Route::post('/list-pembelian/data', [PembelianController::class, 'dataPembelian'])->name('list-pembelian.data');


        // Route::resource('/pembelian_detail', DetailPembelianController::class);
        // Route::get('/show-transaksi-pembelian', [PembelianController::class, 'showTPembelian'])
        Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
        

        // Transaksi Penjualan
        Route::resource('/transaksi-penjualan', TransaksiPenjualanController::class);
        Route::get('/list-penjualan', [ListTransaksiPenjualanController::class, 'index'])->name('list-transaksi.index');
        Route::post('/list-penjualan/data/{awal}/{akhir}', [ListTransaksiPenjualanController::class, 'getData'])->name('list-transaksi.data');
        Route::get('/list-penjualan/pdf/{awal}/{akhir}', [ListTransaksiPenjualanController::class, 'exportPDF'])->name('list-transaksi.export_pdf');

        // Transaksi Pembelian
        Route::resource('/transaksi-pembelian', PembelianController::class);    
        Route::get('/list-pembelian', [ListTransaksiPembelianController::class, 'index'])->name('list-pembelian.index');
        Route::post('/list-pembelian/data/{awal}/{akhir}', [ListTransaksiPembelianController::class, 'getData'])->name('list-pembelian.data');
        Route::get('/list-pembelian/pdf/{awal}/{akhir}', [ListTransaksiPembelianController::class, 'exportPDF'])->name('list-pembelian.export_pdf');

        // Tunggakan Pembayaran
        Route::resource('/pembayaran', PembayaranController::class);
        Route::resource('/pembayaran-pembelian', PembayaranPembelianController::class);

        // Stok opname
        Route::get('/stock-opname', [StokOpnameController::class, 'index'])->name('stockOpname');
        Route::post('/stock-opname', [StokOpnameController::class, 'updateStock']);

        // Retur Penjualan
        Route::resource('/retur-penjualan', ReturPenjualanController::class);
        Route::post('/retur-penjualan/data', [ReturPenjualanController::class, 'data'])->name('retur-penjualan.data');

        // Informasi KAS
        Route::resource('kas-masuk', KasMasukController::class);
        Route::post('/kas-masuk/data', [KasMasukController::class, 'data'])->name('kas-masuk.data');

        Route::resource('kas-keluar', KasKeluarController::class);
        Route::post('/kas-keluar/data', [KasKeluarController::class, 'data'])->name('kas-keluar.data');

        
        Route::get('/list-pelanggan-terbaik', [LaporanController::class, 'indexBestPelanggan'])->name('list-b-pelanggan.index');
        Route::post('/list-pelanggan-terbaik/data/{awal}/{akhir}', [LaporanController::class, 'getDataBPelanggan'])->name('list-b-pelanggan.data');
        Route::get('/list-pelanggan-terbaik/pdf/{awal}/{akhir}', [LaporanController::class, 'exportPDFBPelanggan'])->name('list-b-pelanggan.export_pdf');
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