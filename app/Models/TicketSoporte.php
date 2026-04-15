<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TicketSoporte extends Model
{
    use HasFactory;

    protected $table = 'tickets_soporte';

    protected $fillable = [
        'usuario_id',
        'asignado_a',
        'numero_ticket',
        'titulo',
        'descripcion',
        'prioridad',
        'categoria',
        'estado',
        'fecha_limite',
        'fecha_resolucion',
        'solucion',
        'calificacion',
        'comentario_calificacion',
        'tiempo_resolucion',
        'validado',
        'validado_por',
        'fecha_validacion',
        'observaciones_validacion'
    ];

    protected $casts = [
        'validado' => 'boolean',
        'fecha_limite' => 'datetime',
        'fecha_resolucion' => 'datetime',
        'fecha_validacion' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relación con el usuario (cliente)
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'idusuario');
    }

    // Relación con el empleado asignado
    public function asignado()
    {
        return $this->belongsTo(Usuario::class, 'asignado_a', 'idusuario');
    }

    // Relación con quien validó el ticket
    public function validador()
    {
        return $this->belongsTo(Usuario::class, 'validado_por', 'idusuario');
    }

    // Scopes
    public function scopeAbiertos($query)
    {
        return $query->whereIn('estado', ['abierto', 'en_progreso']);
    }

    public function scopePorPrioridad($query, $prioridad)
    {
        return $query->where('prioridad', $prioridad);
    }

    public function scopeVencidos($query)
    {
        return $query->where('fecha_limite', '<', now())
                    ->whereNotIn('estado', ['resuelto', 'cerrado']);
    }

    public function scopeAsignadoA($query, $usuarioId)
    {
        return $query->where('asignado_a', $usuarioId);
    }

    public function scopeValidados($query)
    {
        return $query->where('validado', true);
    }

    public function scopeSinValidar($query)
    {
        return $query->where('validado', false)->where('estado', 'resuelto');
    }

    // Accessors
    public function getColorPrioridadAttribute()
    {
        $colores = [
            'baja' => 'secondary',
            'normal' => 'primary',
            'alta' => 'warning',
            'urgente' => 'danger'
        ];
        return $colores[$this->prioridad] ?? 'primary';
    }

    public function getColorEstadoAttribute()
    {
        $colores = [
            'abierto' => 'danger',
            'en_progreso' => 'warning',
            'esperando_cliente' => 'info',
            'resuelto' => 'success',
            'cerrado' => 'dark'
        ];
        return $colores[$this->estado] ?? 'secondary';
    }

    public function getIconoEstadoAttribute()
    {
        $iconos = [
            'abierto' => 'fa-exclamation-circle',
            'en_progreso' => 'fa-clock',
            'esperando_cliente' => 'fa-hourglass-half',
            'resuelto' => 'fa-check-circle',
            'cerrado' => 'fa-lock'
        ];
        return $iconos[$this->estado] ?? 'fa-ticket-alt';
    }

    public function getTiempoRespuestaAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getEstaVencidoAttribute()
    {
        return $this->fecha_limite && 
               $this->fecha_limite->isPast() && 
               !in_array($this->estado, ['resuelto', 'cerrado']);
    }

    // Métodos de validación y gestión
    public function puedeEditar($usuarioId)
    {
        return $this->asignado_a == $usuarioId || 
               $this->usuario_id == $usuarioId;
    }

    public function puedeResolver($usuarioId)
    {
        return $this->asignado_a == $usuarioId;
    }

    public function puedeValidar($usuarioId)
    {
        // Solo supervisores/administradores pueden validar
        return $this->estado === 'resuelto' && 
               $this->asignado_a != $usuarioId && 
               !$this->validado;
    }

    public function marcarComoResuelto($solucion = null)
    {
        $tiempoResolucion = $this->created_at->diffInHours(now());
        
        $this->update([
            'estado' => 'resuelto',
            'fecha_resolucion' => now(),
            'solucion' => $solucion,
            'tiempo_resolucion' => $tiempoResolucion
        ]);
    }

    public function validarAtencion($validadorId, $observaciones = null)
{
    $this->update([
        'validado' => true,
        'validado_por' => $validadorId,
        'fecha_validacion' => now(),
        'observaciones_validacion' => $observaciones,
        'estado' => 'cerrado'
    ]);
}

    // Generar número de ticket automáticamente
    public static function generarNumeroTicket()
    {
        $año = date('Y');
        $ultimo = self::whereYear('created_at', $año)
                     ->orderBy('id', 'desc')
                     ->first();
        
        $numero = $ultimo ? (int)substr($ultimo->numero_ticket, -4) + 1 : 1;
        
        return 'TS-' . $año . '-' . str_pad($numero, 4, '0', STR_PAD_LEFT);
    }

    // Boot method para generar número automáticamente
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($ticket) {
            if (!$ticket->numero_ticket) {
                $ticket->numero_ticket = self::generarNumeroTicket();
            }
        });
    }
     public function actividades()
{
    return $this->hasMany(ActividadSoporte::class, 'ticket_id');  // ✅ CORRECTO
}
}