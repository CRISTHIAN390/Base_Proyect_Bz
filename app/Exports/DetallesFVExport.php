<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\DetalleFV;
use App\Models\Empleado;
use App\Models\Flete;
use App\Models\Viatico;


class DetallesFVExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        // Retorna la colección de datos filtrados
        return $this->data->map(function ($item) {
            return [
                $item->iddetallefv, // ID del registro
                $item->Flete->nombre_flete, // Nombre del flete
                $item->Viatico->nombre_viatico, // Nombre del viatico
                $item->Empleado->nombres, // Nombre del empleado
                $item->fecha, // Fecha
                $item->descripcion, // Descripción
                $item->importe, // Importe
            ];
        });
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
        ];
    }
}
