<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Horario Académico</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px;
            text-align: center;
        }

        th {
            background-color: #e3f2fd;
            font-weight: bold;
        }

        .evento {
            font-size: 8px;
            line-height: 1.2;
            overflow: hidden;
            padding: 2px;
            margin: 1px;
            border-radius: 2px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            height: {{ $bloqueHeight }}px; */
        }

        .header-section {
            text-align: center;
            margin-bottom: 10px;
        }

        .header-main {
            font-size: 16px;
            font-weight: bold;
        }

        .header-sub {
            font-size: 12px;
        }

        .info-section {
            font-size: 10px;
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    <div style="display: flex; justify-content: center; align-items: center; margin: 10px 0;">
        <img src="{{ public_path('img/PDF.jpg') }}" alt="Logo de la institución." style="max-width: 100%; margin: 0 8px;">
    </div>
    <div class="header-section">
        <div class="header-main">COORDINACION DEL PROGRAMA NACIONAL DE FORMACION EN INFORMATICA</div>
        <div class="header-sub">SEDE: SEDE CENTRAL (UPTYAB)</div>
    </div>

    <div class="info-section">
        TRAYECTO: III | TRIMESTRE: II | SECCION: 753501<br>
        LABORATORIO SIMON BOLIVAR | ELECTIVA III | LAPSO: 2025-4<br>
        LABORATORIO HUGO CHAVEZ: ING SW II<br>
        LABORATORIO HUGO CHAVEZ: MODELADO BD
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 16%">HORA</th>
                @foreach ($dias as $dia)
                    <th>{{ $dia }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($bloques as $i => $bloque)
                <tr>
                    <td>{{ $bloque['rango'] }}</td>
                    @foreach ($dias as $dia)
                        @php
                            // Buscar si hay un evento que inicia en este bloque y día
                            $evento = collect($eventos)->first(function($e) use ($dia, $i) {
                                return $e['dia'] == $dia && $e['bloque_inicio'] == $i;
                            });
                            // Verificar si este bloque está cubierto por un evento que empezó antes (para no repetir la celda)
                            $eventoEnCurso = collect($eventos)->first(function($e) use ($dia, $i) {
                                return $e['dia'] == $dia && $e['bloque_inicio'] < $i && $e['bloque_fin'] >= $i;
                            });
                        @endphp

                        @if ($evento)
                            <td rowspan="{{ $evento['bloque_fin'] - $evento['bloque_inicio'] + 1 }}" style="vertical-align: middle; text-align: center; background-color: {{ $evento['color'] }}; padding: 0;">
                                <div class="evento">
                                    {{ $evento['texto'] }}
                                </div>
                            </td>
                        @elseif ($eventoEnCurso)
                            {{-- No renderizar celda, ya que está cubierta por un rowspan --}}
                        @else
                            <td></td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 20px; text-align: right; font-size: 10px;">
        COORDINACION DEL PNFI<br>
        ING. ROBERTH MUJICA
    </div>
</body>

</html>



