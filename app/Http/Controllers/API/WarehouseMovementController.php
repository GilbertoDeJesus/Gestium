<?php

namespace App\Http\Controllers\API;

use App\WarehouseMovement;
use App\Http\Controllers\Controller;
use App\ProductWarehouseMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PDF;

class WarehouseMovementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Obtenemos y devolvemos todos los movimientos realizados junto con sus relaciones con otras tablas
       return WarehouseMovement::latest('warehouse_movements.created_at')
       ->join ('deliverers', 'warehouse_movements.deliverer_id', '=', 'deliverers.id')

       ->join('product_warehouse_movement', 'warehouse_movements.id', '=',
        'product_warehouse_movement.warehouse_movement_id')
        //Enviamos la suma de todos los productos solicitados en el movimiento
       ->select('warehouse_movements.id', 'warehouse_movements.fecha_salida', 'warehouse_movements.created_at',
         WarehouseMovement::raw('sum(cantidad) as sum'), 'deliverers.nombre')
       ->groupBy('warehouse_movements.id', 'warehouse_movements.fecha_salida', 'warehouse_movements.created_at',
        'deliverers.nombre')
        ->where("product_warehouse_movement.tipoMovimiento", '=',1)
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
        //creamos un registro en la tabla "warehouse:movement"

        $movement= WarehouseMovement::create([

            'deliverer_id' => $request['deliverer_id'],
            'fecha_salida' => $request['fecha_salida']

        ]);

        //Recorremos todos los productos recibidos en la entrada
        foreach ( $request['products'] as $product) {

            //Por cada uno obtenemos su "id" y "cantidad"
            $product_id = $product['id'];
            $cantidad = $product['cantidad'];

            //Con estos datos llenamos la tabla intermedia entre las tablas “warehouse_movement”
            //Y “products”

            $movement_product = $movement->product()->attach
            ($product_id, ['cantidad' =>$cantidad,
            'tipoMovimiento' => $request['tipoMovimiento']

            ]);

        }

        //Devolvemos el nuevo registro de la tabla "warehouse_movement_product"
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
         'product_warehouse_movement.product_id', '=', 'products.id')
        /*El segundo join es entre las tablas movimiento_producto y movimiento, en las columnas
          warehouse_movement_id y id respectivamente*/
        ->join('warehouse_movements', 'product_warehouse_movement.warehouse_movement_id',
          '=','warehouse_movements.id')
        /*En las siguientes línea se indica que solo se mostraran las columnas 'id' de la tabla
          movimientos, el 'nombre' de la tabla productos, la 'cantidad' y 'fecha_salida' que
          pertenecen a la tabla movimientos_producto.*/
        ->select('products.id', 'products.nombre',  'products.precio_venta',
        'product_warehouse_movement.cantidad', 'product_warehouse_movement.id as pw_id',
        'warehouse_movements.fecha_salida','warehouse_movements.deliverer_id as deliverer_id')
         /*Se devolveran los resultados donde el campo warehouse_movement_id de la tabla
           movimiento_producto coincida con el 'id' que recibe en un principio la función*/
        ->where('product_warehouse_movement.warehouse_movement_id', '=', $id )
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
        //Buscamos y obtenemos el movimiento que conincida con el id recibido
        $warehousemovement = WarehouseMovement::findOrFail($id);

        //Validamos los datos de la entrada
        $validator = Validator::make( $request->all(), [
            'deliverer_id' => 'required|Integer',
            'fecha_salida' => 'required|date',
            ]
        );

         //Si hay un error enviamos un mensaje con el error
        if ($validator->fails()) {
            return response()->json(['validation_errors' => $validator->errors()]);
        }

        //Actualizamos los datos de los campos “deliverer id” y “fecha salida”
        //con lo recibido en el "$request"
        $warehousemovement->update([
            'deliverer_id' => $request['deliverer_id'],
            'fecha_salida' => $request['fecha_salida'],
        ]);
        //Devolvemos el registro de movimiento actualizado
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
      //Se crea una funcion que llama los datos de la base de datos y los muestra en un pdf de forma horizontal
    }
    public function PDFWarehouseMovements(Request $request){
      $fechai = $request->input('fechai');
        $fechaf = $request->input('fechaf');
        $id = $request->input('id');
        if(!empty($fechai) && !empty($fechaf) && !empty($id)){
          $warehousemovements = WarehouseMovement::where("created_at",">=",$fechai)
          ->where('created_at',"<=", $fechaf)
          ->where('deliverer_id', "=", $id)
          ->get();
        }elseif(!empty($fechai) && !empty($fechaf)){
          $warehousemovements = WarehouseMovement::where("created_at",">=",$fechai)
          ->where('created_at',"<=", $fechaf)
          ->get();
        }elseif(!empty($id)){
          $swarehousemovements = WarehouseMovement::where("deliverer_id","=",$id)
          ->get();
        }else{
          $warehousemovements =WarehouseMovement::all();
        }
      $pdf = PDF::loadView('warehousemovements', compact('warehousemovements'));
      return $pdf->setPaper('a4', 'landscape')->stream('warehousemovements.pdf');
  }
}
