@extends('layouts.plantilla')
@section('titulo', 'dasss')

@section('contenido')
    <div class="content">
        <div class="row">
            <div class="col-lg-3 col-sm-6 col-12 d-flex">
                <div class="dash-count">
                    <div class="dash-counts">
                        <h4>{{ $totalIngreso }}</h4>
                        <h5>Ingresos</h5>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="dollar-sign"></i>
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
                        <i data-feather="dollar-sign"></i>
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
                        <i data-feather="shopping-bag"></i>
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
                        <i data-feather="file"></i>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-3 col-sm-6 col-12 d-flex">
                <a href="{{ route('Consultabot') }}" class="btn btn-secondary">Tefi AI</a>
            </div>
        </div><br>
        <script src="/assets/js/graficobarras.js"></script>
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/export-data.js"></script>
        <script src="https://code.highcharts.com/modules/accessibility.js"></script>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Gastos</div>
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
                        <div class="card-title">Ingresos</div>
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

        <script>
            var gastosXmes = @json($gastosXmes);
            var ingresosXmes = @json($ingresosXmes);
        </script>



    @endsection
