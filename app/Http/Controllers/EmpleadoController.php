<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;
class EmpleadoController extends Controller
{
    const PAGINATION=5; //tengo 20 datos se partira en 4 paginas


    public function index(Request $request)
    {
        $buscarpor = $request->get('buscarpor');
        $empleado = Empleado::where('apellidos', 'like', '%' . $buscarpor . '%')->paginate($this::PAGINATION);

        return view('empleado.index', compact('empleado', 'buscarpor'));
    }
    public function create()
    {
        return view('empleado.create');
    }

}
