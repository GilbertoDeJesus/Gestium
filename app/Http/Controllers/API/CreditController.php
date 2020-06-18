<?php

namespace App\Http\Controllers\API;

use App\Credit;
use App\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CreditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Credit::get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $provider= Customer::all();
        return Credit::create([
            'customer_id' => $request['customer_id'],
            'monto' => $request['monto'],
            'descripcion' => $request['descripcion'],
            'fecha'=> $request['fecha'],
            'tipoMovimiento'=> $request['tipoMovimiento'],
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
        $credit = credit::findOrFail($id);
        $validator = Validator ::make( $request->all(),[
            'customer_id'=> 'required|Integer',
            'monto' =>'required|Integer',
            'descripcion' => 'required|max:200',

        ]);
        if($validator->fails()){
            return response()->json(['validation_errors' => $validator->errors()]);
        }
        $credit->update([
            'customer_id' => $request['customer_id'],
                'monto' => $request['monto'],
                'descripcion' => $request['descripcion'],
                'fecha'=> $request['fecha'],
                'tipoMovimiento'=> $request['tipoMovimiento'],
        ]);
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
        $credit = credit::findOrFail($id);
        $credit->update([
            'status' => false,
        ]);
    }
}
