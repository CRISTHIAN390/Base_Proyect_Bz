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


    public function store(Request $request)
    {
        $data = $request->validate([
            'apellidos' => 'required|max:40',
            'nombres' => 'required|max:40',
            'celular' => 'required|max:9',
            'dni' => 'required|max:8|unique:empleado',
        ], [
            'apellidos.required' => 'Ingrese el apellido',
            'apellidos.max' => 'Máximo 40 caracteres',
            'nombres.required' => 'Ingrese el nombre',
            'nombres.max' => 'Máximo 40 caracteres',
            'celular.required' => 'Ingrese el celular',
            'celular.max' => 'Máximo 9 caracteres',
            'dni.required' => 'Ingrese el celular',
            'dni.max' => 'Máximo 8 caracteres',
            'dni.unique' => 'El dni debe ser unico',
        ]);
        $emplead = new Empleado();
        $emplead->apellidos = $request->apellidos;
        $emplead->nombres = $request->nombres;
        $emplead->dni = $request->dni;
        $emplead->celular = $request->celular;
        $emplead->estado = '1';
        $emplead->save();
        return redirect()->route('empleado.index')->with('datos', '¡Su nuevo registro ha sido guardado!');
    }
}
