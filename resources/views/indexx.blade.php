extends('layouts.plantilla')
@extends('layouts.plantilla')
@section('titulo', 'dasss')

@section('contenido')
    <div class="content">
        <div class="row">
            <div class="col-lg-3 col-sm-6 col-12 d-flex">
                <div class="dash-count">
                    <div class="dash-counts">
                        <h4>{{ array_sum($ingresosMesArray) }}</h4> <!-- Total de ingresos -->
                        <h5>Ingresos</h5>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="dollar-sign"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6 col-12 d-flex">
                <div class="dash-count das1">
                    <div class="dash-counts">
                        <h4>{{ array_sum($gastosMesArray) }}</h4> <!-- Total de gastos -->
                        <h5>Gastos</h5>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="shopping-bag"></i>
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
    </div>

    <script>
        $(function() {
            'use strict';
            var ctx1 = document.getElementById('chartBarIngresos').getContext('2d');
            new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                    datasets: [{
                        label: 'Ingresos',
                        // Data dinámica de ingresos por mes
                        data: {!! json_encode(array_values($ingresosMesArray)) !!}, // Aquí se utiliza la data pasada desde el controlador
                        backgroundColor: '#664dc9'
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend: { display: false },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                fontSize: 10,
                                max: Math.max(...{!! json_encode(array_values($ingresosMesArray)) !!}) + 10 // Ajusta la escala
                            }
                        }],
                        xAxes: [{
                            barPercentage: 0.6,
                            ticks: {
                                beginAtZero: true,
                                fontSize: 11
                            }
                        }]
                    }
                }
            });

            var ctx2 = document.getElementById('chartBarGastos').getContext('2d');
            new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                    datasets: [{
                        label: 'Gastos',
                        // Data dinámica de gastos por mes
                        data: {!! json_encode(array_values($gastosMesArray)) !!}, // Aquí se utiliza la data pasada desde el controlador
                        backgroundColor: '#44c4fa'
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend: { display: false },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                fontSize: 10,
                                max: Math.max(...{!! json_encode(array_values($gastosMesArray)) !!}) + 10 // Ajusta la escala
                            }
                        }],
                        xAxes: [{
                            barPercentage: 0.6,
                            ticks: {
                                beginAtZero: true,
                                fontSize: 11
                            }
                        }]
                    }
                }
            });
        });
    </script>

@endsection
