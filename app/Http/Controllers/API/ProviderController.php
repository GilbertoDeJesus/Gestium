<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Provider;
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
        return Provider::get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return Provider::create([
            'nombre' => $request['nombre'],
            'telefono' => $request['telefono'],
            'email' => $request['email']
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
        $provider = provider::findOrFail($id);
        $validator= Validator ::make($request->all(),[
            'nombre'=> 'required|max:40',
            'telefono' =>'required|max:40',
            'email' =>'required|max:40',
        ]);
        if($validator->fails()){
            return response()->json(['validation_errors' => $validator->errors()]);
        }
        $provider->update([
            'nombre' => $request['nombre'],
            'telefono' => $request['telefono'],
            'email' => $request['email'],
        ]);
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
        $provider = provider::findOrFail($id);
        $provider->update([
            'status'=>false,
        ]);
    }
}
