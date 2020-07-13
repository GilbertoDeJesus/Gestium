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
        return Sale::latest()
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
        $total=0;
       // $sale=Sale::find(4);
        $sale= Sale::create([
            'fecha'=>$request['fecha_salida'],
            'monto'=>'0',
            'observacion'=>$request['observacion'],
            'deliverer_id'=>$request['deliverer_id'],
            'customer_id'=>$request['customer_id']
        ]);

        foreach ( $request['products'] as $product) {
            $movement_product_id=$product['pw_id'];
            $cantidad=$product['cantidad'];
            $precio_producto=$product['precio_venta'];
            $subtotal=($cantidad*$precio_producto);
            $product_sale=$sale->productwarehousemovement()->attach
            ($movement_product_id,['cantidadVenta' =>$cantidad,
            'monto' =>$subtotal]);
            $total=$total+$subtotal;

           $pwm= Productwarehousemovement::findOrFail($movement_product_id);
                 $stock=$pwm->cantidad;
                  if ($product['cantidad']<=$stock ){
                    $pwm->update([
                    'cantidad' => $stock - $cantidad]);
                   }
        }
        $sale->update([
            'monto' => $total]);

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
        join('product_warehouse_movement_sale',
        'product_warehouse_movement.id', '=' ,
        'product_warehouse_movement_sale.product_sale_id')

      ->join('products',
        'product_warehouse_movement.product_id', '=',
        'products.id')

      ->select('products.id as product_id','products.nombre',
        'product_warehouse_movement_sale.cantidad as cantidadVenta',
        'product_warehouse_movement_sale.monto')

      ->where('product_warehouse_movement_sale.sale_id','=', $id)
      ->get();

      /*  return Sale::with("productwarehousemovement")
        ->where('id', '=',3)
        ->select('id','monto')
        ->get();*/
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
        $sale = Sale::findOrFail($id);

        $validator = Validator::make( $request->all(), [
            'deliverer_id' => 'required|Integer',
            'customer_id' => 'required|Integer',
            'fecha' =>'required|date',
            'monto' => 'required|numeric',
            'observacion' => 'required|max:255'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['validation_errors' => $validator->errors()]);
        }

        $sale->update([
            'deliverer_id' => $request['deliverer_id'],
            'customer_id' => $request['customer_id'],
            'fecha' => $request['fecha'],
            'monto' => $request['monto'],
            'observacion' => $request['observacion']
                              ]);
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
    }
    public function PDFSales(){
      $sales = Sale::all();
      $pdf = PDF::loadView('sales', compact('sales'));
      return $pdf->setPaper('a4', 'landscape')->stream('sales.pdf');
  }
}
