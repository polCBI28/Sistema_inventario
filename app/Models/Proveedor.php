<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = [
        'ruc',
        'razon_social', 
        'direccion', 
        'telefono', 
        'email', 
        'estado' 
        

    ];
}
