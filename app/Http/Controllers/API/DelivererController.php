<?php

namespace App\Http\Controllers\API;

use App\Deliverer;
use App\Http\Controllers\Controller;
use App\WarehouseMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PDF;

class DelivererController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Obtenemos todos los repartidores registrados con un 'status' igual a 1
        return Deliverer::where('status','=','1')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Devolvemos al nuevo repartidor creado con los datos que se obtienen del $request.
        return Deliverer::create([
            'nombre' => $request['nombre'],
            'aPaterno' => $request['aPaterno'],
            'aMaterno' => $request['aMaterno'],
            'fecha_nacimiento' => $request['fecha_nacimiento'],
            'fecha_contratacion' => $request['fecha_contratacion'],
            'telefono' => $request['telefono'],
            'email' => $request['email'],
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
    }
    public function getmovementList($id)
    {
        //Devolvemos los 3 últimos movimientos realizados por un repartidor
        return Deliverer::findOrFail($id)
        ->warehousemovement()
        //Con la fecha obtenemos los registros más recientes
        ->latest('created_at')
        ->take(1)
        ->get();
    }

    public function getdelivererlist($id_route){

        //Obtenemos y devolvemos todos los repartidores que tiene una ruta
        return Deliverer::join('deliverer_route',
        'deliverer_route.deliverer_id', '=', 'deliverers.id')
        //Seleccionamos solo los campos "route_id" y "created_at" de la tabla "deliverer_route"
        //y de la tabla "deliverers" el campo "nombre".
        ->select('deliverer_route.route_id', 'deliverers.nombre', 'deliverer_route.created_at')
        //Solo los registros que en su campo "route_id" coincidan con el id recibido
        ->where('deliverer_route.route_id', '=', $id_route)
        //Y los repartidores que tengan un "status" igual a 1
        ->where('deliverers.status', "=", 1)
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
        //Buscamos el repartidor que en su campo "id" coincida con el id recibido
        $deliverer = Deliverer::findOrFail($id);

        //Verificamos la información recibida
        $validator = Validator::make( $request->all(), [
            'nombre' => 'required|min:3',
            'aPaterno' => 'required|min:3',
            'aMaterno' => 'required|min:3',
            'fecha_nacimiento' => 'nullable|date',
            'fecha_contratacion' => 'required|date',
            'telefono' => 'nullable',
            'email' => 'nullable|email',

        ]);

        //Si existe algún error enviamos el mensaje con la información.
        if ($validator->fails()) {
            return response()->json(['validation_errors' => $validator->errors()]);
        }
        //Actualizamos los datos del repartidor encontrado anteriormente
        $deliverer->update([
            'nombre' => $request['nombre'],
            'aPaterno' => $request['aPaterno'],
            'aMaterno' => $request['aMaterno'],
            'fecha_nacimiento' => $request['fecha_nacimiento'],
            'fecha_contratacion' => $request['fecha_contratacion'],
            'telefono' => $request['telefono'],
            'email' => $request['email'],
        ]);

        //Devolvemos el repartidor con sus datos actualizados
        return$deliverer;
    }
    //Se crea una funcion que llama los datos de la base de datos y los muestra en un pdf de forma horizontal
    public function PDFDeliverers(Request $request){
        $fechai = $request->input('fechai');
        $fechaf = $request->input('fechaf');
        $id = $request->input('id');
        $status = $request->input('status');
        if(!empty($fechai) && !empty($fechaf) && !empty($status)){
            $deliverers = Deliverer::where("created_at",">=",$fechai)
            ->where('created_at',"<=", $fechaf)
            ->where('status', "=", $status)
            ->get();    
        }elseif(!empty($fechai) && !empty($fechaf) && !empty($id)){
            $deliverers = Deliverer::where("created_at",">=",$fechai)
            ->where('created_at',"<=", $fechaf)
            ->where('id', "=", $id)
            ->get();    
        }elseif(!empty($id)){
            $deliverers = Deliverer::where("id","=",$id)
            ->get(); 
        }elseif(!empty($status)){
            $deliverers = Deliverer::where("status","=",$status)
            ->get();
        }elseif(!empty($fechai) && !empty($fechaf)){
            $deliverers = Deliverer::where("created_at",">=",$fechai)
            ->where('created_at',"<=", $fechaf)
            ->get();    
        }else{
            $deliverers =Deliverer::all();
        }
        $pdf = PDF::loadView('deliverers', compact('deliverers', 'fechai', 'fechaf', 'id', 'status'));
        return $pdf->setPaper('a4', 'landscape')->stream('deliverers.pdf');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         //En el repartidor que coincida con el id recibido se actualiza el campo "status" a 0
        $deliverer = deliverer::findOrFail($id);
        $deliverer->update([
            'status' => false,
        ]);
    }
}
