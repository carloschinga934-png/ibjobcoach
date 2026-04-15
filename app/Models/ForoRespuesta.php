<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForoRespuesta extends Model
{
    protected $table = 'foro_respuestas';
    protected $primaryKey = 'idrespuestaforo';
    public $timestamps = true;

    protected $fillable = [
        'foro_id','usuario_id','nombre','es_admin','mensaje'
    ];

    protected $casts = [
        'es_admin' => 'boolean',
    ];

    public function foro()
    {
        return $this->belongsTo(Foro::class, 'foro_id', 'idforo');
    }

    public function autorUsuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'idusuario');
    }

}
