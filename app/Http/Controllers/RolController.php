<?php

namespace App\Http\Controllers;
use App\Models\Rol;
use Illuminate\Http\Request;

class RolController extends Controller
{
    const PAGINATION = 10;

    public function index(Request $request)
    {
        $buscarpor = $request->get('buscarpor');
        $rol = Rol::where('name', 'like', '%' . $buscarpor . '%')->where('state', '=', '1')->paginate(self::PAGINATION);
        return view('rol.index', compact('rol', 'buscarpor'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:40',
        ], [
            'name.required' => 'Ingrese el nombre del rol',
            'name.max' => 'Máximo 40 caracteres',
        ]);

        $rol = new Rol();
        $rol->name = $request->name;
        $rol->state = 1;
        $rol->save();
        return redirect()->route('rol.index')->with('datos', '¡Su nuevo registro ha sido guardado!');
    }

    public function update(Request $request, $idrol)
    {
        $data = $request->validate([
            'name' => 'required|max:40',
        ], [
            'name.required' => 'Ingrese el nombre del rol',
            'name.max' => 'Máximo 40 caracteres',
        ]);

        $rol = Rol::findOrFail($idrol);
        $rol->name = $request->name;
        $rol->save();
        return redirect()->route('rol.index')->with('datos', '¡Su registro ha sido actualizado!');
    }
    public function destroy($idrol)
    {
        $rol = Rol::findOrFail($idrol);
        $rol->state = 0;
        $rol->save();
        return redirect()->route('rol.index')->with('datos', '¡Su registro ha sido eliminado!');
    }
}
