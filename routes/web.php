<?php

//SUPER ADMIN
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\PDFController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MerekController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\HutangController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PiutangController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KasMasukController;

// Informasi Kas
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SupplierController;

// Transaksi
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KasKeluarController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\KeuntunganController;
use App\Http\Controllers\LaporanBugController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\StokOpnameController;

use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\ExcelLaporanController;
use App\Http\Controllers\ReturPembelianController;
use App\Http\Controllers\ReturPenjualanController;
use App\Http\Controllers\DetailPembelianController;
use App\Http\Controllers\DetailPenjualanController;
use App\Http\Controllers\ListReturPembelianController;
use App\Http\Controllers\ListReturPenjualanController;

// Ujikom
use App\Http\Controllers\PenjualanAksesorisController;

// Import
use App\Http\Controllers\TransaksiPenjualanController;
use App\Http\Controllers\ListTransaksiPembelianController;
use App\Http\Controllers\ListTransaksiPenjualanController;


Route::middleware(['auth'])->group(function () {
        Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
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
                Route::patch('/manage-perusahaan/perbarui/{id}', [SuperAdminController::class, 'perbarui'])->name('manage.perbarui');
                Route::post('/manage-perusahaan/data', [SuperAdminController::class, 'table'])->name('manage.data');
                Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

                // Route::get('/migrate', function(){
                //         Artisan::call('migrate:fresh', [
                //                 '--force' => true
                //         ]);
                //         Artisan::call('db:seed', [
                //                 '--force' => true
                //         ]);
                //         return 'Migration success!';
                // });
                
        });

        Route::group(['prefix' => 'owner', 'middleware' => 'cek-hak-akses:owner', 'as' => 'owner.'], function () {
                Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
                Route::resource('/kategori', KategoriController::class);
                Route::resource('/merek', MerekController::class);
                Route::resource('/satuan', SatuanController::class);
                Route::resource('/perusahaan', PerusahaanController::class);    

                Route::resource('/users', UsersController::class);
                Route::get('/users-tambah', [UsersController::class, 'index2'])->name('pegawai2');
                Route::post('/users-tambah', [UsersController::class, 'store']);
                Route::get('/profile', [UsersController::class, 'profile'])->name('profile');
                Route::post('/profile', [UsersController::class, 'profileUpdate']);
                Route::get('/profile/cards', [UsersController::class, 'card'])->name('profile.cards');
                Route::post('/username', [UsersController::class, 'getUsername'])->name('getUsername');

                Route::get('/changePW', [UsersController::class, 'changePW'])->name('changePW');
                Route::post('/changePW', [UsersController::class, 'changePWUpdate']);

                Route::get('/keuntungan', [KeuntunganController::class, 'index'])->name('keuntungan');
                Route::post('/keuntungan', [KeuntunganController::class, 'store'])->name('keuntungan.store');
                
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

                Route::post('/laporan-stok', [LaporanController::class, 'indexLaporanStok'])->name('laporan-stok.index');
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
                
                // Export Excel LAPORAN 
                Route::get('/download-laporan-kas/{awal}/{akhir}', [ExcelLaporanController::class, 'downloadLaporanKas'])->name('download.laporanKas');
                Route::get('/download-laporan-penjualan/{awal}/{akhir}', [ExcelLaporanController::class, 'downloadLaporanPenjualan'])->name('download.laporanPenjualan');
                Route::get('/download-laporan-pembelian/{awal}/{akhir}', [ExcelLaporanController::class, 'downloadLaporanPembelian'])->name('download.laporanPembelian');
                Route::get('/download-laporan-stok/{merek}/{kategori}', [ExcelLaporanController::class, 'downloadLaporanStok'])->name('download.laporanStok');
                Route::get('/download-laporan-pelanggan-terbaik/{awal}/{akhir}', [ExcelLaporanController::class, 'downloadLaporanPelangganTerbaik'])->name('download.laporanPelangganTerbaik');
                Route::get('/download-laporan-stok-opname/{awal}/{akhir}/{merek}/{kategori}', [ExcelLaporanController::class, 'downloadLaporanStockOpname'])->name('download.laporanStockOpname');
                Route::get('/download-laporan-hutang/{awal}/{akhir}', [ExcelLaporanController::class, 'downloadLaporanHutang'])->name('download.laporanHutang');
                Route::get('/download-laporan-piutang/{awal}/{akhir}', [ExcelLaporanController::class, 'downloadLaporanPiutang'])->name('download.laporanPiutang');
                Route::get('/download-laporan-harian/{awal}/{akhir}', [ExcelLaporanController::class, 'downloadLaporanHarian'])->name('download.laporanHarian');
        });

        Route::group(['prefix' => 'admin', 'middleware' => 'cek-hak-akses:admin', 'as' => 'admin.'], function () {
                Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
                
                // UJI KOM
                // Route::get('/penjualan-aksesoris', [PenjualanAksesorisController::class, 'index'])->name('penjualan-aksesoris');
                // Route::resource('/laporan-bug', LaporanBugController::class);
                // Route::get('/export-pdf', [LaporanBugController::class, 'pdf'])->name('export-bug.pdf');
                // Route::get('/export-excel', [LaporanBugController::class, 'excel'])->name('export-bug.excel');
                // Route::post('/laporan-bug/import', [LaporanBugController::class, 'importBug'])->name('import-bug');

                Route::resource('/kategori', KategoriController::class);
                Route::resource('/merek', MerekController::class);
                Route::resource('/satuan', SatuanController::class);
                Route::resource('/perusahaan', PerusahaanController::class);    

                Route::resource('/barang', BarangController::class);
                Route::get('/barang-konsinyasi', [BarangController::class, 'indexBarangKonsinyasi'])->name('barang.indexKonsinyasi');
                Route::get('/barang-tambah', [BarangController::class, 'index2'])->name('barang2');
                Route::post('/barang-tambah', [BarangController::class, 'store']);
                Route::post('/barang/data', [BarangController::class, 'data'])->name('barang.data');
                Route::post('/barang-konsinyasi/data', [BarangController::class, 'dataKonsinyasi'])->name('barang.dataKonsinyasi');
                Route::get('/import-barang', [ImportController::class, 'viewBarangImport'])->name('importBarang');
                Route::get('/download-data-barang', [BarangController::class, 'downloadBarang'])->name('download.data-barang');
                Route::post('/import-barang', [ImportController::class, 'barangImport'])->name('postImport');
                Route::get('/download-template', [ImportController::class, 'downloadTemplate'])->name('download.template');

                // Export Excel LAPORAN 
                Route::get('/download-laporan-kas/{awal}/{akhir}', [ExcelLaporanController::class, 'downloadLaporanKas'])->name('download.laporanKas');
                Route::get('/download-laporan-penjualan/{awal}/{akhir}', [ExcelLaporanController::class, 'downloadLaporanPenjualan'])->name('download.laporanPenjualan');
                Route::get('/download-laporan-pembelian/{awal}/{akhir}', [ExcelLaporanController::class, 'downloadLaporanPembelian'])->name('download.laporanPembelian');
                Route::get('/download-laporan-stok/{merek}/{kategori}', [ExcelLaporanController::class, 'downloadLaporanStok'])->name('download.laporanStok');
                Route::get('/download-laporan-pelanggan-terbaik/{awal}/{akhir}', [ExcelLaporanController::class, 'downloadLaporanPelangganTerbaik'])->name('download.laporanPelangganTerbaik');
                Route::get('/download-laporan-stok-opname/{awal}/{akhir}/{merek}/{kategori}', [ExcelLaporanController::class, 'downloadLaporanStockOpname'])->name('download.laporanStockOpname');
                Route::get('/download-laporan-hutang/{awal}/{akhir}', [ExcelLaporanController::class, 'downloadLaporanHutang'])->name('download.laporanHutang');
                Route::get('/download-laporan-piutang/{awal}/{akhir}', [ExcelLaporanController::class, 'downloadLaporanPiutang'])->name('download.laporanPiutang');
                Route::get('/download-laporan-harian/{awal}/{akhir}', [ExcelLaporanController::class, 'downloadLaporanHarian'])->name('download.laporanHarian');

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

                Route::post('/username', [UsersController::class, 'getUsername'])->name('getUsername');


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

                Route::post('/barcode/data', [TransaksiPenjualanController::class, 'data'])->name('barcode.data');
                Route::post('/barcodePembelian/data', [PembelianController::class, 'data'])->name('barcodePembelian.data');

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
                Route::get('/list-penjualan/nota/{id}', [ListTransaksiPenjualanController::class, 'printNota'])->name('list-transaksi.print_nota');

                // barcode
                Route::post('/barcode/data', [TransaksiPenjualanController::class, 'data'])->name('barcode.data');
                Route::post('/barcodePembelian/data', [PembelianController::class, 'data'])->name('barcodePembelian.data');

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

                Route::resource('/pelanggan', PelangganController::class);
                Route::get('/pelanggan-tambah', [PelangganController::class, 'index2'])->name('pelanggan2');
                Route::post('/pelanggan-tambah', [PelangganController::class, 'store']);
                // Laporan
                //      Route::get('/list-pelanggan-terbaik', [LaporanController::class, 'indexBestPelanggan'])->name('list-b-pelanggan.index');
                //      Route::post('/list-pelanggan-terbaik/data/{awal}/{akhir}', [LaporanController::class, 'getDataBestPelanggan'])->name('list-b-pelanggan.data');
                //      Route::get('/list-pelanggan-terbaik/download/{awal}/{akhir}', [LaporanController::class, 'DownloadBestPelanggan'])->name('list-b-pelanggan.download');
                //      Route::get('/list-pelanggan-terbaik/pdf/{awal}/{akhir}', [LaporanController::class, 'PrintPDFBestPelanggan'])->name('list-b-pelanggan.print');

        });

        Route::get('/route-clear', function() {
                Artisan::call('route:clear');
                return 'Route cache cleared!';
        });
        
        Route::get('/config-clear', function() {
                Artisan::call('config:clear'); 
                return 'Configuration cache cleared!';
        });
        
        Route::get('/cache-clear', function() {
                Artisan::call('cache:clear'); 
                return 'Cache cleared!';
        });
});

Route::post('/getPerusahaan', [PerusahaanController::class, 'getPerusahaan'])->name('getPerusahaan');
Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/', [LoginController::class, 'login']);
Route::get('/register', [LoginController::class, 'reg'])->name('reg');
Route::post('/register', [LoginController::class, 'register'])->name('register');
Route::get('/register/success/{id}/{token}', [LoginController::class, 'regSuccess'])->name('regSuccess');
Route::get('/contact-us', [LoginController::class, 'contactUs']);

Route::get('/route-clear', function() {
        Artisan::call('route:clear');
        return 'Route cache cleared!';
});

Route::get('/config-clear', function() {
        Artisan::call('config:clear'); 
        return 'Configuration cache cleared!';
});

Route::get('/optimize', function () {
        Artisan::call('optimize');
        return 'Optimization Complete';
});

Route::get('/cache-clear', function() {
        Artisan::call('cache:clear'); 
        return 'Cache cleared!';
});
