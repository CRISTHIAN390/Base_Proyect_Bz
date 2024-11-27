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
        $fechainicio = $request->get('fechainicio');
        $fechafin = $request->get('fechafin');
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
            // Filtrar por fecha de inicio si se proporciona
        if ($fechainicio) {
            $query->where('fecha', '>=', $fechainicio);
        }

        // Filtrar por fecha de fin si se proporciona
        if ($fechafin) {
            $query->where('fecha', '<=', $fechafin);
        }
        // Obtener detalles generales con paginación
        $detalles = (clone $query)
            ->where('estado', '=', 1)
            ->paginate(self::PAGINATION, ['*'], 'general_page');

        return view('detallecar.index', compact('vehiculos', 'empleados', 'detalles', 'idempleado', 'idvehiculo', 'fechainicio', 'fechafin'));
    }

    public function create()
    {
        $vehiculos = Vehiculo::all();
        $empleados = Empleado::all();
        return view('detallecar.create', compact('vehiculos', 'empleados'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'idvehiculo' => 'required',
            'idempleado' => 'required',
            'fecha.*' => 'required|date',
            'observacion.*' => 'required|max:200',
            'monto.*' => 'required|numeric',
        ], [
            'idvehiculo.required' => 'Seleccione el vehiculo',
            'idempleado.required' => 'Seleccione el empleado',
            'fecha.required' => 'Ingrese la fecha',
            'observacion.required' => 'Ingrese la observacion',
            'observacion.max' => 'Máximo 200 caracteres',
            'monto.required' => 'Ingrese el monto',
        ]);

        // Guardar múltiples registros de detalles
        $observaciones = $request->input('observacion');
        $fechas = $request->input('fecha');
        $montos = $request->input('monto');

        foreach ($observaciones as $index => $observacion) {
            $detalle = new Detallcar();
            $detalle->idvehiculo = $request->idvehiculo;
            $detalle->idempleado = $request->idempleado;
            $detalle->fecha = $fechas[$index];
            $detalle->observacion = $observacion;
            $detalle->monto = $montos[$index];
            $detalle->estado = 1;
            $detalle->save();
        }
        return redirect()->route('detallecar.index')->with('datos', '¡Se han guardado los registros correctamente!');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate(
            [
                'fecha' => 'required',
                'observacion' => 'required|max:200',
                'monto' => 'required',
            ],
            [
                'fecha.required' => 'Ingrese la fecha',
                'observacion.required' => 'Ingrese la observacion',
                'observacion.max' => 'Máximo 200 caracteres',
                'monto.required' => 'Ingrese el monto',
            ]
        );
        $detalle = Detallcar::findOrFail($id);
        $detalle->idvehiculo = $request->idvehiculo;
        $detalle->idempleado = $request->idempleado;
        $detalle->fecha = $request->fecha;
        $detalle->observacion = $request->observacion;
        $detalle->monto = $request->monto;
        $detalle->save();
        return redirect()->route('detallecar.index')->with('datos', '¡ Registro Actualizado !');
    }


    public function destroy($id)
    {
        $detalle = Detallcar::findOrFail($id);
        $detalle->estado = '0';
        $detalle->save();
        return redirect()->route('detallecar.index')->with('datos', '¡Su registro ha sido eliminado!');
    }

    public function edit($id)
    {
        $empleados = Empleado::all();
        $vehiculos = Vehiculo::all();
        $detalle = Detallcar::findOrFail($id);
        return view('detalleFV.edit', compact('detalle', 'empleados', 'vehiculos'));
    }
}
