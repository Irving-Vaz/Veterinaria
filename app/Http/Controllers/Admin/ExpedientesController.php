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

    public function detalleConsulta(\App\Models\Mascota $mascota, \App\Models\Consulta $consulta)
    {
        // Asegurarse de que la consulta pertenece a la mascota
        if ($consulta->mascota_id !== $mascota->id) {
            abort(404);
        }

        $mascota->load('dueno');
        $consulta->load('veterinario');

        return view('modules.admin.expedientes.consulta_detalle', compact('mascota', 'consulta'));
    }

    public function diagnostico(\App\Models\Mascota $mascota, \App\Models\Consulta $consulta)
    {
        if ($consulta->mascota_id !== $mascota->id) {
            abort(404);
        }

        return view('modules.admin.expedientes.diagnostico', compact('mascota', 'consulta'));
    }

    public function guardarDiagnostico(Request $request, \App\Models\Mascota $mascota, \App\Models\Consulta $consulta)
    {
        if ($consulta->mascota_id !== $mascota->id) {
            abort(404);
        }

        $request->validate([
            'diagnostico' => 'required|string'
        ]);

        $esNuevo = empty($consulta->diagnostico) || trim(strip_tags($consulta->diagnostico)) === 'Aún sin diagnóstico';

        $nuevoDiagnostico = $request->input('diagnostico');
        
        // Evitar que Quill guarde un tag vacío como un diagnóstico real
        if (trim(strip_tags($nuevoDiagnostico)) === '') {
            $nuevoDiagnostico = null;
        }
        
        $consulta->diagnostico = $nuevoDiagnostico;
        $consulta->save();

        $mensaje = $esNuevo ? 'Se guardó la información' : 'Se actualizó con éxito';

        return redirect()->route('admin.expedientes.consultas.diagnostico', [$mascota->id, $consulta->id])
                         ->with('toast_success', $mensaje);
    }
}
