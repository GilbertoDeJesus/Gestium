<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Provider;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Obtenemos todos los proveedores con "status" igual a 1
        return Provider::where('status','=','1')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Creamos un nuevo registro de proveedor con los datos de la entrada
        return Provider::create([
            'nombre' => $request['nombre'],
            'telefono' => $request['telefono'],
            'email' => $request['email'],
            'status'=> true
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
        //Obtenemos los datos del proveedor que coincida con el "id" recibido.
        $provider = provider::findOrFail($id);

        //Validamos todos los datos de la entrada
        $validator= Validator ::make($request->all(),[
            'nombre'=> 'required|max:40',
            'telefono' =>'required|max:40',
            'email' =>'required|max:40',
        ]);
        //Si hay un error enviamos un mensaje con el error
        if($validator->fails()){
            return response()->json(['validation_errors' => $validator->errors()]);
        }
        //Actualizamos los campos del proveedor encontrado
        $provider->update([
            'nombre' => $request['nombre'],
            'telefono' => $request['telefono'],
            'email' => $request['email'],
        ]);
        //Devolvemos el proveedor con la información actualizada.
        return $provider;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //En el proveedor que coincida con el id recibido se actualiza el campo "status" a 0
        $provider = provider::findOrFail($id);
        $provider->update([
            'status'=>false,
        ]);
    }
    public function PDFProviders(Request $request){
        $fechai = $request->input('fechai');
        $fechaf = $request->input('fechaf');
        $id = $request->input('id');
        $status = $request->input('status');
        if(!empty($fechai) && !empty($fechaf) && !empty($id)){
            $providers = Provider::where("created_at",">=",$fechai)
            ->where('created_at',"<=", $fechaf)
            ->where('id', "=", $id)
            ->get();    
        }elseif(!empty($id)){
            $providers = Provider::where("id","=",$id)
            ->get(); 
        }elseif(!empty($status)){
            $providers = Provider::where("status","==",$status)
            ->get(); 
        }elseif(!empty($fechai) && !empty($fechaf)){
            $providers = Provider::where("created_at",">=",$fechai)
            ->where('created_at',"<=", $fechaf)
            ->get();    
        }
        else{
            $providers =Provider::all();
        }
        $pdf = PDF::loadView('providers', compact('providers'));
        return $pdf->setPaper('a4', 'landscape')->stream('providers.pdf');
    }
}
