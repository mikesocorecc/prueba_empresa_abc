<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProveedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('proveedores')->insert([
            [
                'proveedor' => 'ARTEX DOS MIL',
                'direccion' => '13 av. 2-18 zona 1, Guatemala, C.A.',
                'telefono' => "(502) 2387-8902",
                'telefonoContacto' => "(502) 5621-3912" 
            ],
             
            [
                'proveedor' => 'ELCATEX',
                'direccion' => 'Carretera a Puerto Cortes, entrada Colonia La Mora costado N.O. de Zip Choloma, Complejo Zip Tex, Ch',
                'telefono' => "(504) 2617-7700",
                'telefonoContacto' => "2342343" 
            ],
             
            [
                'proveedor' => 'Alimentos C&amp;Q',
                'direccion' => '13 av. .',
                'telefono' => "(502) 2222-8902",
                'telefonoContacto' => "(502) 2221-3912" 
            ]
             
        ]);
    }
}
