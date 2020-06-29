<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Route;
use Illuminate\Support\Facades\Validator;

class RouteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Route::where('status','=','1')->get() ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return Route::create([
            'municipio' => $request['municipio'],
            'status'=>true
        ]);
    }
    public function createdeliverer_route(Request $request)
    {
        return Route::findOrFail($request['id'])->deliverer()->attach
        ($request['deliverer_id']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
        $route = Route::findOrFail($id);

        $validator = Validator::make( $request->all(), [
            'municipio' => 'required|max:255'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['validation_errors' => $validator->errors()]);
        }

        $route->update([
            'municipio' => $request['municipio']
             ]);
     return $route;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $route = Route::findOrFail($id);
        $route->update([
            'status' => false
        ]);
    }
}
