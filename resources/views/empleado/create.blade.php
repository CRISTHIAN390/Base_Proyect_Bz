@extends('layouts.plantilla')
@section('titulo', 'Registro')
@section('contenido')
    <div class="container">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Perfil</h4>
                    <h6>Perfil de Empleado</h6>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="profile-set">
                        <div class="profile-head">
                        </div>

                    </div>
                    <form method="POST" action="{{route('empleado.store')}}">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label for="apellidos">Apellidos</label>
                                    <input type="text" id="apellidos" name="apellidos" placeholder="apellidos" required oninput="restrictToLetters(event)">
                                    <small class="form-text text-muted">Solo se permiten letras</small>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label for="nombres">Nombres</label>
                                    <input type="text" id="nombres" name="nombres" placeholder="nombres" required oninput="restrictToLetters(event)">
                                    <small class="form-text text-muted">Solo se permiten letras </small>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label for="dni">DNI</label>
                                    <input type="text" id="dni" name="dni" placeholder="dni" required oninput="restrictToNumbers(event)" maxlength="8">
                                    <small class="form-text text-muted">Debe contener 8 dígitos numéricos.</small>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label for="celular">Celular</label>
                                    <input type="text" id="celular" name="celular" placeholder="celular" required oninput="restrictToNumbers(event)" maxlength="9">
                                    <small class="form-text text-muted">Debe contener 9 dígitos numéricos.</small>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-submit me-2">Guardar</button>
                                <a href="{{route('cancelarempleado')}}" class="btn btn-cancel">  Cancelar </a>
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
            input.value = input.value.slice(0, -1); // Remove last character if invalid
        }
    }

    function restrictToNumbers(event) {
        validateInput(event, '^[0-9]*$');
    }

    function restrictToLetters(event) {
        validateInput(event, '^[A-Za-z\\s]*$');
    }
</script>
