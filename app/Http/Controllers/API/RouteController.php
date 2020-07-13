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
        //Se obtienen y devuelven todas las rutas que tengan un "status" igual a 1
        //y se ordenan de manera descendente
        return Route::latest()->where('status','=','1')
        //También nos permitimos el acceso a los datos de la tabla intermedia entre route y deliverer
        ->with('deliverer')
        ->get();


    }
    //Obtiene los clientes que pertenecen al id de la ruta que se recibe
    public function getCustomer($id_route){
        //Se obtiene y devuelve la información de los clientes que pertenecen a la ruta
        //donde su campo "id" sea igual al "id" recibido
        return Route::findOrFail($id_route)->customer()
        ->where('customers.status', "=", 1)
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
        //Creamos una nuevo registro de ruta
        $route=Route::create([
            'municipio' => $request['municipio'],
            'status'=>true
        ]);

        //Llenamos la tabla intermedia con los datos obtenidos en el request y
        // del nuevo registro de la ruta
        $deliverer_route=$route->deliverer()->attach
        ($request['deliverer_id']);

        //Devolvemos el nuevo registro de la tabla intermedia
        return $deliverer_route;

        /*foreach ( $request['deliverers'] as $deliverer) {
            $deliverer_id=$deliverer['id'];
            $deliverer_route=$route->deliverer()->attach
            ($deliverer_id);
        }*/


    }
    public function createdeliverer_route(Request $request)
    {
        //Obtenemos la ruta que coincida con el id obtenido y llenamos la tabla intermedia
        // con los datos de la entrada.
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
        //Obtenemos y devolvemos todos los datos de las rutas que tiene un repartidor.
        //Hacemos un leftjoin con el campo "route_id" de la tabla "deliverer_route"
        //y el campo "id" de la tabla "routes"
        return Route::leftjoin('deliverer_route',
        'deliverer_route.route_id','=','routes.id')
        //Donde en la tabla "deliverer_route" todos los registros
        //que en su campo "deliverer_id" sean igual al "id" recibido.
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
        //Buscamos la ruta que en su campo "id" coincida con e "id" recibido y la guardamos en "$route"
        $route = Route::findOrFail($id);

        //Validamos los datos de la entrada
        $validator = Validator::make( $request->all(), [
            'municipio' => 'required|max:255'
            ]
        );

         //Si hay un error enviamos un mensaje con el error
        if ($validator->fails()) {
            return response()->json(['validation_errors' => $validator->errors()]);
        }

        //Actualizamos el campo "municipio" de la tabla "routes" con la información obtenida de la entrada.
        $route->update([
            'municipio' => $request['municipio']
             ]);

        //Devolvemos la ruta con su campo actualizado.
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
        //En la ruta que coincida con el id recibido se actualiza el campo "status" a 0
        $route = Route::findOrFail($id);
        $route->update([
            'status' => false
        ]);
    }
}
