@extends('layouts.plantilla')
@section('titulo', 'Fletes')

@section('contenido')
    <div class="container">
        <div class="page-header d-flex justify-content-between align-items-center">
            <div class="page-title">
                <h4>Lista de Fletes</h4>
            </div>
            <div class="d-flex align-items-center">
                <!-- Botón para abrir el modal -->
                <button type="button" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#nuevoFleteModal">
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
                <div class="table-responsive" id="fleteTable">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">N°</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Descripcion</th>
                                <th scope="col">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($flete) <= 0)
                                <tr>
                                    <td colspan="5"><i>:: NO HAY REGISTROS ::</i></td>
                                </tr>
                            @else
                                @foreach ($flete as $itemflete)
                                    <tr>
                                        <td>{{ $itemflete->idflete }}</td>
                                        <td>{{ $itemflete->nombre_flete }}</td>
                                        <td>{{ $itemflete->descripcion }}</td>
                                        <td>
                                            <a class="me-3 edit" data-id="{{ $itemflete->idflete }}"
                                                data-nombre="{{ $itemflete->nombre_flete }}"
                                                data-descripcion="{{ $itemflete->descripcion }}"
                                                 data-bs-toggle="modal"
                                                data-bs-target="#editarFleteModal">
                                                <img src="/assets/img/icons/edit.svg" alt="img">
                                            </a>
                                            <a class="me-3 delete" data-id="{{ $itemflete->idflete }}"
                                                data-nombre="{{ $itemflete->nombre_flete }}"
                                                data-descripcion="{{ $itemflete->descripcion }}" data-bs-toggle="modal"
                                                data-bs-target="#eliminarFleteModal">
                                                <img src="/assets/img/icons/delete.svg" alt="img">
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    <br>
                    {{ $flete->links() }}
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
    <div class="modal fade" id="nuevoFleteModal" tabindex="-1" aria-labelledby="nuevoFleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nuevoFleteModalLabel">Nuevo Flete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="nuevoFleteForm" method="POST" action="{{ route('flete.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="nombre_flete" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre_flete" name="nombre_flete" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripcion</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary" id="guardarFleteBtn">Guardar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Editar -->
    <div class="modal fade" id="editarFleteModal" tabindex="-1" aria-labelledby="editarFleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarFleteModalLabel">Editar Flete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editarFleteForm" method="POST" action="">
                        @method('PUT')
                        @csrf
                        <input type="hidden" id="editarFleteId" name="id">

                        <div class="mb-3">
                            <label for="editarNombre_flete" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="editarNombre_flete" name="nombre_flete"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="editarDescripcion" class="form-label">Descripcion</label>
                            <textarea class="form-control" id="editarDescripcion" name="descripcion" required></textarea>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary" id="editarFleteBtn">Actualizar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Eliminar -->
    <div class="modal fade" id="eliminarFleteModal" tabindex="-1" aria-labelledby="eliminarFleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eliminarFleteModalLabel">Eliminar Flete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¿Está seguro de que desea eliminar el flete: <span id="eliminarNombre_flete"></span>?</p>
                    <form id="eliminarFleteForm" method="POST" action="">
                        @method('DELETE')
                        @csrf
                        <input type="hidden" id="eliminarFleteId" name="id">

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
        document.getElementById('buscarpor').addEventListener('keyup', function() {
            let query = this.value;

            fetch(`{{ route('flete.index') }}?buscarpor=${query}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    let parser = new DOMParser();
                    let doc = parser.parseFromString(html, 'text/html');
                    let newTable = doc.getElementById('fleteTable').innerHTML;
                    document.getElementById('fleteTable').innerHTML = newTable;
                });
        });

        // Para el modal de edición, establecer el ID antes de abrir el modal
        document.querySelectorAll('.edit').forEach(button => {
            button.addEventListener('click', function() {
                // Obtener los valores del flete almacenados en los atributos data-*
                let idflete = this.getAttribute('data-id');
                let nombre = this.getAttribute('data-nombre');
                let descripcion = this.getAttribute('data-descripcion');
                

                // Asignar los valores a los campos del modal de edición
                document.getElementById('editarFleteId').value = idflete;
                document.getElementById('editarNombre_flete').value = nombre;
                document.getElementById('editarDescripcion').value = descripcion;

                // Actualizar la acción del formulario para que apunte a la ruta correcta
                document.getElementById('editarFleteForm').action = `/flete/${idflete}`;
            });
        });
        document.querySelectorAll('.delete').forEach(button => {
            button.addEventListener('click', function() {
                // Obtener los valores del flete almacenados en los atributos data-*
                let idflete = this.getAttribute('data-id');
                let nombre = this.getAttribute('data-nombre');
                let descripcion = this.getAttribute('data-descripcion');
                document.getElementById('eliminarFleteId').value = idflete;
                document.getElementById('eliminarNombre_flete').textContent = nombre;

                document.getElementById('eliminarFleteForm').action = `/flete/${idflete}`;
            });
        });
    </script>

@endsection
