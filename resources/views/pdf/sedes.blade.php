<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sedes</title>

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
        <div class="header-main">LISTADO DE SEDES</div>
    </div>

    <table>
        <tr>
            <th>#</th>
            <th>Número Sede</th>
            <th>Nombre</th>
            <th>Abreviado</th>
            <th>Municipio</th>
            <th>Direccion</th>
        </tr>

        @foreach ($sedes as $i => $sede)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $sede->nro_sede }}</td>
                <td>{{ $sede->nombre_sede }}</td>
                <td>{{ $sede->nombre_abreviado }}</td>
                <td>{{ $sede->municipio }}</td>
                <td>{{ $sede->direccion }}</td>
            </tr>
        @endforeach

    </table>
</body>

</html>
