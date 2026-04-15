<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Foro extends Model
{
    use SoftDeletes;

    protected $table = 'foro';
    protected $primaryKey = 'idforo';
    public $timestamps = true;

    protected $fillable = [
        'autor','foto','tipo','tamanio','titulo','descripcion',
        'fecha','estado','vistas',
        'categoria_id','empleado_id','num_respuestas','last_activity_at',
        'pinned','closed','tags'
    ];

    protected $casts = [
        'fecha'            => 'datetime',
        'last_activity_at' => 'datetime',
        'pinned'           => 'boolean',
        'closed'           => 'boolean',
        'tags'             => 'array',
    ];

    public function respuestas()
    {
        return $this->hasMany(ForoRespuesta::class, 'foro_id', 'idforo');
    }
}
