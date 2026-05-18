<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    protected $fillable = [
        'mascota_id',
        'veterinario_id',
        'fecha_consulta',
        'peso',
        'talla',
        'diagnostico',
        'tratamiento',
    ];

    protected $casts = [
        'fecha_consulta' => 'datetime',
        'peso' => 'decimal:2',
        'talla' => 'decimal:2',
    ];

    public function mascota()
    {
        return $this->belongsTo(Mascota::class);
    }

    public function veterinario()
    {
        return $this->belongsTo(Veterinario::class);
    }
}
