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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/pdfrepartidores', 'API\DelivererController@PDFDeliverers')->name('descargarPDFDeliverers');
Route::get('/pdfproductos', 'API\ProductController@PDFProducts')->name('descargarPDFProducts');
Route::get('/pdfentradas', 'API\EntryController@PDFEntries')->name('descargarPDFEntries');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('{path}','HomeController@index')->where( 'path', '([A-z\/_.\d-]+)?' );

