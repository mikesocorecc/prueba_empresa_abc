<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Envios extends Model
{
    use HasFactory;
    protected $fillable = ["fechaEntrega","paisDestino","contenedorid"];

    public function contenedor()
    {
        return $this->hasOne(Contenedores::class, "id", "contenedorid");
    }
}
