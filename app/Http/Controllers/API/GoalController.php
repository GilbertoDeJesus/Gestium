<?php

namespace App\Http\Controllers\API;

use App\Goal;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class GoalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Goal::get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return Goal::create([
            'deliverer_id' => $request['deliverer_id'],
            'producto_meta' => $request['producto_meta'],
            'nombre_producto' => $request['nombre_producto'],
            'numero_kilos' => $request['numero_kilos']
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
        $goal = goal::findOrFail($id);

        $validator = Validator::make( $request->all(), [
            'deliverer_id' => 'required|Integer',
            'producto_meta' => 'required|boolean',
            'nombre_producto' => 'required|max:200',
            'numero_kilos' => 'required|Integer',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['validation_errors' => $validator->errors()]);
        }

        $goal->update([
            'deliverer_id' => $request['deliverer_id'],
            'producto_meta' => $request['producto_meta'],
            'nombre_producto' => $request['nombre_producto'],
            'numero_kilos' => $request['numero_kilos'],
        ]);

        return$goal;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $goal = goal::findOrFail($id);
        $goal->update([
            'status' => false,
        ]);
    }
}
