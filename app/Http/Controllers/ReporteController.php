<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReporteController extends Controller
//Retorna a la pagina dashboard1 
{
    public function index()
    {
        return view('dashboard1');
    }
}
