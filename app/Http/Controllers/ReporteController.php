<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Deliverer;
use App\Product;
use App\Provider;
use App\Route;
use Illuminate\Http\Request;

class ReporteController extends Controller
//Retorna a la pagina dashboard1 
{
    public function index()
    {
        $route = Route::all();
        $customer = Customer::all();
        $product = Product::all();
        $provider = Provider::all();
        $deliverers = Deliverer::all();
        return view('dashboard1', compact('deliverers', 'provider', 'product', 'customer', 'route'));
    }
}
