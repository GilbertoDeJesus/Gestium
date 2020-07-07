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
        //return Route::latest()->where('status','=','1')->get() ;
        return Route::latest()->where('status','=','1')
        ->with('deliverer')
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
        $route=Route::create([
            'municipio' => $request['municipio'],
            'status'=>true
        ]);
        foreach ( $request['deliverers'] as $deliverer) {
            $deliverer_id=$deliverer['id'];
            $deliverer_route=$route->deliverer()->attach
            ($deliverer_id);
        }
        return $deliverer_route;

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
        //ruta:  axios.get(`api/routes/${this.id_Deliverer}`)
        return Route::leftjoin('deliverer_route',
        'deliverer_route.route_id','=','routes.id')
        ->where('deliverer_route.deliverer_id', '=',$id)
        ->get();
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
