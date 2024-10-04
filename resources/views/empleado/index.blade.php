@extends('layouts.plantilla')
@section('titulo', 'Empleado')

@section('contenido')

    <div class="container">
        <div class="page-header d-flex justify-content-between align-items-center">
            <div class="page-title">
                <h4>Lista de Colaboradores</h4>
            </div>
            <div class="d-flex align-items-center">
                <a href="{{ route('empleado.create') }}" class="btn btn-added">
                    <img src="/assets/img/icons/plus.svg" alt="img" class="me-2">Nuevo
                </a>
            </div>
        </div>
        <nav class="navbar navbar-light float-right">
            <div class="d-flex align-items-left">
                <form class="form-inline my-2" method="GET" id="search-form">
                    <input id="buscarpor" name="buscarpor" class="form-control me-2" type="search"
                        placeholder="Buscar por apellido" value="{{ $buscarpor }}">
                </form>
            </div>
            <div class="d-flex align-items-center">
                <a href="#" class="btn btn-added">
                    <img src="/assets/img/icons/pdf.svg" alt="Generar PDF" class="me-2">
                    Generar PDF
                </a>
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
                <div class="table-responsive" id="empleadoTable">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">N°</th>
                                <th scope="col">Apellidos</th>
                                <th scope="col">Nombres</th>
                                <th scope="col">Celular</th>
                                <th scope="col">Dni</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($empleado) <= 0)
                                <tr>
                                    <td colspan="7"><i>:: NO HAY REGISTROS ::</i></td>
                                </tr>
                            @else
                                @foreach ($empleado as $itemcliente)
                                    <tr>
                                        <td>{{ $itemcliente->idempleado }}</td>
                                        <td>{{ $itemcliente->apellidos }}</td>
                                        <td>{{ $itemcliente->nombres }}</td>
                                        <td>{{ $itemcliente->celular }}</td>
                                        <td>{{ $itemcliente->dni }}</td>
                                        <td>
                                            @if ($itemcliente->estado == 1)
                                                <span class="badges bg-lightgreen">Activo</span>
                                            @else
                                                <span class="badges bg-lightred">Inactivo</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a class="me-3 edit" data-id="{{ $itemcliente->idempleado }}"
                                                data-apellidos="{{ $itemcliente->apellidos }}"
                                                data-nombres="{{ $itemcliente->nombres }}"
                                                data-celular="{{ $itemcliente->celular }}"
                                                data-dni="{{ $itemcliente->dni }}"
                                                data-estado="{{ $itemcliente->estado }}" data-bs-toggle="modal"
                                                data-bs-target="#editarEmpleadoModal">
                                                <img src="/assets/img/icons/edit.svg" alt="img">
                                            </a>
                                            <a class="me-3 delete"  href="{{ route('confirmar.empleado',$itemcliente->idempleado) }}">
                                                <img src="/assets/img/icons/delete.svg" alt="img">
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    <br>
                    {{ $empleado->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Editar -->
    <div class="modal fade" id="editarEmpleadoModal" tabindex="-1" aria-labelledby="editarEmpleadoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarEmpleadoModalLabel">Editar Empleado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editarEmpleadoForm" method="POST" action="">
                        @method('PUT')
                        @csrf
                        <input type="hidden" id="editarEmpleadoId" name="id">

                        <div class="mb-3">
                            <label for="editarApellidos" class="form-label">Apellidos</label>
                            <input type="text" class="form-control" id="editarApellidos" name="apellidos"
                                placeholder="Apellidos" required>
                        </div>
                        <div class="mb-3">
                            <label for="editarNombres" class="form-label">Nombres</label>
                            <input type="text" class="form-control" id="editarNombres" name="nombres"
                                placeholder="Nombres" required>
                        </div>
                        <div class="mb-3">
                            <label for="editarCelular" class="form-label">Celular</label>
                            <input type="text" class="form-control" id="editarCelular" name="celular"
                                placeholder="celular" required>
                        </div>
                        <div class="mb-3">
                            <label for="editarDni" class="form-label">Dni</label>
                            <input type="text" class="form-control" id="editarDni" name="dni" placeholder="dni"
                                required>
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
                            <button type="submit" class="btn btn-primary" id="editarEmpleadoBtn">Actualizar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Ocultar el mensaje -->

    <!-- Modal Eliminar -->
    <div class="modal fade" id="deleteEmpleadoModal" tabindex="-1" aria-labelledby="eliminarEmpleadoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eliminarEmpleadoModalLabel">Eliminar Empleado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¿Está seguro de que desea eliminar al colaborador: <span id="eliminarApellidos"></span>?</p>
                    <form id="eliminarEmpleadoForm" method="post" action="">
                        @method('DELETE')
                        @csrf
                        <input type="hidden" id="eliminarEmpleadoId" name="id">
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-danger" id="eliminarEmpleadoBtn">Eliminar</button>
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

            fetch(`{{ route('empleado.index') }}?buscarpor=${query}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    let parser = new DOMParser();
                    let doc = parser.parseFromString(html, 'text/html');
                    let newTable = doc.getElementById('empleadoTable').innerHTML;
                    document.getElementById('empleadoTable').innerHTML = newTable;
                });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const successMessage = document.getElementById('successMessage');
            if (successMessage) {
                setTimeout(() => {
                    successMessage.style.display = 'none';
                }, 4000); // Ocultar después de 4 segundo
            }
        });
        // Para el modal de edición, establecer el ID antes de abrir el modal
        document.querySelectorAll('.edit').forEach(button => {
            button.addEventListener('click', function() {
                // Obtener los valores almacenados en los atributos data-*
                let idempleado = this.getAttribute('data-id');
                let apellidos = this.getAttribute('data-apellidos');
                let nombres = this.getAttribute('data-nombres');
                let celular = this.getAttribute('data-celular');
                let dni = this.getAttribute('data-dni');
                let estado = this.getAttribute('data-estado');

                // Asignar los valores a los campos del modal de edición
                document.getElementById('editarEmpleadoId').value = idempleado;
                document.getElementById('editarApellidos').value = apellidos;
                document.getElementById('editarNombres').value = nombres;
                document.getElementById('editarCelular').value = celular;
                document.getElementById('editarDni').value = dni;
            
                // Seleccionar la opción correspondiente en el campo de estado
                const selectEstado = document.getElementById('editarEstado');
                selectEstado.value = estado === '1' ? '1' : '0';

                // Actualizar la acción del formulario para que apunte a la ruta correcta
                document.getElementById('editarEmpleadoForm').action = `/empleado/${idempleado}`;
            });
        });
    </script>
@endsection
