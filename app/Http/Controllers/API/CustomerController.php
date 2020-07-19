<?php

namespace App\Http\Controllers\API;

use App\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use PDF;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        //Obtenemos los clientes que tengan un status igual a 0
        return Customer::where('status','=','1')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Damos de alta a un nuevo cliente con los elementos de nuestro "$request".
        return Customer::create([
            'nombre' => $request['nombre'],
            'telefono' => $request['telefono'],
            'direccion' => $request['direccion'],
            'establecimiento' => $request['establecimiento'],
            'email' => $request['email'],
            'status'=> true,
            'route_id' => $request['route_id'],
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
        //Actualizamos los campos del cliente que en su id coincida con el id recibido
        $customer = Customer::findOrFail($id);

        //Validamos los elementos de nuestro "$request".
        $validator = Validator::make( $request->all(), [
            'nombre' => 'required|min:5',
            'telefono' => 'nullable',
            'direccion' => 'required|max:255',
            'establecimiento' =>'required|max:255',
            'email' => 'nullable|email',
            'route_id' => 'required|Integer',
            ]
        );

        //Si existe algún error se envía un mensaje con él.
        if ($validator->fails()) {
            return response()->json(['validation_errors' => $validator->errors()]);
        }

        //Si todo es correcto actualizamos los campos del cliente que se encontró con el id.
        $customer->update([
            'nombre' => $request['nombre'],
            'telefono' => $request['telefono'],
            'direccion' => $request['direccion'],
            'establecimiento' => $request['establecimiento'],
            'email' => $request['email'],
            'route_id' => $request['route_id'],
         ]);


         //Se devuelve el cliente con los datos actualizados
         return $customer;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //En el cliente que coincida con el id recibido se actualiza el campo "status" a 0
        $customer = Customer::findOrFail($id);
        $customer->update([
            'status' => false
        ]);
        //Se crea una funcion que llama los datos de la base de datos y los muestra en un pdf de forma horizontal
    }
    public function PDFCustomers(Request $request){
        $fechai = $request->input('fechai');
        $fechaf = $request->input('fechaf');
        $nombre = $request->input('nombre');
        $id = $request->input('id');
        $status = $request->input('status');
        if(!empty($fechai) && !empty($fechaf) && !empty($id) && !empty($nombre)){
            $customers = Customer::where("created_at",">=",$fechai)
            ->where('created_at',"<=", $fechaf)
            ->where('route_id', "=", $id)
            ->where('nombre',"=", $nombre)
            ->get();    
        }elseif(!empty($fechai) && !empty($fechaf) && !empty($id)){
            $customers = Customer::where("created_at",">=",$fechai)
            ->where('created_at',"<=", $fechaf)
            ->where('route_id', "=", $id)
            ->get();    
        }elseif(!empty($nombre) && !empty($id)){
            $customers = Customer::where("nombre","=",$nombre)
            ->where('route_id',"=", $id)
            ->get(); 
        }elseif(!empty($id)){
            $customers = Customer::where("route_id","=",$id)
            ->get(); 
        }elseif(!empty($nombre)){
            $customers = Customer::where("nombre","=",$nombre)
            ->get(); 
        }elseif(!empty($status)){
            $customers = Customer::where("status","==",$status)
            ->get(); 
        }elseif(!empty($fechai) && !empty($fechaf)){
            $customers = Customer::where("created_at",">=",$fechai)
            ->where('created_at',"<=", $fechaf)
            ->get();    
        }else{
            $customers =Customer::all();
        }
        $pdf = PDF::loadView('customers', compact('customers'));
        return $pdf->setPaper('a4', 'landscape')->stream('customers.pdf');
    }
}
