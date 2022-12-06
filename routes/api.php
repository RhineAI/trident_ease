<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controller\API\UserController;
use App\Http\Controller\API\MerekController;
use App\Http\Controller\API\SatuanController;
use App\Http\Controller\API\BarangControllers;
use App\Http\Controller\API\KategoriController;
use App\Http\Controller\API\SupplierController;
use App\Http\Controller\API\MahasiswaController;
use App\Http\Controller\API\PelangganController;
use App\Http\Controller\API\PenjualanController;
use App\Http\Controller\API\PerusahaanController;


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

// Route::middleware(['auth'])->group(function () {
    
//ROUTE PERUSAHAAN
Route::get('/Perusahaan',  'App\Http\Controllers\API\PerusahaanController@index');
Route::post('Perusahaan/Store',  'App\Http\Controllers\API\PerusahaanController@store');
Route::get('Perusahaan/Show/{id}',  'App\Http\Controllers\API\PerusahaanController@show');
Route::post('Perusahaan/Update/{id}',  'App\Http\Controllers\API\PerusahaanController@update');
Route::get('Perusahaan/Destroy/{id}',  'App\Http\Controllers\API\PerusahaanController@destroy');


//ROUTE SATUAN
Route::get('/Satuan',  'App\Http\Controllers\API\SatuanController@index');
Route::post('/Satuan/Store',  'App\Http\Controllers\API\SatuanController@store');
Route::get('/Satuan/Show/{id}',  'App\Http\Controllers\API\SatuanController@show');
Route::post('/Satuan/Update/{id}',  'App\Http\Controllers\API\SatuanController@update');
Route::get('/Satuan/Destroy/{id}',  'App\Http\Controllers\API\SatuanController@destroy');

//ROUTE KATEGORI
Route::get('/Kategori',  'App\Http\Controllers\API\KategoriController@index');
Route::post('/Kategori/Store',  'App\Http\Controllers\API\KategoriController@store');
Route::get('/Kategori/Show/{id}',  'App\Http\Controllers\API\KategoriController@show');
Route::post('/Kategori/Update/{id}',  'App\Http\Controllers\API\KategoriController@update');
Route::get('/Kategori/Destroy/{id}',  'App\Http\Controllers\API\KategoriController@destroy');

//ROUTE SUPPLIER
//ERROR ON UPDATE SUPPLIER
Route::get('/Supplier',  'App\Http\Controllers\API\SupplierController@index');
Route::post('/Supplier/Update/{id}',  'App\Http\Controllers\API\SupplierController@update');
Route::get('/Supplier/Show/{id}',  'App\Http\Controllers\API\SupplierController@show');
Route::post('/Supplier/Store',  'App\Http\Controllers\API\SupplierController@store');
Route::get('/Supplier/Destroy/{id}',  'App\Http\Controllers\API\SupplierController@destroy');

//ROUTE PELANGGAN
Route::get('/Pelanggan',  'App\Http\Controllers\API\PelangganController@index');
Route::post('/Pelanggan/Store',  'App\Http\Controllers\API\PelangganController@store');
Route::get('/Pelanggan/Show/{id}',  'App\Http\Controllers\API\PelangganController@show');
Route::post('/Pelanggan/Update/{id}',  'App\Http\Controllers\API\PelangganController@update');
Route::get('/Pelanggan/Destroy/{id}',  'App\Http\Controllers\API\PelangganController@destroy');

//ROUTE USER
Route::get('/User', 'App\Http\Controllers\API\UserController@index');
Route::post('/User/Store', 'App\Http\Controllers\API\UserController@store');
Route::get('/User/Show/{id}', 'App\Http\Controllers\API\UserController@show');
Route::post('/User/Update/{id}', 'App\Http\Controllers\API\UserController@update');
Route::get('/User/Destroy/{id}', 'App\Http\Controllers\API\UserController@destroy');

//ROUTE BARANG
Route::get('/Barang', 'App\Http\Controllers\API\BarangController@index');
Route::post('/Barang/Store', 'App\Http\Controllers\API\BarangController@store');
Route::get('/Barang/Show/{id}', 'App\Http\Controllers\API\BarangController@show');
Route::post('/Barang/Update/{id}', 'App\Http\Controllers\API\BarangController@update');
Route::get('/Barang/Destroy/{id}', 'App\Http\Controllers\API\BarangController@destroy');


//ROUTE MEREK
Route::get('/Merek', 'App\Http\Controllers\API\MerekController@index');
Route::post('/Merek/Store', 'App\Http\Controllers\API\MerekController@store');
Route::get('/Merek/Show/{id}', 'App\Http\Controllers\API\MerekController@show');
Route::post('/Merek/Update/{id}', 'App\Http\Controllers\API\MerekController@update');
Route::get('/Merek/Destroy/{id}', 'App\Http\Controllers\API\MerekController@destroy');


//ROUTE TRANSAKSI PENJUALAN
Route::get('/Transaksi/Penjualan', 'App\Http\Controllers\API\PenjualanController@index');
Route::post('/Transaksi/Penjualan/Store', 'App\Http\Controllers\API\PenjualanController@store');
Route::get('/Transaksi/Penjualan', 'App\Http\Controllers\API\PenjualanController@index');
Route::get('/Transaksi/Penjualan', 'App\Http\Controllers\API\PenjualanController@index');
Route::get('/Transaksi/Penjualan', 'App\Http\Controllers\API\PenjualanController@index');

// });

//API LOGIN
Route::post('/Login', 'App\Http\Controllers\API\UserController@login');

//API REGISTER
Route::post('/Register', 'App\Http\Controllers\API\PerusahaanController@store');