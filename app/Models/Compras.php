<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compras extends Model
{
    use HasFactory;
    protected $fillable = ["usuarioid","fechacompra","totalcompra"];

    public function usuario()
    {
        return $this->hasOne(User::class,"id","usuarioid");
    }
    
    public function detallecompras(){
        return $this->belongsToMany(Detallecompras::class,"id","compraid");
    }
}
