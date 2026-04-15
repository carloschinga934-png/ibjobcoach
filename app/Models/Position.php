<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $table = 'posiciones'; // <- Importante, tu tabla real
    protected $fillable = ['nombre', 'valor'];
    public $timestamps = false; // Si tu tabla no tiene created_at/updated_at
}


