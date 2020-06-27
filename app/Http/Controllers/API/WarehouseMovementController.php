<?php

namespace App\Http\Controllers\API;

use App\WarehouseMovement;
use App\Http\Controllers\Controller;
use App\WarehouseMovementProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WarehouseMovementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return WarehouseMovement::with('Deliverer')->get();
       // return WarehouseMovement::get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return WarehouseMovement::create([
            'deliverer_id' => $request['deliverer_id'],
            'fecha_salida' => $request['fecha_salida'],
        ]);
        $movement= WarehouseMovement::create([
            'deliverer_id' => $request['deliverer_id'],
            'fecha_salida' => $request['fecha_salida']
        ]);
        $movement->get();
        $movementproduct= WarehouseMovementProduct::create([
            'product_id'=>$request['product_id'],
            'warehouse_movement_id'=>$movement['id'],
            'cantidad'=>$request['cantidad'],
            'tipoMovimineto'=>$request['tipoMovimiento']
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
        $warehousemovement = WarehouseMovement::findOrFail($id);

        $validator = Validator::make( $request->all(), [
            'deliverer_id' => 'required|Integer',
            'fecha_salida' => 'required|date',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['validation_errors' => $validator->errors()]);
        }

        $warehousemovement->update([
            'deliverer_id' => $request['deliverer_id'],
            'fecha_salida' => $request['fecha_salida'],
        ]);

        return$warehousemovement;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $warehousemovement = WarehouseMovement::findOrFail($id);
        $warehousemovement->update([
            'status' => false,
        ]);
    }
}
