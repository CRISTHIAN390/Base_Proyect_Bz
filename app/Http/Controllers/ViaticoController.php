<?php

namespace App\Http\Controllers;

use App\Models\Viatico;
use Illuminate\Http\Request;

class ViaticoController extends Controller
{
    const PAGINATION=5; //tengo 20 datos se partira en 4 paginas


    public function index(Request $request)
    {
        $buscarpor = $request->get('buscarpor');
        $viatico = Viatico::where('nombre_viatico', 'like', '%' . $buscarpor . '%')->where('estado','=','1')->paginate($this::PAGINATION);

        return view('viatico.index', compact('viatico', 'buscarpor'));
    }

    public function store(Request $request)
    {
        $data=request()->validate([
            'nombre_viatico'=>'required|max:40',
            'descripcion'=>'max:200',
        ],
        [
            'nombre_viatico.required'=>'Ingrese apellido',
            'nombre_viatico.max'=>'Máximo 40 caracteres ',
            'descripcion.max'=>'Máximo 2000 caracteres ',
        ]);
        $viatico=new Viatico();
        $viatico->nombre_viatico=$request->nombre_viatico;
        $viatico->descripcion=$request->descripcion;
        $viatico->estado='1';
        $viatico->save();
        return redirect()->route('viatico.index')->with('datos','¡ Su nuevo registro ha sido guardado... !');
    }
    public function update(Request $request, $idflete)
    {
        $data = $request->validate([
            'nombre_viatico' => 'required|max:40',
            'descripcion' => 'max:200',
        ], [
            'nombre_viatico.required' => 'Ingrese el nombre del flete',
            'nombre_viatico.max' => 'Máximo 40 caracteres',
            'descripcion.max' => 'Máximo 200 caracteres',
        ]);

        $viatico = Viatico::findOrFail($idflete);
        $viatico->nombre_viatico = $request->nombre_viatico;
        $viatico->descripcion = $request->descripcion;
        $viatico->save();

        return redirect()->route('viatico.index')->with('datos', '¡Su registro ha sido actualizado!');
    }


    public function destroy($id)
    {
        $viatico=Viatico::findOrfail($id);
        $viatico->estado='0';
        $viatico->save();
        return redirect()->route('viatico.index')->with('datos','¡ Su registro ha sido Eliminado!');
    }
}
