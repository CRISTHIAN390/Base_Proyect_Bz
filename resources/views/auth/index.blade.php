@extends('layouts.plantilla')
@section('titulo', 'Usuarios')

@section('contenido')
    <div class="container">
        <div class="page-header d-flex justify-content-between align-items-center">
            <div class="page-title">
                <h4>Lista de Usuarios</h4>
            </div>
        </div>

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
                                <th scope="col">Correo</th>
                                <th scope="col">Rol</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Acceso</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($usuarios->isEmpty())
                                <tr>
                                    <td colspan="6" class="text-center"><i>:: NO HAY REGISTROS ::</i></td>
                                </tr>
                            @else
                                @php $contadoru = ($usuarios->currentPage() - 1) * $usuarios->perPage() + 1; @endphp
                                @foreach ($usuarios as $usuario)
                                    <tr>
                                        <td>{{ $contadoru++ }}</td>
                                        <td>{{ $usuario->name }}</td>
                                        <td>{{ $usuario->email }}</td>
                                        <td>{{ $usuario->rol->name }}</td>
                                        <td>
                                            @if ($usuario->state == 1)
                                                <span class="badges bg-lightgreen">Activo</span>
                                            @else
                                                <span class="badges bg-lightred">Inactivo</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary me-3 edit"
                                                data-id="{{ $usuario->id }}"
                                                data-name="{{ $usuario->name }}"
                                                data-email="{{ $usuario->email }}"
                                                data-idrol="{{ $usuario->rol->id }}"
                                                data-state="{{ $usuario->state }}"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editarUsuarioModal">
                                                <img src="/assets/img/icons/edit.svg" alt="img">
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    <br>
                    {{ $usuarios->links() }}
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


<!-- Modal Editar -->
<div class="modal fade" id="editarUsuarioModal" tabindex="-1" aria-labelledby="editarUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarUsuarioLabel">Editar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editarUsuarioForm" method="post" action="{{ route('editRolState') }}">
                    @csrf
                    @method('put')
                    
                    <input type="hidden" name="id" id="editarUsuarioId">
                    
                    <div class="mb-3">
                        <label for="editarUsuarioName" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="editarUsuarioName" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="editarUsuarioEmail" class="form-label">Correo</label>
                        <input type="email" class="form-control" id="editarUsuarioEmail" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label for="editarUsuarioRol" class="form-label">Rol</label>
                        <select class="form-select" id="editarUsuarioRol" name="idrol" required>
                            @foreach ($roles as $rol)
                                <option value="{{ $rol->id }}">{{ $rol->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="editarUsuarioState" class="form-label">Estado</label>
                        <select class="form-select" id="editarUsuarioState" name="state" required>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript para poblar el formulario -->
<script>
    document.querySelectorAll('.edit').forEach(button => {
        button.addEventListener('click', function () {
            // Obtener datos del usuario del botón
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const email = this.getAttribute('data-email');
            const idrol = this.getAttribute('data-idrol');
            const state = this.getAttribute('data-state');
            
            // Llenar el formulario con los datos del usuario
            document.getElementById('editarUsuarioId').value = id;
            document.getElementById('editarUsuarioName').value = name;
            document.getElementById('editarUsuarioEmail').value = email;
            document.getElementById('editarUsuarioRol').value = idrol;  // Actualizar con el rol correcto
            document.getElementById('editarUsuarioState').value = state;
        });
    });
</script>

@endsection
