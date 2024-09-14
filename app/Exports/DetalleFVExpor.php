<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class DetalleFVExpor implements FromCollection, WithHeadings, WithStyles, WithEvents
{
    protected $data;
    protected $GastoTotalFiltrado;
    protected $IngresoTotalFiltrado;
    protected $MontoRestante;

    public function __construct($data, $IngresoTotalFiltrado,$GastoTotalFiltrado, $MontoRestante)
    {
        $this->data = $data;
        $this->IngresoTotalFiltrado = $IngresoTotalFiltrado;
        $this->GastoTotalFiltrado = $GastoTotalFiltrado;
        $this->MontoRestante = $MontoRestante;
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
                number_format($item->importe, 2, '.', ','), // Importe formateado
                $tipoIG, // Descripción del tipo
            ];
        });
    
        // Añadir las filas con los totales y asegurar que se muestren como 0.00 si están vacíos
        $collection->push(['', '', '', '', '', 'Importe Total:', number_format($this->IngresoTotalFiltrado ?: 0.00, 2, '.', ','), '']);
        $collection->push(['', '', '', '', '', 'Gasto Total:', number_format($this->GastoTotalFiltrado ?: 0.00, 2, '.', ','), '']);
        $collection->push(['', '', '', '', '', 'Resultado:', number_format($this->MontoRestante ?: 0.00, 2, '.', ','), '']);
    
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
        $sheet->getStyle('A2:H' . ($sheet->getHighestRow() - 3))->applyFromArray($styleArray); // Datos

        // Cambiar el color de fondo de la primera fila
        $sheet->getStyle('A1:H1')->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => '15FFFF'],
            ],
        ]);

        return [];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
    
                // Estilo para la fila de importe total
                $importTotalRow = $sheet->getHighestRow() - 2; // Cambia la fila para que coincida con la fila correcta
                $sheet->getStyle("A{$importTotalRow}:H{$importTotalRow}")->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'C4C4C4'], // Color gris
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
    
                // Estilo para la fila de gasto total
                $gastoTotalRow = $sheet->getHighestRow() - 1; // Cambia la fila para que coincida con la fila correcta
                $sheet->getStyle("A{$gastoTotalRow}:H{$gastoTotalRow}")->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'C4C4C4'], // Color gris
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
    
                // Estilo para la fila del resultante
                $totalRow = $sheet->getHighestRow(); // Asegúrate de que sea la fila correcta para el total
                $color = $this->MontoRestante < 0 ? 'F44E4E' : '03E33E'; // Color según el monto resultante
                $sheet->getStyle("A{$totalRow}:H{$totalRow}")->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => $color],
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
