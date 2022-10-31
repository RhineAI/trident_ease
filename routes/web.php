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
use App\Http\Controllers\PDFController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\ListTransaksiPembelianController;

use App\Http\Controllers\HutangController;
use App\Http\Controllers\PiutangController;
use App\Http\Controllers\ReturPenjualanController;
use App\Http\Controllers\ListReturPenjualanController;
use App\Http\Controllers\ReturPembelianController;
use App\Http\Controllers\StokOpnameController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'hak_akses:1'], function () {
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
        Route::resource('/data-piutang', PiutangController::class);
        Route::resource('/data-hutang', HutangController::class);

        // Stok opname
        Route::get('/stock-opname', [StokOpnameController::class, 'index'])->name('stockOpname');
        Route::post('/stock-opname', [StokOpnameController::class, 'updateStock']);

        // Retur Penjualan
        Route::resource('/retur-penjualan', ReturPenjualanController::class);
        Route::post('/retur-penjualan/data', [ReturPenjualanController::class, 'data'])->name('retur-penjualan.data');
        Route::get('/list-retur-penjualan', [ListReturPenjualanController::class, 'index'])->name('list-retur-penjualan.index');
        Route::post('/list-retur-penjualan/data/{awal}/{akhir}', [ListReturPenjualanController::class, 'getData'])->name('list-retur-penjualan.data');
        Route::get('/list-retur-penjualan/pdf/{awal}/{akhir}', [ListReturPenjualanController::class, 'exportPDF'])->name('list-retur-penjualan.export_pdf');

        // Retur Pembelian
        Route::resource('/retur-pembelian', ReturPembelianController::class);
        Route::post('/retur-pembelian/data', [ReturPembelianController::class, 'data'])->name('retur-pembelian.data');
        Route::get('/list-retur-pembelian', [ListReturPembelianController::class, 'index'])->name('list-retur-pembelian.index');
        Route::post('/list-retur-pembelian/data/{awal}/{akhir}', [ListReturPembelianController::class, 'getData'])->name('list-retur-pembelian.data');
        Route::get('/list-retur-pembelian/pdf/{awal}/{akhir}', [ListReturPembelianController::class, 'exportPDF'])->name('list-retur-pembelian.export_pdf');

        // Informasi KAS
        Route::resource('kas-masuk', KasMasukController::class);
        Route::post('/kas-masuk/data', [KasMasukController::class, 'data'])->name('kas-masuk.data');

        Route::resource('kas-keluar', KasKeluarController::class);
        Route::post('/kas-keluar/data', [KasKeluarController::class, 'data'])->name('kas-keluar.data');

        // Laporan
        Route::get('/list-pelanggan-terbaik', [LaporanController::class, 'indexBestPelanggan'])->name('list-b-pelanggan.index');
        Route::post('/list-pelanggan-terbaik/data/{awal}/{akhir}', [LaporanController::class, 'getDataBestBPelanggan'])->name('list-b-pelanggan.data');
        Route::get('/list-pelanggan-terbaik/pdf/{awal}/{akhir}', [LaporanController::class, 'PDFBestPelanggan'])->name('list-b-pelanggan.pdf');

        Route::get('/laporan-kas', [LaporanController::class, 'indexLaporanKas'])->name('laporan-kas.index');
        Route::post('/laporan-kas-masuk/data/{awal}/{akhir}', [LaporanController::class, 'dataLaporanKasMasuk'])->name('laporan-kas-masuk.data');
        Route::post('/laporan-kas-keluar/data/{awal}/{akhir}', [LaporanController::class, 'dataLaporanKasKeluar'])->name('laporan-kas-keluar.data');
        Route::post('/laporan-kas-keluar/pdf/{awal}/{akhir}', [LaporanController::class, 'PDFKas'])->name('laporan-kas.pdf');

        Route::get('/laporan-penjualan', [LaporanController::class, 'indexLaporanPenjualan'])->name('laporan-penjualan.index');
        Route::post('/laporan-penjualan/data/{awal}/{akhir}', [LaporanController::class, 'dataLaporanPenjualan'])->name('laporan-penjualan.data');
        Route::post('/laporan-penjualan/pdf/{awal}/{akhir}', [LaporanController::class, 'PDFPenjualan'])->name('laporan-penjualan.pdf');

        Route::post('/laporan-pembelian/data/{awal}/{akhir}', [LaporanController::class, 'dataLaporanPembelian'])->name('laporan-pembelian.data');

        Route::get('/laporan-harian', [LaporanController::class, 'indexLaporanHarian'])->name('laporan-harian.index');
        Route::post('/laporan-harian/pdf/{awal}/{akhir}', [LaporanController::class, 'PDFHarian'])->name('laporan-harian.pdf');
       
        Route::get('/laporan-stok', [LaporanController::class, 'indexLaporanStok'])->name('laporan-stok.index');
        Route::post('/laporan-stok/data/{merek}/{kategori}', [LaporanController::class, 'dataLaporanStok'])->name('laporan-stok.data');
        Route::post('/laporan-stok/pdf/{merek}/{kategori}', [LaporanController::class, 'PDFStok'])->name('laporan-stok.pdf');

        Route::get('/laporan-kesesuaian-stock', [LaporanController::class, 'indexLaporanKesesuaianStok'])->name('laporan-kesesuaian-stock.index');
        Route::post('/laporan-kesesuaian-stock/data/{awal}/{akhir}', [LaporanController::class, 'dataLaporanKesesuaianStok'])->name('laporan-kesesuaian-stock.data');
        Route::post('/laporan-kesesuaian-stock/pdf/{awal}/{akhir}', [LaporanController::class, 'PDFKesesuaianStok'])->name('laporan-kesesuaian-stock.pdf');
     
        Route::get('/laporan-hutang-piutang', [LaporanController::class, 'indexLaporanHutangPiutang'])->name('laporan-hutang-piutang.index');
        Route::post('/laporan-hutang/data/{awal}/{akhir}', [LaporanController::class, 'dataLaporanHutang'])->name('laporan-hutang.data');
        Route::post('/laporan-piutang/data/{awal}/{akhir}', [LaporanController::class, 'dataLaporanPiutang'])->name('laporan-piutang.data');
  

        Route::get('/laporan-harian', [LaporanController::class, 'indexLaporanHarian'])->name('laporan-harian.index');
        Route::post('/laporan-harian/pdf/{awal}/{akhir}', [LaporanController::class, 'PDFHarian'])->name('laporan-harian.pdf');
        Route::post('/laporan-pembelian/data/{awal}/{akhir}', [LaporanController::class, 'dataLaporanPembelian'])->name('laporan-pembelian.data');
        Route::post('/laporan-retur-penjualan/data/{awal}/{akhir}', [LaporanController::class, 'dataLaporanReturPenjualan'])->name('laporan-retur-penjualan.data');
        Route::post('/laporan-retur-pembelian/data/{awal}/{akhir}', [LaporanController::class, 'dataLaporanReturPembelian'])->name('laporan-retur-pembelian.data');
   
        
        Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});

