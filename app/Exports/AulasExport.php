<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AulasExport implements FromArray, WithStyles, WithHeadings
{
    use Exportable;
    protected $sedesEjemplo;

    public function __construct($sedesEjemplo = [])
    {
        $this->sedesEjemplo = $sedesEjemplo;
    }

    public function array(): array
    {
        return [
            ['A', '101', $this->sedesEjemplo[0] ?? 'SEDE CENTRAL', 'A-101'],
            ['B', '205', $this->sedesEjemplo[1] ?? 'SEDE NORTE', 'B-205'],
            ['C', '310', $this->sedesEjemplo[2] ?? 'SEDE SUR', 'C-310'],
        ];
    }

    public function headings(): array
    {
        return [
            'etapa',
            'numero',
            'sede',
            'aula'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'E6E6FA']]
            ],
            'A2:D4' => [
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'F0FFF0']]
            ],
        ];
    }
}
