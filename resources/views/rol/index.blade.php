@extends('layouts.plantilla')
@section('titulo', 'Rols')

@section('contenido')
<div class="container">
    <div class="page-header d-flex justify-content-between align-items-center">
        <div class="page-title">
            <h4>Lista de Roles</h4>
        </div>
        <div class="d-flex align-items-center">
            <!-- Botón Nuevo -->
            <button type="button" class="btn btn-added me-2" data-bs-toggle="modal" data-bs-target="#nuevoRolModal">
                <img src="/assets/img/icons/plus.svg" alt="img" class="me-2">Nuevo
            </button>
            
            <!-- Botón Regresar a Usuarios -->
            <button type="button" class="btn text-white me-2" style="background-color: #ffc107;" onclick="window.location.href='{{ route('listauser') }}'">
                <i class="bi bi-person-plus"></i> Regresar a usuarios
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

    @if (session('datos'))
    <div id="successMessage" class="alert alert-success mt-3">
        {{ session('datos') }}
    </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive" id="RolTable">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">N°</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($rol) <= 0)
                        <tr>
                            <td colspan="3"><i>:: NO HAY REGISTROS ::</i></td>
                        </tr>
                        @else
                        @foreach ($rol as $index => $itemRol)
                        <tr>
                            <td>{{ $rol->firstItem() + $index }}</td>
                            <td>{{ $itemRol->name }}</td>
                            <td>
                                <a class="me-3 edit" data-id="{{ $itemRol->id }}" data-nombre="{{ $itemRol->name }}"
                                    data-bs-toggle="modal" data-bs-target="#editarRolModal">
                                    <img src="/assets/img/icons/edit.svg" alt="img">
                                </a>
                                <a class="me-3 delete" data-id="{{ $itemRol->id }}" data-nombre="{{ $itemRol->name }}"
                                    data-bs-toggle="modal" data-bs-target="#eliminarRolModal">
                                    <img src="/assets/img/icons/delete.svg" alt="img">
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
                <br>
                {{ $rol->links() }}
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
            }, 4000); // Ocultar después de 4 segundos
        }
    });
</script>

<!-- Modal Guardar -->
<div class="modal fade" id="nuevoRolModal" tabindex="-1" aria-labelledby="nuevoRolModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nuevoRolModalLabel">Nuevo rol</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="nuevoRolForm" method="POST" action="{{ route('rol.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary" id="guardarRolBtn">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar -->
<div class="modal fade" id="editarRolModal" tabindex="-1" aria-labelledby="editarRolModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarRolModalLabel">Editar rol</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editarRolForm" method="POST" action="">
                    @method('PUT')
                    @csrf
                    <input type="hidden" id="editarRolId" name="id">
                    <div class="mb-3">
                        <label for="editarNombre_Rol" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="editarNombre_Rol" name="name" required>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary" id="editarRolBtn">Actualizar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Eliminar -->
<div class="modal fade" id="eliminarRolModal" tabindex="-1" aria-labelledby="eliminarRolModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eliminarRolModalLabel">Eliminar rol</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de que desea eliminar el rol: <span id="eliminarNombre_Rol"></span>?</p>
                <form id="eliminarRolForm" method="POST" action="">
                    @method('DELETE')
                    @csrf
                    <input type="hidden" id="eliminarRolId" name="id">
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-danger" id="eliminarRolBtn">Eliminar</button>
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
        fetch(`{{ route('rol.index') }}?buscarpor=${query}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                let parser = new DOMParser();
                let doc = parser.parseFromString(html, 'text/html');
                let newTable = doc.getElementById('RolTable').innerHTML;
                document.getElementById('RolTable').innerHTML = newTable;
            });
    });

    document.querySelectorAll('.edit').forEach(button => {
        button.addEventListener('click', function() {
            let id = this.getAttribute('data-id');
            let nombre = this.getAttribute('data-nombre');
            document.getElementById('editarRolId').value = id;
            document.getElementById('editarNombre_Rol').value = nombre;
            document.getElementById('editarRolForm').action = `/rol/${id}`;
        });
    });

    document.querySelectorAll('.delete').forEach(button => {
        button.addEventListener('click', function() {
            let id = this.getAttribute('data-id');
            let nombre = this.getAttribute('data-nombre');
            document.getElementById('eliminarRolId').value = id;
            document.getElementById('eliminarNombre_Rol').textContent = nombre;
            document.getElementById('eliminarRolForm').action = `/rol/${id}`;
        });
    });
</script>
@endsection
