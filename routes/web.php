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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/pesan', 'PesanController@index');

Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/uploadfile', 'uploadController@index');
    Route::post('/uploadfile', 'uploadController@insert');

    Route::get('/menu', 'MenuController@index');

    Route::get('/kasir', 'KasirController@index');
    Route::post('/kasir/create', 'KasirController@create');
    Route::get('/kasir/{id}/edit', 'KasirController@edit');
    Route::post('/kasir/{id}/update', 'KasirController@update');
    Route::get('/kasir/{id}/delete', 'KasirController@delete');


    Route::get('/slider', 'SliderController@index');
    Route::post('/slider/create', 'SliderController@create');
    Route::get('/slider/{id}/edit', 'SliderController@edit');
    Route::post('/slider/{id}/update', 'SliderController@update');
    Route::get('/slider/{id}/delete', 'SliderController@delete');

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/home/{id}/struk', 'HomeController@edit');
    Route::get('/home/{id}/cetak_pdf', 'HomeController@cetak_pdf');
    Route::post('/home/{id}/update', 'HomeController@update');


    Route::get('laporan', 'LaporanController@index');
    Route::get('/laporan/cetak_pdf', 'LaporanController@cetak_pdf');

    Route::get('home/{id}/cetak_struk', 'HomeController@cetak_pdf');

    Route::get('approve/{id_transaksi}', 'TransaksiController@approve')->name('approve');
    Route::get('reject/{id_transaksi}', 'TransaksiController@reject')->name('reject');
});


Route::middleware(['auth'])->group(function () {

    Route::get('/customer/home', 'CustomerController@index');

    Route::post('/customer/upload/bukti/{id_transaksi}', 'CustomerController@uploadBukti');

    Route::post('/pesan/create', 'PesanController@create');
});


// Route::get('siswa','SiswaController@index');
// Route::post('/siswa/create','SiswaController@create');
// Route::get('/siswa/{id}/edit','SiswaController@edit');
// Route::post('/siswa/{id}/update','SiswaController@update');
// Route::get('/siswa/{id}/delete','SiswaController@delete');

// Route::get('buku','BukuController@index');




// Route::get('laporan_struk', 'HomeController@index');
Auth::routes();
