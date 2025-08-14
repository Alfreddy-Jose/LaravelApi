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
            background-color: #f0f0f0;
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
            height: {{ $bloqueHeight }}px;
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
                <th style="width: 8%">HORA</th>
                @foreach ($dias as $dia)
                    <th>{{ $dia }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($bloques as $bloque)
                <tr>
                    <td>{{ $bloque['rango'] }}</td>
                    @foreach ($dias as $dia)
                        <td style="position: relative; height: 40px;">
                            @foreach ($eventos as $evento)
                                @if ($evento['dia'] == $dia && $evento['bloque'] == $bloque['id'])
                                    <div class="evento"
                                        style="background-color: {{ $evento['color'] }}; height: {{ $evento['duracion'] * 40 - 4 }}px;">
                                        {{ $evento['texto'] }}
                                    </div>
                                @endif
                            @endforeach
                        </td>
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
