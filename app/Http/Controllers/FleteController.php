<?php

namespace App\Http\Controllers;

use App\Models\Flete;
use Illuminate\Http\Request;

class FleteController extends Controller
{
    const PAGINATION = 5;

    public function index(Request $request)
    {
        $buscarpor = $request->get('buscarpor');
        $flete = Flete::where('nombre_flete', 'like', '%' . $buscarpor . '%')->paginate(self::PAGINATION);
        return view('flete.index', compact('flete', 'buscarpor'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre_flete' => 'required|max:40',
            'descripcion' => 'max:200',
        ], [
            'nombre_flete.required' => 'Ingrese el nombre del flete',
            'nombre_flete.max' => 'Máximo 40 caracteres',
            'descripcion.max' => 'Máximo 200 caracteres',
        ]);

        $flete = new Flete();
        $flete->nombre_flete = $request->nombre_flete;
        $flete->descripcion = $request->descripcion;
        $flete->estado = '1';
        $flete->save();

        return redirect()->route('flete.index')->with('datos', '¡Su nuevo registro ha sido guardado!');
    }

    public function update(Request $request, $idflete)
    {
        $data = $request->validate([
            'nombre_flete' => 'required|max:40',
            'descripcion' => 'max:200',
        ], [
            'nombre_flete.required' => 'Ingrese el nombre del flete',
            'nombre_flete.max' => 'Máximo 40 caracteres',
            'descripcion.max' => 'Máximo 200 caracteres',
        ]);

        $flete = Flete::findOrFail($idflete);
        $flete->nombre_flete = $request->nombre_flete;
        $flete->descripcion = $request->descripcion;
        $flete->estado = $request->estado;
        $flete->save();

        return redirect()->route('flete.index')->with('datos', '¡Su registro ha sido actualizado!');
    }


    public function destroy($idflete)
    {
        $flete = Flete::findOrFail($idflete);
        $flete->estado = '0';
        $flete->save();

        return redirect()->route('flete.index')->with('datos', '¡Su registro ha sido eliminado!');
    }
}
