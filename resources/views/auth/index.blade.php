@extends('layouts.plantilla')
@section('titulo', 'Usuarios')

@section('contenido')
<div class="container">
    <div class="page-header d-flex justify-content-between align-items-center">
        <div class="page-title">
            <h4>Lista de Usuarios</h4>
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">N°</th>
                <th scope="col">Nombre</th>
                <th scope="col">Correo</th>
                <th scope="col">Rol</th>
                <th scope="col">Estado</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usuarios as $usuario)
            <tr>
                <th scope="row">{{ $usuario->id }}</th>
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
                    <a class="me-3 edit" data-iduser="{{ $usuario->id }}"
                        data-name="{{ $usuario->name }}"
                        data-email="{{ $usuario->email }}"
                        data-idrol="{{ $usuario->rol->idrol }}"
                        data-bs-toggle="modal"
                        data-bs-target="#editarUsuarioModal">
                        <img src="/assets/img/icons/edit.svg" alt="img">
                    </a>
                    <a class="me-3 deletee" data-iduser="{{ $usuario->id}}"
                        data-name="{{ $usuario->name }}"
                        data-bs-toggle="modal" data-bs-target="#eliminarUsuarioModal">
                        <img src="/assets/img/icons/delete.svg" alt="Eliminar">
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Editar -->
<div class="modal fade" id="editarUsuarioModal" tabindex="-1" aria-labelledby="editarUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarUsuarioLabel">Editar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditarUsuario" action="#" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="edit-id">
                    <div class="mb-3">
                        <label for="edit-name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="edit-name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-email" class="form-label">Correo</label>
                        <input type="email" class="form-control" id="edit-email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-rol" class="form-label">Rol</label>
                        <select class="form-select" id="edit-rol" name="rol_id" required>
                            <option value="">Seleccionar Rol</option>
                            @foreach ($roles as $rol)
                                <option value="{{ $rol->idrol }}">{{ $rol->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnGuardarCambios">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Eliminar -->
<div class="modal fade" id="eliminarUsuarioModal" tabindex="-1" aria-labelledby="eliminarUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eliminarUsuarioLabel">Eliminar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro que deseas eliminar al usuario: <span id="nombreUsuario"></span>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="btnEliminarUsuario">Eliminar</button>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    // Llenar el formulario de editar usuario
    document.addEventListener('DOMContentLoaded', function () {
        const editModal = document.getElementById('editarUsuarioModal');
        editModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-iduser');
            const name = button.getAttribute('data-name');
            const email = button.getAttribute('data-email');
            const rolId = button.getAttribute('data-idrol');

            const editIdInput = editModal.querySelector('#edit-id');
            const editNameInput = editModal.querySelector('#edit-name');
            const editEmailInput = editModal.querySelector('#edit-email');
            const editRolSelect = editModal.querySelector('#edit-rol');

            editIdInput.value = id;
            editNameInput.value = name;
            editEmailInput.value = email;
            editRolSelect.value = rolId; // Asigna el rol seleccionado
        });

        // Llenar el modal de eliminar usuario
        document.querySelectorAll('.deletee').forEach(button => {
            button.addEventListener('click', function() {
            const nombre = button.getAttribute('data-name');
            const idUser = button.getAttribute('data-id');
            document.getElementById('nombreUsuario').textContent = nombre;
        });
        }
    
    
    );
    }
    
    
    );
</script>
@endsection

@endsection