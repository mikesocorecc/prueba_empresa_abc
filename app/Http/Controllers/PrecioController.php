<?php

namespace App\Http\Controllers;

use App\Models\Precios;
use App\Models\Productos;
use App\Models\Proveedores;
use Illuminate\Http\Request;

class PrecioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $precios = Precios::with("producto")->with("proveedor")->get();
        $productos = Productos::all();
        $proveedores = Proveedores::all();
        return response()->json([
            "precios" => $precios,
            "productos" => $productos,
            "proveedores" => $proveedores,
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
        $precio = Precios::create($request->post());
        return response()->json([           
            'blog'=>$precio
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Precios $precio)
    {
        //
        return response()->json($precio);
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
    public function update(Request $request, Precios $precio)
    {
        //
        $precio->fill($request->post())->save();
        return response()->json([            
            'precio'=>$precio
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Precios $precio)
    {
        //
        $precio->delete();
        return response()->json([
            "mensaje" =>"precio eliminado"
        ]);
    }
    // Metodos propios
    public function proveedoresPrecios(Precios $proveedor)
    {
        //
        return response()->json($proveedor);
    }
}
