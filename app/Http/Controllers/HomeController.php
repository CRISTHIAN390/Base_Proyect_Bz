<?php

namespace App\Http\Controllers;

use App\Models\Flete;
use App\Models\DetalleFV;
use App\Models\Empleado;
use App\Models\Viatico;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function  IndexLogin()
    {

        return view('auth.login');
    }

    public function  Dashboard(Request $request)
    {
        // consulta para el gasto total
        $totalGasto = DetalleFV::where('tipoIG', '=', 1)->where('estado', '=', 1)->sum('importe');

        // consulta para el ingreso total
        $totalIngreso = DetalleFV::where('tipoIG', '=', 2)->where('estado', '=', 1)->sum('importe');
        $totalRegistro = DetalleFV::where('estado', '=', 1)->count();
        $totalEmpleados = Empleado::where('estado', '=', 1)->count();

 
        $listadeAnios = DetalleFV::where('estado', '=', 1)
            ->select(DetalleFV::raw('YEAR(fecha) as year'))
            ->distinct()
            ->orderBy('year')  
            ->get();

        $anio = $request->input('year') ?? date('Y');

        // Obtener gastos e ingresos por mes
        $gastosXmes = $this->calcularGastosIngresosPorMes(1, $anio);
        $ingresosXmes = $this->calcularGastosIngresosPorMes(2, $anio);

        return view('indexx', compact('listadeAnios', 'totalEmpleados', 'totalGasto', 'totalIngreso', 'totalRegistro', 'gastosXmes', 'ingresosXmes'));
    }

    private function calcularGastosIngresosPorMes($tipoIG, $anio)
    {
        $meses = array_fill(0, 12, 0.00);
        
        for ($i = 0; $i < 12; $i++) {
            $meses[$i] = (float) DetalleFV::where('tipoIG', $tipoIG)
                ->where('estado', 1)
                ->whereMonth('fecha', $i + 1)
                ->whereYear('fecha', $anio)
                ->sum('importe');
        }
        
        return $meses;
    }
    
    public function getGastosPorAnio(Request $request)
    {
        $anio = $request->input('year');
        
        if (!$anio) {
            return response()->json(['error' => 'Año no válido'], 400);
        }
    
        $gastosXmes = $this->calcularGastosIngresosPorMes(1, $anio);
    
        return response()->json($gastosXmes);
    }

    public function getIngresosPorAnio(Request $request)
    {
        $anio = $request->input('year');
        
        if (!$anio) {
            return response()->json(['error' => 'Año no válido'], 400);
        }
    
        $ingresosXmes = $this->calcularGastosIngresosPorMes(2, $anio);
    
        return response()->json($ingresosXmes);
    }
}
