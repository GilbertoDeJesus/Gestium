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
        //return  WarehouseMovement::with('Deliverer:id,nombre')->get();
       return  WarehouseMovement::with('Deliverer:id,nombre')
       ->join('product_warehouse_movement','warehouse_movements.id','=','product_warehouse_movement.warehouse_movement_id')
       ->select('warehouse_movements.deliverer_id', 'product_warehouse_movement.cantidad', 'product_warehouse_movement.product_id')
       ->get();
      /*return  WarehouseMovementProduct::join('products',"product_warehouse_movement.product_id",'=','products.id')
       ->get();*/
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $movement= WarehouseMovement::create([
            'deliverer_id' => $request['deliverer_id'],
            'fecha_salida' => $request['fecha_salida']

        ]);
        $movement->get();
        $product_id='';
        $cantidad='';
        foreach ( $request['products'] as $product) {
            $product_id=$product['id'];
            $cantidad=$product['cantidad'];
        $movement_product=$movement->product()->attach( $product_id,['cantidad' =>$cantidad,
        'tipoMovimiento' =>$request['tipoMovimiento']]);

        }
        return $movement_product;
        return $movement;


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
