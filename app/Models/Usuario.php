<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'idusuario';
    public $timestamps = true;

    protected $fillable = [
        'nombre', 'apellido', 'correo', 'password',
        'pais', 'telefono', 'cargo',
        'status', 'role_id', 'fin_prueba',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $rememberTokenName = 'remember_token';

    public function username()
    {
        return 'correo';
    }

    // **AÑADE ESTE MÉTODO**
    public function getAuthIdentifierName()
    {
        return $this->getKeyName();
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    

    // Helpers para roles
    public function tieneRol($rol)
    {
        return $this->role && $this->role->nombre === $rol;
    }

    public function tieneAlgunRol(array $roles)
    {
        return $this->role && in_array($this->role->nombre, $roles);
    }

    public function esActivo()
    {
        return $this->status === 'activo';
    }

    public function enPruebaValida()
    {
        return $this->status === 'prueba' && $this->fin_prueba && now()->lt($this->fin_prueba);
    }
}
