<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\Sale;
use App\ProductWarehouseMovement;
use Illuminate\Http\Request;
use PDF;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Obtenemos y devolvemos todas las salidas registradas y se ordenan de acuerdo a la más reciente.
        return Sale::latest()
        //También se permite acceso a la tabla intermedia entre ventas y clientes
        ->with('customer:id,nombre')
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
        //Creamos una nueva venta, descontamos los productos vendidos de la salida correspondiente
        // y llenamos la tabla intermedia de las tablas "warehouse_movement_product y sales.

        $total=0;

        //Creamos la venta con los datos de la entrada
        $sale= Sale::create([
            'fecha' => $request['fecha_salida'],
            'monto'=>'0',
            'observacion' => $request['observacion'],
            'deliverer_id' => $request['deliverer_id'],
            'customer_id' => $request['customer_id']
        ]);

        //Obtenemos y recorremos cada uno de los productos que nos da la entrada
        foreach ( $request['products'] as $product) {

            $movement_product_id = $product['pw_id'];
            $cantidad = $product['cantidad'];
            $precio_producto = $product['precio_venta'];

            //Obtemos el total a pagar por el precio del producto y la cantidad vendida
            $subtotal = ($cantidad * $precio_producto);

            // Llenamos la tabla intermedia con los datos de la nueva venta y los demás
            //datos obtenidos del request y operaciones
            $product_sale = $sale->productwarehousemovement()->attach
            ($movement_product_id, ['cantidad' => $cantidad,
            'monto' => $subtotal]);

            //Calculamos el total de la venta de todos los productos
            $total = $total+$subtotal;

            //Actualizamos cantidad de productos en la salida siempre y cuando sea menor o igual a la
            //cantidad existente
           $pwm= Productwarehousemovement::findOrFail($movement_product_id);
                 $stock = $pwm->cantidad;

                  if ($product['cantidad'] <= $stock ){
                    $pwm->update([
                    'cantidad' => $stock - $cantidad]);
                   }
        }

        //Actualizamos el monto total de la venta en el último registro de venta
        $sale->update(['monto' => $total]);

        //Devolvemos el registro de la tabla intermedia.
        return $product_sale;
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
    //La función obtine los datos de una venta, sus productos, la cantidad de cada uno
    //y el total a pagar por producto.
    public function getSaleDetail($id){

      return ProductWarehouseMovement::
      //El primer join entre tabla "product_warehouse_movement" en su campo "id" y
      //la tabla product_warehouse_movement_sale campo "product_sale_id"
        join('product_warehouse_movement_sale',
        'product_warehouse_movement.id', '=' ,
        'product_warehouse_movement_sale.product_sale_id')

        //Join entre tabla "product_warehouse_movement" campo "product_id"
        // y "productos" campo "id"
      ->join('products',
        'product_warehouse_movement.product_id', '=',
        'products.id')

        //solo obtenemos los campos "id" y "nombre" de la tabla "products"
        //y campos "cantidad" y monto de la tabla "product_warehouse_movement_sale"
      ->select('products.id as product_id','products.nombre',
        'product_warehouse_movement_sale.cantidad as cantidadVenta',
        'product_warehouse_movement_sale.monto')

        //Donde el campo "sale_id" de la tabla "product_warehouse_movement_sale"
        //sea igual al "id" recibido
      ->where('product_warehouse_movement_sale.sale_id', '=', $id)
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
        //Buscamos la venta que coincida con el "id" recibido y la guarmamos en "$sale"
        $sale = Sale::findOrFail($id);

        //Validamos los datos de la entrada
        $validator = Validator::make( $request->all(), [
            'deliverer_id' => 'required|Integer',
            'customer_id' => 'required|Integer',
            'fecha' =>'required|date',
            'monto' => 'required|numeric',
            'observacion' => 'required|max:255'
            ]
        );

        //Si hay un error enviamos un mensaje con el error
        if ($validator->fails()) {
            return response()->json(['validation_errors' => $validator->errors()]);
        }

        //Acualizamos los datos de la venta encontrada
        $sale->update([
            'deliverer_id' => $request['deliverer_id'],
            'customer_id' => $request['customer_id'],
            'fecha' => $request['fecha'],
            'monto' => $request['monto'],
            'observacion' => $request['observacion']
            ]);

          // Devolvemos la venta actualizada
         return $sale;
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
    public function PDFSales(Request $request){
      $fechai = $request->input('fechai');
        $fechaf = $request->input('fechaf');
        $idc = $request->input('idcliente');
        $idr = $request->input('idruta');
        $status = $request->input('status');
        $nombre = $request->input('nombre');
        if(!empty($fechai) && !empty($fechaf) && !empty($idr) && !empty($idc)){
          $sales = Sale::where("created_at",">=",$fechai)
          ->where('created_at',"<=", $fechaf)
          ->where('route_id', "=", $idr)
          ->where('customer_id', "=", $idc)
          ->get();    
        }elseif(!empty($fechai) && !empty($fechaf) && !empty($idr)){
          $sales = Sale::where("created_at",">=",$fechai)
          ->where('created_at',"<=", $fechaf)
          ->where('route_id', "=", $idr)
          ->get();    
        }elseif(!empty($fechai) && !empty($fechaf) && !empty($idc)){
            $sales = Sale::where("created_at",">=",$fechai)
            ->where('created_at',"<=", $fechaf)
            ->where('customer_id', "=", $idc)
            ->get();    
        }elseif(!empty($fechai) && !empty($fechaf)){
          $sales = Sale::where("created_at",">=",$fechai)
          ->where('created_at',"<=", $fechaf)
          ->get();    
        }elseif(!empty($idc) && !empty($idr)){
          $sales = Sale::where("customer_id","=",$idc)
          ->where('route_id',"=",$idr)
          ->get(); 
        }elseif(!empty($idc)){
          $sales = Sale::where("customer_id","=",$idc)
          ->get(); 
        }elseif(!empty($idr)){
            $sales = Sale::where("route_id","=",$idr)
            ->get(); 
        }else{
            $sales =Sale::all();
        }
      $pdf = PDF::loadView('sales', compact('sales'));
      return $pdf->setPaper('a4', 'landscape')->stream('sales.pdf');
  }
}
