<?php

namespace App\Http\Controllers;

use App\Models\DetalleFV;
use App\Models\Flete;
use App\Models\Empleado;
use App\Models\Viatico;
use Illuminate\Http\Request;

class ReporteController extends Controller
{

    public function index(Request $request)
    {
        $empleados = Empleado::all();
        $fletes = Flete::all();
        $viaticos = Viatico::all();
        $detalle = DetalleFV::all();

        return view('Reporte.index', compact('fletes', 'viaticos', 'empleados','detalle'));
    }

}
