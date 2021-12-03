<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Precios extends Model
{
    use HasFactory;
    protected $fillable = ["productoid","proveedorid","precio"];

    public function producto()
    {
        return $this->belongsTo(Productos::class,"productoid");
    }
    public function proveedor()
    {
        return $this->hasMany(Proveedores::class,"id");
    }
}
