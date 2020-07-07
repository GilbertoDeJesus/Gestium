<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\Sale;
use App\ProductWarehouseMovement;
use Illuminate\Http\Request;

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
            ($movement_product_id,['cantidad' =>$cantidad,
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
}