//Kasir
Route::group(['middleware' => 'auth'], function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        // Transaksi Penjualan
        Route::resource('/transaksi-penjualan', TransaksiPenjualanController::class);
        Route::get('/list-penjualan', [ListTransaksiPenjualanController::class, 'index'])->name('list-transaksi.index');
        Route::post('/list-penjualan/data/{awal}/{akhir}', [ListTransaksiPenjualanController::class, 'getData'])->name('list-transaksi.data');
        Route::get('/list-penjualan/pdf/{awal}/{akhir}', [ListTransaksiPenjualanController::class, 'exportPDF'])->name('list-transaksi.export_pdf');

        Route::get('/list-pelanggan-terbaik', [LaporanController::class, 'indexBestPelanggan'])->name('list-b-pelanggan.index');
        Route::post('/list-pelanggan-terbaik/data/{awal}/{akhir}', [LaporanController::class, 'getDataBPelanggan'])->name('list-b-pelanggan.data');
        Route::get('/list-pelanggan-terbaik/pdf/{awal}/{akhir}', [LaporanController::class, 'exportPDFBPelanggan'])->name('list-b-pelanggan.export_pdf');
});


Route::middleware('guest')->group(function(){
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [LoginController::class, 'reg'])->name('reg');
    Route::post('/register', [LoginController::class, 'register'])->name('register');
    Route::get('/success', [LoginController::class, 'regSuccess'])->name('regSuccess');
});