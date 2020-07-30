<?php

namespace App\Http\Controllers\API;

use App\Credit;
use App\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PDF;

class CreditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //En esta función llamamos a los créditos existentes de los clientes.
    public function index()
    {
        //obtenemos los créditos que tienen los clientes.
        return Credit::with('Customer')
        //los ordenamos por la fecha más reciente.
        ->latest('credits.created_at')
         //solo los creditos dónde el tipo de movimiento sea igual a 1
        ->where('tipoMovimiento',"=" ,1)
         //Y el estatus igual a 1.
        ->where('status',"=" ,1)
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
        //En las siguientes líneas asignamos un nuevo crédito.
        return Credit::create([
        //De los datos recibidos obtenemos los necesarios para
        //añadirlos a nuestra tabla en el campo correspondiente.
            'customer_id' => $request['customer_id'],
            'monto' => $request['monto'],
            'descripcion' => $request['descripcion'],
            'fecha'=> $request['fecha'],
            'tipoMovimiento'=> 1,
            'aPagar'=>$request['monto'],
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
        //Guardamos en '$credit' los datos relacionados con el 'id' recibido
        $credit = credit::findOrFail($id);
        //En 'montoOld' guardamos el valor del campo "apagar" del objeto $credit.
        $montoOld=$credit->aPagar;

        //Validamos nuestro request
        $validator = Validator ::make( $request->all(),[
            'customer_id'=> 'required|Integer',
            'monto' =>'required|Integer',

        ]);

        //Si hay un error enviamos un mensaje con el error
        if($validator->fails()){

            return response()->json(['validation_errors' => $validator->errors()]);
        }


        //A 'creditAbono' le asignamos la diferencia de '$montoOld' y el valor de 'monto' obtenido
        //en nuestro request
        $creditAbono = $montoOld - $request['monto'];

        //Si nuestro 'monto' en request es menor o igual a lo que ahora tiene '$montoOld' actualizamos
        // lo que tiene '$credit' en su elemento 'monto'.
        if($request['monto'] <= $montoOld){
            $credit->update([
                'customer_id' => $request['customer_id'],
                'aPagar' =>$creditAbono
            ]);

            //Ahora en la misma tabla con los elementos del request
           // crearemos un abono indicado por el 'tipoMovimiento' igual a 0

            Credit::create([
                'customer_id' => $request['customer_id'],
                'monto' => $request['monto'],
                'descripcion' => $request['descripcion'],
                'fecha'=> $request['fecha'],
                'tipoMovimiento'=> 0,
                'aPagar'=>$creditAbono,
                'status'=> true

            ]);
        }

        //Devolvemos el credito encontrado con el monto actualizado
        return $credit;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //En el crédito que coincida con el id recibido se actualiza el campo "status" a 0
        $credit = credit::findOrFail($id);
        $credit->update([
            'status' => false,
        ]);
        //Se crea una funcion que llama los datos de la base de datos y los muestra en un pdf de forma horizontal
    }
    public function PDFCredits(Request $request){
        $fechai = $request->input('fechai');
        $fechaf = $request->input('fechaf');
        $id = $request->input('id');
        if(!empty($fechai) && !empty($fechaf) && !empty($id)){
            $credits = Credit::where("created_at",">=",$fechai)
            ->where('created_at',"<=", $fechaf)
            ->where('customer_id', "=", $id)
            ->get();
        }elseif(!empty($id)){
            $credits = Credit::where("customer_id","=",$id)
            ->get();
        }elseif(!empty($fechai) && !empty($fechaf)){
            $credits = Credit::where("created_at",">=",$fechai)
            ->where('created_at',"<=", $fechaf)
            ->get();
        }else{
            $credits =Credit::all();
        }
        $pdf = PDF::loadView('credits', compact('credits'));
        return $pdf->setPaper('a4', 'landscape')->stream('credits.pdf');
    }
}
