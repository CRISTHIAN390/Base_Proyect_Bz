@extends('layouts.plantilla')

@section('contenido')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4>Editar Detalle</h4>
            </div>
            <script>
                $(document).ready(function() {
                    $('#idflete').select2({
                        allowClear: true,
                        width: '100%' // Ajusta el ancho según tu diseño
                    });
                    $('#idviatico').select2({
                        allowClear: true,
                        width: '100%' // Ajusta el ancho según tu diseño
                    });
                    $('#idempleado').select2({
                        allowClear: true,
                        width: '100%' // Ajusta el ancho según tu diseño
                    });
                });
            </script>
            <div class="card-body">
                <form method="POST" action="{{ route('detalleFV.update', $detalle->iddetallefv) }}">
                    @method('PUT')
                    @csrf

                    <!-- Trabajador -->
                    <div class="mb-3">
                        <label for="idempleado" class="form-label">Colaboradores:</label>
                        <select  class='form-control' id="idempleado" name="idempleado" required>
                            <option value="" selected disabled>Seleccionar un colaborador</option>
                            @foreach ($empleados as $itempleado)
                                <option value="{{ $itempleado->idempleado }}"
                                    {{ $itempleado->idempleado == $detalle->idempleado ? 'selected' : '' }}>
                                    {{ $itempleado->nombres }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Flete -->
                    <div class="mb-3">
                        <label for="idflete" class="form-label">Flete:</label>
                        <select class='form-control' id="idflete" name="idflete" required>
                            <option value="" selected disabled>Seleccionar un Flete</option>
                            @foreach ($fletes as $flete)
                                <option value="{{ $flete->idflete }}"
                                    {{ $flete->idflete == $detalle->idflete ? 'selected' : '' }}>
                                    {{ $flete->nombre_flete }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Viático -->
                    <div class="mb-3">
                        <label for="idviatico" class="form-label">Viático:</label>
                        <select class='form-control' id="idviatico" name="idviatico" required>
                            <option value="" selected disabled>Seleccionar un Viático</option>
                            @foreach ($viaticos as $viatico)
                                <option value="{{ $viatico->idviatico }}"
                                    {{ $viatico->idviatico == $detalle->idviatico ? 'selected' : '' }}>
                                    {{ $viatico->nombre_viatico }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Fecha y Tipo (G/I) -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="fecha" class="form-label">Fecha</label>
                            <input type="date" class="form-control" id="fecha" name="fecha"
                                value="{{ $detalle->fecha }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="tipoIG" class="form-label">Tipo (G/I)</label>
                            <select class="form-select" id="tipoIG" name="tipoIG" required>
                                <option value="1" {{ $detalle->tipoIG == 1 ? 'selected' : '' }}>Gasto</option>
                                <option value="2" {{ $detalle->tipoIG == 2 ? 'selected' : '' }}>Ingreso</option>
                            </select>
                        </div>
                    </div>

                    <!-- Importe y Descripción -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="importe" class="form-label">Importe (S/.)</label>
                            <input type="number" class="form-control" id="importe" name="importe"
                                value="{{ $detalle->importe }}" step="0.01" required> 
                        </div>
                        <div class="col-md-6">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" required>{{ $detalle->descripcion }}</textarea>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        <button type="submit" class="btn btn-primary me-3">
                            Actualizar
                        </button>
                        <a href="{{ route('cancelardetalle') }}" class="btn btn-danger ms-3">
                            <i class="fas fa-ban"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
