<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DetalleFVExpor implements FromCollection, WithHeadings
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
        $collection = $this->data->map(function ($item) {
            // Determina el valor de tipoIG
            $tipoIG = $item->tipoIG == 1 ? 'Gasto' : ($item->tipoIG == 2 ? 'Ingreso' : 'Gastos/Ingresos');
            
            return [
                $item->iddetallefv, // ID del registro
                $item->Flete->nombre_flete, // Nombre del flete
                $item->Viatico->nombre_viatico, // Nombre del viatico
                $item->Empleado->nombres, // Nombre del empleado
                $item->fecha, // Fecha
                $item->descripcion, // Descripción
                $item->importe, // Importe
                $tipoIG, // Descripción del tipo
            ];
        });

        // Añadir la fila con el valor de importexfiltrado
        $collection->push([
            '', '', '', '', '', '', 'Total:', $this->importexfiltrado
        ]);

        return $collection;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Flete',
            'Viático',
            'Empleado',
            'Fecha',
            'Descripción',
            'Importe',
            'Tipo', 
        ];
    }
}
