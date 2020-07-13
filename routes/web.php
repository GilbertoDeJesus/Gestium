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
Route::post('repartidores', function () {
    return request('picker');
});
Route::get('/pdfproductos', 'API\ProductController@PDFProducts')->name('descargarPDFProducts');
Route::get('/pdfentradas', 'API\EntryController@PDFEntries')->name('descargarPDFEntries');
Route::get('/pdfalmacen', 'API\WarehouseMovementController@PDFWarehouseMovements')->name('descargarPDFWarehouseMovements');
Route::get('/pdfventas', 'API\SaleController@PDFSales')->name('descargarPDFSales');
Route::get('/pdfmetas', 'API\GoalController@PDFGoals')->name('descargarPDFGoals');
Route::get('/pdfgastos', 'API\ExpenseController@PDFExpenses')->name('descargarPDFExpenses');
Route::get('/pdfclientes', 'API\CustomerController@PDFCustomers')->name('descargarPDFCustomers');
Route::get('/pdfcreditos', 'API\CreditController@PDFCredits')->name('descargarPDFCredits');
Route::get('/reportes', 'ReporteController@index')->name('reportes');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('{path}','HomeController@index')->where( 'path', '([A-z\/_.\d-]+)?' );

