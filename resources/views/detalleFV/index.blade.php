@extends('layouts.plantilla')
@section('titulo', 'Empleado')

@section('contenido')

    <div class="container">
        <div class="page-header d-flex justify-content-between align-items-center mb-4">
            <div class="page-title">
                <h4 class="text-primary fw-bold">Lista de Detalles de Fletes</h4>
            </div>

            <div class="d-flex align-items-center">
                <button type="button" class="btn btn-primary shadow" data-bs-toggle="modal" data-bs-target="#nuevoDetalleModal">
                    <img src="/assets/img/icons/plus.svg" alt="Nuevo" class="me-2">Nuevo
                </button>
            </div>
        </div>

        <nav class="navbar navbar-light bg-light p-3 rounded shadow-sm">
            <div class="container-fluid">
                <form class="form" method="GET" id="search-form">
                    <div class="row mb-3">
                        <!-- Primera fila: Colaboradores -->
                        <div class="col-md-6 mb-3">
                            <label for="idempleado" class="form-label">Colaboradores:</label>
                            <select class="form-select" name="idempleado" id="idempleado">
                                <option value="" selected disabled>Seleccionar un colaborador</option>
                                @foreach ($empleados as $itempleado)
                                    <option value="{{ $itempleado->idempleado }}">{{ $itempleado->nombres }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Segunda fila: Fletes y Viáticos -->
                        <div class="col-md-6 mb-3">
                            <label for="idflete" class="form-label">Fletes:</label>
                            <select class="form-select" name="idflete" id="idflete">
                                <option value="" selected disabled>Seleccionar flete</option>
                                @foreach ($fletes as $itemflete)
                                    <option value="{{ $itemflete->idflete }}">{{ $itemflete->nombre_flete }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <label for="idviatico" class="form-label">Viáticos:</label>
                            <select class="form-select" name="idviatico" id="idviatico">
                                <option value="" selected disabled>Seleccionar viático</option>
                                @foreach ($viaticos as $itemviatico)
                                    <option value="{{ $itemviatico->idviatico }}">{{ $itemviatico->nombre_viatico }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tercera fila: Fechas -->
                        <div class="col-md-6 mb-3">
                            <label for="fechaInicio" class="form-label">Fecha inicio:</label>
                            <input id="fechaInicio" name="fechaInicio" class="form-control" type="date"
                                value="{{ request('fechaInicio') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="fechaFin" class="form-label">Fecha fin:</label>
                            <input id="fechaFin" name="fechaFin" class="form-control" type="date"
                                value="{{ request('fechaFin') }}">
                        </div>
                    </div>

                    <!-- Cuarta fila: Ordenar y Gasto/Ingreso -->
                    <div class="row mb-3">
                        <div class="col-md-6 d-flex align-items-center">
                            <input type="checkbox" class="form-check-input me-2" id="ordenarPorFecha" name="ordenarPorFecha"
                                value="1" {{ request('ordenarPorFecha') ? 'checked' : '' }}>
                            <label class="form-check-label" for="ordenarPorFecha">Ordenar por fecha</label>
                        </div>
                        <div class="col-md-6">
                            <label for="tipoIG" class="form-label">Gasto/Ingreso:</label>
                            <select class="form-select" name="tipoIG" id="tipoIG">
                                <option value="" selected disabled>.:Flujo:.</option>
                                <option value="1">Gasto</option>
                                <option value="2">Ingreso</option>
                            </select>
                        </div>
                    </div>

                    <!-- Quinta fila: Botones -->
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Filtrar</button>
                        <a href="{{ route('detalleFV.index') }}" class="btn btn-secondary">Limpiar</a>
                    </div>
                </form>
            </div>
        </nav>
        <br>
        <script>
            $(document).ready(function() {
                $('#idflete, #idviatico, #idempleado').select2({
                    allowClear: true,
                    width: '100%'
                });
            });
        </script>
        <!-- Mensaje de confirmación -->
        @if (session('datos'))
            <div id="successMessage" class="alert alert-success mt-3">
                {{ session('datos') }}
            </div>
        @endif
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
        <div class="row">
            <div class="col-12">

                <label class="subtitulo">
                    @if ($tipoIG == '1')
                        Gastos
                    @elseif($tipoIG == '2')
                        Ingreso
                    @else
                        Gastos/Ingreso
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
                                        <th scope="col">Conductor</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Descripcion</th>
                                        <th scope="col">Importe</th>
                                        <th scope="col">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($detallegeneral->isEmpty())
                                        <tr>
                                            <td colspan="8"><i>:: NO HAY REGISTROS ::</i></td>
                                        </tr>
                                    @else
                                        @php $contadorg = ($detallegeneral->currentPage() - 1) * $detallegeneral->perPage() + 1; @endphp
                                        @foreach ($detallegeneral as $itemgeneral)
                                            <tr>
                                                <td>{{ $contadorg++ }}</td>
                                                <td>{{ $itemgeneral->Flete->nombre_flete }}</td>
                                                <td>{{ $itemgeneral->Viatico->nombre_viatico }}</td>
                                                <td>{{ $itemgeneral->Empleado->nombres }}</td>
                                                <td>{{ $itemgeneral->fecha }}</td>
                                                <td>{{ $itemgeneral->descripcion }}</td>
                                                <td>{{ $itemgeneral->importe }}</td>
                                                <td>
                                                    <a class="me-3"
                                                        href="{{ route('detalleFV.edit', $itemgeneral->iddetallefv) }}">
                                                        <img src="/assets/img/icons/edit.svg" alt="img">
                                                    </a>
                                                    <a class="me-3 delete" data-id="{{ $itemgeneral->iddetallefv }}"
                                                        data-importe="{{ $itemgeneral->importe }}"
                                                        data-descripcion="{{ $itemgeneral->descripcion }}"
                                                        data-tipoIG="{{ $itemgeneral->tipoIG }}"
                                                        data-fecha="{{ $itemgeneral->fecha }}" data-bs-toggle="modal"
                                                        data-bs-target="#eliminarDetalleModal">
                                                        <img src="/assets/img/icons/delete.svg" alt="img">
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach

                                        <!-- Mostrar filas basadas en el valor de $tipoIG -->
                                        @if (empty($tipoIG))
                                            <tr style="background-color: #d2d2d2">
                                                <td colspan="2" class="text-right"><strong>Ingreso Total:</strong></td>
                                                <td>{{ $totalIngreso }}</td>
                                            </tr>
                                            <tr style="background-color: #d2d2d2">
                                                <td colspan="2" class="text-right"><strong>Gasto Total:</strong></td>
                                                <td>{{ $totalGasto }}</td>
                                            </tr>
                                            @php
                                                $diferencia = $totalIngreso - $totalGasto;
                                                $colorClase = $diferencia < 0 ? 'text-danger' : 'text-primary';
                                            @endphp
                                            <tr style="background-color: #d2d2d2">
                                                <td colspan="2" class="text-right"><strong>Diferencia:</strong></td>
                                                <td class="{{ $colorClase }}">{{ $diferencia }}</td>
                                            </tr>
                                        @else
                                            <tr style="background-color: #d2d2d2">
                                                <td colspan="2" class="text-right"><strong>
                                                        @if ($tipoIG == '1')
                                                            Gasto Total:
                                                        @elseif($tipoIG == '2')
                                                            Ingreso Total:
                                                        @endif
                                                    </strong></td>
                                                <td>
                                                    @if ($tipoIG == '1')
                                                        {{ $totalGasto }}
                                                    @elseif($tipoIG == '2')
                                                        {{ $totalIngreso }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    @endif
                                </tbody>

                            </table>
                            {{ $detallegeneral->appends(request()->except('general_page'))->links() }}
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                            <label for="idempleado" class="form-label">Conductor</label>
                            <select class="form-select" id="idempleado" name="idempleado" required>
                                <option value="">Seleccione un Conductor</option>
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
