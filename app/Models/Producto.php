<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    /** @use HasFactory<\Database\Factories\ProductoFactory> */
    use HasFactory;

    protected $fillable = [
        'nombre',
        'decripcion',
        'codigo_barras',
        'precio_compra',
        'stock',
        'stock_minimo',
        'estado',
        'categoria_id',
        'proveedor_id'
    ];
    
protected $casts = [
    'estado' => 'boolean',
];
public function categoria()
{
    return $this->belongsTo(Categoria::class,'categoria_id');
}
public function proveedor()
{
    return $this->belongsTo(Proveedor::class,'proveedor_id');
}
}

