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
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Grafico de Barras Gasto x mes</div>
                    </div>
                    <div class="card-body">
                        <div>
                            <script src="https://code.highcharts.com/highcharts.js"></script>
                            <script src="https://code.highcharts.com/modules/exporting.js"></script>
                            <script src="https://code.highcharts.com/modules/export-data.js"></script>
                            <script src="https://code.highcharts.com/modules/accessibility.js"></script>

                            <figure class="highcharts-figure">
                                <div id="contenedorgrafico"></div>
                                <p class="highcharts-description">
                                    A basic column chart comparing estimated corn and wheat production
                                    in some countries.
                                </p>
                            </figure>

                        </div>
                    </div>
                </div>
            </div>
            <style>
                .highcharts-figure,
                .highcharts-data-table table {
                    min-width: 310px;
                    max-width: 800px;
                    margin: 1em auto;
                }

                #contenedorgrafico {
                    height: 400px;
                }

                .highcharts-data-table table {
                    font-family: Verdana, sans-serif;
                    border-collapse: collapse;
                    border: 1px solid #ebebeb;
                    margin: 10px auto;
                    text-align: center;
                    width: 100%;
                    max-width: 500px;
                }

                .highcharts-data-table caption {
                    padding: 1em 0;
                    font-size: 1.2em;
                    color: #555;
                }

                .highcharts-data-table th {
                    font-weight: 600;
                    padding: 0.5em;
                }

                .highcharts-data-table td,
                .highcharts-data-table th,
                .highcharts-data-table caption {
                    padding: 0.5em;
                }

                .highcharts-data-table thead tr,
                .highcharts-data-table tr:nth-child(even) {
                    background: #f8f8f8;
                }

                .highcharts-data-table tr:hover {
                    background: #f1f7ff;
                }
            </style>

            <script>
                Highcharts.chart('contenedorgrafico', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Gastos por Mes',
                        align: 'left'
                    },
                    xAxis: {
                        categories: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'September', 'October', 'November', 'December'],
                        crosshair: true,
                        accessibility: {
                            description: 'Countries'
                        }
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Cantidad de soles'
                        }
                    },
                    tooltip: {
                        valueSuffix: ' (1000 MT)'
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0
                        }
                    },
                    series: [{
                            name: 'Gastos',
                            data: [387749, 280000, 129000, 64300, 54000, 34300]
                        }
                    ]
                });
            </script>
            <!--
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header">
                                                    <div class="card-title">Viáticos</div>
                                                </div>
                                                <div class="card-body">
                                                    <div>
                                                        <canvas id="chartBarViaticos" class="h-300"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header">
                                                    <div class="card-title">Ingresos</div>
                                                </div>
                                                <div class="card-body">
                                                    <div>
                                                        <canvas id="chartBarIngresos" class="h-300"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header">
                                                    <div class="card-title">Gastos</div>
                                                </div>
                                                <div class="card-body">
                                                    <div>
                                                        <canvas id="chartBarGastos" class="h-300"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                        -->
        </div>
    @endsection
