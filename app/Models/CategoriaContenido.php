<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaContenido extends Model
{
    protected $table = 'categoriacontenido';
    protected $primaryKey = 'idcategoria';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
    ];

    public function contenidos()
    {
        return $this->hasMany(Contenido::class, 'idcategoria');
    }
}
