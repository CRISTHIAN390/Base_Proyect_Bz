@extends('layouts.plantilla')
@section('titulo', 'Viaticos')

@section('contenido')

    <div class="container">
        <div class="page-header d-flex justify-content-between align-items-center">
            <div class="page-title">
                <h4>Lista de Viaticos</h4>
            </div>
            <div class="d-flex align-items-center">
                <!-- Botón para abrir el modal -->
                <button type="button" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#nuevoViaticoModal">
                    <img src="/assets/img/icons/plus.svg" alt="img" class="me-2">Nuevo
                </button>
            </div>
        </div>

        <nav class="navbar navbar-light float-right">
            <div class="d-flex align-items-left">
                <form class="form-inline my-2" method="GET" id="search-form">
                    <input id="buscarpor" name="buscarpor" class="form-control me-2" type="search"
                        placeholder="Buscar por nombre" value="{{ $buscarpor }}">
                </form>
            </div>
        </nav>
                 <!-- Mensaje de confirmación -->
                 @if (session('datos'))
                 <div id="successMessage" class="alert alert-success mt-3">
                     {{ session('datos') }}
                 </div>
                @endif
        <div class="card">
            <div class="card-body">
                <div class="table-responsive" id="viaticoTable">

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">N°</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Descripcion</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($viatico) <= 0)
                                <tr>
                                    <td colspan="5"><i>:: NO HAY REGISTROS ::</i></td>
                                </tr>
                            @else
                                @foreach ($viatico as $itemviatico)
                                    <tr>
                                        <td>{{ $itemviatico->idviatico }}</td>
                                        <td>{{ $itemviatico->nombre_viatico }}</td>
                                        <td>{{ $itemviatico->descripcion }}</td>
                                        <td>
                                            @if ($itemviatico->estado == 1)
                                                <span class="badges bg-lightgreen">Activo</span>
                                            @else
                                                <span class="badges bg-lightred">Inactivo</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a class="me-3 edit" data-id="{{ $itemviatico->idviatico }}"
                                                data-nombre="{{ $itemviatico->nombre_viatico }}"
                                                data-descripcion="{{ $itemviatico->descripcion }}"
                                                data-estado="{{ $itemviatico->estado }}" data-bs-toggle="modal"
                                                data-bs-target="#editarViaticoModal">
                                                <img src="/assets/img/icons/edit.svg" alt="img">
                                            </a>
                                            <a class="me-3 delete" data-id="{{ $itemviatico->idviatico }}"
                                                data-nombre="{{ $itemviatico->nombre_viatico }}"
                                                data-descripcion="{{ $itemviatico->descripcion }}" data-bs-toggle="modal"
                                                data-bs-target="#eliminarViaticoModal">
                                                <img src="/assets/img/icons/delete.svg" alt="img">
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    {{ $viatico->links() }}
                    <br>
                </div>
            </div>
        </div>
    </div>
     <!-- Ocultar el mensaje -->
     <script>
        document.addEventListener('DOMContentLoaded', function () {
            const successMessage = document.getElementById('successMessage');
            if (successMessage) {
                setTimeout(() => {
                    successMessage.style.display = 'none';
                }, 4000); // Ocultar después de 4 segundo
            }
        });
    </script>
    <!-- Modal Guardar -->
    <div class="modal fade" id="nuevoViaticoModal" tabindex="-1" aria-labelledby="nuevoViaticoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nuevoViaticoModalLabel">Nuevo Viatico</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="nuevoViaticoForm" method="POST" action="{{ route('viatico.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="nombre_viatico" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre_viatico" name="nombre_viatico" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripcion</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary" id="guardarViaticoeBtn">Guardar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Editar -->
    <div class="modal fade" id="editarViaticoModal" tabindex="-1" aria-labelledby="editarViaticoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarViaticoModalLabel">Editar Viatico</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editarViaticoForm" method="POST" action="">
                        @method('PUT')
                        @csrf
                        <input type="hidden" id="editarViaticoId" name="id">

                        <div class="mb-3">
                            <label for="editarNombre_viatico" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="editarNombre_viatico" name="nombre_viatico"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="editarDescripcion" class="form-label">Descripcion</label>
                            <textarea class="form-control" id="editarDescripcion" name="descripcion" required></textarea>
                        </div>
                        @if (Auth::check() && Auth::user()->idrol === 1)
                        <div class="mb-3">
                            <label for="editarEstado" class="form-label">Estado</label>
                            <select class="form-select" id="editarEstado" name="estado" required>
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                        @endif
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary" id="editarViaticoBtn">Actualizar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Eliminar -->
    <div class="modal fade" id="eliminarViaticoModal" tabindex="-1" aria-labelledby="eliminarViaticoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eliminarViaticoModalLabel">Eliminar Viatico</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¿Está seguro de que desea eliminar el Viatico: <span id="eliminarNombre_viatico"></span>?</p>
                    <form id="eliminarViaticoForm" method="POST" action="">
                        @method('DELETE')
                        @csrf
                        <input type="hidden" id="eliminarViaticoId" name="id">

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-danger" id="eliminarViaticoBtn">Eliminar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            document.getElementById('buscarpor').addEventListener('keyup', function() {
                let query = this.value;

                fetch(`{{ route('viatico.index') }}?buscarpor=${query}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        let parser = new DOMParser();
                        let doc = parser.parseFromString(html, 'text/html');
                        let newTable = doc.getElementById('viaticoTable').innerHTML;
                        document.getElementById('viaticoTable').innerHTML = newTable;
                    });
            });

            // Para el modal de edición, establecer el ID antes de abrir el modal
            document.querySelectorAll('.edit').forEach(button => {
                button.addEventListener('click', function() {
                    // Obtener los valores del  viatico almacenados en los atributos data-*
                    let idviatico = this.getAttribute('data-id');
                    let nombre = this.getAttribute('data-nombre');
                    let descripcion = this.getAttribute('data-descripcion');
                    let estado = this.getAttribute('data-estado');

                    // Asignar los valores a los campos del modal de edición
                    document.getElementById('editarViaticoId').value = idviatico;
                    document.getElementById('editarNombre_viatico').value = nombre;
                    document.getElementById('editarDescripcion').value = descripcion;
                    // Seleccionar la opción correspondiente en el campo de estado
                    const selectEstado = document.getElementById('editarEstado');
                    selectEstado.value = estado === '1' ? '1' : '0';

                    // Actualizar la acción del formulario para que apunte a la ruta correcta
                    document.getElementById('editarViaticoForm').action = `/viatico/${idviatico}`;
                });
            });

            document.querySelectorAll('.delete').forEach(button => {
                button.addEventListener('click', function() {
                    // Obtener los valores del viatico  almacenados en los atributos data-*
                    let idviatico = this.getAttribute('data-id');
                    let nombre = this.getAttribute('data-nombre');
                    let descripcion = this.getAttribute('data-descripcion');
                    document.getElementById('eliminarViaticoId').value = idviatico;
                    document.getElementById('eliminarNombre_viatico').textContent = nombre;

                    document.getElementById('eliminarViaticoForm').action = `/viatico/${idviatico}`;
                });
            });
        </script>

    @endsection
