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
            $rol = Auth::user()->rol;

            if ($rol === 'administrador') {
                return to_route('admin.dashboard');
            }

            return to_route('home');
        }

        return to_route('login');
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
        return view('modules/admin/dashboard');
    }
}
