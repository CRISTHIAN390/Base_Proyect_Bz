@extends('layouts.plantilla')
@section('titulo', 'Empleado')

@section('contenido')

    <div class="container">
        <div class="page-header d-flex justify-content-between align-items-center">
            <div class="page-title">
                <h4>Lista de Detalles de fletes</h4>
            </div>

            <div class="d-flex align-items-center">
                <a href="{{ route('detalleFV.create') }}" class="btn btn-added">
                    <img src="/assets/img/icons/plus.svg" alt="img" class="me-2">Nuevo
                </a>
            </div>
        </div>
        <nav class="navbar navbar-light float-right">
            <div class="d-flex flex-column align-items-start">
                <form class="form" method="GET" id="search-form">

                    <div class="form-group mb-3">
                        <label for="idempleado">Empleado:</label>
                        <select class="form-select" name="idempleado" id="idempleado">
                            <option selected disabled>Seleccione un Empleado</option>
                            @foreach ($empleados as $itempleado)
                                <option value="{{ $itempleado->idempleado }}" {{ request('idempleado') == $itempleado->idempleado ? 'selected' : '' }}>
                                    {{ $itempleado->nombres }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                      <!-- Primera fila: Select Flete -->
                    <div class="form-group mb-3">
                        <label for="idflete">Flete:</label>
                        <select class="form-select" name="idflete" id="idflete">
                            <option selected disabled>Seleccione un flete</option>
                            @foreach ($fletes as $itemflete)
                                <option value="{{ $itemflete->idflete }}" {{ request('idflete') == $itemflete->idflete ? 'selected' : '' }}>
                                    FLETE-{{ $itemflete->nombre_flete }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Segunda fila: Select Viático -->
                    <div class="form-group mb-3">
                        <label for="idviatico">Viático:</label>
                        <select class="form-select" name="idviatico" id="idviatico">
                            <option selected disabled>Seleccione un viático</option>
                            @foreach ($viaticos as $itemviatico)
                                <option value="{{ $itemviatico->idviatico }}" {{ request('idviatico') == $itemviatico->idviatico ? 'selected' : '' }}>
                                    VIATICO-{{ $itemviatico->nombre_viatico }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tercera fila: Fechas -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="fechaInicio">Fecha inicio:</label>
                            <input id="fechaInicio" name="fechaInicio" class="form-control" type="date" placeholder="Fecha inicio" value="{{ request('fechaInicio') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="fechaFin">Fecha fin:</label>
                            <input id="fechaFin" name="fechaFin" class="form-control" type="date" placeholder="Fecha fin" value="{{ request('fechaFin') }}">
                        </div>
                    </div>

                    <!-- Cuarta fila: Botones Filtrar y Limpiar -->
                    <div class="form-group d-flex">
                        <button type="submit" class="btn btn-primary me-2">Filtrar</button>
                        <a href="{{ route('detalleFV.index') }}" class="btn btn-secondary">Limpiar</a>
                    </div>
                </form>
            </div>
        </nav>
        <div class="row">
            <div class="col-12">
                <label>Gastos</label>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive" id="empleadoTable">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">N°</th>
                                        <th scope="col">Flete</th>
                                        <th scope="col">Viatico</th>
                                        <th scope="col">Empleado</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Descripcion</th>
                                        <th scope="col">Importe</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($detalleGastos) <= 0)
                                        <tr>
                                            <td colspan="9"><i>:: NO HAY REGISTROS ::</i></td>
                                        </tr>
                                    @else
                                        @php
                                            $totalGasto = 0.00;
                                            $contadorg = 1;
                                        @endphp
                                        @foreach ($detalleGastos as $itemGasto)
                                            <tr>
                                                <td>{{ $contadorg++ }}</td>
                                                <td>{{ $itemGasto->Flete->nombre_flete }}</td>
                                                <td>{{ $itemGasto->Viatico->nombre_viatico }}</td>
                                                <td>{{ $itemGasto->Empleado->nombres }}</td>
                                                <td>{{ $itemGasto->fecha }}</td>
                                                <td>{{ $itemGasto->descripcion }}</td>
                                                <td>{{ $itemGasto->importe }}</td>
                                                <td>
                                                    @if ($itemGasto->estado == 1)
                                                        <span class="badges bg-lightgreen">Activo</span>
                                                    @else
                                                        <span class="badges bg-lightred">Inactivo</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a class="me-3" href="#">
                                                        <img src="/assets/img/icons/edit.svg" alt="img">
                                                    </a>
                                                    <a class="me-3 confirm-text" href="">
                                                        <img src="/assets/img/icons/delete.svg" alt="img">
                                                    </a>
                                                </td>
                                            </tr>
                                            @php
                                                $totalGasto += $itemGasto->importe;
                                            @endphp
                                        @endforeach
                                        <tr>
                                            <td colspan="7">Gasto total: {{ $totalGasto }}</td>
                                        </tr>
                                    @endif
                                </tbody>

                            </table>
                            <br>
                        </div>
                    </div>
                </div>
                <label>Ingresos</label>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive" id="empleadoTable">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">N°</th>
                                        <th scope="col">Flete</th>
                                        <th scope="col">Viatico</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Descripcion-Pago</th>
                                        <th scope="col">Importe</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($detalleIngresos) <= 0)
                                        <tr>
                                            <td colspan="7"><i>:: NO HAY REGISTROS ::</i></td>
                                        </tr>
                                    @else
                                        @php
                                            $totalingreso = 0.00;
                                            $contadori = 1;
                                        @endphp
                                        @foreach ($detalleIngresos as $itemIngreso)
                                            <tr>
                                                <td>{{ $contadori++ }}</td>
                                                <td>{{ $itemIngreso->Flete->nombre_flete }}</td>
                                                <td>{{ $itemIngreso->Viatico->nombre_viatico }}</td>
                                                <td>{{ $itemIngreso->fecha }}</td>
                                                <td>{{ $itemIngreso->descripcion }}</td>
                                                <td>{{ $itemIngreso->importe }}</td>
                                                <td>
                                                    @if ($itemIngreso->estado == 1)
                                                        <span class="badges bg-lightgreen">Activo</span>
                                                    @else
                                                        <span class="badges bg-lightred">Inactivo</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a class="me-3" href="#">
                                                        <img src="/assets/img/icons/edit.svg" alt="img">
                                                    </a>
                                                    <a class="me-3 confirm-text" href="">
                                                        <img src="/assets/img/icons/delete.svg" alt="img">
                                                    </a>
                                                </td>
                                            </tr>
                                            @php
                                                $totalingreso += $itemIngreso->importe;
                                            @endphp
                                        @endforeach
                                        <tr>
                                            <td colspan="7">Ingreso total: {{ $totalingreso }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <br>
                        </div>
                    </div>
                </div>
                <!--
                <label>
                    Devolver:
                    <p style="font-weight: bold; color:  ($totalingreso - $totalGasto) > 0.00 ? 'red' : 'black' }};">
                          $totalGasto-$totalingreso }}
                    </p>
                </label>
                -->
            </div>
        </div>
    </div>


@endsection
