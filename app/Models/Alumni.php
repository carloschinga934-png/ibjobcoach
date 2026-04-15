<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    protected $table = 'alumni';
    protected $primaryKey = 'idalumni';
    public $timestamps = false; // Si tu tabla no tiene created_at ni updated_at

    protected $fillable = [
        'nombre',
        'name',      // Nombre del archivo de imagen
        'tipo',      // image/jpeg, image/png, etc.
        'tamanio',   // tamaño del archivo
        'email',
        'empresa',
        'posicion',
    ];
}
