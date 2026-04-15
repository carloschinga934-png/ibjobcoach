<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaArticulo extends Model
{
    protected $table = 'categoriaarticulo';
    protected $primaryKey = 'idcategoria';
    public $timestamps = false;

    protected $fillable = ['nombre'];

    public function articulos()
    {
        return $this->hasMany(Articulo::class, 'idcategoria');
    }
}
