<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'estado',
        'pendiente_validacion',
        'validado_por',
        'validado_en',
        'observaciones_validacion',
        // …otros campos
    ];

    protected $casts = [
        'pendiente_validacion' => 'boolean',
        'validado_en'          => 'datetime',
    ];
}