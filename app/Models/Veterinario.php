<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Veterinario extends Model
{
    protected $table = 'veterinarios';

    protected $fillable = [
        'usuario_id',
        'nombre_completo',
        'especialidad',
        'cedula_profesional',
        'foto_firma',
    ];

    /**
     * Un veterinario pertenece a un usuario (cuenta de sistema)
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
