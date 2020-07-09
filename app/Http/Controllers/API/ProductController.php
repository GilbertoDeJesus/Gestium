<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Product;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return Product::where('status','=','1')->with('Unit')->get();;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return Product::create([
            'provider_id' => $request['provider_id'],
            'unit_id' => $request['unit_id'],
            'nombre' => $request['nombre'],
            'meta' => $request['meta'],
            'descripcion' => $request['descripcion'],
            'precio_compra' => $request['precio_compra'],
            'precio_venta' => $request['precio_venta'],
            'stock' => $request['stock'],
            'stock_minimo' => $request['stock_minimo'],
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
    public function updateS(Request $request)
    {
        $product =$request->input();
        foreach($product as $producto){
         $id_product= product::findOrFail($producto['id']);
         $stock=$id_product->stock;
         $stock_minimo=$id_product->stock_minimo;
         $operacion=$stock-$stock_minimo;
           if ($producto['cantidad']<=$operacion ){
             $id_product->update([
             'stock' => $stock - $producto['cantidad'] ]);
            }
        }
    }

    public function returnProduct(Request $request) //Método para devolver los productos no vendidos al almacen.
    {
        $product =$request->input();
        foreach($product as $p){
           $id_product= product::findOrFail($p['id']);
           $id_product->update([
           'stock' => $id_product->stock + $p['cantidad'] ]);
        }
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
        $product = product::findOrFail($id);
        $validator = Validator ::make( $request->all(),[
            'provider_id'=> 'required|Integer',
            'unit_id' => 'required |Integer',
            'nombre' => 'required|max:200',
            'meta' => 'required|boolean',
            'descripcion' =>'required|max:200',
            'precio_compra' => 'required|numeric',
            'precio_venta'=>'required|numeric',
            'stock' =>'required|Integer',
            'stock_minimo' =>'required|Integer',
        ]
        );
       if($validator->fails()){
           return response()->json(['validation_errors' => $validator->errors()]);
       }
       $product->update([
        'provider_id' => $request['provider_id'],
        'unit_id' => $request['unit_id'],
        'nombre' => $request['nombre'],
        'meta' => $request['meta'],
        'descripcion' => $request['descripcion'],
        'precio_compra' => $request['precio_compra'],
        'precio_venta' => $request['precio_venta'],
        'stock' => $request['stock'],
        'stock_minimo' => $request['stock_minimo'],

        ]);
       return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = product::findOrFail($id);
        $product->update([
            'status' => false,
        ]);
    }
    public function PDFProducts(){
        $products = Product::all();
        $pdf = PDF::loadView('products', compact('products'));
        return $pdf->setPaper('a4', 'landscape')->stream('products.pdf');
    }
}
