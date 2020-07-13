<?php

namespace App\Http\Controllers\API;

use App\Entry;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PDF;
class EntryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Obtenemos todas las entradas registradas.
        return Entry::get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Registramos una nueva entrada con los datos obtenidos del $request.
        return Entry::create([
            'provider_id' => $request['provider_id'],
            'observacion' => $request['observacion'],
            'fecha_entrada' => $request['fecha_entrada']
        ]);
    }
    //Se crea una funcion que llama los datos de la base de datos y los muestra en un pdf de forma horizontal
    public function PDFEntries(){
        $entries = Entry::all();
        $pdf = PDF::loadView('entries', compact('entries'));
        return $pdf->setPaper('a4', 'landscape')->stream('entries.pdf');
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
        //Buscamos una entrada donde su campo "id" coincida con el "$id" recibido
        $entry = entry::findOrFail($id);

        //Validamos la información obtenida.
        $validator = Validator::make( $request->all(), [
            'provider_id' => 'required|Integer',
            'observacion' => 'required|max:200',
            'fecha_entrada' => 'required|date',
            ]
        );

         //Si hay un error envíamos un mensaje con el error
        if ($validator->fails()) {
            return response()->json(['validation_errors' => $validator->errors()]);
        }

        //Actualizamos los datos de la entrada encontrada.
        $entry->update([
            'provider_id' => $request['provider_id'],
            'observacion' => $request['observacion'],
            'fecha_entrada' => $request['fecha_entrada'],
        ]);

        //Devolvemos la entrada con los datos actualizados.
        return$entry;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //En la entrada que coincida con el id recibido se actualiza el campo "status" a 0
        $entry = entry::findOrFail($id);
        $entry->update([
            'status' => false,
        ]);
    }
}
