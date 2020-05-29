<?php

namespace App\Http\Controllers\API;

use App\Deliverer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DelivererController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Deliverer::get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return Deliverer::create([
            'nombre' => $request['nombre'],
            'aPaterno' => $request['aPaterno'],
            'aMaterno' => $request['aMaterno'],
            'fecha_nacimiento' => $request['fecha_nacimiento'],
            'fecha_contratacion' => $request['fecha_contratacion'],
            'telfono' => $request['telfono'],
            'email' => $request['email']
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
