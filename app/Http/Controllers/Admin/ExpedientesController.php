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

    public function create()
    {
        return view('modules.admin.expedientes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            // Dueño validation
            'dueno_nombre' => 'required|string|max:255',
            'dueno_telefono' => 'required|string|max:20',
            'dueno_direccion' => 'nullable|string|max:500',
            
            // Mascota validation
            'mascota_nombre' => 'required|string|max:255',
            'especie' => 'required|string|max:100',
            'raza' => 'nullable|string|max:100',
            'fecha_nacimiento' => 'nullable|date',
            'tipo_sangre' => 'nullable|string|max:10',
            'comportamiento' => 'nullable|string|max:100',
            'es_adoptado' => 'nullable|boolean',
        ]);

        // Create Dueno
        $dueno = \App\Models\Dueno::create([
            'nombre_completo' => $request->input('dueno_nombre'),
            'telefono' => $request->input('dueno_telefono'),
            'direccion' => $request->input('dueno_direccion'),
        ]);

        // Create Mascota
        $mascota = \App\Models\Mascota::create([
            'dueno_id' => $dueno->id,
            'nombre' => $request->input('mascota_nombre'),
            'especie' => $request->input('especie'),
            'raza' => $request->input('raza'),
            'fecha_nacimiento' => $request->input('fecha_nacimiento'),
            'tipo_sangre' => $request->input('tipo_sangre'),
            'comportamiento' => $request->input('comportamiento'),
            'es_adoptado' => $request->has('es_adoptado'),
        ]);

        return redirect()->route('admin.expedientes.consultas', $mascota->id)
                         ->with('toast_success', 'Paciente registrado con éxito');
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

    public function tratamiento(\App\Models\Mascota $mascota, \App\Models\Consulta $consulta)
    {
        if ($consulta->mascota_id !== $mascota->id) {
            abort(404);
        }

        return view('modules.admin.expedientes.tratamiento', compact('mascota', 'consulta'));
    }

    public function guardarTratamiento(Request $request, \App\Models\Mascota $mascota, \App\Models\Consulta $consulta)
    {
        if ($consulta->mascota_id !== $mascota->id) {
            abort(404);
        }

        $request->validate([
            'medicamentos' => 'required|array|min:1',
            'medicamentos.*.nombre' => 'required|string|max:255',
            'medicamentos.*.dosis' => 'required|string|max:100',
            'medicamentos.*.via' => 'required|string|max:100',
            'medicamentos.*.frecuencia' => 'required|integer|min:0', // 0 = dosis unica, 8, 12, 24 = horas
            'medicamentos.*.duracion' => 'required|integer|min:1', // dias
        ]);

        $esNuevo = empty($consulta->tratamiento);

        $consulta->tratamiento = $request->input('medicamentos');
        $consulta->save();

        $mensaje = $esNuevo ? 'Tratamiento registrado exitosamente' : 'Tratamiento actualizado con éxito';

        return redirect()->route('admin.expedientes.consultas.tratamiento', [$mascota->id, $consulta->id])
                         ->with('toast_success', $mensaje);
    }

    public function alergias(\App\Models\Mascota $mascota, \App\Models\Consulta $consulta)
    {
        if ($consulta->mascota_id !== $mascota->id) {
            abort(404);
        }

        return view('modules.admin.expedientes.alergias', compact('mascota', 'consulta'));
    }

    public function guardarAlergias(Request $request, \App\Models\Mascota $mascota, \App\Models\Consulta $consulta)
    {
        if ($consulta->mascota_id !== $mascota->id) {
            abort(404);
        }

        $request->validate([
            'alergias' => 'array',
            'alergias.insectos' => 'nullable|string|max:1000',
            'alergias.medicamentos' => 'nullable|string|max:1000',
            'alergias.alimentos' => 'nullable|string|max:1000',
            'alergias.ambientales' => 'nullable|string|max:1000',
        ]);

        $mascota->alergias = $request->input('alergias');
        $mascota->save();

        return redirect()->route('admin.expedientes.consultas.alergias', [$mascota->id, $consulta->id])
                         ->with('toast_success', 'Alergias actualizadas con éxito');
    }

    public function lesiones(\App\Models\Mascota $mascota, \App\Models\Consulta $consulta)
    {
        if ($consulta->mascota_id !== $mascota->id) {
            abort(404);
        }

        return view('modules.admin.expedientes.lesiones', compact('mascota', 'consulta'));
    }

    public function guardarLesiones(Request $request, \App\Models\Mascota $mascota, \App\Models\Consulta $consulta)
    {
        if ($consulta->mascota_id !== $mascota->id) {
            abort(404);
        }

        $request->validate([
            'lesiones' => 'nullable|array',
            'lesiones.*.lugar' => 'required|string|max:255',
            'lesiones.*.procedimiento' => 'required|string|max:255',
            'lesiones.*.fecha' => 'required|date',
            'lesiones.*.vincular_consulta' => 'nullable',
            // vinculamos el id de la consulta solo si el checkbox esta marcado
        ]);

        $lesionesInput = $request->input('lesiones', []);
        
        $lesionesGuardar = [];
        foreach ($lesionesInput as $lesion) {
            $consultaIdVinculada = isset($lesion['vincular_consulta']) && $lesion['vincular_consulta'] ? $consulta->id : ($lesion['consulta_id'] ?? null);
            
            $lesionesGuardar[] = [
                'lugar' => $lesion['lugar'],
                'procedimiento' => $lesion['procedimiento'],
                'fecha' => $lesion['fecha'],
                'consulta_id' => $consultaIdVinculada
            ];
        }

        $mascota->lesiones = $lesionesGuardar;
        $mascota->save();

        return redirect()->route('admin.expedientes.consultas.lesiones', [$mascota->id, $consulta->id])
                         ->with('toast_success', 'Historial de lesiones actualizado con éxito');
    }

    public function alimentacion(\App\Models\Mascota $mascota, \App\Models\Consulta $consulta)
    {
        if ($consulta->mascota_id !== $mascota->id) {
            abort(404);
        }

        return view('modules.admin.expedientes.alimentacion', compact('mascota', 'consulta'));
    }

    public function guardarAlimentacion(Request $request, \App\Models\Mascota $mascota, \App\Models\Consulta $consulta)
    {
        if ($consulta->mascota_id !== $mascota->id) {
            abort(404);
        }

        $request->validate([
            'dietas' => 'nullable|array',
            'dietas.*.dieta_especial' => 'nullable|boolean',
            'dietas.*.motivo_dieta' => 'nullable|string|max:255',
            'dietas.*.dieta_terapeutica' => 'nullable|string|max:255',
            'dietas.*.fecha_inicio' => 'required|date',
            'dietas.*.fecha_fin' => 'nullable|date',
            'dietas.*.permanente' => 'nullable|boolean',
            'dietas.*.veterinario_responsable' => 'nullable|string|max:255',
            'dietas.*.restricciones' => 'nullable|string|max:1000',
            'dietas.*.observaciones_nutricionales' => 'nullable|string|max:1000',
        ]);

        $dietasInput = $request->input('dietas', []);
        
        $dietasGuardar = [];
        foreach ($dietasInput as $dieta) {
            $permanente = isset($dieta['permanente']) && $dieta['permanente'];
            $dietasGuardar[] = [
                'dieta_especial' => isset($dieta['dieta_especial']) && $dieta['dieta_especial'],
                'motivo_dieta' => $dieta['motivo_dieta'] ?? null,
                'dieta_terapeutica' => $dieta['dieta_terapeutica'] ?? null,
                'fecha_inicio' => $dieta['fecha_inicio'],
                'fecha_fin' => $permanente ? null : ($dieta['fecha_fin'] ?? null),
                'permanente' => $permanente,
                'veterinario_responsable' => $dieta['veterinario_responsable'] ?? null,
                'restricciones' => $dieta['restricciones'] ?? null,
                'observaciones_nutricionales' => $dieta['observaciones_nutricionales'] ?? null,
                'consulta_id' => $consulta->id // Siempre lo vinculamos a la consulta donde se editó
            ];
        }

        $mascota->alimentacion = $dietasGuardar;
        $mascota->save();

        return redirect()->route('admin.expedientes.consultas.alimentacion', [$mascota->id, $consulta->id])
                         ->with('toast_success', 'Historial de alimentación actualizado con éxito');
    }

    public function patologias(\App\Models\Mascota $mascota, \App\Models\Consulta $consulta)
    {
        if ($consulta->mascota_id !== $mascota->id) {
            abort(404);
        }

        return view('modules.admin.expedientes.patologias', compact('mascota', 'consulta'));
    }

    public function guardarPatologias(Request $request, \App\Models\Mascota $mascota, \App\Models\Consulta $consulta)
    {
        if ($consulta->mascota_id !== $mascota->id) {
            abort(404);
        }

        $request->validate([
            'patologias' => 'nullable|array',
            'patologias.*.enfermedad' => 'required|string|max:255',
            'patologias.*.es_cronica' => 'nullable|boolean',
        ]);

        $patologiasInput = $request->input('patologias', []);
        
        $patologiasGuardar = [];
        foreach ($patologiasInput as $patologia) {
            $patologiasGuardar[] = [
                'enfermedad' => $patologia['enfermedad'],
                'es_cronica' => isset($patologia['es_cronica']) && $patologia['es_cronica'],
                'consulta_id' => $consulta->id
            ];
        }

        $mascota->patologias = $patologiasGuardar;
        $mascota->save();

        return redirect()->route('admin.expedientes.consultas.patologias', [$mascota->id, $consulta->id])
                         ->with('toast_success', 'Antecedentes patológicos actualizados con éxito');
    }
}
