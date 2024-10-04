@extends('layouts.plantilla')
@section('titulo', 'DetalleFV')

@section('contenido')

    <div class="container">
        <div class="page-header d-flex justify-content-between align-items-center mb-4">
            <div class="page-title">
                <h4 class="text-primary fw-bold">Lista de Detalles de los Fletes</h4>
            </div>

            <div class="d-flex align-items-center">
                <a type="button" class="btn btn-added"href="{{ route('detalleFV.create') }}">
                    <img src="/assets/img/icons/plus.svg" alt="Nuevo" class="me-2">Nuevo
                </a>
            </div>
        </div>

        <nav class="navbar navbar-light bg-light p-3 rounded shadow-sm">
            <div class="container-fluid">
                <form class="form" method="GET" id="search-form">
                    <!-- Primera fila: Colaboradores -->
                    <div class="row col-12 align-items-center mb-3">
                        <div class="col-md-12">
                            <label for="idempleado" class="form-label">Transportista:</label>
                            <select class="form-select" name="idempleado" id="idempleado">
                                <option value="" selected disabled>Seleccionar</option>
                                @foreach ($empleados as $itempleado)
                                    <option value="{{ $itempleado->idempleado }}">{{ $itempleado->nombres }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Segunda fila: Fletes, Viáticos y Fechas -->
                    <div class="row col-12 align-items-center mb-3">
                        <div class="col-lg-3">
                            <label for="idflete" class="form-label">Fletes:</label>
                            <select class="form-select" name="idflete" id="idflete">
                                <option value="" selected disabled>Seleccionar flete</option>
                                @foreach ($fletes as $itemflete)
                                    <option value="{{ $itemflete->idflete }}">{{ $itemflete->nombre_flete }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label for="idviatico" class="form-label">Viáticos:</label>
                            <select class="form-select" name="idviatico" id="idviatico">
                                <option value="" selected disabled>Seleccionar viático</option>
                                @foreach ($viaticos as $itemviatico)
                                    <option value="{{ $itemviatico->idviatico }}">{{ $itemviatico->nombre_viatico }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label for="fechaInicio" class="form-label">Fecha inicio:</label>
                            <input id="fechaInicio" name="fechaInicio" class="form-control" type="date"
                                value="{{ request('fechaInicio') }}">
                        </div>
                        <div class="col-lg-3">
                            <label for="fechaFin" class="form-label">Fecha fin:</label>
                            <input id="fechaFin" name="fechaFin" class="form-control" type="date"
                                value="{{ request('fechaFin') }}">
                        </div>
                    </div>

                    <div class="row align-items-center mb-3">
                        <div class="col-lg-3">
                            <label for="tipoIG" class="form-label">Gasto/Ingreso:</label>
                            <select class="form-select" name="tipoIG" id="tipoIG">
                                <option value="" selected disabled>.:Flujo:.</option>
                                <option value="1">Gasto</option>
                                <option value="2">Ingreso</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 d-flex align-items-center">
                            <input type="checkbox" class="form-check-input me-2" id="ordenarPorFecha" name="ordenarPorFecha"
                                value="1" {{ request('ordenarPorFecha') ? 'checked' : '' }}>
                            <label class="form-check-label" for="ordenarPorFecha">Ordenar por fecha</label>
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

            <style type="text/css">.subtitulo {
                font-size: 1rem;
                font-weight: bold;
                color: #000000;
                margin-bottom: 1rem;
                display: block;
            }
        </style>

        <div class="row">
            <div class="col-12">
                <!-- Subtítulo -->
                <label class="subtitulo">
                    @if ($tipoIG == '1')
                        Gastos
                    @elseif($tipoIG == '2')
                        Ingreso
                    @else
                        Gastos/Ingreso
                    @endif
                </label>

                <!-- Tarjeta de tabla -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive" id="empleadoTable">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">N°</th>
                                        <th scope="col">Flete</th>
                                        <th scope="col">Viático</th>
                                        <th scope="col">Conductor</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Descripción</th>
                                        <th scope="col">Importe</th>
                                        <th scope="col">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($detallegeneral->isEmpty())
                                        <tr>
                                            <td colspan="8" class="text-center"><i>:: NO HAY REGISTROS ::</i></td>
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
                                                <td>S/. {{ $itemgeneral->importe }}</td>
                                                <td>
                                                    <a class="me-3"
                                                        href="{{ route('detalleFV.edit', $itemgeneral->iddetallefv) }}">
                                                        <img src="/assets/img/icons/edit.svg" alt="Editar">
                                                    </a>
                                                    <a class="me-3 delete" data-id="{{ $itemgeneral->iddetallefv }}"
                                                        data-importe="{{ $itemgeneral->importe }}"
                                                        data-descripcion="{{ $itemgeneral->descripcion }}"
                                                        data-tipoIG="{{ $itemgeneral->tipoIG }}"
                                                        data-fecha="{{ $itemgeneral->fecha }}" data-bs-toggle="modal"
                                                        data-bs-target="#eliminarDetalleModal">
                                                        <img src="/assets/img/icons/delete.svg" alt="Eliminar">
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach

                                        <!-- Mostrar filas de totales -->
                                        @if (empty($tipoIG))
                                            <tr class="table-secondary">
                                                <td colspan="6" class="text-end fw-bold">Ingreso Total:</td>
                                                <td><b>S/.{{ $totalIngreso }}</b> </td>
                                                <td></td>
                                            </tr>
                                            <tr class="table-secondary">
                                                <td colspan="6" class="text-end fw-bold">Gasto Total:</td>
                                                <td><b>S/.{{ $totalGasto }}</b> </td>
                                                <td></td>
                                            </tr>
                                            @php
                                                $diferencia = $totalIngreso - $totalGasto;
                                                $colorClase = $diferencia < 0 ? 'text-danger' : 'text-primary';
                                                $diferenciaRedondeada = round($diferencia); // Redondear a entero
                                            @endphp
                                            <tr class="table-secondary">
                                                <td colspan="6" class="text-end fw-bold">Diferencia:</td>
                                                <td class="{{ $colorClase }}"><b>S/.{{ $diferencia }} ≈ S/.{{ $diferenciaRedondeada }}</b></td>
                                                <td></td>
                                            </tr>
                                        @else
                                            <tr class="table-secondary">
                                                <td colspan="6" class="text-end fw-bold">
                                                    @if ($tipoIG == '1')
                                                        Gasto Total:
                                                    @elseif($tipoIG == '2')
                                                        Ingreso Total:
                                                    @endif
                                                </td>

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
                            </table><br>
                            <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                                {{ $detallegeneral->appends(request()->except('general_page'))->links() }}
                            </div><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
    
    
        <!-- Modal Eliminar -->
        <div class="modal fade" id="eliminarDetalleModal" tabindex="-1" aria-labelledby="eliminarDetalleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <!-- Cabecera del modal -->
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="eliminarDetalleModalLabel">Confirmar Eliminación</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <!-- Cuerpo del modal -->
                    <div class="modal-body">
                        <p class="fw-bold text-center text-danger">¿Está seguro de que desea eliminar este <span
                                id="eliminarTipoIG_detalle"></span>?</p>
                        <ul class="list-unstyled">
                            <li><strong>Fecha:</strong> <span id="eliminarFecha_detalle"></span></li>
                            <li><strong>Descripción:</strong> <span id="eliminarDescripcion_detalle"></span></li>
                            <li><strong>Importe:</strong> <span id="eliminarImporte_detalle"></span></li>
                        </ul>
                        <form id="eliminarDetalleForm" method="POST" action="">
                            @method('DELETE')
                            @csrf
                            <input type="hidden" id="eliminarDetalleId" name="id">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-4">
                                <button type="submit" class="btn btn-danger me-md-2">Eliminar</button>
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Cancelar</button>
                            </div>
                        </form>
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
        <script>
            $(document).ready(function() {
                $('#idflete, #idviatico, #idempleado').select2({
                    allowClear: true,
                    width: '100%'
                });
            });
        </script>
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
                }


            );
        </script>

    @endsection
