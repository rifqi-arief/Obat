<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//view
Route::get('/login', 'ViewController@index');
Route::get('/registration', 'ViewController@registration');
Route::get('/produk', 'ViewController@dashboard');
Route::get('/shop', 'ViewController@shop');
Route::get('/detail-produk', 'ViewController@detailProduk');
Route::get('/keranjang', 'ViewController@keranjang');
Route::get('/pelanggan', 'ViewController@pelanggan');
Route::get('/transaksi', 'ViewController@transaksi');

//User
Route::post('/register', 'UserController@addUser')->name('registration-action');
Route::post('/login', 'UserController@login')->name('login-action');
Route::post('/edit-user', 'UserController@EditUser');
Route::post('/delete-user', 'UserController@deleteUser');
Route::get('/get-all-user', 'UserController@getAllUser');
Route::get('/get-detail-user/{id_user}', 'UserController@getDetailUser');

//Product
Route::post('/add-produk', 'ProdukController@addProduk')->name('add-produk' );
Route::post('/edit-produk', 'ProdukController@EditProduk');
Route::post('/delete-produk', 'ProdukController@deleteProduk');
Route::get('/get-all-produk', 'ProdukController@getAllProduk')->name('get-all-produk');
Route::get('/get-all-produk-shop', 'ProdukController@getAllProdukShop')->name('get-all-produk-shop');
Route::get('/get-detail-produk/{id_produk}', 'ProdukController@getDetailProduk');

//Keranjang
Route::post('/add-keranjang', 'KeranjangController@addKeranjang');
Route::post('/edit-keranjang', 'KeranjangController@editKeranjang');
Route::get('/delete-keranjang/{id_keranjang}', 'KeranjangController@deleteKeranjang');
Route::get('/get-all-keranjang/{id_user}', 'KeranjangController@getAllKeranjang');

//Transaksi
Route::post('/add-transaksi', 'TransaksiController@addTransaksi');
Route::post('/upload-bukti-bayar', 'TransaksiController@uploadBuktiBayar');
Route::post('/edit-status', 'TransaksiController@editStatus');
Route::get('/get-all-transaksi/{id_user}', 'TransaksiController@getAllTransaksi');
Route::get('/get-detail-transaksi/{id_transaksi}', 'TransaksiController@getDetailTransaksi');
Route::get('/get-all-pembayaran/', 'TransaksiController@getAllPembayaran');
Route::get('/get-detail-pembayaran/{id_transaksi}', 'TransaksiController@getDetailPembayaran');
