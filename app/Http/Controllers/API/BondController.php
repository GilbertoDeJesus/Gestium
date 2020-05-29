<?php

namespace App\Http\Controllers\API;

use App\Bond;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BondController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Bond::get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return Bond::create([
            'goal_id' => $request['goal_id'],
            'porcentaje' => $request['porcentaje'],
            'cantidad' => $request['cantidad']
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
        $bond = bond::findOrFail($id);
        $validator = Validator ::make( $request->all(),[

            'goal_id' => 'required|Integer',
            'porcentaje' =>'required|numeric',
            'cantidad'=>'required|numeric',
        ]);
        if($validator->fails()){
            return response()->json(['validation_errors' => $validator->errors()]);
        }
        $bond->update([
            'goal_id' => $request['goal_id'],
            'porcentaje' => $request['porcentaje'],
            'cantidad' => $request['cantidad']
        ]);
        return $bond;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bond = bond::findOrFail($id);
        $bond->update([
            'status' => false,
        ]);
    }
}
