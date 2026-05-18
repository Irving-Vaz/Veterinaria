<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Dueno;
use App\Models\Mascota;
use App\Models\Consulta;
use App\Models\Veterinario;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ExpedienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Obtener o crear un veterinario de prueba
        $veterinario = Veterinario::first();
        
        if (!$veterinario) {
            $user = User::create([
                'name' => 'vet_test',
                'email' => 'vet@test.com',
                'password' => Hash::make('password'),
                'rol' => 'veterinario',
                'is_active' => true,
            ]);
            
            $veterinario = Veterinario::create([
                'usuario_id' => $user->id,
                'nombre_completo' => 'Dr. Test Veterinario',
                'especialidad' => 'Medicina General',
                'cedula_profesional' => '12345678',
            ]);
        }

        // 2. Crear un dueño
        $dueno = Dueno::create([
            'nombre_completo' => 'Carlos López',
            'telefono' => '555-123-4567',
            'direccion' => 'Calle Falsa 123, Ciudad',
        ]);

        // 3. Crear una mascota
        $mascota = Mascota::create([
            'dueno_id' => $dueno->id,
            'nombre' => 'Firulais',
            'especie' => 'Perro',
            'raza' => 'Mestizo',
            'fecha_nacimiento' => Carbon::now()->subYears(3)->format('Y-m-d'),
            'tipo_sangre' => 'DEA 1.1 Positivo',
            'comportamiento' => 'Dócil y juguetón',
            'es_adoptado' => true,
        ]);

        // 4. Crear dos consultas
        Consulta::create([
            'mascota_id' => $mascota->id,
            'veterinario_id' => $veterinario->id,
            'fecha_consulta' => Carbon::now()->subDays(30),
            'peso' => 12.5,
            'talla' => 45.0,
            'diagnostico' => 'Chequeo general, presenta leve inflamación en encías.',
            'tratamiento' => 'Limpieza dental recomendada y dieta blanda por 3 días.',
        ]);

        Consulta::create([
            'mascota_id' => $mascota->id,
            'veterinario_id' => $veterinario->id,
            'fecha_consulta' => Carbon::now(),
            'peso' => 12.8,
            'talla' => 45.0,
            'diagnostico' => 'Paciente saludable, recuperación de encías favorable.',
            'tratamiento' => 'Continuar con alimentación normal y profilaxis anual.',
        ]);
    }
}
