<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index()
    {
        return view('modules/auth/login');
    }

    public function logear(Request $request)
    {
        $credenciales = [
            'email'    => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credenciales)) {
            $name = Auth::user()->name;
            $rol  = Auth::user()->rol;

            if ($rol === 'administrador') {
                return to_route('admin.dashboard')
                    ->with('toast_success', "¡Bienvenido al panel de administración, {$name}!");
            }

            return to_route('home')
                ->with('toast_success', "¡Bienvenido, {$name}!");
        }

        return redirect()->back()
            ->with('toast_error', 'Credenciales incorrectas. Verifica tu correo y contraseña.');
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return to_route('login');
    }

    // ── Veterinario ──────────────────────────────────────────────
    public function home()
    {
        return view('modules/dashboard/home');
    }

    // ── Administrador ─────────────────────────────────────────────
    public function adminDashboard()
    {
        $totalUsuarios = \App\Models\User::count();
        $totalVeterinarios = \App\Models\User::where('rol', 'veterinario')->count();
        $users = \App\Models\User::orderBy('created_at', 'desc')->take(5)->get();

        return view('modules/admin/dashboard', compact('totalUsuarios', 'totalVeterinarios', 'users'));
    }
}
