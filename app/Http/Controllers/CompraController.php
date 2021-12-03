<?php

namespace App\Http\Controllers;

use App\Models\Compras;
use App\Models\Precios;
use App\Models\Productos;
use App\Models\Proveedores;
use Illuminate\Http\Request;
use App\Models\Detallecompras;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\auth\AuthController;

class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $compras = Compras::with("usuario")->get();
        $proveedores = Proveedores::all();
        $productos = Productos::all();
        $precios = Precios::with("producto")->get();
        return response()->json([
            "compras" => $compras,
            "precios" => $precios,
            "proveedores" => $proveedores,
            "productos" => $productos,
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
        DB::beginTransaction();
        try {
            $compra = Compras::create([
                    'fechacompra' => date("Y-m-d"),
                    'totalcompra' => $request->post("total"),
                    'usuarioid' => 1
            ]);
            foreach ($request->post("detalle") as $value) {
                Detallecompras::create([
                        'cantidad' => $value['cantidad'],
                        'precio' => $value['precio'],
                        'compraid' => $compra->id,
                        'productoid' => $value['productoid'],
                        'proveedorid' => $value['proveedorid'],
                        'subtotal' => $value['subtotal']
                ]);
            }
            DB::commit();
            return response()->json("comptra agregada correctamente");

        } catch (\Throwable $e) {
            DB::rollback();
            return response()->json($e);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Compras $compra)
    {
        $query = DB::table('detallecompras')
        ->join('productos', 'detallecompras.productoid', 'productos.id')
        ->join('proveedores', 'detallecompras.proveedorid', 'proveedores.id')
        ->join('compras', 'detallecompras.compraid', 'compras.id')
        ->select(
            'compras.id',
            'compras.totalcompra',
            'compras.created_at',
            'proveedores.proveedor',
            'productos.producto',
            'detallecompras.id as codigo',
            'detallecompras.cantidad',
            'detallecompras.precio',
            'detallecompras.subtotal',
        )
        ->where('detallecompras.compraid', $compra->id)
        ->get();

        // return $query;
        //
        return response()->json($query);
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
    public function update(Request $request, Compras $compra)
    {
        $compra->fill($request->post())->save();
        return response()->json([
            'compra'=>$compra
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Compras $compra)
    {
        //
        $compra->delete();
        return response()->json([
            "mensaje" =>"compra eliminado"
        ]);
    }
}
