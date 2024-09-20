<?php

namespace App\Http\Controllers;
use App\Models\Flete;
use App\Models\DetalleFV;
use App\Models\Empleado;
use App\Models\Viatico;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function  IndexLogin(){

        return view('auth.login');
    }

    public function  Dashboard(){
        // consulta para el gasto total
        $totalGasto = DetalleFV::where('tipoIG', '=', 1)->where('estado', '=', 1)->sum('importe');

        // consulta para el ingreso total
        $totalIngreso = DetalleFV::where('tipoIG', '=', 2)->where('estado', '=', 1)->sum('importe');
        $totalRegistro= DetalleFV::where('estado', '=', 1)->count();
        $totalEmpleados= Empleado::where('estado', '=', 1)->count();

        $gastosXmes = array_fill(1, 12, 0); // Inicializa todos los meses a 0
        $ingresosXmes = array_fill(1, 12, 0); // Inicializa todos los meses a 0
    
        for ($i = 1; $i <= 12; $i++) {
            $gastosXmes[$i] = DetalleFV::where('tipoIG', 1)
                ->where('estado', 1)
                ->whereMonth('fecha', $i)
                ->sum('importe');
    
            $ingresosXmes[$i] = DetalleFV::where('tipoIG', 2)
                ->where('estado', 1)
                ->whereMonth('fecha', $i)
                ->sum('importe');
        }
        return view('indexx', compact('totalEmpleados','totalGasto', 'totalIngreso', 'totalRegistro', 'gastosXmes', 'ingresosXmes'));
    }
}
