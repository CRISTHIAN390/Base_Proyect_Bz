@extends('layouts.plantilla')
@section('titulo', 'Dashboard')

@section('contenido')

    <div class="content">
        <div class="row">
            <div class="col-lg-3 col-sm-6 col-12 d-flex">
                <div class="dash-count">
                    <div class="dash-counts">
                        <h4>{{ $totalIngreso }}</h4>
                        <h5>Pagos</h5>
                    </div>
                    <div class="dash-imgs">
                        <span class="text-lg font-semibold text-blue-500" style="font-size: 40px">S/.</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12 d-flex">
                <div class="dash-count das2">
                    <div class="dash-counts">
                        <h4>{{ $totalGasto }}</h4>
                        <h5>Gastos</h5>
                    </div>
                    <div class="dash-imgs">
                        <span class="text-lg font-semibold text-blue-500" style="font-size: 40px">S/.</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12 d-flex">
                <div class="dash-count das1">
                    <div class="dash-counts">
                        <h4>{{ $totalEmpleados }}</h4>
                        <h5>Trabajadores</h5>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="users"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6 col-12 d-flex">
                <div class="dash-count das3">
                    <div class="dash-counts">
                        <h4>{{ $totalRegistro }}</h4>
                        <h5>Registros</h5>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="file-text"></i>
                    </div>
                </div>
            </div>

        </div>
        <script src="/assets/js/graficobarras.js"></script>
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/export-data.js"></script>
        <script src="https://code.highcharts.com/modules/accessibility.js"></script>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Gastos en Viaticos</div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-end align-items-center">
                            <select id="yearSelector" name="year" class="form-control form-control-lg"
                                style="width: auto; min-width: 150px;">
                                <option selected disabled>Selecciona un año</option>
                                @foreach ($listadeAnios as $anio)
                                    <option value="{{ $anio->year }}">{{ $anio->year }}</option>
                                @endforeach
                            </select>
                        </div>
                        <figure class="highcharts-figure">
                            <div id="contenedorgrafico"></div>
                        </figure>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Pagos</div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-end align-items-center">
                            <select id="yearSelector2" name="year" class="form-control form-control-lg"
                                style="width: auto; min-width: 150px;">
                                <option selected disabled>Selecciona un año</option>
                                @foreach ($listadeAnios as $anio2)
                                    <option value="{{ $anio2->year }}">{{ $anio2->year }}</option>
                                @endforeach
                            </select>
                        </div>
                        <figure class="highcharts-figure">
                            <div id="contenedorgrafico2"></div>
                        </figure>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Comparacion</div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-end align-items-center">
                            <select id="yearSelector3" name="year" class="form-control form-control-lg"
                                style="width: auto; min-width: 150px;">
                                <option selected disabled>Selecciona un año</option>
                                @foreach ($listadeAnios as $anio3)
                                    <option value="{{ $anio3->year }}">{{ $anio3->year }}</option>
                                @endforeach
                            </select>
                        </div>
                        <figure class="highcharts-figure">
                            <div id="container"></div>
                        </figure>
                    </div>
                </div>
            </div>
        </div>

        <script>
            var gastosXmes = @json($gastosXmes);
            var ingresosXmes = @json($ingresosXmes);
        </script>
     <!-- Antes de cerrar el <body>, agregar el script de SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    </div>
    @if (!empty($mensajeNotificaciones))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    title: 'Notificaciones',
                    text: `{{ $mensajeNotificaciones }}`,
                    icon: 'info',
                    confirmButtonText: 'Cerrar',
                    customClass: {
                        popup: 'swal-wide'
                    }
                });
            });
        </script>
    @endif
@endsection
