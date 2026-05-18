<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UsuariosController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('modules.admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('modules.admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'rol' => 'required|in:administrador,veterinario',
            'nombre_completo' => 'required_if:rol,veterinario|string|max:255',
            'especialidad' => 'required_if:rol,veterinario|string|max:255',
            'cedula_profesional' => 'required_if:rol,veterinario|string|max:255',
            'foto_firma' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        \Illuminate\Support\Facades\DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => \Illuminate\Support\Facades\Hash::make($request->password),
                'rol' => $request->rol,
            ]);

            if ($request->rol === 'veterinario') {
                $rutaFoto = null;
                if ($request->hasFile('foto_firma')) {
                    $rutaFoto = $request->file('foto_firma')->store('firmas', 'public');
                }

                \App\Models\Veterinario::create([
                    'usuario_id' => $user->id,
                    'nombre_completo' => $request->nombre_completo,
                    'especialidad' => $request->especialidad,
                    'cedula_profesional' => $request->cedula_profesional,
                    'foto_firma' => $rutaFoto,
                ]);
            }
        });

        return redirect()->route('admin.users.index')->with('toast_success', 'Usuario creado correctamente.');
    }
}
