<?php

namespace App\Http\Controllers;
use App\Exports\DetalleFVExpor;
use App\Models\DetalleFV;
use App\Models\Flete;
use App\Models\Empleado;
use App\Models\Viatico;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;

class ReporteController extends Controller
{
    const PAGINATION = 10;

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
        $tipoIG = $request->get('tipoIG');
        $ordenarPorFecha = $request->get('ordenarPorFecha'); // Nuevo checkbox

        // Construir consulta base
        $query = DetalleFV::query();

        // Filtrar por rango de fechas si se proporcionan
        if ($fechaInicio && $fechaFin) {
            $query->whereBetween('fecha', [$fechaInicio, $fechaFin]);
        }

        // Filtrar por tipo si se proporciona
        if ($tipoIG) {
            $query->where('tipoIG', $tipoIG);
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

        // Ordenar por fecha si el checkbox está marcado
        if ($ordenarPorFecha) {
            $query->orderBy('fecha', 'asc');
        }

        // Consulta para el gasto total
        $totalGasto = (clone $query)
            ->where('tipoIG', '=', 1)
            ->where('estado', '=', 1)
            ->sum('importe');

        // Consulta para el ingreso total
        $totalIngreso = (clone $query)
            ->where('tipoIG', '=', 2)
            ->where('estado', '=', 1)
            ->sum('importe');

        // Consulta para el importe total por filtrado
        $importexfiltrado = (clone $query)
            ->where('estado', '=', 1)
            ->sum('importe');

        // Obtener detalles generales con paginación
        $detallegeneral = (clone $query)
            ->where('estado', '=', 1)
            ->paginate(self::PAGINATION, ['*'], 'general_page');

        return view('Reporte.index', compact('importexfiltrado', 'detallegeneral', 'fechaInicio', 'tipoIG', 'fechaFin', 'idflete', 'idviatico', 'fletes', 'viaticos', 'empleados', 'totalGasto', 'totalIngreso', 'ordenarPorFecha'));
    }

    public function exportarExcel(Request $request)
    {
        $fechaInicio = $request->get('fechaInicio');
        $fechaFin = $request->get('fechaFin');
        $idempleado = $request->get('idempleado');
        $idflete = $request->get('idflete');
        $idviatico = $request->get('idviatico');
        $tipoIG = $request->get('tipoIG');
        $ordenarPorFecha = $request->get('ordenarPorFecha');

        $query = DetalleFV::query();

        if ($fechaInicio && $fechaFin) {
            $query->whereBetween('fecha', [$fechaInicio, $fechaFin]);
        }

        if ($tipoIG) {
            $query->where('tipoIG', $tipoIG);
        }

        if ($idempleado) {
            $query->where('idempleado', $idempleado);
        }

        if ($idflete) {
            $query->where('idflete', $idflete);
        }

        if ($idviatico) {
            $query->where('idviatico', $idviatico);
        }

        if ($ordenarPorFecha) {
            $query->orderBy('fecha', 'asc');
        }
        // Consulta para el importe total por filtrado
        $importexfiltrado = (clone $query)
            ->where('estado', '=', 1)
            ->sum('importe');
    
        return Excel::download(new DetalleFVExpor($query->get(),$importexfiltrado), 'reportes.xlsx');


    }
    public function exportarPdf(){


    }
}
