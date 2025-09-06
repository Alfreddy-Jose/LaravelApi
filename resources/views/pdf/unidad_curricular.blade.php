@extends('layout.layout_pdf')

@section('title', 'Unidad Curricular')

@section('title_lista', 'UNIDADES CURRICULARES')

@section('table')
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>NOMBRE</th>
                <th>HORAS PRÁCTICAS</th>
                <th>HORAS TEÓRICAS</th>
                <th>HORAS TOTAL</th>
                <th>UNIDAD CRÉDITO</th>
                <th>PERÍODO</th>
                <th>TRIMESTRE</th>
                <th>DESCRIPCIÓN</th>
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
@endsection
