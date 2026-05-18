<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dueno extends Model
{
    protected $fillable = [
        'nombre_completo',
        'telefono',
        'direccion',
    ];

    public function mascotas()
    {
        return $this->hasMany(Mascota::class);
    }
}
