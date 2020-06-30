<?php

namespace App\Http\Controllers\API;

use App\WarehouseMovement;
use App\Http\Controllers\Controller;
use App\ProductWarehouseMovement;
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
       return WarehouseMovement::latest('warehouse_movements.created_at')
       ->join ('deliverers','warehouse_movements.deliverer_id','=','deliverers.id')
       ->join('product_warehouse_movement','warehouse_movements.id','=',
        'product_warehouse_movement.warehouse_movement_id')
       ->select('warehouse_movements.id','warehouse_movements.fecha_salida',
         WarehouseMovement::raw('sum(cantidad) as sum'),'deliverers.nombre')
       ->groupBy('warehouse_movements.id','warehouse_movements.fecha_salida'
       ,'deliverers.nombre')
       ->get();
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
        foreach ( $request['products'] as $product) {
            $product_id=$product['id'];
            $cantidad=$product['cantidad'];
            $movement_product=$movement->product()->attach
            ($product_id,['cantidad' =>$cantidad,
            'tipoMovimiento' =>$request['tipoMovimiento']]);

        }
        return $movement_product;


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Se devulve una consulta que tendra los campos id, nombre, cantidad y fehca_salida.
        /*El primer join es entre las tablas producto y movimiento, en las columnas
           product_id y id respectivamente*/
        return ProductWarehouseMovement::join('products',
         'product_warehouse_movement.product_id','=','products.id')
        /*El segundo join es entre las tablas movimiento_producto y movimiento, en las columnas
          warehouse_movement_id y id respectivamente*/
        ->join('warehouse_movements','product_warehouse_movement.warehouse_movement_id',
          '=','warehouse_movements.id')
        /*En las siguientes línea se indica que solo se mostraran las columnas 'id' de la tabla
          movimientos, el 'nombre' de la tabla productos, la 'cantidad' y 'fecha_salida' que
          pertenecen a la tabla movimientos_producto.*/
        ->select('products.nombre','product_warehouse_movement.cantidad','warehouse_movements.fecha_salida')
         /*Se devolveran los resultados donde el campo warehouse_movement_id de la tabla
           movimiento_producto coincida con el 'id' que recibe en un principio la función*/
        ->where('product_warehouse_movement.warehouse_movement_id', '=',$id )
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
    }
}
