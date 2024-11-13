<?php

namespace App\Http\Controllers;
use App\Models\Detallcar;
use App\Models\Vehiculo;
use App\Models\Empleado;

use Illuminate\Http\Request;

class DetallcarController extends Controller
{
    const PAGINATION = 10;
    public function index(Request $request)
    {
        $empleados = Empleado::all();
        $vehiculos = Vehiculo::all();

        // Obtener los valores de los filtros
        $idempleado = $request->get('idempleado');
        $idvehiculo = $request->get('idvehiculo');
        // Inicializar consulta base
        $query = Detallcar::query();

        // Filtrar por empleado si se proporciona
        if ($idempleado) {
            $query->where('idempleado', $idempleado);
        }

        // Filtrar por vehiculo si se proporciona
        if ($idvehiculo) {
            $query->where('idvehiculo', $idvehiculo);
        }
        // Obtener detalles generales con paginación
        $detalles = (clone $query)
            ->where('estado', '=', 1)
            ->paginate(self::PAGINATION, ['*'], 'general_page');

        return view('detallecar.index', compact('vehiculos','empleados','detalles','idempleado','idvehiculo'));
    }

    public function create(){
        $vehiculos = Vehiculo::all();
        $empleados = Empleado::all();
        return view('detallecar.create', compact('vehiculos', 'empleados'));
    }








}
