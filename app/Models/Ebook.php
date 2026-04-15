<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Ebook extends Model
{
    use HasFactory;

    // Si tu PK es "id" elimina esta línea
    protected $primaryKey = 'idebook';

    // Si tu tabla se llama distinto, cámbiala. Por defecto "ebooks"
    protected $table = 'ebooks';

    // Campos asignables en masa
    protected $fillable = [
        'titulo',
        'fecha',
        'autor',
        'precio',
        'archivo', 
    ];

    // Casts útiles
    protected $casts = [
        'fecha'  => 'date',
        'precio' => 'decimal:2',
    ];

    // Accesor conveniente: url pública del archivo
    protected $appends = ['archivo_url'];


    public function getArchivoUrlAttribute(): ?string
    {
        return $this->archivo ? asset('storage/'.$this->archivo) : null;
    }

}
