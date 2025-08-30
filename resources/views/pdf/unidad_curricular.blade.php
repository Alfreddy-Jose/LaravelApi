<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Unidades Curriculares</title>
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
        <div class="header-main">LISTADO DE UNIDAD CURRICULAR</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Horas Prácticas</th>
                <th>Horas Teóricas</th>
                <th>Horas Total</th>
                <th>Unidad Crédito</th>
                <th>Período</th>
                <th>Trimestre</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($unidades as $i => $unidad)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $unidad->nombre }}</td>
                    <td>{{ $unidad->hora_practica }}</td>
                    <td>{{ $unidad->hora_teorica }}</td>
                    <td>{{ $unidad->hora_total_est }}</td>
                    <td>{{ $unidad->unidad_credito }}</td>
                    <td>{{ $unidad->periodo }}</td>
                    <td>{{ $unidad->trimestre->nombre ?? '' }}</td>
                    <td>{{ $unidad->descripcion ?? 'SIN DESCRIPCIÓN' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
