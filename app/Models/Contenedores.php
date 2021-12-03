<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contenedores extends Model
{
    use HasFactory;
    protected $fillable = ["identificacion","producto","cantidad","fechaArribo","lugarArribo","aeropuertodestino","productoid"];
    public function producto()
    {
        return $this->hasMany(Productos::class,"id");
    }

    
    public function envio()
    {
        return $this->hasMany(Envios::class,"id");
    }


}
