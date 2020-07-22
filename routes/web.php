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
Route::any('/pdfrepartidores', 'API\DelivererController@PDFDeliverers')->name('descargarPDFDeliverers');
Route::any('/pdfproveedores', 'API\ProviderController@PDFProviders')->name('descargarPDFProvviders');
Route::any('/pdfproductos', 'API\ProductController@PDFProducts')->name('descargarPDFProducts');
Route::any('/pdfentradas', 'API\EntryController@PDFEntries')->name('descargarPDFEntries');
Route::any('/pdfalmacen', 'API\WarehouseMovementController@PDFWarehouseMovements')->name('descargarPDFWarehouseMovements');
Route::any('/pdfventas', 'API\SaleController@PDFSales')->name('descargarPDFSales');
Route::any('/pdfclientes', 'API\CustomerController@PDFCustomers')->name('descargarPDFCustomers');
Route::any('/pdfcreditos', 'API\CreditController@PDFCredits')->name('descargarPDFCredits');
Route::get('/reportes', 'ReporteController@index')->name('reportes');
Route::any('/pdfrutas', 'API\RouteController@PDFRoutes')->name('descargarPDFRoutes');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('{path}','HomeController@index')->where( 'path', '([A-z\/_.\d-]+)?' );

