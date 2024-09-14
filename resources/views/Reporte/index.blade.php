@extends('layouts.plantilla')
@section('titulo', 'Reportes')
@section('contenido')

    <div class="container">
        <div class="page-header d-flex justify-content-between align-items-center">
            <div class="page-title">
                <h4>Reportes</h4>
            </div>

            <div class="d-flex align-items-center">
                <a href="{{ route('expoexcel', request()->all()) }}">
                    <span class="badges bg-lightgreen">Descargar Excel</span>
                </a>
            </div>

        </div>
        <script>
            $(document).ready(function() {
                $('#idflete, #idviatico, #idempleado').select2({
                    allowClear: true,
                    width: '100%'
                });
            });
        </script>
        <style type="text/css">
            .subtitulo {
                font-size: 1rem;
                /* Tamaño de fuente */
                font-weight: bold;
                /* Negrita */
                color: #000000;
                /* Color del texto */
                margin-bottom: 1rem;
                /* Espacio debajo del subtítulo */
                display: block;
                /* Asegura que el label ocupe toda la línea */
            }
        </style>

        <nav class="navbar navbar-light">
            <div class="d-flex flex-column align-items-start">
                <form class="form" method="GET" id="search-form">
                    <!-- Primera fila: Colaboradores -->
                    <div class="row col-12 align-items-center">
                        <div class="col-lg-12 mb-2 ">
                            <label for="idempleado">Colaboradores:</label>
                            <select class='form-control' name="idempleado" id="idempleado">
                                <option value="" selected disabled>Seleccionar un colaborador</option>
                                @foreach ($empleados as $itempleado)
                                    <option value="{{ $itempleado->idempleado }}">{{ $itempleado->nombres }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Segunda fila: Fletes, Viáticos y Fechas -->
                    <div class="row col-12 align-items-center">
                        <div class="col-lg-3 mb-2 ">
                            <label for="idflete">Fletes:</label>
                            <select class='form-control' name="idflete" id="idflete">
                                <option value="" selected disabled>Seleccionar flete</option>
                                @foreach ($fletes as $itemflete)
                                    <option value="{{ $itemflete->idflete }}">{{ $itemflete->nombre_flete }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3 mb-2">
                            <label for="idviatico">Viáticos:</label>
                            <select class='form-control' name="idviatico" id="idviatico">
                                <option value="" selected disabled>Seleccionar viatico</option>
                                @foreach ($viaticos as $itemviatico)
                                    <option value="{{ $itemviatico->idviatico }}">{{ $itemviatico->nombre_viatico }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3 mb-2">
                            <label for="fechaInicio">Fecha inicio:</label>
                            <input id="fechaInicio" name="fechaInicio" class="form-control" type="date"
                                value="{{ request('fechaInicio') }}">
                        </div>
                        <div class="col-lg-3 mb-2">
                            <label for="fechaFin">Fecha fin:</label>
                            <input id="fechaFin" name="fechaFin" class="form-control" type="date"
                                value="{{ request('fechaFin') }}">
                        </div>
                    </div>

                    <!-- Checkbox para ordenar por fecha -->
                    <div class="form-check mb-3 text-start">
                        <input type="checkbox" class="form-check-input" id="ordenarPorFecha" name="ordenarPorFecha"
                            value="1" {{ request('ordenarPorFecha') ? 'checked' : '' }}>
                        <label class="form-check-label" for="ordenarPorFecha">Ordenar</label>
                    </div>
                    <div class="col-lg-3 mb-2">
                        <label for="tipoIG">Gasto/Ingreso:</label>
                        <select class='form-control' name="tipoIG" id="tipoIG">
                            <option value="" selected disabled>.:Flujo:.</option>
                            <option value="1">Gasto</option>
                            <option value="2">Ingreso</option>
                        </select>
                    </div>
                    <!-- Botones de acción centrados -->
                    <div class="form-group d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary me-2">Filtrar</button>
                        <a href="{{ route('reporte.index') }}" class="btn btn-secondary">Limpiar</a>
                    </div>
                </form>
            </div>

        </nav>

        <div class="row">
            <div class="col-12">
                <label class="subtitulo">
                    @if ($tipoIG == '1')
                        Gastos
                    @elseif($tipoIG == '2')
                        Ingresos
                    @else
                        Gastos/Ingresos
                    @endif
                </label>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive" id="empleadoTable">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">N°</th>
                                        <th scope="col">Flete</th>
                                        <th scope="col">Viatico</th>
                                        <th scope="col">Trabajador</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Descripcion</th>
                                        <th scope="col">Importe(S/.)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($detallegeneral->isEmpty())
                                        <tr>
                                            <td colspan="7"><i>:: NO HAY REGISTROS ::</i></td>
                                        </tr>
                                    @else
                                        @php $contadorg = ($detallegeneral->currentPage() - 1) * $detallegeneral->perPage() + 1; @endphp
                                        @foreach ($detallegeneral as $itemGasto)
                                            <tr>
                                                <td>{{ $contadorg++ }}</td>
                                                <td>{{ $itemGasto->Flete->nombre_flete }}</td>
                                                <td>{{ $itemGasto->Viatico->nombre_viatico }}</td>
                                                <td>{{ $itemGasto->Empleado->nombres }}</td>
                                                <td>{{ $itemGasto->fecha }}</td>
                                                <td>{{ $itemGasto->descripcion }}</td>
                                                <td>{{ $itemGasto->importe }}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="2" class="text-right"><strong>Total:</strong></td>
                                            <td>
                                                @if ($tipoIG == '1')
                                                    {{ $totalGasto }}
                                                @elseif($tipoIG == '2')
                                                    {{ $totalIngreso }}
                                                @else
                                                    {{ $importexfiltrado }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <!-- Paginación -->
                            {{ $detallegeneral->appends(request()->except('general_page'))->links() }}
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
