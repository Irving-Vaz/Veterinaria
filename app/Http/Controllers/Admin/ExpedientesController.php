<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExpedientesController extends Controller
{
    public function index()
    {
        return view('modules.admin.expedientes.index');
    }

    public function search(Request $request)
    {
        $query = $request->input('q', '');
        
        if (empty($query)) {
            return response()->json([]);
        }

        $mascotas = \App\Models\Mascota::search($query)
            ->query(function ($builder) use ($query) {
                $builder->with('dueno')
                        ->orWhereHas('dueno', function ($q) use ($query) {
                            $q->where('nombre_completo', 'like', '%' . $query . '%');
                        });
            })
            ->take(5)
            ->get();

        return response()->json($mascotas);
    }

    public function consultas(\App\Models\Mascota $mascota)
    {
        $mascota->load(['dueno', 'consultas' => function ($query) {
            $query->with('veterinario')->orderBy('fecha_consulta', 'desc');
        }]);

        return view('modules.admin.expedientes.consultas', compact('mascota'));
    }
}
