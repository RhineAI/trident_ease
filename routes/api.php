<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controller\api\UserController;
use App\Http\Controller\api\MerekController;
use App\Http\Controller\api\SatuanController;
use App\Http\Controller\api\BarangControllers;
use App\Http\Controller\api\KategoriController;
use App\Http\Controller\api\SupplierController;
use App\Http\Controller\api\MahasiswaController;
use App\Http\Controller\api\PelangganController;
use App\Http\Controller\api\PenjualanController;
use App\Http\Controller\api\PerusahaanController;


/*
|--------------------------------------------------------------------------
| api Routes
|--------------------------------------------------------------------------
|
| Here is where you can register api routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your api!
|
*/


    
//ROUTE PERUSAHAAN
Route::get('/Perusahaan',  'App\Http\Controllers\api\PerusahaanController@index');
Route::post('Perusahaan/Store',  'App\Http\Controllers\api\PerusahaanController@store');
Route::get('Perusahaan/Show/{id}',  'App\Http\Controllers\api\PerusahaanController@show');
Route::post('Perusahaan/Update/{id}',  'App\Http\Controllers\api\PerusahaanController@update');
Route::get('Perusahaan/Destroy/{id}',  'App\Http\Controllers\api\PerusahaanController@destroy');


//ROUTE SATUAN
Route::get('/Satuan',  'App\Http\Controllers\api\SatuanController@index');
Route::post('/Satuan/Store',  'App\Http\Controllers\api\SatuanController@store');
Route::get('/Satuan/Show/{id}',  'App\Http\Controllers\api\SatuanController@show');
Route::post('/Satuan/Update/{id}',  'App\Http\Controllers\api\SatuanController@update');
Route::get('/Satuan/Destroy/{id}',  'App\Http\Controllers\api\SatuanController@destroy');

//ROUTE KATEGORI
Route::get('/Kategori',  'App\Http\Controllers\api\KategoriController@index');
Route::post('/Kategori/Store',  'App\Http\Controllers\api\KategoriController@store');
Route::get('/Kategori/Show/{id}',  'App\Http\Controllers\api\KategoriController@show');
Route::post('/Kategori/Update/{id}',  'App\Http\Controllers\api\KategoriController@update');
Route::get('/Kategori/Destroy/{id}',  'App\Http\Controllers\api\KategoriController@destroy');

//ROUTE SUPPLIER
//ERROR ON UPDATE SUPPLIER
Route::get('/Supplier',  'App\Http\Controllers\api\SupplierController@index');
Route::post('/Supplier/Update/{id}',  'App\Http\Controllers\api\SupplierController@update');
Route::get('/Supplier/Show/{id}',  'App\Http\Controllers\api\SupplierController@show');
Route::post('/Supplier/Store',  'App\Http\Controllers\api\SupplierController@store');
Route::get('/Supplier/Destroy/{id}',  'App\Http\Controllers\api\SupplierController@destroy');

//ROUTE PELANGGAN
Route::get('/Pelanggan',  'App\Http\Controllers\api\PelangganController@index');
Route::post('/Pelanggan/Store',  'App\Http\Controllers\api\PelangganController@store');
Route::get('/Pelanggan/Show/{id}',  'App\Http\Controllers\api\PelangganController@show');
Route::post('/Pelanggan/Update/{id}',  'App\Http\Controllers\api\PelangganController@update');
Route::get('/Pelanggan/Destroy/{id}',  'App\Http\Controllers\api\PelangganController@destroy');

//ROUTE USER
Route::get('/User', 'App\Http\Controllers\api\UserController@index');
Route::post('/User/Store', 'App\Http\Controllers\api\UserController@store');
Route::get('/User/Show/{id}', 'App\Http\Controllers\api\UserController@show');
Route::post('/User/Update/{id}', 'App\Http\Controllers\api\UserController@update');
Route::get('/User/Destroy/{id}', 'App\Http\Controllers\api\UserController@destroy');

//ROUTE BARANG
Route::get('/Barang', 'App\Http\Controllers\api\BarangController@index');
Route::post('/Barang/Store', 'App\Http\Controllers\api\BarangController@store');
Route::get('/Barang/Show/{id}', 'App\Http\Controllers\api\BarangController@show');
Route::post('/Barang/Update/{id}', 'App\Http\Controllers\api\BarangController@update');
Route::get('/Barang/Destroy/{id}', 'App\Http\Controllers\api\BarangController@destroy');


//ROUTE MEREK
Route::get('/Merek', 'App\Http\Controllers\api\MerekController@index');
Route::post('/Merek/Store', 'App\Http\Controllers\api\MerekController@store');
Route::get('/Merek/Show/{id}', 'App\Http\Controllers\api\MerekController@show');
Route::post('/Merek/Update/{id}', 'App\Http\Controllers\api\MerekController@update');
Route::get('/Merek/Destroy/{id}', 'App\Http\Controllers\api\MerekController@destroy');


//ROUTE TRANSAKSI PENJUALAN
Route::get('/Transaksi/Penjualan', 'App\Http\Controllers\api\PenjualanController@index');
Route::post('/Transaksi/Penjualan/Store', 'App\Http\Controllers\api\PenjualanController@store');
Route::get('/Transaksi/Penjualan', 'App\Http\Controllers\api\PenjualanController@index');
Route::get('/Transaksi/Penjualan', 'App\Http\Controllers\api\PenjualanController@index');
Route::get('/Transaksi/Penjualan', 'App\Http\Controllers\api\PenjualanController@index');


//api LOGIN
Route::post('/Login', 'App\Http\Controllers\api\UserController@login')->name('Login');

//api REGISTER
Route::post('/Register', 'App\Http\Controllers\api\PerusahaanController@store');

//api logout
Route::post('/Logout', 'App\Http\Controllers\api\PerusahaanController@store');