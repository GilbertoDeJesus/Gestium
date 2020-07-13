<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Obtenemos y devolvemos las unidades de medida registradas
        return Unit::get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Creamos y devolvemos una nueva unidad de medida con los datos obtenidos en el "$request"
        return Unit::create([
            'tipo' => $request['tipo'],
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
        //Buscamos una unidad de medida que en su campo "id" coincida con el "id" obtenido
        $unit = Unit::findOrFail($id);

        //Validamos la información de la entrada
        $validator = Validator::make( $request->all(), [
            'tipo' => 'required|max:40',
            ]
        );

        //Si hay un error enviamos un mensaje con el error
        if ($validator->fails()) {
            return response()->json(['validation_errors' => $validator->errors()]);
        }

        //Actualizamos la unidad encontrada
        $unit->update([

            'tipo' => $request['tipo']

        ]);

        //Devolvemos la unidad de medida actualizada
        return $unit;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Eliminamos la unidad de medida que en su campo "id" coincida con el "id" obtenido.
        $unit = Unit::findOrFail($id);
        $unit->delete();
    }
}
