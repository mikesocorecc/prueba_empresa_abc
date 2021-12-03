<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('productos')->insert([
            [
                'producto' => 'Azuca La morena',
                'sku' => '123456',
                'presentacion' => "Libra",
                'volumen' => "15 Kgs",
                'unidades' => "21" 
            ],
            [
                'producto' => 'Nescafe',
                'sku' => '23423',
                'presentacion' => "Libra",
                'volumen' => "50 Kgs",
                'unidades' => "1" 
            ],
            [
                'producto' => 'Velas aromaticas',
                'sku' => 'VLA01',
                'presentacion' => "Velas",
                'volumen' => "1 Qty",
                'unidades' => "3" 
            ]
        ]);
    }
}
