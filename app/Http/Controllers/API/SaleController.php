<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\Sale;
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
        return Sale::get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return Sale::create([
            'deliverer_id' => $request['deliverer_id'],
            'customer_id' => $request['customer_id'],
            'fecha' => $request['fecha'],
            'monto' => $request['monto'],
            'observacion' => $request['observacion']
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
