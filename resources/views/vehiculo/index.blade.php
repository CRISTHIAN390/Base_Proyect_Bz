@extends('layouts.plantilla')
@section('titulo', 'Vehiculos')

@section('contenido')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Lista de Vehículos</h4>
        <button type="button" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#nuevoVehiculoModal">
            <img src="/assets/img/icons/plus.svg" alt="img" class="me-2" width="18"> Nuevo Vehículo
        </button>
    </div>

    <!-- Barra de búsqueda -->
    <div class="d-flex justify-content-between mb-3">
        <form class="d-flex" method="GET" id="search-form">
            <input id="buscarpor" name="buscarpor" class="form-control me-2"   placeholder="Buscar por placa" value="{{ $buscarpor }}">
        </form>
    </div>

    <!-- Mensaje de confirmación -->
    @if (session('datos'))
        <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('datos') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Tabla de vehículos -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive" id="vehiculoTable">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">N°</th>
                            <th scope="col">Placa</th>
                            <th scope="col">Marca</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Fecha de Registro</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($vehiculo) <= 0)
                            <tr>
                                <td colspan="7" class="text-center"><i>:: NO HAY REGISTROS ::</i></td>
                            </tr>
                        @else
                            @php
                                $num = ($vehiculo->currentPage() - 1) * $vehiculo->perPage() + 1;
                            @endphp
                            @foreach ($vehiculo as $itemvehiculo)
                                <tr>
                                    <td>{{ $num++ }}</td>
                                    <td>{{ $itemvehiculo->placa }}</td>
                                    <td>{{ $itemvehiculo->marca }}</td>
                                    <td>{{ $itemvehiculo->descripcion }}</td>
                                    <td>{{ $itemvehiculo->fecha_registro }}</td>
                                    <td>
                                        @if ($itemvehiculo->estado == 1)
                                            <span class="badge bg-success">Activo</span>
                                        @else
                                            <span class="badge bg-danger">Inactivo</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="javascript:void(0);" class="text-primary me-2 edit" data-id="{{ $itemvehiculo->idvehiculo }}"
                                           data-placa="{{ $itemvehiculo->placa }}" data-marca="{{ $itemvehiculo->marca }}"
                                           data-descripcion="{{ $itemvehiculo->descripcion }}" data-fecha_registro="{{ $itemvehiculo->fecha_registro }}"
                                           data-estado="{{ $itemvehiculo->estado }}" data-bs-toggle="modal" data-bs-target="#editarVehiculoModal">
                                            <img src="/assets/img/icons/edit.svg" alt="Edit" >
                                        </a>
                                        <a href="{{ route('confirmar.vehiculo', $itemvehiculo->idvehiculo) }}" class="text-danger delete">
                                            <img src="/assets/img/icons/delete.svg" alt="Delete" >
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{ $vehiculo->links() }}
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
                }, 4000); // Ocultar después de 4 segundo
            }
        });
    </script>


    <!-- Modal Guardar -->
    <div class="modal fade" id="nuevoVehiculoModal" tabindex="-1" aria-labelledby="nuevoVehiculoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Encabezado del Modal -->
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="nuevoVehiculoModalLabel">Registrar Nuevo Vehículo</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
    
                <!-- Cuerpo del Modal -->
                <div class="modal-body">
                    <form id="nuevoVehiculoForm" method="POST" action="{{ route('vehiculo.store') }}">
                        @csrf
    
                        <!-- Campo de Placa -->
                        <div class="form-group mb-3">
                            <label for="placa" class="form-label">Placa</label>
                            <input type="text" class="form-control" id="placa" name="placa" placeholder="Ingrese la placa del vehículo" required>
                        </div>
    
                        <!-- Campo de Marca -->
                        <div class="form-group mb-3">
                            <label for="marca" class="form-label">Marca</label>
                            <input type="text" class="form-control" id="marca" name="marca" placeholder="Ingrese la marca" required>
                        </div>
    
                        <!-- Campo de Descripción -->
                        <div class="form-group mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" placeholder="Describa el estado del vehículo" required></textarea>
                        </div>
    
                        <!-- Campo de Fecha de Registro -->
                        <div class="form-group mb-3">
                            <label for="fecha_registro" class="form-label">Fecha de Registro</label>
                            <input type="date" class="form-control" id="fecha_registro" name="fecha_registro" required>
                        </div>
    
                        <!-- Botones -->
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-success" id="guardarVehiculoBtn">Guardar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editarVehiculoModal" tabindex="-1" aria-labelledby="editarVehiculoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Encabezado del Modal -->
                <div class="modal-header bg-info text-dark">
                    <h5 class="modal-title" id="editarVehiculoModalLabel" style="color: white">Editar Vehículo</h5>
                    <button type="button" class="btn-close btn-close-black" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
    
                <!-- Cuerpo del Modal -->
                <div class="modal-body">
                    <form id="editarVehiculoForm" method="POST" action="">
                        @method('PUT')
                        @csrf
                        <input type="hidden" id="editarVehiculoId" name="id">
    
                        <!-- Campo de Placa -->
                        <div class="form-group mb-3">
                            <label for="editarPlaca" class="form-label">Placa</label>
                            <input type="text" class="form-control" id="editarPlaca" name="placa" placeholder="Ingrese la placa del vehículo" required>
                        </div>
    
                        <!-- Campo de Marca -->
                        <div class="form-group mb-3">
                            <label for="editarMarca" class="form-label">Marca</label>
                            <input type="text" class="form-control" id="editarMarca" name="marca" placeholder="Ingrese la marca" required>
                        </div>
    
                        <!-- Campo de Descripción -->
                        <div class="form-group mb-3">
                            <label for="editarDescripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="editarDescripcion" name="descripcion" rows="3" placeholder="Describa el estado del vehículo" required></textarea>
                        </div>
    
                        <!-- Campo de Fecha de Registro -->
                        <div class="form-group mb-3">
                            <label for="editarFecha_registro" class="form-label">Fecha de Registro</label>
                            <input type="date" class="form-control" id="editarFecha_registro" name="fecha_registro" required>
                        </div>
    
                        <!-- Campo de Estado -->
                        <div class="form-group mb-3">
                            <label for="editarEstado" class="form-label">Estado</label>
                            <select class="form-select" id="editarEstado" name="estado" required>
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
    
                        <!-- Botones -->
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-success" id="editarVehiculoBtn">Actualizar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.getElementById('buscarpor').addEventListener('keyup', function() {
            let query = this.value;

            fetch(`{{ route('vehiculo.index') }}?buscarpor=${query}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    let parser = new DOMParser();
                    let doc = parser.parseFromString(html, 'text/html');
                    let newTable = doc.getElementById('vehiculoTable').innerHTML;
                    document.getElementById('vehiculoTable').innerHTML = newTable;
                });
        });


        // Para el modal de edición, establecer el ID antes de abrir el modal
        document.querySelectorAll('.edit').forEach(button => {
            button.addEventListener('click', function() {
                // Obtener los valores del flete almacenados en los atributos data-*
                let idvehiculo = this.getAttribute('data-id');
                let placa = this.getAttribute('data-placa');
                let marca = this.getAttribute('data-marca');
                let descripcion = this.getAttribute('data-descripcion');
                let fecha_registro = this.getAttribute('data-fecha_registro');
                let estado = this.getAttribute('data-estado');

                // Asignar los valores a los campos del modal de edición
                document.getElementById('editarVehiculoId').value = idvehiculo;
                document.getElementById('editarPlaca').value = placa;
                document.getElementById('editarMarca').value = marca;
                document.getElementById('editarDescripcion').value = descripcion;
                document.getElementById('editarFecha_registro').value = fecha_registro;
                // Seleccionar la opción correspondiente en el campo de estado
                const selectEstado = document.getElementById('editarEstado');
                selectEstado.value = estado === '1' ? '1' : '0';
                // Actualizar la acción del formulario para que apunte a la ruta correcta
                document.getElementById('editarVehiculoForm').action = `/vehiculo/${idvehiculo}`;
            });
        });

    </script>

@endsection
