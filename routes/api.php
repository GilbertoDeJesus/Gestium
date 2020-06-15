<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources([
    'users' => 'API\UsersController',
    'customers' => 'API\CustomerController',
    'routes' => 'API\RouteController',
    'goals' => 'API\GoalController',
    'deliverers' => 'API\DelivererController',
    'expenses' => 'API\ExpenseController',
    'depurates' => 'API\DepurateController',
    'sales' => 'API\SaleController',
    'credits' => 'API\CreditController',
    'products'=> 'API\ProductController',
    'entries'=> 'API\EntryController',
    'providers' => 'API\ProviderController',
    'units' => 'API\UnitController'


]);

/* oute::post('login', 'API\AuthController@login')->name('get-token');
Route::post('register', 'API\AuthController@register');
Route::middleware('auth:api')->post('logout', 'API\AuthController@logout'); */
