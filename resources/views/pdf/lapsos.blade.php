<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lapso Academico</title>

        <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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

        .header-section {
            text-align: center;
            margin-bottom: 10px;
        }

        .header-main {
            font-size: 16px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div style="display: flex; justify-content: center; align-items: center; margin: 10px 0;">
        <img src="{{ public_path('img/PDF.jpg') }}" alt="Logo de la institución." style="max-width: 100%; margin: 0 8px;">
    </div>
    <div class="header-section">
        <div class="header-main">LISTADO DE LAPSO ACADEMICO</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Año</th>
                <th>Tipo de lapso</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($lapsos as $i => $lapso)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $lapso->nombre_lapso }}</td>
                    <td>{{ $lapso->ano }}</td>
                    <td>{{ $lapso->tipolapso->nombre }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>