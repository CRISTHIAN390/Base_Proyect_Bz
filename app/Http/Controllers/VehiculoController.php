<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    const PAGINATION = 5;

    public function index(Request $request)
    {
        $buscarpor = $request->get('buscarpor');
        $vehiculo = Vehiculo::where('placa', 'like', '%' . $buscarpor . '%')->where('estado','=','1')->paginate(self::PAGINATION);
        return view('vehiculo.index', compact('vehiculo', 'buscarpor'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'placa' => 'required|max:10|unique:vehiculo,placa',
            'marca' => 'required|max:50',
            'descripcion' => 'max:200',
        ], [
            'placa.required' => 'La placa es obligatoria.',
            'placa.unique' => 'Ya existe un vehículo con esta placa.',
            'marca.required' => 'La marca es obligatoria.',
            'descripcion.max' => 'Máximo 200 caracteres para la descripción.',
        ]);

        // Creación del vehículo
        $vehiculo = new Vehiculo();
        $vehiculo->placa = $request->placa;
        $vehiculo->marca = $request->marca;
        $vehiculo->descripcion = $request->descripcion;
        $vehiculo->fecha_registro = $request->fecha_registro;
        $vehiculo->estado = 1;
        $vehiculo->save();

        return redirect()->route('vehiculo.index')->with('datos', '¡El vehículo ha sido registrado exitosamente!');
    }

    public function update(Request $request, $idvehiculo)
    {
        // Validación de los datos entrantes
        $data = $request->validate([
            'placa' => 'required|max:10|unique:vehiculo,placa,' . $idvehiculo . ',idvehiculo',
            'marca' => 'required|max:50',
            'descripcion' => 'max:200',
        ], [
            'placa.required' => 'La placa es obligatoria.',
            'placa.unique' => 'Ya existe un vehículo con esta placa.',
            'marca.required' => 'La marca es obligatoria.',
            'descripcion.max' => 'Máximo 200 caracteres para la descripción.',
        ]);

        // Actualizar el vehículo
        $vehiculo = Vehiculo::findOrFail($idvehiculo);
        $vehiculo->placa = $request->placa;
        $vehiculo->marca = $request->marca;
        $vehiculo->descripcion = $request->descripcion;
        $vehiculo->fecha_registro = $request->fecha_registro;
        $vehiculo->save();

        return redirect()->route('vehiculo.index')->with('datos', '¡El vehículo ha sido actualizado exitosamente!');
    }

    public function confirmar($idvehiculo)
    {
        $vehiculo = Vehiculo::findOrFail($idvehiculo);
        
        return view('vehiculo.confirmar', compact('vehiculo'));
    }
    public function destroy($idvehiculo)
    {
        $vehiculo = Vehiculo::findOrFail($idvehiculo);
        $vehiculo->estado = '0'; 
        $vehiculo->save();

        return redirect()->route('vehiculo.index')->with('datos', '¡El vehículo ha sido eliminado exitosamente!');
    }
}
