<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class DetalleFVExpor implements FromCollection, WithHeadings, WithStyles, WithEvents
{
    protected $data;
    protected $importexfiltrado;

    public function __construct($data, $importexfiltrado)
    {
        $this->data = $data;
        $this->importexfiltrado = $importexfiltrado;
    }

    public function collection()
    {
        // Crear la colección de datos filtrados
        $collection = $this->data->map(function ($item, $index) {

            $tipoIG = $item->tipoIG == 1 ? 'Gasto' : ($item->tipoIG == 2 ? 'Ingreso' : 'Gastos/Ingresos');

            return [
                $index + 1, // Número auto-incremental
                $item->Flete->nombre_flete, // Nombre del flete
                $item->Viatico->nombre_viatico, // Nombre del viatico
                $item->Empleado->nombres, // Nombre del empleado
                $item->fecha, // Fecha
                $item->descripcion, // Descripción
                $item->importe, // Importe
                $tipoIG, // Descripción del tipo
            ];
        });

        // Añadir la fila con el valor 
        $collection->push([
            '', '', '', '', '', 'Total:', $this->importexfiltrado, ''
        ]);

        return $collection;
    }

    public function headings(): array
    {
        return [
            'N°',
            'Flete',
            'Viático',
            'Empleado',
            'Fecha',
            'Descripción',
            'Importe',
            'Tipo', 
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];

        // Aplicar estilos a toda la hoja
        $sheet->getStyle('A1:H1')->applyFromArray($styleArray); // Títulos
        $sheet->getStyle('A2:H' . ($sheet->getHighestRow() - 1))->applyFromArray($styleArray); // Datos

        // Cambiar el color de fondo de la primera fila
        $sheet->getStyle('A1:H1')->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF83C5ED'],
            ],
        ]);

        return [];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                
                // Estilo para la fila del total
                $totalRow = $sheet->getHighestRow();
                $sheet->getStyle("A{$totalRow}:H{$totalRow}")->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFFF00'], // Color amarillo
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);
            },
        ];
    }
}