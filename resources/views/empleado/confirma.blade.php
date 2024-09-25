@extends('layouts.plantilla')

@section('titulo', 'Confirmar')

@section('contenido')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header text-center bg-danger text-white">
            <h1>¿ELIMINAR PERFIL DEL EMPLEADO?</h1>
        </div>
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center mb-4">
                        <h4>Perfil de Empleado</h4>
                        <h6>Revisa los datos antes de confirmar</h6>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="apellidos">Apellidos</label>
                                <input type="text" class="form-control" id="apellidos" name="apellidos" 
                                    value="{{ $empleado->apellidos }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombres">Nombres</label>
                                <input type="text" class="form-control" id="nombres" name="nombres" 
                                    value="{{ $empleado->nombres }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dni">DNI</label>
                                <input type="text" class="form-control" id="dni" name="dni" 
                                    value="{{ $empleado->dni }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="celular">Celular</label>
                                <input type="text" class="form-control" id="celular" name="celular" 
                                    value="{{ $empleado->celular }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <form method="POST" action="{{ route('empleado.destroy', $empleado->idempleado) }}">
                            @method('delete')
                            @csrf
                            <button type="submit" class="btn btn-danger me-2">Eliminar</button>
                            <a href="{{ route('cancelarempleado') }}" class="btn btn-secondary">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection