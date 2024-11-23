@extends('layouts.plantilla')
@section('titulo', 'Detallecar')

@section('contenido')
    <div class="container">
        <div class="page-header d-flex justify-content-between align-items-center mb-4">
            <div class="page-title">
                <h3 class="  fw-bold">Detalles Vehiculares</h3>
            </div>

            <div class="d-flex align-items-center">
                <a class="btn btn-added" href="{{ route('detallecar.create') }}">
                    <img src="/assets/img/icons/plus.svg" alt="Nuevo" class="me-2">Nuevo
                </a>
            </div>
        </div>
        <nav class="navbar navbar-light bg-light p-4 rounded shadow-sm mb-4">
            <div class="container-fluid d-flex flex-column align-items-center">
                <form class="form w-100" method="GET" id="search-form" style="max-width: 600px;">
                    <!-- Fila de selección de Vehículo y Transportista centrados -->
                    <div class="row mb-3 text-center">
                        <!-- Selección de Vehículo -->
                        <div class="col-md-6">
                            <label for="idvehiculo" class="form-label fw-bold">Vehículo:</label>
                            <select class="form-select" name="idvehiculo" id="idvehiculo" aria-label="Seleccionar vehículo">
                                <option value="" selected disabled>Seleccionar</option>
                                @foreach ($vehiculos as $vehiculo)
                                    <option value="{{ $vehiculo->idvehiculo }}">{{ $vehiculo->marca }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Selección de Transportista -->
                        <div class="col-md-6">
                            <label for="idempleado" class="form-label fw-bold">Transportista:</label>
                            <select class="form-select" name="idempleado" id="idempleado"
                                aria-label="Seleccionar transportista">
                                <option value="" selected disabled>Seleccionar</option>
                                @foreach ($empleados as $empleado)
                                    <option value="{{ $empleado->idempleado }}">{{ $empleado->nombres }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Botones de Filtrado y Limpieza centrados -->
                    <div class="d-flex justify-content-center gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">Filtrar</button>
                        <a href="{{ route('detallecar.index') }}" class="btn btn-secondary">Limpiar</a>
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
        <div class="row">
            <div class="col-12">
                <!-- Tarjeta de tabla -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive" id="detallecarTable">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr style="text-align: center">
                                        <th scope="col">N°</th>
                                        <th scope="col">Vehiculo</th>
                                        <th scope="col">Conductor</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Observacion</th>
                                        <th scope="col">Monto</th>
                                        <th scope="col">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($detalles->isEmpty())
                                        <tr>
                                            <td colspan="7" class="text-center"><i>:: NO HAY REGISTROS ::</i></td>
                                        </tr>
                                    @else
                                        @php $contador = ($detalles->currentPage() - 1) * $detalles->perPage() + 1; @endphp
                                        @foreach ($detalles as $itemgeneral)
                                        <tr>
                                            <td>{{ $contador++ }}</td>
                                            <td>{{ $itemgeneral->Empleado->nombres }}</td>
                                            <td>{{ $itemgeneral->Vehiculo->marca }}</td>
                                            <td>{{ $itemgeneral->fecha }}</td>
                                            <td>{{ $itemgeneral->observacion }}</td>
                                            <td>{{ $itemgeneral->monto }}</td>
                                            <td>
                                                <a class="me-3 edit" data-id="{{ $itemgeneral->iddetalleveh }}"
                                                    data-idvehiculo="{{ $itemgeneral->Vehiculo->idvehiculo }}"
                                                    data-idempleado="{{ $itemgeneral->Empleado->idempleado }}"
                                                    data-fecha="{{ $itemgeneral->fecha }}"
                                                    data-observacion="{{ $itemgeneral->observacion }}"
                                                    data-monto="{{ $itemgeneral->monto }}" 
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editarDetallecarModal">
                                                    <img src="/assets/img/icons/edit.svg" alt="img">
                                                </a>
                                                <a class="me-3 delete" data-id="{{ $itemgeneral->iddetalleveh }}"
                                                    data-idempleado="{{ $itemgeneral->Empleado->idempleado }}"
                                                    data-idvehiculo="{{ $itemgeneral->Vehiculo->idvehiculo }}" data-bs-toggle="modal"
                                                    data-bs-target="#eliminarDetallecarModal">
                                                    <img src="/assets/img/icons/delete.svg" alt="img">
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table><br>
                            <div
                                style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                                {{ $detalles->appends(request()->except('general_page'))->links() }}
                            </div><br>

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
    <script>
        $(document).ready(function() {
            $('#idvehiculo, #idempleado').select2({
                allowClear: true,
                width: '100%'
            });
        });
    </script>

    <!-- Modal Editar -->
    <div class="modal fade" id="editarDetallecarModal" tabindex="-1" aria-labelledby="editarEmpleadoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarEmpleadoModalLabel">Editar Detalle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editarEmpleadoForm" method="POST" action="">
                        @method('PUT')
                        @csrf
                        <input type="hidden" id="editariddetalleveh" name="id">

                        <div class="mb-3">
                            <label for="editaridvehiculo" class="form-label">Vehiculo</label>
                            <input type="text" class="form-control" id="editaridvehiculo" name="vehiculo"
                                placeholder="vehiculo" required>
                        </div>
                        <div class="mb-3">
                            <label for="editaridempleado" class="form-label">Empleado</label>
                            <input type="text" class="form-control" id="editaridempleado" name="empleado"
                                placeholder="empleado" required>
                        </div>


                        <div class="mb-3">
                            <label for="editarfecha" class="form-label">Fecha</label>
                            <input type="text" class="form-control" id="editarfecha" name="fecha"
                                placeholder="fecha" required>
                        </div>
                        <div class="mb-3">
                            <label for="editarobservacion" class="form-label">Observacion</label>
                            <input type="text" class="form-control" id="editarobservacion" name="observacion" placeholder="observacion"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="editarmonto" class="form-label">Monto</label>
                            <input type="text" class="form-control" id="editarmonto" name="monto" placeholder="monto"
                                required>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary" id="editarDetallecarBtn">Actualizar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Eliminar -->
    <div class="modal fade" id="eliminarDetallecarModal" tabindex="-1" aria-labelledby="eliminarDetallecarModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eliminarDetallecarModalLabel">Eliminar Flete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¿Está seguro de que desea eliminar el empleado: <span id="eliminarIdempleado"></span>?</p>
                    <p>¿Está seguro de que desea eliminar el empleado: <span id="eliminarIdempleado"></span>?</p>
                    <p>¿Está seguro de que desea eliminar el empleado: <span id="eliminarIdvehiculo"></span>?</p>
                    <form id="eliminarDetallecarForm" method="POST" action="">
                        @method('DELETE')
                        @csrf
                        <input type="hidden" id="eliminarIddetalleveh" name="id">

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

        // Para el modal de edición, establecer el ID antes de abrir el modal
        document.querySelectorAll('.edit').forEach(button => {
            button.addEventListener('click', function() {
                // Obtener los valores del flete almacenados en los atributos data-*
                let iddetalleveh = this.getAttribute('data-id');
                let idvehiculo = this.getAttribute('data-idvehiculo');
                let idempleado = this.getAttribute('data-idempleado');
                let fecha = this.getAttribute('data-fecha');
                let observacion = this.getAttribute('data-observacion');
                let monto = this.getAttribute('data-monto');

                // Asignar los valores a los campos del modal de edición
                document.getElementById('editariddetalleveh').value = iddetalleveh;
                document.getElementById('editaridvehiculo').value = idvehiculo;
                document.getElementById('editaridempleado').value = idempleado;
                document.getElementById('editarfecha').value = fecha;
                document.getElementById('editarobservacion').value = observacion;
                document.getElementById('editarmonto').value = monto;

                // Actualizar la acción del formulario para que apunte a la ruta correcta
                document.getElementById('editarDetallecarForm').action = `/detallecar/${iddetalleveh}`;
            });
        });
         
        document.querySelectorAll('.delete').forEach(button => {
            button.addEventListener('click', function() {
                // Obtener los valores del flete almacenados en los atributos data-*
                let iddetalleveh = this.getAttribute('data-id');
                let idempleado = this.getAttribute('data-idempleado');
                let idvehiculo = this.getAttribute('data-idvehiculo');
                document.getElementById('eliminarIddetalleveh').value = iddetalleveh;
                document.getElementById('eliminarIdempleado').textContent = idempleado;
                document.getElementById('eliminarIdvehiculo').textContent = idempleado;
                document.getElementById('eliminarDetallecarForm').action = `/detallecar/${iddetalleveh}`;
            });
        }); 
    </script>




















@endsection
