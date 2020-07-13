<?php

namespace App\Http\Controllers\API;

use App\Expense;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use PDF;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Expense::get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return Expense::create([
            'deliverer_id' => $request['deliverer_id'],
            'descripcion' => $request['descripcion'],
            'monto' => $request['monto'],
            'status' => true
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
        $expense = expense::findOrFail($id);

        $validator = Validator::make( $request->all(), [
            'deliverer_id' => 'nullable|Integer',
            'descripcion' => 'required|max:200',
            'monto' => 'required|numeric',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['validation_errors' => $validator->errors()]);
        }

        $expense->update([
            'deliverer_id' => $request['deliverer_id'],
            'descripcion' => $request['descripcion'],
            'monto' => $request['monto'],
        ]);

        return$expense;
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $expense = expense::findOrFail($id);
        $expense->update([
            'status' => false,
        ]);
    }
    //Se crea una funcion que llama los datos de la base de datos y los muestra en un pdf de forma horizontal
    public function PDFExpenses(){
        $expenses = Expense::all();
        $pdf = PDF::loadView('expenses', compact('expenses'));
        return $pdf->setPaper('a4', 'landscape')->stream('expenses.pdf');
    }
}
