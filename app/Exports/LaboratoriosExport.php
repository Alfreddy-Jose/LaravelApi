<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaboratoriosExport implements FromArray, WithHeadings, WithStyles
{
    use Exportable;
    protected $sedesEjemplo;

    public function __construct(array $sedesEjemplo)
    {
        $this->sedesEjemplo = $sedesEjemplo;
    }

    public function array(): array
    {
        return [
            [
                $this->sedesEjemplo[0] ?? 'SEDE_CENTRAL', 
                'A', 
                'LABORATORIO DE QUÍMICA', 
                'LAB_QUIM', 
                '25'
            ],
            [
                $this->sedesEjemplo[1] ?? 'SEDE_NORTE', 
                'B', 
                'LABORATORIO DE FÍSICA', 
                'LAB_FIS', 
                '30'
            ],
            [
                $this->sedesEjemplo[2] ?? 'SEDE_SUR', 
                'C', 
                'LABORATORIO DE INFORMÁTICA', 
                'LAB_INFO', 
                '40'
            ],
        ];
    }

    public function headings(): array
    {
        return [
            'sede',
            'etapa', 
            'laboratorio',
            'abreviado',
            'equipos'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'E6E6FA']]
            ],
            'A2:E4' => [
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'F0FFF0']]
            ],
        ];
    }
}