<?php

namespace App\Http\Controllers\API;

use App\Deliverer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DelivererController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Deliverer::where('status','=','1')->get();
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
            'telefono' => $request['telefono'],
            'email' => $request['email'],
            'status' => true
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


    }
    public function getdelivererlist($id_route){
        return Deliverer::join('deliverer_route',
        'deliverer_route.deliverer_id','=','deliverers.id')
        ->select('deliverer_route.route_id','deliverers.nombre','deliverer_route.created_at')
        ->where('deliverer_route.route_id', '=',$id_route)
        ->where('deliverers.status',"=",1)
        ->get();
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
        $deliverer = Deliverer::findOrFail($id);

        $validator = Validator::make( $request->all(), [
            'nombre' => 'required|min:3',
            'aPaterno' => 'required|min:3',
            'aMaterno' => 'required|min:3',
            'fecha_nacimiento' => 'nullable|date',
            'fecha_contratacion' => 'required|date',
            'telefono' => 'nullable',
            'email' => 'nullable|email',

        ]);

        if ($validator->fails()) {
            return response()->json(['validation_errors' => $validator->errors()]);
        }
        $deliverer->update([
            'nombre' => $request['nombre'],
            'aPaterno' => $request['aPaterno'],
            'aMaterno' => $request['aMaterno'],
            'fecha_nacimiento' => $request['fecha_nacimiento'],
            'fecha_contratacion' => $request['fecha_contratacion'],
            'telefono' => $request['telefono'],
            'email' => $request['email'],
        ]);

        return$deliverer;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deliverer = deliverer::findOrFail($id);
        $deliverer->update([
            'status' => false,
        ]);
    }
}
