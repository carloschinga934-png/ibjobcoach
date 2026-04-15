<?php

// app/Models/ActividadSoporte.php

// app/Models/ActividadSoporte.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActividadSoporte extends Model
{
    protected $fillable = ['ticket_id', 'usuario_id', 'actividad'];

    // Relación con el ticket
    public function ticket()
    {
        return $this->belongsTo(TicketSoporte::class, 'ticket_id');  // Usar ticket_id
    }

    // Relación con el usuario que realizó la actividad
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}

