@extends('layouts.plantilla')
@section('titulo', 'dasss')

@section('contenido')
    <div class="content">
        <div class="row">
            <div class="col-lg-3 col-sm-6 col-12 d-flex">
                <div class="dash-count">
                    <div class="dash-counts">
                        <h5>Ingresos</h5>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="dollar-sign"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12 d-flex">
                <div class="dash-count">
                    <div class="dash-counts">
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
                        <h5>Trabajadores</h5>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="shopping-bag"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12 d-flex">
                <div class="dash-count das1">
                    <div class="dash-counts">
                        <h5>Registros</h5>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="shopping-bag"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12 d-flex">
            <a href="{{ route('Consultabot') }}" class="btn btn-secondary">Tefi AI</a>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Fletes</div>
                    </div>
                    <div class="card-body">
                        <div>
                            <canvas id="chartBarFletes" class="h-300"></canvas>
                        </div>
                    </div>
                </div>
            </div>

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
    </div>
@endsection
