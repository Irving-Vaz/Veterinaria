<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\Admin\StoreUsuarioRequest;
use App\Http\Requests\Admin\UpdateUsuarioRequest;

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

    public function store(StoreUsuarioRequest $request)
    {
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

    public function edit(User $usuario)
    {
        $usuario->load('veterinario');
        return view('modules.admin.users.edit', compact('usuario'));
    }

    public function update(UpdateUsuarioRequest $request, User $usuario)
    {
        \Illuminate\Support\Facades\DB::transaction(function () use ($request, $usuario) {
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'rol' => $request->rol,
                'is_active' => $request->has('is_active') ? true : false,
            ];

            if ($request->filled('password')) {
                $userData['password'] = \Illuminate\Support\Facades\Hash::make($request->password);
            }

            $usuario->update($userData);

            if ($request->rol === 'veterinario') {
                $veterinario = $usuario->veterinario ?? new \App\Models\Veterinario(['usuario_id' => $usuario->id]);
                
                $veterinario->nombre_completo = $request->nombre_completo;
                $veterinario->especialidad = $request->especialidad;
                $veterinario->cedula_profesional = $request->cedula_profesional;

                if ($request->hasFile('foto_firma')) {
                    if ($veterinario->foto_firma && \Illuminate\Support\Facades\Storage::disk('public')->exists($veterinario->foto_firma)) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($veterinario->foto_firma);
                    }
                    $veterinario->foto_firma = $request->file('foto_firma')->store('firmas', 'public');
                }

                $veterinario->save();
            } else {
                if ($usuario->veterinario) {
                    if ($usuario->veterinario->foto_firma && \Illuminate\Support\Facades\Storage::disk('public')->exists($usuario->veterinario->foto_firma)) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($usuario->veterinario->foto_firma);
                    }
                    $usuario->veterinario->delete();
                }
            }
        });

        return redirect()->route('admin.users.index')->with('toast_success', 'Usuario actualizado correctamente.');
    }
}
