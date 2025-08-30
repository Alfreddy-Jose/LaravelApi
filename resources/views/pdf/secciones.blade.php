<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Secciones PDF</title>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
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
    {{-- <h2>Listado de Secciones</h2> --}}
    <div style="display: flex; justify-content: center; align-items: center; margin: 10px 0;">
        <img src="{{ public_path('img/PDF.jpg') }}" alt="Logo de la institución." style="max-width: 100%; margin: 0 8px;">
    </div>
    <div class="header-section">
        <div class="header-main">LISTADO DE SECCIONES</div>
    </div>

    <div class="container-fluid">
        <table class="table text-center">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>PNF</th>
                    <th>Matricula</th>
                    <th>Trayecto</th>
                    <th>Sede</th>
                    <th>Lapso</th>
                    <th>N° Sección</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($secciones as $i => $s)
                    <tr>
                        <td class="td">{{ $i + 1 }}</td>
                        <td class="td">{{ $s->nombre }}</td>
                        <td class="td">{{ $s->pnf->nombre ?? '' }}</td>
                        <td class="td">{{ $s->matricula->nombre ?? '' }}</td>
                        <td class="td">{{ $s->trayecto->nombre ?? '' }}</td>
                        <td class="td">{{ $s->sede->nombre_sede ?? '' }}</td>
                        <td class="td">{{ $s->lapso->ano ?? '' }}</td>
                        <td class="td">{{ $s->numero_seccion }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
