@extends('layouts.plantilla')
@section('titulo', 'Registro')
@section('contenido')
<div class="container mt-4">
    <div class="content">
        <div class="page-header mb-4">
            <div class="page-title">
                <h4>Perfil</h4>
                <h6>Perfil de Empleado</h6>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('empleado.store') }}">
                    @csrf
                    <div class="row g-3">
                        <!-- Apellidos -->
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label for="apellidos">Apellidos</label>
                                <input type="text" id="apellidos" name="apellidos" class="form-control" placeholder="Apellidos" required oninput="restrictToLetters(event)" pattern="[A-Za-z\s]+" title="Solo se permiten letras">
                                <small class="form-text text-muted">Solo se permiten letras</small>
                            </div>
                        </div>

                        <!-- Nombres -->
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label for="nombres">Nombres</label>
                                <input type="text" id="nombres" name="nombres" class="form-control" placeholder="Nombres" required oninput="restrictToLetters(event)" pattern="[A-Za-z\s]+" title="Solo se permiten letras">
                                <small class="form-text text-muted">Solo se permiten letras</small>
                            </div>
                        </div>

                        <!-- DNI -->
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label for="dni">DNI</label>
                                <input type="text" id="dni" name="dni" class="form-control" placeholder="DNI" required oninput="restrictToNumbers(event)" pattern="\d{8}" maxlength="8" title="Debe contener 8 dígitos numéricos">
                                <small class="form-text text-muted">Debe contener 8 dígitos numéricos.</small>
                            </div>
                        </div>

                        <!-- Celular -->
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label for="celular">Celular</label>
                                <input type="text" id="celular" name="celular" class="form-control" placeholder="Celular" required oninput="restrictToNumbers(event)" pattern="\d{9}" maxlength="9" title="Debe contener 9 dígitos numéricos">
                                <small class="form-text text-muted">Debe contener 9 dígitos numéricos.</small>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="col-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary me-2">Guardar</button>
                            <a href="{{ route('cancelarempleado') }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    function validateInput(event, pattern) {
        const input = event.target;
        const regex = new RegExp(pattern);
        if (!regex.test(input.value)) {
            input.value = input.value.slice(0, -1); // Remover último carácter si es inválido
        }
    }

    function restrictToNumbers(event) {
        validateInput(event, '^[0-9]*$');
    }

    function restrictToLetters(event) {
        validateInput(event, '^[A-Za-z\\s]*$');
    }
</script>
