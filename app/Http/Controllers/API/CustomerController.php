<?php

namespace App\Http\Controllers\API;

use App\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        return Customer::create([
            'route_id' => $request['route_id'],
            'nombre' => $request['nombre'],
            'telefono' => $request['telefono'],
            'email' => $request['email'],
            'establecimiento' => $request['establecimiento'],
            'direccion' => $request['direccion'],
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
        $customer = Customer::findOrFail($id);

        $validator = Validator::make( $request->all(), [
           'route_id' => 'required|Integer',
            'nombre' => 'required|min:5',
            'telefono' => 'nullable',
            'email' => 'nullable|email',
            'establecimiento' =>'required|max:255',
            'direccion' => 'required|max:255',

            ]
        );

        if ($validator->fails()) {
            return response()->json(['validation_errors' => $validator->errors()]);
        }

        $customer->update([
            'route_id' => $request['route_id'],
            'nombre' => $request['nombre'],
            'telefono' => $request['telefono'],
            'email' => $request['email'],
            'establecimiento' => $request['establecimiento'],
            'direccion' => $request['direccion']
                   ]);
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
        $customer = Customer::findOrFail($id);
        $customer->update([
            'status' => false
        ]);

    }
}
