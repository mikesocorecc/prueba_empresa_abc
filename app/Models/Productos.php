<?php

namespace App\Models;

use App\Models\Precios;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Productos extends Model
{
    use HasFactory;
    protected $fillable = ["producto","sku","presentacion","volumen","unidades"];

    // public function precios(){
    //     return $this->hasMany(Precios::class);
    //     // return $this->belongsTo(Precios::class);
    // }
}
