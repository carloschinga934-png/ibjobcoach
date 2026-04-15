<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    protected $table = 'articulos'; // O 'articulos' si así se llama, fíjate en tu BD
    protected $primaryKey = 'idarticulo';
    public $timestamps = false;

    protected $fillable = [
        'descripcion',
        'nombre',
        'tipo',
        'tamanio',
        'fechapublicacion',
        'idcategoria',
    ];

    public function categoria()
    {
        return $this->belongsTo(CategoriaArticulo::class, 'idcategoria');
    }
}
