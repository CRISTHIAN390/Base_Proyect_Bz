@extends('layouts.plantilla')

@section('titulo', 'Confirmar Eliminación')

@section('contenido')
<div class="container mt-5">
    <div class="card shadow-lg rounded">
        <div class="card-header text-center bg-danger bg-gradient text-white rounded-top">
            <h1 class="fw-bold">¿ELIMINAR VEHÍCULO?</h1>
        </div>
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center mb-4">
                        <h5 class="fw-light">Revisa los datos antes de confirmar</h5>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="placa" class="form-label">Placa</label>
                                <input type="text" class="form-control-plaintext" id="placa" name="placa" 
                                    value="{{ $vehiculo->placa }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="marca" class="form-label">Marca</label>
                                <input type="text" class="form-control-plaintext" id="marca" name="marca" 
                                    value="{{ $vehiculo->marca }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <input type="text" class="form-control-plaintext" id="descripcion" name="descripcion" 
                                    value="{{ $vehiculo->descripcion }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fecha_registro" class="form-label">Fecha de Registro</label>
                                <input type="text" class="form-control-plaintext" id="fecha_registro" name="fecha_registro" 
                                    value="{{ $vehiculo->fecha_registro }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <form method="POST" action="{{ route('vehiculo.destroy', $vehiculo->idvehiculo) }}">
                            @method('delete')
                            @csrf
                            <button type="submit" class="btn btn-danger me-2">Eliminar</button>
                            <a href="{{ route('cancelarvehiculo') }}" class="btn btn-outline-secondary">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
