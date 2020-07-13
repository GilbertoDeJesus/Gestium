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
        $customer = Customer::findOrFail($id);

        $validator = Validator::make( $request->all(), [
            'nombre' => 'required|min:5',
            'telefono' => 'nullable',
            'direccion' => 'required|max:255',
            'establecimiento' =>'required|max:255',
            'email' => 'nullable|email',
            'route_id' => 'required|Integer',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['validation_errors' => $validator->errors()]);
        }

        $customer->update([
            'nombre' => $request['nombre'],
            'telefono' => $request['telefono'],
            'direccion' => $request['direccion'],
            'establecimiento' => $request['establecimiento'],
            'email' => $request['email'],
            'route_id' => $request['route_id'],
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
    public function PDFCustomers(){
        $customers = Customer::all();
        $pdf = PDF::loadView('customers', compact('customers'));
        return $pdf->setPaper('a4', 'landscape')->stream('customers.pdf');
    }
}
