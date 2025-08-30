<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PNF</title>
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
        <div class="header-main">LISTADO DE PNF</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>codigo</th>
                <th>Abreviado</th>
                <th>Abreviado Coordinación</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pnfs as $i => $pnf)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $pnf->nombre }}</td>
                    <td>{{ $pnf->codigo }}</td>
                    <td>{{ $pnf->abreviado }}</td>
                    <td>{{ $pnf->abreviado_coord }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>