<?php

namespace App\Http\Controllers;

use App\Models\Contenedores;
use App\Models\Productos;
use Illuminate\Http\Request;

class ContenedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $contenedores = Contenedores::with("producto")->get();
        $productos = Productos::all();
        return response()->json([
            "contenedores" => $contenedores,
            "productos" => $productos
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
        $contenedor = Contenedores::create($request->post());
        return response()->json([           
            'contenedor'=>$contenedor
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Contenedores $contenedor)
    {
        //
        return response()->json($contenedor);
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
    public function update(Request $request,Contenedores $contenedor)
    {
        //
        $contenedor->fill($request->post())->save();
        return response()->json([            
            'contenedor'=>$contenedor
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contenedores $contenedor)
    {
        //
        $contenedor->delete();
        return response()->json([
            "mensaje" =>"contenedor eliminado"
        ]);
    }
}