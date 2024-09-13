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
        <script>
            $(document).ready(function() {
                $('#idflete').select2({
                    allowClear: true,
                    width: '100%' // Ajusta el ancho según tu diseño
                });
                $('#idviatico').select2({
                    allowClear: true,
                    width: '100%' // Ajusta el ancho según tu diseño
                });
                $('#idempleado').select2({
                    allowClear: true,
                    width: '100%' // Ajusta el ancho según tu diseño
                });
            });
        </script>
        <nav class="navbar navbar-light float-right">
            <div class="d-flex flex-column align-items-start">
                <form class="form" method="GET" id="search-form">

                    <div class="form-group mb-3">
                        <label for="idempleado">Colaboradores:</label>
                        <select   class='form-control' name="idempleado" id="idempleado">
                            <option value="" selected disabled>Seleccionar un colaborador</option>
                            @foreach ($empleados as $itempleado)
                                <option value="{{ $itempleado->idempleado }}">{{ $itempleado->nombres }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="idflete">Fletes:</label>
                            <select class='form-control' name="idflete" id="idflete">
                                <option value="" selected disabled>Seleccionar flete</option>
                                @foreach ($fletes as $itemflete)
                                    <option value="{{ $itemflete->idflete }}">{{ $itemflete->nombre_flete }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="idviatico">Viáticos:</label>
                            <select  class='form-control' name="idviatico" id="idviatico">
                                <option value="" selected disabled>Seleccionar viatico</option>
                                @foreach ($viaticos as $itemviatico)
                                    <option value="{{ $itemviatico->idviatico }}">{{ $itemviatico->nombre_viatico }}
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


        <!-- Mensaje de confirmación -->
        @if (session('datos'))
            <div id="successMessage" class="alert alert-success mt-3">
                {{ session('datos') }}
            </div>
        @endif



        <div class="row">
            <div class="col-12">
                <label class="subtitulo">Gastos</label>
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
                                        <th scope="col">Importe</th>
                                        <th scope="col">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($detalleGastos) <= 0)
                                        <tr>
                                            <td colspan="8"><i>:: NO HAY REGISTROS ::</i></td>
                                        </tr>
                                    @else
                                        @php
                                            $contadorg =
                                                ($detalleGastos->currentPage() - 1) * $detalleGastos->perPage() + 1;
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
                                                    <a class="me-3"
                                                        href="{{ route('detalleFV.edit', $itemGasto->iddetallefv) }}">
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
                                        @endforeach
                                        <tr>
                                            <td colspan="8"> Gasto total: {{ $totalGasto }}</td>
                                        </tr>
                                    @endif
                                </tbody>

                            </table>
                            <!-- Paginación de Gastos -->
                            {{ $detalleGastos->appends(request()->except('gastos_page'))->links() }}
                            <br>
                        </div>
                    </div>
                </div>
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
                <label class="subtitulo">Ingresos</label>
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
                                        <th scope="col">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($detalleIngresos) <= 0)
                                        <tr>
                                            <td colspan="5"><i>:: NO HAY REGISTROS ::</i></td>
                                        </tr>
                                    @else
                                        @php
                                            $contadori =
                                                ($detalleIngresos->currentPage() - 1) * $detalleIngresos->perPage() + 1;
                                        @endphp
                                        @foreach ($detalleIngresos as $itemIngreso)
                                            <tr>
                                                <td>{{ $contadori++ }}</td>
                                                <td>{{ $itemIngreso->fecha }}</td>
                                                <td>{{ $itemIngreso->descripcion }}</td>
                                                <td>{{ $itemIngreso->importe }}</td>
                                                <td>
                                                    <a class="me-3"
                                                        href="{{ route('detalleFV.edit', $itemIngreso->iddetallefv) }}">
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
                                        @endforeach
                                        <tr>
                                            <td colspan="5"> Ingreso total: {{ $totalIngreso }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <!-- Paginación de Ingresos -->
                            {{ $detalleIngresos->appends(request()->except('ingresos_page'))->links() }}
                            <br>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        @if ($fechaInicio != null && $idflete != null && $fechaFin != null)
            {
            <div class="row">
                <div class="col-12" style="display: flex; justify-content: center; align-items: center;">
                    <span style="margin-right: 10px; font-weight: bold;">
                        {{ $totalGasto > $totalIngreso ? 'Rendición en contra' : 'Rendición a favor' }}
                    </span>
                    <button
                        style="background-color: {{ $totalGasto > $totalIngreso ? 'red' : 'blue' }}; color: white; border: none; padding: 10px 20px; font-weight: bold;">
                        {{ $totalIngreso - $totalGasto }}
                    </button>
                </div>
            </div>
            }
        @endif
    </div>
    <!-- Ocultar el mensaje -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const successMessage = document.getElementById('successMessage');
            if (successMessage) {
                setTimeout(() => {
                    successMessage.style.display = 'none';
                }, 3800); // Ocultar después de 4 segundo
            }
        });
    </script>
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
                        <div class="mb-3">
                            <label for="idempleado" class="form-label">Trabajador</label>
                            <select class="form-select" id="idempleado" name="idempleado" required>
                                <option value="">Seleccione un Trabajador</option>
                                @foreach ($empleados as $empleado)
                                    <option value="{{ $empleado->idempleado }}">{{ $empleado->nombres }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="idflete" class="form-label">Flete</label>
                            <select class="form-select" id="idflete" name="idflete" required>
                                <option value="">Seleccione un flete</option>
                                @foreach ($fletes as $flete)
                                    <option value="{{ $flete->idflete }}">{{ $flete->nombre_flete }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="idviatico" class="form-label">Viático</label>
                            <select class="form-select" id="idviatico" name="idviatico" required>
                                <option value="">Seleccione un viático</option>
                                @foreach ($viaticos as $viatico)
                                    <option value="{{ $viatico->idviatico }}">{{ $viatico->nombre_viatico }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="fecha" class="form-label">Fecha</label>
                                <input type="date" class="form-control" id="fecha" name="fecha" required>
                            </div>
                            <div class="col-md-6">
                                <label for="tipoIG" class="form-label">Tipo (G/I)</label>
                                <select class="form-select" id="tipoIG" name="tipoIG" required>
                                    <option value="1">Gasto</option>
                                    <option value="2">Ingreso</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="importe" class="form-label">Importe</label>
                                <input type="number" class="form-control" id="importe" name="importe" step="0.01"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="d-flex justify-content-center mt-4">
                            <button type="submit" class="btn btn-primary me-3" id="guardarDetalleBtn">Guardar</button>
                            <button type="button" class="btn btn-secondary ms-3"
                                data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
