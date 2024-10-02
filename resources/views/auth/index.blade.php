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
                                                data-id="{{ $usuario->id }}" data-name="{{ $usuario->name }}"
                                                data-email="{{ $usuario->email }}" data-idrol="{{ $usuario->rol->idrol }}"
                                                data-state="{{ $usuario->state }}" data-bs-toggle="modal"
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
                <!-- Formulario para actualizar el perfil -->
                <form id="editarUsuarioForm" method="post" action="{{ route('editRolState') }}">
                    @csrf
                    @method('put')
                    
                    <!-- Campo oculto para el ID del usuario -->
                    <input type="hidden" id="editarUsuarioId" name="id" value="{{ $usuario->id }}">

                    <!-- Campo de nombre -->
                    <div class="mb-3">
                        <label for="editarNombre_usuario" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="editarNombre_usuario" name="name" 
                               value="{{ old('name', $usuario->name) }}" disabled autofocus>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Campo de correo electrónico -->
                    <div class="mb-3">
                        <label for="editarEmail" class="form-label">Correo</label>
                        <input type="email" class="form-control" id="editarEmail" name="email" 
                               value="{{ old('email', $usuario->email) }}" disabled>
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                        @if ($usuario instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$usuario->hasVerifiedEmail())
                            <div class="mt-2 text-sm text-danger">
                                {{ __('Tu dirección de correo electrónico no está verificada.') }}
                                <button form="send-verification" class="btn btn-link p-0">
                                    {{ __('Haz clic aquí para reenviar el correo de verificación.') }}
                                </button>
                            </div>
                            @if (session('status') === 'verification-link-sent')
                                <div class="mt-2 text-success">
                                    {{ __('Un nuevo enlace de verificación ha sido enviado a tu dirección de correo electrónico.') }}
                                </div>
                            @endif
                        @endif
                    </div>

                    <!-- Campo de estado -->
                    <div class="mb-3">
                        <label for="editarEstado" class="form-label">Estado</label>
                        <select class="form-select" id="editarEstado" name="state" required>
                            <option value="" disabled>Seleccionar Estado</option>
                            <option value="1" {{ old('state', $usuario->state) == 1 ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ old('state', $usuario->state) == 0 ? 'selected' : '' }}>Bloquear</option>
                        </select>
                        @error('state')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Campo de rol -->
                    <div class="mb-3">
                        <label for="editarRol" class="form-label">Rol</label>
                        <select class="form-select" id="editarRol" name="idrol" required>
                            <option value="" disabled>Seleccionar Rol</option>
                            @foreach ($roles as $rol)
                                <option value="{{ $rol->idrol }}" {{ old('idrol', $usuario->rol->idrol) == $rol->idrol ? 'selected' : '' }}>
                                    {{ $rol->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('idrol')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Botones de acción -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    <script>
        // Llenar el formulario de editar usuario
        document.querySelectorAll('.edit').forEach(button => {
            button.addEventListener('click', function() {
                let idusuario = this.getAttribute('data-id');
                let name = this.getAttribute('data-name');
                let email = this.getAttribute('data-email');
                let idrol = this.getAttribute('data-idrol');
                let state = this.getAttribute('data-state'); // Cambiar 'data-estado' por 'data-state'

                // Asignar los valores a los campos del modal de edición
                document.getElementById('editarUsuarioId').value = idusuario;
                document.getElementById('editarNombre_usuario').value = name;
                document.getElementById('editarEmail').value = email;


                // Asignar valor al select del rol
                const selectRol = document.getElementById('editarRol');
                Array.from(selectRol.options).forEach(option => {
                    if (option.value == idrol) {
                        option.selected =
                            true; // Selecciona el rol que coincide con el idrol del usuario
                    }
                });

                // Asignar valor al select del estado
                const selectEstado = document.getElementById('editarEstado');
                selectEstado.value = state === '1' ? '1' : '0';
            });
        });
    </script>

@endsection
