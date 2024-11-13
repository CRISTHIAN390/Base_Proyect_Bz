@extends('layouts.plantilla')
@section('titulo', 'Detallecar')

@section('contenido')
    <div class="container">
        <div class="page-header d-flex justify-content-between align-items-center mb-4">
            <div class="page-title">
                <h3 class="  fw-bold">Detalles Vehiculares</h3>
            </div>

            <div class="d-flex align-items-center">
                <a class="btn btn-added" href="{{ route('detallecar.create') }}">
                    <img src="/assets/img/icons/plus.svg" alt="Nuevo" class="me-2">Nuevo
                </a>
            </div>
        </div>
        <nav class="navbar navbar-light bg-light p-4 rounded shadow-sm mb-4">
            <div class="container-fluid d-flex flex-column align-items-center">
                <form class="form w-100" method="GET" id="search-form" style="max-width: 600px;">
                    <!-- Fila de selección de Vehículo y Transportista centrados -->
                    <div class="row mb-3 text-center">
                        <!-- Selección de Vehículo -->
                        <div class="col-md-6">
                            <label for="idvehiculo" class="form-label fw-bold">Vehículo:</label>
                            <select class="form-select" name="idvehiculo" id="idvehiculo" aria-label="Seleccionar vehículo">
                                <option value="" selected disabled>Seleccionar</option>
                                @foreach ($vehiculos as $vehiculo)
                                    <option value="{{ $vehiculo->idvehiculo }}">{{ $vehiculo->marca }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Selección de Transportista -->
                        <div class="col-md-6">
                            <label for="idempleado" class="form-label fw-bold">Transportista:</label>
                            <select class="form-select" name="idempleado" id="idempleado"
                                aria-label="Seleccionar transportista">
                                <option value="" selected disabled>Seleccionar</option>
                                @foreach ($empleados as $empleado)
                                    <option value="{{ $empleado->idempleado }}">{{ $empleado->nombres }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Botones de Filtrado y Limpieza centrados -->
                    <div class="d-flex justify-content-center gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">Filtrar</button>
                        <a href="{{ route('detallecar.index') }}" class="btn btn-secondary">Limpiar</a>
                    </div>
                </form>
            </div>
        </nav>
        <br>
        <!-- Mensaje de confirmación -->
        @if (session('datos'))
            <div id="successMessage" class="alert alert-success mt-3">
                {{ session('datos') }}
            </div>
        @endif
        <div class="row">
            <div class="col-12">
                <!-- Tarjeta de tabla -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive" id="detallecarTable">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr style="text-align: center">
                                        <th scope="col">N°</th>
                                        <th scope="col">Vehiculo</th>
                                        <th scope="col">Conductor</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Observacion</th>
                                        <th scope="col">Monto</th>
                                        <th scope="col">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($detalles->isEmpty())
                                        <tr>
                                            <td colspan="7" class="text-center"><i>:: NO HAY REGISTROS ::</i></td>
                                        </tr>
                                    @else
                                        @php $contador = ($detalles->currentPage() - 1) * $detalles->perPage() + 1; @endphp
                                        @foreach ($detalles as $itemgeneral)
                                        <tr>
                                            <td>{{ $contador++ }}</td>
                                            <td>{{ $itemgeneral->Empleado->nombres }}</td>
                                            <td>{{ $itemgeneral->Vehiculo->marca }}</td>
                                            <td>{{ $itemgeneral->fecha }}</td>
                                            <td>{{ $itemgeneral->observacion }}</td>
                                            <td>{{ $itemgeneral->monto }}</td>
                                            <td>
                                                
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endif
                                </tbody>



                            </table><br>
                            <div
                                style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                                {{ $detalles->appends(request()->except('general_page'))->links() }}
                            </div><br>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        s

    </div>
    <!-- Ocultar el mensaje -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const successMessage = document.getElementById('successMessage');
            if (successMessage) {
                setTimeout(() => {
                    successMessage.style.display = 'none';
                }, 3800); // Ocultar después de 4 segundo
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#idvehiculo, #idempleado').select2({
                allowClear: true,
                width: '100%'
            });
        });
    </script>





@endsection
