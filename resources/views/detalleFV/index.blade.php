@extends('layouts.plantilla')
@section('titulo', 'Empleado')

@section('contenido')

    <div class="container">
        <div class="page-header d-flex justify-content-between align-items-center">
            <div class="page-title">
                <h4>Lista de Detalles de fletes</h4>
            </div>

            <div class="d-flex align-items-center">
                <!-- Botón para abrir el modal -->
                <button type="button" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#nuevoDetalleModal">
                    <img src="/assets/img/icons/plus.svg" alt="img" class="me-2">Nuevo
                </button>
            </div>
        </div>
        <nav class="navbar navbar-light float-right">
            <div class="d-flex flex-column align-items-start">
                <form class="form" method="GET" id="search-form">

                    <div class="form-group mb-3">
                        <label for="idempleado">Trabajador:</label>
                        <select class="form-select" name="idempleado" id="idempleado">
                            <option selected disabled>Seleccione trabajador</option>
                            @foreach ($empleados as $itempleado)
                                <option value="{{ $itempleado->idempleado }}"
                                    {{ request('idempleado') == $itempleado->idempleado ? 'selected' : '' }}>
                                    {{ $itempleado->nombres }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="idflete">Flete:</label>
                            <select class="form-select" name="idflete" id="idflete">
                                <option selected disabled>Seleccione un flete</option>
                                @foreach ($fletes as $itemflete)
                                    <option value="{{ $itemflete->idflete }}"
                                        {{ request('idflete') == $itemflete->idflete ? 'selected' : '' }}>
                                        FLETE-{{ $itemflete->nombre_flete }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="idviatico">Viático:</label>
                            <select class="form-select" name="idviatico" id="idviatico">
                                <option selected disabled>Seleccione un viático</option>
                                @foreach ($viaticos as $itemviatico)
                                    <option value="{{ $itemviatico->idviatico }}"
                                        {{ request('idviatico') == $itemviatico->idviatico ? 'selected' : '' }}>
                                        VIATICO-{{ $itemviatico->nombre_viatico }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- Tercera fila: Fechas -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="fechaInicio">Fecha inicio:</label>
                            <input id="fechaInicio" name="fechaInicio" class="form-control" type="date"
                                placeholder="Fecha inicio" value="{{ request('fechaInicio') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="fechaFin">Fecha fin:</label>
                            <input id="fechaFin" name="fechaFin" class="form-control" type="date"
                                placeholder="Fecha fin" value="{{ request('fechaFin') }}">
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
                                            $totalGasto = 0.0;
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
                                                    <a class="me-3 delete" data-id="{{ $itemGasto->iddetallefv }}"
                                                        data-importe="{{ $itemGasto->importe }}"
                                                        data-descripcion="{{ $itemGasto->descripcion }}"
                                                        data-tipoIG="{{ $itemGasto->tipoIG }}"
                                                        data-fecha="{{ $itemGasto->fecha }}" data-bs-toggle="modal"
                                                        data-bs-target="#eliminarDetalleModal">
                                                        <img src="/assets/img/icons/delete.svg" alt="img">
                                                    </a>
                                                </td>
                                            </tr>
                                            @php
                                                $totalGasto += $itemGasto->importe;
                                            @endphp
                                        @endforeach
                                        <tr>
                                            <td colspan="9"> Gasto total: {{ $totalGasto }}</td>
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
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Descripcion</th>
                                        <th scope="col">Importe</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($detalleIngresos) <= 0)
                                        <tr>
                                            <td colspan="6"><i>:: NO HAY REGISTROS ::</i></td>
                                        </tr>
                                    @else
                                        @php
                                            $totalingreso = 0.0;
                                            $contadori = 1;
                                        @endphp
                                        @foreach ($detalleIngresos as $itemIngreso)
                                            <tr>
                                                <td>{{ $contadori++ }}</td>
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
                                                    <a class="me-3 delete" data-id="{{ $itemIngreso->iddetallefv }}"
                                                        data-importe="{{ $itemIngreso->importe }}"
                                                        data-descripcion="{{ $itemIngreso->descripcion }}"
                                                        data-tipoIG="{{ $itemIngreso->tipoIG }}"
                                                        data-fecha="{{ $itemIngreso->fecha }}" data-bs-toggle="modal"
                                                        data-bs-target="#eliminarDetalleModal">
                                                        <img src="/assets/img/icons/delete.svg" alt="img">
                                                    </a>
                                                </td>
                                            </tr>
                                            @php
                                                $totalingreso += $itemIngreso->importe;
                                            @endphp
                                        @endforeach
                                        <tr>
                                            <td colspan="6">Ingreso total: {{ $totalingreso }}</td>
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

    <!-- Modal Guardar -->
    <div class="modal fade" id="nuevoDetalleModal" tabindex="-1" aria-labelledby="nuevoDetalleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nuevoDetalleModalLabel">Nuevo Gasto/Ingreso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="nuevoDetalleForm" method="POST" action="{{ route('detalleFV.store') }}">
                        @csrf
                        <!-- Primera fila: Trabajador -->
                        <div class="mb-3">
                            <label for="empleado_id" class="form-label">Trabajador</label>
                            <select class="form-select" id="empleado_id" name="empleado_id" required>
                                <option value="">Seleccione un Trabajador</option>
                                @foreach ($empleados as $empleado)
                                    <option value="{{ $empleado->idempleado }}">{{ $empleado->nombres }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Segunda fila: Flete -->
                        <div class="mb-3">
                            <label for="flete_id" class="form-label">Flete</label>
                            <select class="form-select" id="flete_id" name="flete_id" required>
                                <option value="">Seleccione un flete</option>
                                @foreach ($fletes as $flete)
                                    <option value="{{ $flete->id }}">{{ $flete->nombre_flete }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tercera fila: Viático -->
                        <div class="mb-3">
                            <label for="viatico_id" class="form-label">Viático</label>
                            <select class="form-select" id="viatico_id" name="viatico_id" required>
                                <option value="">Seleccione un viático</option>
                                @foreach ($viaticos as $viatico)
                                    <option value="{{ $viatico->id }}">{{ $viatico->nombre_viatico }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Cuarta fila: Fecha y Tipo al lado -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="fecha" class="form-label">Fecha</label>
                                <input type="date" class="form-control" id="fecha" name="fecha" required>
                            </div>
                            <div class="col-md-6">
                                <label for="tipo" class="form-label">Tipo (G/I)</label>
                                <select class="form-select" id="tipo" name="tipo" required>
                                    <option value="1">Gasto</option>
                                    <option value="2">Ingreso</option>
                                </select>
                            </div>
                        </div>

                        <!-- Quinta fila: Importe y Descripción al lado -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="importe" class="form-label">Importe</label>
                                <input type="number" class="form-control" id="importe" name="importe" required>
                            </div>
                            <div class="col-md-6">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary" id="guardarDetalleBtn">Guardar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Eliminar -->

    <!-- Modal Eliminar -->
    <div class="modal fade" id="eliminarDetalleModal" tabindex="-1" aria-labelledby="eliminarDetalleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eliminarDetalleModalLabel">
                        Confirmar Eliminación
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¿Está seguro de que desea eliminar este <span id="eliminarTipoIG_detalle"></span>?</p>
                    <ul>
                        <li><strong>Fecha:</strong> <span id="eliminarFecha_detalle"></span></li>
                        <li><strong>Descripción:</strong> <span id="eliminarDescripcion_detalle"></span></li>
                        <li><strong>Importe:</strong> <span id="eliminarImporte_detalle"></span></li>
                    </ul>
                    <br>
                    <form id="eliminarDetalleForm" method="POST" action="">
                        @method('DELETE')
                        @csrf
                        <input type="hidden" id="eliminarDetalleId" name="id">

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-danger" id="eliminarFleteBtn">Eliminar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.delete').forEach(button => {
            button.addEventListener('click', function() {
                // Obtener los valores del detalle almacenados en los atributos data-*
                let iddetallefv = this.getAttribute('data-id');
                let fecha = this.getAttribute('data-fecha');
                let tipo = this.getAttribute('data-tipoIG');
                let importe = this.getAttribute('data-importe');
                let descripcion = this.getAttribute('data-descripcion');

                // Asignar los valores a los elementos del modal
                document.getElementById('eliminarDetalleId').value = iddetallefv;
                document.getElementById('eliminarFecha_detalle').textContent = fecha;
                document.getElementById('eliminarTipoIG_detalle').textContent = tipo == 1 ? 'Gasto' :
                    'Ingreso';
                document.getElementById('eliminarDescripcion_detalle').textContent = descripcion;
                document.getElementById('eliminarImporte_detalle').textContent = importe;

                // Establecer la acción del formulario
                document.getElementById('eliminarDetalleForm').action = `/detalleFV/${iddetallefv}`;
            });
        });
    </script>
@endsection
