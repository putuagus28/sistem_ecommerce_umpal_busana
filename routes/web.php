<?php

use Illuminate\Support\Facades\Route;

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


Route::get('/', 'FrontEndController@index')->name('home');
Route::get('/produk/detail/{id}', 'FrontEndController@detail')->name('produk.detail');
Route::get('/contact-us', 'FrontEndController@contact')->name('contact');
Route::get('/product/search', 'FrontEndController@search')->name('search');
Route::post('/kirimemail', 'DashboardController@email');


/** admin */
Route::middleware(['auth:admin', 'ceklevel:admin'])->group(function () {
    /** dashboard*/
    Route::get('admin/dashboard', 'DashboardController@index')->name('admin.dashboard');
    Route::get('admin/chart', 'DashboardController@chart')->name('admin.chart');
    Route::get('chart2', 'DashboardController@chart2')->name('chart2');
    /** admin*/
    Route::get('user', 'AdminController@index')->name('user');
    Route::post('user', 'AdminController@index')->name('json.user');
    Route::get('user/edit', 'AdminController@edit')->name('edit.user');
    Route::post('user/insert', 'AdminController@insert')->name('insert.user');
    Route::post('user/update', 'AdminController@update')->name('update.user');
    /** pelanggan*/
    Route::get('pelanggan', 'PelangganController@index')->name('pelanggan');
    Route::post('pelanggan', 'PelangganController@index')->name('json.pelanggan');
    Route::get('pelanggan/edit', 'PelangganController@edit')->name('edit.pelanggan');
    Route::post('pelanggan/insert', 'PelangganController@insert')->name('insert.pelanggan');
    Route::post('pelanggan/update', 'PelangganController@update')->name('update.pelanggan');
    /** kategori*/
    Route::get('kategori', 'KategoriController@index')->name('kategori');
    Route::post('kategori', 'KategoriController@index')->name('json.kategori');
    Route::get('kategori/edit', 'KategoriController@edit')->name('edit.kategori');
    Route::post('kategori/insert', 'KategoriController@insert')->name('insert.kategori');
    Route::post('kategori/update', 'KategoriController@update')->name('update.kategori');
    /** produk*/
    Route::get('general/produk', 'ProdukController@index')->name('produk');
    Route::post('general/produk', 'ProdukController@index')->name('json.produk');
    Route::get('produk/edit', 'ProdukController@edit')->name('edit.produk');
    Route::post('produk/insert', 'ProdukController@insert')->name('insert.produk');
    Route::post('produk/update', 'ProdukController@update')->name('update.produk');
    Route::post('produk/update/stok', 'ProdukController@update_stok')->name('update.stok');
    /** auditstok*/
    Route::get('auditstok', 'StokOpnameController@index')->name('auditstok');
    Route::post('auditstok', 'StokOpnameController@index')->name('json.auditstok');
    Route::get('auditstok/edit', 'StokOpnameController@edit')->name('edit.auditstok');
    Route::post('auditstok/insert', 'StokOpnameController@insert')->name('insert.auditstok');
    Route::post('auditstok/update', 'StokOpnameController@update')->name('update.auditstok');
    /** pesanan*/
    Route::get('general/pesanan', 'PesananController@index')->name('pesanan');
    Route::post('general/pesanan', 'PesananController@index')->name('json.pesanan');
    Route::get('pesanan/update_status', 'PesananController@update_status')->name('update.status.pesanan');
    /** laporan */
    Route::get('laporan/{jenis}', 'LaporanController@index')->name('laporan');
    Route::get('laporan-pdf/{jenis}/{periode}/{id?}/{ukm?}', 'LaporanController@generatePDF')->name('laporan-pdf');
    Route::post('laporan', 'LaporanController@getLaporan')->name('post.laporan');
});

/** pelanggan */
Route::middleware(['auth:pelanggan', 'ceklevel:pelanggan'])->group(function () {
    /** dashboard*/
    Route::get('pelanggan/dashboard', 'DashboardController@index')->name('pelanggan.dashboard');
    Route::get('pelanggan/dashboard/transaksi', 'DashboardController@transaksi')->name('pelanggan.transaksi');
    Route::post('pelanggan/batalkan/transaksi', 'DashboardController@batalkan')->name('pelanggan.batalkan');
    Route::post('pelanggan/uploadbukti', 'DashboardController@uploadbukti')->name('pelanggan.uploadbukti');
    /** profile*/
    Route::get('pelanggan/setting/profile', 'DashboardController@profile')->name('pelanggan.profile');
    Route::post('pelanggan/setting/profile', 'DashboardController@profile')->name('pelanggan.post.profile');
});

/** semua */
Route::middleware(['auth:admin,pelanggan', 'ceklevel:admin,pelanggan'])->group(function () {
    Route::get('cart', 'FrontEndController@cart')->name('cart');
    Route::get('cart/checkout', 'Carts@checkout')->name('cart.checkout');
    Route::post('cart/checkout', 'Carts@checkout_submit')->name('submit.checkout');
    Route::post('cart', 'Carts@addToCart')->name('post.cart');
    Route::get('cart/{id}', 'Carts@removeOne');
    Route::get('cart/{act}/{id}', 'Carts@action');

    /** detail pesanan admin & pelanggan */
    Route::get('pesanan/detail', 'PesananController@detail')->name('detail.pesanan');

    Route::post('ongkir', 'CheckOngkirController@check_ongkir');
    Route::get('cities/{province_id}', 'CheckOngkirController@getCities');
});

// Login
Route::middleware(['guest'])->group(function () {
    Route::get('admin/login', 'LoginController@getLogin')->name('login');
    Route::get('login', 'LoginController@getLogin_member')->name('login.member');
    Route::get('register', 'LoginController@getRegister_member')->name('register.member');
    Route::post('register', 'LoginController@registerMember')->name('postregister.member');
    Route::post('admin/login', 'LoginController@postLogin');
});

Route::middleware(['auth:admin,pelanggan'])->group(function () {
    Route::get('logout', 'LoginController@logout')->name('logout');
});
