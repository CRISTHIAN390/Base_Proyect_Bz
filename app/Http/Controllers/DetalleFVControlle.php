<?php

namespace App\Http\Controllers;

use App\Models\DetalleFV;
use App\Models\Flete;
use App\Models\Empleado;
use App\Models\Viatico;
use Illuminate\Http\Request;

class DetalleFVControlle extends Controller
{
    const PAGINATION = 3;

    public function index(Request $request)
    {
        $empleados = Empleado::all();
        $fletes = Flete::all();
        $viaticos = Viatico::all();

        // Obtener los valores de los filtros
        $fechaInicio = $request->get('fechaInicio');
        $fechaFin = $request->get('fechaFin');
        $idempleado = $request->get('idempleado');
        $idflete = $request->get('idflete');
        $idviatico = $request->get('idviatico');

        // Inicializar consulta base
        $query = DetalleFV::query();

        // Filtrar por rango de fechas si se proporcionan
        if ($fechaInicio && $fechaFin) {
            $query->whereBetween('fecha', [$fechaInicio, $fechaFin]);
        }
        // Filtrar por empleado si se proporciona
        if ($idempleado) {
            $query->where('idempleado', $idempleado);
        }
        // Filtrar por Flete si se proporciona
        if ($idflete) {
            $query->where('idflete', $idflete);
        }

        // Filtrar por Viatico si se proporciona
        if ($idviatico) {
            $query->where('idviatico', $idviatico);
        }
        // Filtrar por tipo de gasto
        $detalleGastos = (clone $query)
            ->where('tipoIG', '=', 1)
            ->paginate(self::PAGINATION);

        // Filtrar por tipo de ingreso
        $detalleIngresos = (clone $query)
            ->where('tipoIG', '=', 2)
            ->paginate(self::PAGINATION);

        return view('detalleFV.index', compact('detalleGastos', 'detalleIngresos', 'fechaInicio', 'fechaFin', 'idflete', 'idviatico', 'fletes', 'viaticos','empleados'));
    }

    public function create()
    {
        return view('detalleFV.create');
    }
}
