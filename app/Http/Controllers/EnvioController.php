<?php

namespace App\Http\Controllers;

use App\Models\Contenedores;
use App\Models\Envios;
use Illuminate\Http\Request;

class EnvioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $envios = Envios::with("contenedor")->get();
        $contenedores = Contenedores::all();
        return response()->json([
            "envios" => $envios,
            "contenedores" => $contenedores
        ]);
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
        //
        $envios = Envios::create($request->post());
        return response()->json([           
            'envios'=>$envios
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Envios $envio)
    {
        //
        return response()->json($envio);
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
    public function update(Request $request,Envios $envio)
    {
        //
        $envio->fill($request->post())->save();
        return response()->json([            
            'envios'=>$envio
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Envios $envio)
    {
        //
        $envio->delete();
        return response()->json([
            "mensaje" =>"envio eliminado"
        ]);
    }
}