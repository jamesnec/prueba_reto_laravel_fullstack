<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Exchange;

class ExchangeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['convert']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list_exchanges = Exchange::all();

        $data = [
            'list_exchanges' => $list_exchanges
        ];

        return response()->json($data);  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required|numeric',
            'origin' => 'required|string',
            'destination' => 'required|string',
        ], [
            'amount.required' => 'Campo obligatorio',
            'amount.numeric' => 'Campo numérico',
            'origin.required' => 'Campo obligatorio',
            'destination.required' => 'Campo obligatorio',
        ]);

        $add_article = Exchange::saveCreate($request);
        if($add_article->save()){
            return response()->json(["success" => "Tipo de cambio agregado"], 200);
        } else {
            return response()->json(["error" => "Error al agregar el tipo de cambio"], 401);
        } 
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        if($my_exchange = Exchange::find($id)){
            $this->validate($request, [
                'amount' => 'required|numeric',
                'origin' => 'required|string',
                'destination' => 'required|string',
            ], [
                'amount.required' => 'Campo obligatorio',
                'amount.numeric' => 'Campo numérico',
                'origin.required' => 'Campo obligatorio',
                'destination.required' => 'Campo obligatorio',
            ]);
    
            $update_article = Exchange::saveUpdate($request, $id);
            if($update_article->save()){
                return response()->json(["success" => "Tipo de cambio actualizado"], 200);
            } else {
                return response()->json(["error" => "Error al actualizar el tipo de cambio"], 401);
            } 
        }else{
            return response()->json(["error" => "El tipo de cambio no existe"], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($my_exchange = Exchange::find($id)){
            if($my_exchange->delete()){
                return response()->json(["success" => "Tipo de cambio eliminado"], 200);
            } else {
                return response()->json(["error" => "Error al eliminar el tipo de cambio"], 401);
            } 
        }else{
            return response()->json(["error" => "El tipo de cambio no existe"], 404);
        }
    }

    public function convert(Request $request){
        $this->validate($request, [
            'amount' => 'required|numeric',
            'origin' => 'required|string',
            'destination' => 'required|string',
        ], [
            'amount.required' => 'Campo obligatorio',
            'amount.numeric' => 'Campo numérico',
            'origin.required' => 'Campo obligatorio',
            'destination.required' => 'Campo obligatorio',
        ]);

        $my_exchange = Exchange::select('amount','origin','destination')->where('origin', $request['origin'])->where('destination', $request['destination'])->first();
        if($my_exchange){
            $new_amount = $my_exchange['amount'] * $request['amount'];
            $data = [
                "my_exchange" => $my_exchange,
                "old_amount" => $request['amount'],
                "new_amount" => $new_amount
            ];

            return response()->json($data, 200);
        } else {
            return response()->json(["message" => "Tipo de cambio no registrado"], 401);
        } 
    }

    public function list(){
        $list_exchanges = Exchange::select('amount', 'origin', 'destination')->get();

        $data = [
            'list_exchanges' => $list_exchanges
        ];

        return response()->json($data);
    }
}
