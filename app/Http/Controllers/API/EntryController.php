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
        return Entry::create([
            'provider_id' => $request['provider_id'],
            'observacion' => $request['observacion'],
            'fecha_entrada' => $request['fecha_entrada']
        ]);
    }
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
        $entry = entry::findOrFail($id);

        $validator = Validator::make( $request->all(), [
            'provider_id' => 'required|Integer',
            'observacion' => 'required|max:200',
            'fecha_entrada' => 'required|date',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['validation_errors' => $validator->errors()]);
        }

        $entry->update([
            'provider_id' => $request['provider_id'],
            'observacion' => $request['observacion'],
            'fecha_entrada' => $request['fecha_entrada'],
        ]);

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
        $entry = entry::findOrFail($id);
        $entry->update([
            'status' => false,
        ]);
    }
}
