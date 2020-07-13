<?php

namespace App\Http\Controllers\API;

use App\Goal;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use PDF;

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
            'numero_kilos' => $request['numero_kilos'],
            'porcentaje' => $request['porcentaje'],
            'numero_kilos' => $request['numero_kilos'],
            'progreso' => $request['progreso'],
            'bono_entregado' => $request['bono_entregado'],
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
            'numero_kilos' => 'required|Integer',
            'porcentaje' => 'required|Integer',
            'progreso' => 'required|Integer',
            'bono_entregado' => 'required|boolean',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['validation_errors' => $validator->errors()]);
        }

        $goal->update([
            'deliverer_id' => $request['deliverer_id'],
            'numero_kilos' => $request['numero_kilos'],
            'nombre_producto' => $request['nombre_producto'],
            'numero_kilos' => $request['numero_kilos'],
            'progreso' => $request['progreso'],
            'bono_entregado' => $request['bono_entregado'],
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
    //Se crea una funcion que llama los datos de la base de datos y los muestra en un pdf de forma horizontal
    public function PDFGoals(){
        $goals = Goal::all();
        $pdf = PDF::loadView('goals', compact('goals'));
        return $pdf->setPaper('a4', 'landscape')->stream('goals.pdf');
    }
}
