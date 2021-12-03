<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detallecompras extends Model
{
    use HasFactory;
    protected $fillable = ["cantidad","precio","compraid","productoid","proveedorid","subtotal"];

    
    public function compra()
    {
        return $this->belongsTo(Compras::class);
    }
}
