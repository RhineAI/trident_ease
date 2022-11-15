<?php

//SUPER ADMIN
use App\Http\Controllers\SuperAdminController;


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
use App\Http\Controllers\ListReturPembelianController;
use App\Http\Controllers\PiutangController;
use App\Http\Controllers\ReturPenjualanController;
use App\Http\Controllers\ListReturPenjualanController;
use App\Http\Controllers\ReturPembelianController;
use App\Http\Controllers\StokOpnameController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
        Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
        // Route::patch('/manage-perusahaan/perbarui/{id}', [SuperAdminController::class, 'perbarui'])->name('manage.perbarui');

        Route::group(['prefix' => 'super_admin', 'middleware' => 'cek-hak-akses:super_admin', 'as' => 'super_admin.'], function () {
                Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

                Route::resource('/users', UsersController::class);
                Route::get('/users-tambah', [UsersController::class, 'index2'])->name('pegawai2');
                Route::post('/users-tambah', [UsersController::class, 'store']);
                Route::get('/profile', [UsersController::class, 'profile'])->name('profile');
                Route::post('/profile', [UsersController::class, 'profileUpdate']);
                Route::get('/profile/cards', [UsersController::class, 'card'])->name('profile.cards');

                Route::get('/changePW', [UsersController::class, 'changePW'])->name('changePW');
                Route::post('/changePW', [UsersController::class, 'changePWUpdate']);

                Route::resource('/manage-perusahaan', SuperAdminController::class);
                Route::post('/manage-perusahaan/data', [SuperAdminController::class, 'table'])->name('manage.data');
                Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
        });

        Route::group(['prefix' => 'owner', 'middleware' => 'cek-hak-akses:owner', 'as' => 'owner.'], function () {
                Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
                
                Route::resource('/users', UsersController::class);
                Route::get('/users-tambah', [UsersController::class, 'index2'])->name('pegawai2');
                Route::post('/users-tambah', [UsersController::class, 'store']);
                Route::get('/profile', [UsersController::class, 'profile'])->name('profile');
                Route::post('/profile', [UsersController::class, 'profileUpdate']);
                Route::get('/profile/cards', [UsersController::class, 'card'])->name('profile.cards');

                Route::get('/changePW', [UsersController::class, 'changePW'])->name('changePW');
                Route::post('/changePW', [UsersController::class, 'changePWUpdate']);

                // Stok opname
                Route::get('/stock-opname', [StokOpnameController::class, 'index'])->name('stockOpname');
                Route::post('/stock-opname', [StokOpnameController::class, 'updateStock']);      
                
                // Laporan
                Route::get('/list-pelanggan-terbaik', [LaporanController::class, 'indexBestPelanggan'])->name('list-b-pelanggan.index');
                Route::post('/list-pelanggan-terbaik/data/{awal}/{akhir}', [LaporanController::class, 'getDataBestPelanggan'])->name('list-b-pelanggan.data');
                Route::get('/list-pelanggan-terbaik/download/{awal}/{akhir}', [LaporanController::class, 'DownloadBestPelanggan'])->name('list-b-pelanggan.download');
                Route::get('/list-pelanggan-terbaik/pdf/{awal}/{akhir}', [LaporanController::class, 'PrintPDFBestPelanggan'])->name('list-b-pelanggan.print');

                Route::get('/laporan-kas', [LaporanController::class, 'indexLaporanKas'])->name('laporan-kas.index');
                Route::post('/laporan-kas-masuk/data/{awal}/{akhir}', [LaporanController::class, 'dataLaporanKasMasuk'])->name('laporan-kas-masuk.data');
                Route::post('/laporan-kas-keluar/data/{awal}/{akhir}', [LaporanController::class, 'dataLaporanKasKeluar'])->name('laporan-kas-keluar.data');
                Route::get('/laporan-kas/download/{awal}/{akhir}', [LaporanController::class, 'DownloadKas'])->name('laporan-kas.download');
                Route::get('/laporan-kas/pdf/{awal}/{akhir}', [LaporanController::class, 'PrintPDFKas'])->name('laporan-kas.print');
                
                Route::get('/laporan-penjualan', [LaporanController::class, 'indexLaporanPenjualan'])->name('laporan-penjualan.index');
                Route::post('/laporan-penjualan/data/{awal}/{akhir}', [LaporanController::class, 'dataLaporanPenjualan'])->name('laporan-penjualan.data');
                Route::get('/laporan-penjualan/download/{awal}/{akhir}', [LaporanController::class, 'DownloadPenjualan'])->name('laporan-penjualan.download');
                Route::get('/laporan-penjualan/pdf/{awal}/{akhir}', [LaporanController::class, 'PrintPDFPenjualan'])->name('laporan-penjualan.print');

                Route::get('/laporan-pembelian', [LaporanController::class, 'indexLaporanPembelian'])->name('laporan-pembelian.index');
                Route::post('/laporan-pembelian/data/{awal}/{akhir}', [LaporanController::class, 'dataLaporanPembelian'])->name('laporan-pembelian.data');
                Route::get('/laporan-pembelian/download/{awal}/{akhir}', [LaporanController::class, 'DownloadPembelian'])->name('laporan-pembelian.download');
                Route::get('/laporan-pembelian/pdf/{awal}/{akhir}', [LaporanController::class, 'PrintPDFPembelian'])->name('laporan-pembelian.print');

                Route::get('/laporan-stok', [LaporanController::class, 'indexLaporanStok'])->name('laporan-stok.index');
                Route::post('/laporan-stok/data/{merek}/{kategori}', [LaporanController::class, 'dataLaporanStok'])->name('laporan-stok.data');
                Route::get('/laporan-stok/download/{merek}/{kategori}', [LaporanController::class, 'DownloadStok'])->name('laporan-stok.download');
                Route::get('/laporan-stok/pdf/{merek}/{kategori}', [LaporanController::class, 'PrintPDFStok'])->name('laporan-stok.print');

                Route::get('/laporan-kesesuaian-stok', [LaporanController::class, 'indexLaporanKesesuaianStok'])->name('laporan-kesesuaian-stok.index');
                Route::post('/laporan-kesesuaian-stok/data/{awal}/{akhir}/{merek}/{kategori}', [LaporanController::class, 'dataLaporanKesesuaianStok'])->name('laporan-kesesuaian-stok.data');
                Route::get('/laporan-kesesuaian-stok/download/{awal}/{akhir}/{merek}/{kategori}', [LaporanController::class, 'DownloadKesesuaianStok'])->name('laporan-kesesuaian-stok.download');
                Route::get('/laporan-kesesuaian-stok/pdf/{awal}/{akhir}/{merek}/{kategori}', [LaporanController::class, 'PrintPDFKesesuaianStok'])->name('laporan-kesesuaian-stok.print');
        
                Route::get('/laporan-hutang', [LaporanController::class, 'indexLaporanHutang'])->name('laporan-hutang.index');
                Route::post('/laporan-hutang/data/{awal}/{akhir}', [LaporanController::class, 'dataLaporanHutang'])->name('laporan-hutang.data');
                Route::get('/laporan-hutang/download/{awal}/{akhir}', [LaporanController::class, 'DownloadHutang'])->name('laporan-hutang.download');
                Route::get('/laporan-hutang/pdf/{awal}/{akhir}', [LaporanController::class, 'PrintPDFHutang'])->name('laporan-hutang.print');
                
                Route::get('/laporan-piutang', [LaporanController::class, 'indexLaporanPiutang'])->name('laporan-piutang.index');
                Route::post('/laporan-piutang/data/{awal}/{akhir}', [LaporanController::class, 'dataLaporanPiutang'])->name('laporan-piutang.data');
                Route::get('/laporan-piutang/download/{awal}/{akhir}', [LaporanController::class, 'DownloadPiutang'])->name('laporan-piutang.download');
                Route::get('/laporan-piutang/pdf/{awal}/{akhir}', [LaporanController::class, 'PrintPDFPiutang'])->name('laporan-piutang.print');


                Route::get('/laporan-harian', [LaporanController::class, 'indexLaporanHarian'])->name('laporan-harian.index');
                Route::get('/laporan-harian/download/{awal}/{akhir}', [LaporanController::class, 'DownloadHarian'])->name('laporan-harian.download');
                Route::get('/laporan-harian/pdf/{awal}/{akhir}', [LaporanController::class, 'PrintPDFHarian'])->name('laporan-harian.print');
                Route::post('/laporan-retur-penjualan/data/{awal}/{akhir}', [LaporanController::class, 'dataLaporanReturPenjualan'])->name('laporan-retur-penjualan.data');
                Route::post('/laporan-retur-pembelian/data/{awal}/{akhir}', [LaporanController::class, 'dataLaporanReturPembelian'])->name('laporan-retur-pembelian.data');   
        });

        Route::group(['prefix' => 'admin', 'middleware' => 'cek-hak-akses:admin', 'as' => 'admin.'], function () {
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
                Route::get('/profile/cards', [UsersController::class, 'card'])->name('profile.cards');

                Route::get('/changePW', [UsersController::class, 'changePW'])->name('changePW');
                Route::post('/changePW', [UsersController::class, 'changePWUpdate']);

                Route::get('/keuntungan', [KeuntunganController::class, 'index'])->name('keuntungan');
                Route::post('/keuntungan', [KeuntunganController::class, 'store'])->name('keuntungan.store');

                
                // Transaksi Penjualan
                Route::resource('/transaksi-penjualan', TransaksiPenjualanController::class);
                Route::get('/list-penjualan', [ListTransaksiPenjualanController::class, 'index'])->name('list-transaksi.index');
                Route::post('/list-penjualan/data/{awal}/{akhir}', [ListTransaksiPenjualanController::class, 'getData'])->name('list-transaksi.data');
                Route::get('/list-penjualan/pdf/{awal}/{akhir}', [ListTransaksiPenjualanController::class, 'exportPDF'])->name('list-transaksi.export_pdf');
                Route::get('/list-penjualan/nota/{id}', [ListTransaksiPenjualanController::class, 'printNota'])->name('list-transaksi.print_nota');

                // Transaksi Pembelian
                Route::resource('/transaksi-pembelian', PembelianController::class);    
                Route::get('/list-pembelian', [ListTransaksiPembelianController::class, 'index'])->name('list-pembelian.index');
                Route::post('/list-pembelian/data/{awal}/{akhir}', [ListTransaksiPembelianController::class, 'data'])->name('list-pembelian.data');
                Route::get('/list-pembelian/pdf/{awal}/{akhir}', [ListTransaksiPembelianController::class, 'exportPDF'])->name('list-pembelian.export_pdf');
                Route::get('/list-pembelian/nota/{id}', [ListTransaksiPembelianController::class, 'printNota'])->name('list-pembelian.print_nota');

                // Tunggakan Pembayaran
                Route::resource('/data-piutang', PiutangController::class);
                Route::get('/data-piutang/nota/{id}', [PiutangController::class, 'printNota'])->name('data-piutang.print_nota');

                Route::resource('/data-hutang', HutangController::class);
                Route::get('/data-hutang/nota/{id}', [HutangController::class, 'printNota'])->name('data-hutang.print_nota');

                // Stok opname
                Route::get('/stock-opname', [StokOpnameController::class, 'index'])->name('stockOpname');
                Route::post('/stock-opname', [StokOpnameController::class, 'updateStock']);

                // Retur Penjualan
                Route::resource('/retur-penjualan', ReturPenjualanController::class);
                Route::post('/retur-penjualan/data', [ReturPenjualanController::class, 'data'])->name('retur-penjualan.data');
                Route::get('/list-retur-penjualan', [ListReturPenjualanController::class, 'index'])->name('list-retur-penjualan.index');
                Route::post('/list-retur-penjualan/data/{awal}/{akhir}', [ListReturPenjualanController::class, 'getData'])->name('list-retur-penjualan.data');
                Route::get('/list-retur-penjualan/pdf/{awal}/{akhir}', [ListReturPenjualanController::class, 'exportPDF'])->name('list-retur-penjualan.export_pdf');
                Route::get('/list-retur-penjualan/nota/{id}', [ListReturPenjualanController::class, 'printNota'])->name('list-retur-penjualan.print_nota');

                // Retur Pembelian
                Route::resource('/retur-pembelian', ReturPembelianController::class);
                Route::post('/retur-pembelian/data', [ReturPembelianController::class, 'data'])->name('retur-pembelian.data');
                Route::get('/list-retur-pembelian', [ListReturPembelianController::class, 'index'])->name('list-retur-pembelian.index');
                Route::post('/list-retur-pembelian/data/{awal}/{akhir}', [ListReturPembelianController::class, 'getData'])->name('list-retur-pembelian.data');
                Route::get('/list-retur-pembelian/pdf/{awal}/{akhir}', [ListReturPembelianController::class, 'exportPDF'])->name('list-retur-pembelian.export_pdf');
                Route::get('/list-retur-pembelian/nota/{id}', [ListReturPembelianController::class, 'printNota'])->name('list-retur-pembelian.print_nota');


                // Informasi KAS
                Route::resource('kas-masuk', KasMasukController::class);
                Route::post('/kas-masuk/data', [KasMasukController::class, 'data'])->name('kas-masuk.data');

                Route::resource('kas-keluar', KasKeluarController::class);
                Route::post('/kas-keluar/data', [KasKeluarController::class, 'data'])->name('kas-keluar.data');

                // Laporan
                Route::get('/list-pelanggan-terbaik', [LaporanController::class, 'indexBestPelanggan'])->name('list-b-pelanggan.index');
                Route::post('/list-pelanggan-terbaik/data/{awal}/{akhir}', [LaporanController::class, 'getDataBestPelanggan'])->name('list-b-pelanggan.data');
                Route::get('/list-pelanggan-terbaik/download/{awal}/{akhir}', [LaporanController::class, 'DownloadBestPelanggan'])->name('list-b-pelanggan.download');
                Route::get('/list-pelanggan-terbaik/pdf/{awal}/{akhir}', [LaporanController::class, 'PrintPDFBestPelanggan'])->name('list-b-pelanggan.print');

                Route::get('/laporan-kas', [LaporanController::class, 'indexLaporanKas'])->name('laporan-kas.index');
                Route::post('/laporan-kas-masuk/data/{awal}/{akhir}', [LaporanController::class, 'dataLaporanKasMasuk'])->name('laporan-kas-masuk.data');
                Route::post('/laporan-kas-keluar/data/{awal}/{akhir}', [LaporanController::class, 'dataLaporanKasKeluar'])->name('laporan-kas-keluar.data');
                Route::get('/laporan-kas/download/{awal}/{akhir}', [LaporanController::class, 'DownloadKas'])->name('laporan-kas.download');
                Route::get('/laporan-kas/pdf/{awal}/{akhir}', [LaporanController::class, 'PrintPDFKas'])->name('laporan-kas.print');
                
                Route::get('/laporan-penjualan', [LaporanController::class, 'indexLaporanPenjualan'])->name('laporan-penjualan.index');
                Route::post('/laporan-penjualan/data/{awal}/{akhir}', [LaporanController::class, 'dataLaporanPenjualan'])->name('laporan-penjualan.data');
                Route::get('/laporan-penjualan/download/{awal}/{akhir}', [LaporanController::class, 'DownloadPenjualan'])->name('laporan-penjualan.download');
                Route::get('/laporan-penjualan/pdf/{awal}/{akhir}', [LaporanController::class, 'PrintPDFPenjualan'])->name('laporan-penjualan.print');

                Route::get('/laporan-pembelian', [LaporanController::class, 'indexLaporanPembelian'])->name('laporan-pembelian.index');
                Route::post('/laporan-pembelian/data/{awal}/{akhir}', [LaporanController::class, 'dataLaporanPembelian'])->name('laporan-pembelian.data');
                Route::get('/laporan-pembelian/download/{awal}/{akhir}', [LaporanController::class, 'DownloadPembelian'])->name('laporan-pembelian.download');
                Route::get('/laporan-pembelian/pdf/{awal}/{akhir}', [LaporanController::class, 'PrintPDFPembelian'])->name('laporan-pembelian.print');

                Route::get('/laporan-stok', [LaporanController::class, 'indexLaporanStok'])->name('laporan-stok.index');
                Route::post('/laporan-stok/data/{merek}/{kategori}', [LaporanController::class, 'dataLaporanStok'])->name('laporan-stok.data');
                Route::get('/laporan-stok/download/{merek}/{kategori}', [LaporanController::class, 'DownloadStok'])->name('laporan-stok.download');
                Route::get('/laporan-stok/pdf/{merek}/{kategori}', [LaporanController::class, 'PrintPDFStok'])->name('laporan-stok.print');

                Route::get('/laporan-kesesuaian-stok', [LaporanController::class, 'indexLaporanKesesuaianStok'])->name('laporan-kesesuaian-stok.index');
                Route::post('/laporan-kesesuaian-stok/data/{awal}/{akhir}/{merek}/{kategori}', [LaporanController::class, 'dataLaporanKesesuaianStok'])->name('laporan-kesesuaian-stok.data');
                Route::get('/laporan-kesesuaian-stok/download/{awal}/{akhir}/{merek}/{kategori}', [LaporanController::class, 'DownloadKesesuaianStok'])->name('laporan-kesesuaian-stok.download');
                Route::get('/laporan-kesesuaian-stok/pdf/{awal}/{akhir}/{merek}/{kategori}', [LaporanController::class, 'PrintPDFKesesuaianStok'])->name('laporan-kesesuaian-stok.print');
        
                Route::get('/laporan-hutang', [LaporanController::class, 'indexLaporanHutang'])->name('laporan-hutang.index');
                Route::post('/laporan-hutang/data/{awal}/{akhir}', [LaporanController::class, 'dataLaporanHutang'])->name('laporan-hutang.data');
                Route::get('/laporan-hutang/download/{awal}/{akhir}', [LaporanController::class, 'DownloadHutang'])->name('laporan-hutang.download');
                Route::get('/laporan-hutang/pdf/{awal}/{akhir}', [LaporanController::class, 'PrintPDFHutang'])->name('laporan-hutang.print');
                
                Route::get('/laporan-piutang', [LaporanController::class, 'indexLaporanPiutang'])->name('laporan-piutang.index');
                Route::post('/laporan-piutang/data/{awal}/{akhir}', [LaporanController::class, 'dataLaporanPiutang'])->name('laporan-piutang.data');
                Route::get('/laporan-piutang/download/{awal}/{akhir}', [LaporanController::class, 'DownloadPiutang'])->name('laporan-piutang.download');
                Route::get('/laporan-piutang/pdf/{awal}/{akhir}', [LaporanController::class, 'PrintPDFPiutang'])->name('laporan-piutang.print');


                Route::get('/laporan-harian', [LaporanController::class, 'indexLaporanHarian'])->name('laporan-harian.index');
                Route::get('/laporan-harian/download/{awal}/{akhir}', [LaporanController::class, 'DownloadHarian'])->name('laporan-harian.download');
                Route::get('/laporan-harian/pdf/{awal}/{akhir}', [LaporanController::class, 'PrintPDFHarian'])->name('laporan-harian.print');
                Route::post('/laporan-retur-penjualan/data/{awal}/{akhir}', [LaporanController::class, 'dataLaporanReturPenjualan'])->name('laporan-retur-penjualan.data');
                Route::post('/laporan-retur-pembelian/data/{awal}/{akhir}', [LaporanController::class, 'dataLaporanReturPembelian'])->name('laporan-retur-pembelian.data');                
        });

        //Kasir
        Route::group(['prefix' => 'kasir', 'middleware' => 'cek-hak-akses:kasir', 'as' => 'kasir.'], function () {
                Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
                // Transaksi Penjualan
                Route::resource('/transaksi-penjualan', TransaksiPenjualanController::class);
                Route::get('/list-penjualan', [ListTransaksiPenjualanController::class, 'index'])->name('list-transaksi.index');
                Route::post('/list-penjualan/data/{awal}/{akhir}', [ListTransaksiPenjualanController::class, 'getData'])->name('list-transaksi.data');
                Route::get('/list-penjualan/pdf/{awal}/{akhir}', [ListTransaksiPenjualanController::class, 'exportPDF'])->name('list-transaksi.export_pdf');
                
                Route::get('/profile', [UsersController::class, 'profile'])->name('profile');
                Route::post('/profile', [UsersController::class, 'profileUpdate']);
                Route::get('/profile/cards', [UsersController::class, 'card'])->name('profile.cards');

                Route::get('/changePW', [UsersController::class, 'changePW'])->name('changePW');
                Route::post('/changePW', [UsersController::class, 'changePWUpdate']);

                Route::resource('/data-piutang', PiutangController::class);
                Route::get('/data-piutang/nota/{id}', [PiutangController::class, 'printNota'])->name('data-piutang.print_nota');

                Route::resource('/retur-penjualan', ReturPenjualanController::class);
                Route::post('/retur-penjualan/data', [ReturPenjualanController::class, 'data'])->name('retur-penjualan.data');
                Route::get('/list-retur-penjualan', [ListReturPenjualanController::class, 'index'])->name('list-retur-penjualan.index');
                Route::post('/list-retur-penjualan/data/{awal}/{akhir}', [ListReturPenjualanController::class, 'getData'])->name('list-retur-penjualan.data');
                Route::get('/list-retur-penjualan/pdf/{awal}/{akhir}', [ListReturPenjualanController::class, 'exportPDF'])->name('list-retur-penjualan.export_pdf');
                Route::get('/list-retur-penjualan/nota/{id}', [ListReturPenjualanController::class, 'printNota'])->name('list-retur-penjualan.print_nota');

        // Laporan
        //      Route::get('/list-pelanggan-terbaik', [LaporanController::class, 'indexBestPelanggan'])->name('list-b-pelanggan.index');
        //      Route::post('/list-pelanggan-terbaik/data/{awal}/{akhir}', [LaporanController::class, 'getDataBestPelanggan'])->name('list-b-pelanggan.data');
        //      Route::get('/list-pelanggan-terbaik/download/{awal}/{akhir}', [LaporanController::class, 'DownloadBestPelanggan'])->name('list-b-pelanggan.download');
        //      Route::get('/list-pelanggan-terbaik/pdf/{awal}/{akhir}', [LaporanController::class, 'PrintPDFBestPelanggan'])->name('list-b-pelanggan.print');

        });
});

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/', [LoginController::class, 'login']);
Route::get('/register', [LoginController::class, 'reg'])->name('reg');
Route::post('/register', [LoginController::class, 'register'])->name('register');
Route::get('/success', [LoginController::class, 'regSuccess'])->name('regSuccess');
