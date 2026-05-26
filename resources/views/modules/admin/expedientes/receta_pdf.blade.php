<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Receta Médica - {{ $mascota->nombre }}</title>
    <style>
        /* Márgenes de página seguros para evitar bucles infinitos */
        @page {
            margin: 40px 40px 100px 40px; 
            size: A4 landscape;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
            /* El borde izquierdo se aplica al body en lugar de usar position: fixed */
            border-left: 12px solid #113458;
            padding-left: 20px;
        }
        
        /* FOOTER FIJO (Anclado al margen inferior) */
        footer {
            position: fixed;
            bottom: -60px; /* Entra dentro del margen de 100px */
            left: 0;
            right: 0;
            height: 60px;
        }

        /* TABLA DE CABECERA (Segura) */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .header-left {
            width: 50%;
            vertical-align: top;
        }
        .header-right {
            width: 50%;
            vertical-align: top;
            text-align: right;
        }
        /* La caja turquesa con bordes curvos, armada con HTML/CSS simple */
        .caja-urgencias {
            background-color: #00A3B5;
            color: white;
            padding: 25px 30px 25px 0;
            border-bottom-left-radius: 40px;
            font-size: 16px;
            font-weight: bold;
            display: inline-block;
            width: 100%;
            margin-top: -40px; /* Para pegarse arriba */
            margin-right: -40px; /* Para pegarse a la derecha */
        }

        .logo-k {
            font-size: 65px;
            font-weight: bold;
            color: #00A3B5;
            float: left;
            margin-right: 15px;
            line-height: 55px;
        }
        .logo-text {
            float: left;
            padding-top: 5px;
        }
        .logo-name {
            font-size: 20px;
            font-weight: bold;
            color: #8C99AA;
            margin: 0;
        }
        .logo-subtitle {
            font-size: 12px;
            color: #00A3B5;
            letter-spacing: 2px;
            margin: 5px 0 0 0;
            font-weight: bold;
        }

        /* STRIP DATOS */
        .info-strip {
            width: 100%;
            font-size: 14px;
            font-weight: bold;
            color: #556270;
            display: table;
            margin-bottom: 25px;
        }
        .info-item {
            display: table-cell;
            white-space: nowrap;
        }
        .dotted-line {
            display: inline-block;
            border-bottom: 1px dotted #556270;
            margin: 0 5px;
        }
        .text-red { color: #E53935; }

        /* BODY / RX */
        .rx-title {
            font-size: 22px;
            font-weight: bold;
            color: #556270;
            margin-bottom: 15px;
        }
        .diagnostic {
            text-align: justify;
            font-size: 14px;
            color: #113458;
            margin-bottom: 20px;
            background-color: #f0f4f8;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #00A3B5;
        }
        
        /* TRATAMIENTO TABLE */
        .treatment-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .treatment-table th {
            text-align: left;
            background-color: #e2e8f0;
            color: #113458;
            padding: 8px 10px;
            font-size: 14px;
            border-bottom: 2px solid #cbd5e1;
        }
        .treatment-table td {
            padding: 10px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 13px;
            color: #334155;
            vertical-align: top;
        }
        .med-name {
            font-weight: bold;
            color: #00A3B5;
            font-size: 14px;
            display: block;
            margin-bottom: 4px;
        }
    </style>
</head>
<body>

    <!-- FOOTER NATIVO (Se imprime en todas las hojas si hay más de una, pero no rompe el layout) -->
    <footer>
        <table width="100%" cellspacing="0" cellpadding="0">
            <tr>
                <td width="50%" valign="bottom">
                    <div style="text-align: center; width: 350px;">
                        @if($veterinario && $veterinario->foto_firma)
                            <img src="{{ storage_path('app/public/' . $veterinario->foto_firma) }}" style="max-height: 60px; max-width: 250px; display: block; margin: 0 auto; margin-bottom: 5px;">
                        @else
                            <div style="height: 65px;"></div>
                        @endif
                        <div style="border-top: 2px solid #113458; padding-top: 5px; font-weight: bold; color: #113458; font-size: 14px;">
                            MVZ. {{ $veterinario ? $veterinario->nombre_completo : 'Nombre del Veterinario' }}
                        </div>
                    </div>
                </td>
                <td width="50%" valign="bottom" style="text-align: right;">
                    <div style="float: right; margin-left: 15px; width: 60px; height: 60px; background-color: #ddd; border: 1px solid #aaa; text-align: center; line-height: 60px; font-size: 10px; color: #555;">QR CODE</div>
                    <div style="color: #113458; font-size: 12px; margin-top: 10px;">
                        <strong>Ced. Prof. {{ $veterinario ? $veterinario->cedula_profesional : 'XXXXXXXX' }}</strong><br>
                        {{ $veterinario ? $veterinario->especialidad : 'Médico Veterinario Zootecnista' }}<br>
                        Clínica Veterinaria Autorizada
                    </div>
                </td>
            </tr>
        </table>
        <!-- Barra Turquesa inferior (segura) -->
        <div style="position: absolute; bottom: -40px; left: -60px; width: 45%; height: 25px; background-color: #00A3B5; border-top-right-radius: 20px;"></div>
        <div style="position: absolute; bottom: -40px; right: -40px; width: 55%; height: 10px; background-color: #113458; margin-top: 15px;"></div>
    </footer>

    <!-- CONTENIDO PRINCIPAL -->
    <main>
        <!-- HEADER (Flujo de documento para evitar saltos) -->
        <table class="header-table">
            <tr>
                <td class="header-left">
                    <div class="logo-k">K</div>
                    <div class="logo-text">
                        <p class="logo-name">MVZ. {{ $veterinario ? explode(' ', $veterinario->nombre_completo)[0] : 'Veterinario' }}</p>
                        <p class="logo-subtitle">MÉDICO VETERINARIO</p>
                    </div>
                </td>
                <td class="header-right">
                    <div class="caja-urgencias">
                        Tel. Citas y Urgencias:<br>777 787 4088
                    </div>
                </td>
            </tr>
        </table>

        <!-- INFO STRIP -->
        <div class="info-strip">
            <div class="info-item">
                Paciente: <span class="dotted-line" style="width: 200px; text-align: center;">{{ $mascota->nombre }} ({{ $mascota->especie }})</span>
            </div>
            <div class="info-item">
                Temp: <span class="dotted-line" style="width: 50px; text-align: center;">{{ $consulta->temperatura ?? '--' }}</span>
            </div>
            <div class="info-item">
                Peso: <span class="dotted-line" style="width: 50px; text-align: center;">{{ $consulta->peso ?? '--' }} kg</span>
            </div>
            <div class="info-item">
                Fecha: <span class="dotted-line" style="width: 90px; text-align: center;">{{ $consulta->fecha_consulta->format('d/m/Y') }}</span>
            </div>
            <div class="info-item">
                Folio: <span class="dotted-line text-red" style="width: 50px; text-align: center;">{{ str_pad($consulta->id, 3, '0', STR_PAD_LEFT) }}</span>
            </div>
        </div>

        <!-- RX BODY -->
        <div class="rx-section">
            <div class="rx-title">Rx:</div>
            
            <div class="diagnostic">
                <strong>Diagnóstico:</strong> {{ strip_tags($consulta->diagnostico) }}
            </div>

            @if(is_array($consulta->tratamiento) && count($consulta->tratamiento) > 0)
                <table class="treatment-table">
                    <thead>
                        <tr>
                            <th>Medicamento</th>
                            <th>Dosis / Vía</th>
                            <th>Frecuencia y Duración</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($consulta->tratamiento as $t)
                            <tr>
                                <td>
                                    <span class="med-name">{{ mb_strtoupper($t['nombre'] ?? 'Desconocido') }}</span>
                                </td>
                                <td>
                                    {{ $t['dosis'] ?? '--' }}<br>
                                    <small style="color:#64748b;">Vía: {{ $t['via'] ?? 'N/A' }}</small>
                                </td>
                                <td>
                                    Cada {{ $t['frecuencia'] ?? '--' }} horas<br>
                                    <small style="color:#64748b;">Durante: {{ $t['duracion'] ?? '--' }}</small>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p style="color: #64748b; font-style: italic;">No se prescribieron medicamentos en esta consulta.</p>
            @endif

            @if($dietaEspecial)
                <div style="margin-top: 25px; padding: 15px; border: 1px dashed #00A3B5; border-radius: 8px; background-color: #f0fdfa;">
                    <strong style="color: #E53935; font-size: 15px; display: block; margin-bottom: 8px;">RECOMENDACIÓN NUTRICIONAL</strong>
                    <div style="font-size: 14px; color: #334155;">
                        {!! $dietaEspecial['dieta_terapeutica'] ?? 'Dieta especial asignada.' !!}
                    </div>
                </div>
            @endif
        </div>
    </main>
</body>
</html>
