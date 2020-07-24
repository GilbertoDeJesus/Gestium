<?php

namespace App\Http\Controllers\API;

use App\Entry;
use App\Http\Controllers\Controller;
use App\Product;
use PDF;
use App\ProductWarehouseMovement;
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
       //Obtenemos y devolvemos todos los productos que tengan un "status" igual a 1
       //y también su relación con la tabla "units"
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
        //Creamos un nuevo producto con los datos obtenidos del $request.
        $product=Product::create([
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

        //Creamos un nuevo registro en la tabla de entradas
        $entry= Entry::create([
            'provider_id' => $request['provider_id'],
            'observacion' => $request['descripcion'],
            'fecha_entrada' =>date("d-m-y")
        ]);

        //Llenamos la tabla formada por entradas y productos
        $entry->product()->attach
        ($product['id'], ['cantidad' => $request['stock'],
        'precio_compra' => $request['precio_compra']
        ]);

        //Devolvemos el registro del producto creado
        return $product;
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
        //Recuperamos todos los datos de la entrada
        $product = $request->input();

        //Recorremos todos los productos obtenidos
        foreach($product as $producto){

         //Buscamos un producto que en su id coincida con el 'id' recibido
         $id_product = product::findOrFail($producto['id']);

         //A la variable stock le asignamos el valor del campo "stock" del objeto "id_product"
         $stock = $id_product->stock;
         //A la variable stock le asignamos el valor del campo "stock_minimo" del objeto "id_product"
         $stock_minimo = $id_product->stock_minimo;
         //Operación la igualamos a la diferencia de las variables "stock" y "stock_minimo"
         $operacion = $stock - $stock_minimo;

         //Si "$producto" en su elemento "cantidad" es menor o igual a "$operacion" se actualiza el
         // stock del producto encontrado en un principio con la diferencia de su columna "stock" menos
         //el valor de "$producto" en su elemento "cantidad"
           if ($producto['cantidad'] <= $operacion ){
             $id_product->update([
             'stock' => $stock - $producto['cantidad'] ]);
            }
        }
    }

    //Método para devolver los productos no vendidos al almacen.
    public function returnProduct(Request $request)
    {
        //Recuperamos todos los datos de la entrada
        $product = $request->input();

        //Recorremos la entrada
        foreach($product as $p){
            // Buscamos el producto con el id del objeto recorrido
           $id_product = product::findOrFail($p['id']);

           //Actualizamos en el campo "stock" del producto enocntrado con la suma de lo ya almacenado
           //con la "cantidad" nueva.
           $id_product->update([
           'stock' => $id_product->stock + $p['cantidad'] ]);

           //Actualizamos el campo "cantidad" de la salida a la que corresponde la devolución
           $pwm= Productwarehousemovement::findOrFail($p['pw_id']);
                 $stock = $pwm->cantidad;

                  if ($p['cantidad'] <= $stock ){
                    $pwm->update(['cantidad' => $stock -  $p['cantidad']]);
                   }
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
        //Buscamos el producto que en su campo "id" coincida con el "id" recibido
        $product = product::findOrFail($id);

        //Validamos los datos recibidos
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

        //Si hay un error enviamos un mensaje con el error
       if($validator->fails()){
           return response()->json(['validation_errors' => $validator->errors()]);
       }

       //Actualizamos los datos del producto encontrado
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
        //Devolvemos el producto con la información actualizada
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
        //En el producto que coincida con el id recibido se actualiza el campo "status" a 0
        $product = product::findOrFail($id);
        $product->update([
            'status' => false,
        ]);
    }
    //Se crea una funcion que llama los datos de la base de datos y los muestra en un pdf de forma horizontal
    public function PDFProducts(Request $request){
        $fechai = $request->input('fechai');
        $fechaf = $request->input('fechaf');
        $idp = $request->input('idp');
        $nombre = $request->input('id');
        $meta = $request->input('meta');
        if(!empty($fechai) && !empty($fechaf) && !empty($nombre) && !empty($meta)){
            $products = Product::where("created_at",">=",$fechai)
            ->where('created_at',"<=", $fechaf)
            ->where('nombre',"=", $nombre)
            ->where('meta',"=", $meta)
            ->get();
        }elseif(!empty($fechai) && !empty($fechaf) && !empty($idp) && !empty($meta)){
            $products = Product::where("created_at",">=",$fechai)
            ->where('created_at',"<=", $fechaf)
            ->where('provider_id',"=", $idp)
            ->where('meta',"=", $meta)
            ->get();
        }elseif(!empty($fechai) && !empty($fechaf) && !empty($idp)){
            $products = Product::where("created_at",">=",$fechai)
            ->where('created_at',"<=", $fechaf)
            ->where('provider_id',"=", $idp)
            ->get();
        }elseif(!empty($fechai) && !empty($fechaf) && !empty($nombre)){
            $products = Product::where("created_at",">=",$fechai)
            ->where('created_at',"<=", $fechaf)
            ->where('id',"=", $nombre)
            ->get();
        }elseif(!empty($fechai) && !empty($fechaf) && !empty($meta)){
            $products = Product::where("created_at",">=",$fechai)
            ->where('created_at',"<=", $fechaf)
            ->where('meta',"=", $meta)
            ->get();
        }elseif(!empty($meta) && !empty($idp)){
            $products = Product::where("meta","=",$meta)
            ->where('provider_id',"=", $idp)
            ->get();
        }elseif(!empty($fechai) && !empty($fechaf)){
            $products = Product::where("created_at",">=",$fechai)
            ->where('created_at',"<=", $fechaf)
            ->get();
        }elseif(!empty($idp)){
            $products = Product::where("provider_id","=",$idp)
            ->get();
        }elseif(!empty($meta)){
            $products = Product::where("meta","=",$meta)
            ->get();
        }elseif(!empty($nombre)){
            $products = Product::where("id","=",$nombre)
            ->get();
        }else{
            $products =Product::all();
        }
        $pdf = PDF::loadView('products', compact('products'));
        return $pdf->setPaper('a4', 'landscape')->stream('products.pdf');
    }
}
