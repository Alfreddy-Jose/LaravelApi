<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Secciones PDF</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px;}
        th, td { border: 1px solid #333; padding: 5px; text-align: left;}
        th { background: #eee; }
    </style>
</head>
<body>
    <h2>Listado de Secciones</h2>
    <table>
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
            @foreach($secciones as $i => $s)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $s->nombre }}</td>
                <td>{{ $s->pnf->nombre ?? '' }}</td>
                <td>{{ $s->matricula->nombre ?? '' }}</td>
                <td>{{ $s->trayecto->nombre ?? '' }}</td>
                <td>{{ $s->sede->nombre_sede ?? '' }}</td>
                <td>{{ $s->lapso->ano ?? '' }}</td>
                <td>{{ $s->numero_seccion }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>