<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contenido extends Model
{
    protected $table = 'contenidos';
    protected $primaryKey = 'idcontenido';
    public $timestamps = false;

    protected $fillable = [
        'descripcion',
        'nombre',
        'url',
        'idcategoria',
        'fechapublicacion',
    ];

    public function categoria()
    {
        return $this->belongsTo(CategoriaContenido::class, 'idcategoria');
    }
}