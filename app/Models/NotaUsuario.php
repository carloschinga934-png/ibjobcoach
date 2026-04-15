<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotaUsuario extends Model
{
    use HasFactory;

    protected $table = 'notas_usuarios';

    protected $fillable = [
        'usuario_id',
        'autor_id', 
        'titulo',
        'contenido',
        'tipo',
        'es_privada'
    ];

    protected $casts = [
        'es_privada' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relación con el usuario sobre quien es la nota
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'idusuario');
    }

    // Relación con el autor de la nota
    public function autor()
    {
        return $this->belongsTo(Usuario::class, 'autor_id', 'idusuario');
    }

    // Scopes para filtrar notas
    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    public function scopePublicas($query)
    {
        return $query->where('es_privada', false);
    }

    public function scopePrivadas($query)
    {
        return $query->where('es_privada', true);
    }

    public function scopeRecientes($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // Accessor para formato de fecha amigable
    public function getFechaFormateadaAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    // Accessor para color según tipo
    public function getColorTipoAttribute()
    {
        $colores = [
            'info' => 'primary',
            'importante' => 'warning', 
            'seguimiento' => 'info',
            'problema' => 'danger',
            'resuelto' => 'success'
        ];

        return $colores[$this->tipo] ?? 'secondary';
    }

    // Accessor para icono según tipo
    public function getIconoTipoAttribute()
    {
        $iconos = [
            'info' => 'fa-info-circle',
            'importante' => 'fa-exclamation-triangle',
            'seguimiento' => 'fa-clock',
            'problema' => 'fa-bug',
            'resuelto' => 'fa-check-circle'
        ];

        return $iconos[$this->tipo] ?? 'fa-sticky-note';
    }

    // Método para verificar si el usuario puede ver la nota
    public function puedeVer($usuarioId)
    {
        if (!$this->es_privada) {
            return true;
        }
        
        return $this->autor_id == $usuarioId;
    }
}