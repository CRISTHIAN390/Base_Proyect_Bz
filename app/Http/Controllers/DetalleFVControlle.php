<?php

namespace App\Http\Controllers;

use App\Models\DetalleFV;
use App\Models\Flete;
use App\Models\Empleado;
use App\Models\Viatico;
use Illuminate\Http\Request;

class DetalleFVControlle extends Controller
{
    const PAGINATION = 5;

    public function index(Request $request)
    {
        $empleados = Empleado::all();
        $fletes = Flete::all();
        $viaticos = Viatico::all();

        // Obtener los valores de los filtros
        $fechaInicio = $request->get('fechaInicio');
        $fechaFin = $request->get('fechaFin');
        $idempleado = $request->get('idempleado');
        $idflete = $request->get('idflete');
        $idviatico = $request->get('idviatico');

        // Inicializar consulta base
        $query = DetalleFV::query();

        // Filtrar por rango de fechas si se proporcionan
        if ($fechaInicio && $fechaFin) {
            $query->whereBetween('fecha', [$fechaInicio, $fechaFin]);
        }
        // Filtrar por empleado si se proporciona
        if ($idempleado) {
            $query->where('idempleado', $idempleado);
        }
        // Filtrar por Flete si se proporciona
        if ($idflete) {
            $query->where('idflete', $idflete);
        }

        // Filtrar por Viatico si se proporciona
        if ($idviatico) {
            $query->where('idviatico', $idviatico);
        }
        // consulta para el gasto total
        $totalGasto = (clone $query)
        ->where('tipoIG', '=', 1)
        ->where('estado', '=', 1)
        ->sum('importe');

        // consulta para el ingreso total
        $totalIngreso = (clone $query)
        ->where('tipoIG', '=', 2)
        ->where('estado', '=', 1)
        ->sum('importe');

        // Filtrar por tipo de gasto
        $detalleGastos = (clone $query)
            ->where('tipoIG', '=', 1)->where('estado', '=', 1)
            ->paginate(self::PAGINATION, ['*'], 'gastos_page');

        // Filtrar por tipo de ingreso
        $detalleIngresos = (clone $query)
            ->where('tipoIG', '=', 2)->where('estado', '=', 1)
            ->paginate(self::PAGINATION, ['*'], 'ingresos_page');

        return view('detalleFV.index', compact('detalleGastos', 'detalleIngresos', 'fechaInicio', 'fechaFin', 'idflete', 'idviatico', 'fletes', 'viaticos', 'empleados','totalGasto', 'totalIngreso'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'idempleado' => 'required',
            'idflete' => 'required',
            'idviatico' => 'required',
            'fecha' => 'required',
            'descripcion' => 'required|max:200',
            'importe' => 'required',
            'tipoIG' => 'required',
        ], [
            'idempleado.required' => 'Seleccione el empleado',
            'idflete.required' => 'Seleccione el flete',
            'idviatico.required' => 'Seleccione el viático',
            'fecha.required' => 'Ingrese la fecha',
            'descripcion.required' => 'Ingrese la descripción',
            'descripcion.max' => 'Máximo 200 caracteres',
            'importe.required' => 'Ingrese el importe',
            'tipoIG.required' => 'Seleccione el tipo de gasto/ingreso',
        ]);
        $detalle = new DetalleFV();
        $detalle->idempleado = $request->idempleado;
        $detalle->idflete = $request->idflete;
        $detalle->idviatico = $request->idviatico;
        $detalle->fecha = $request->fecha;
        $detalle->importe = $request->importe;
        $detalle->tipoIG = $request->tipoIG;
        $detalle->descripcion = $request->descripcion;
        $detalle->estado = 1;
        $detalle->save();
        return redirect()->route('detalleFV.index')->with('datos', 'Su nuevo registro ha sido guardado!');
    }
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'idempleado' => 'required',
            'idflete' => 'required',
            'idviatico' => 'required',
            'fecha' => 'required',
            'descripcion' => 'required|max:200',
            'importe' => 'required|numeric',
        ], [
            'idempleado.required' => 'Seleccione el empleado',
            'idflete.required' => 'Seleccione el flete',
            'idviatico.required' => 'Seleccione el viático',
            'fecha.required' => 'Ingrese la fecha',
            'descripcion.required' => 'Ingrese la descripción',
            'descripcion.max' => 'Máximo 200 caracteres',
            'importe.required' => 'Ingrese el importe',
        ]);
        $detalle = new DetalleFV();
        return redirect()->route('detalleFV.index')->with('datos', 'Su nuevo registro ha sido guardado!');
    }

    public function destroy($id)
    {
        $detalle = DetalleFV::findOrFail($id);
        $detalle->estado = '0';
        $detalle->save();
        return redirect()->route('detalleFV.index')->with('datos', '¡Su registro ha sido eliminado!');
    }
}
