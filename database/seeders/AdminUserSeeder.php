<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Crea los usuarios por defecto: administrador y veterinario.
     */
    public function run(): void
    {
        User::create([
            'name'     => 'admin',
            'email'    => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'rol'      => 'administrador',
        ]);

        User::create([
            'name'     => 'veterinario',
            'email'    => 'veterinario@gmail.com',
            'password' => Hash::make('veterinario'),
            'rol'      => 'veterinario',
        ]);
    }
}
