@extends('layout.layout_pdf')

@section('title', 'Aulas')

@section('title_lista', 'AULAS')

@section('table')
    <table>
        <thead>
            <th>#</th>
            <th>CÓDIGO</th>
            <th>NOMBRE</th>
            <th>ETAPA</th>
            <th>NÚMERO</th>
            <th>SEDE</th>
        </thead>
        <tbody>
            @foreach ($aulas as $i => $aula)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $aula->codigo }}</td>
                    <td>{{ $aula->nombre_aula }}</td>
                    <td>{{ $aula->etapa }}</td>
                    <td>{{ $aula->nro_aula }}</td>
                    <td>{{ $aula->sede->nombre_sede }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection