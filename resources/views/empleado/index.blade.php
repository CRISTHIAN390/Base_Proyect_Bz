@extends('layouts.plantilla')
@section('titulo', 'Empleado')

@section('contenido')

    <div class="container">
        <div class="page-header d-flex justify-content-between align-items-center">
            <div class="page-title">
                <h4>Lista de Trabajadores</h4>
            </div>
            <div class="d-flex align-items-center">
                <a href="{{ route('empleado.create') }}" class="btn btn-added">
                    <img src="/assets/img/icons/plus.svg" alt="img" class="me-2">Nuevo
                </a>
            </div>
        </div>
        <nav class="navbar navbar-light float-right">
            <div class="d-flex align-items-left">
                <form class="form-inline my-2" method="GET" id="search-form">
                    <input id="buscarpor" name="buscarpor" class="form-control me-2" type="search"
                        placeholder="Buscar por apellido" value="{{ $buscarpor }}">
                </form>
            </div>
            <div class="d-flex align-items-center">
                <a href="#" class="btn btn-added">
                    <img src="/assets/img/icons/pdf.svg" alt="Generar PDF" class="me-2">
                    Generar PDF
                </a>
            </div>
        </nav>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive" id="empleadoTable">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">N°</th>
                                <th scope="col">Apellidos</th>
                                <th scope="col">Nombres</th>
                                <th scope="col">Celular</th>
                                <th scope="col">Dni</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($empleado) <= 0)
                                <tr>
                                    <td colspan="7"><i>:: NO HAY REGISTROS ::</i></td>
                                </tr>
                            @else
                                @foreach ($empleado as $itemcliente)
                                    <tr>
                                        <td>{{ $itemcliente->idempleado }}</td>
                                        <td>{{ $itemcliente->apellidos }}</td>
                                        <td>{{ $itemcliente->nombres }}</td>
                                        <td>{{ $itemcliente->celular }}</td>
                                        <td>{{ $itemcliente->dni }}</td>
                                        <td>
                                            @if ($itemcliente->estado == 1)
                                                <span class="badges bg-lightgreen">Activo</span>
                                            @else
                                                <span class="badges bg-lightred">Inactivo</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a class="me-3" href="#">
                                                <img src="/assets/img/icons/edit.svg" alt="img">
                                            </a>
                                            <a class="me-3 confirm-text" href="">
                                                <img src="/assets/img/icons/delete.svg" alt="img">
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    <br>
                    {{ $empleado->links() }}
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('buscarpor').addEventListener('keyup', function() {
            let query = this.value;

            fetch(`{{ route('empleado.index') }}?buscarpor=${query}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    let parser = new DOMParser();
                    let doc = parser.parseFromString(html, 'text/html');
                    let newTable = doc.getElementById('empleadoTable').innerHTML;
                    document.getElementById('empleadoTable').innerHTML = newTable;
                });
        });
    </script>

@endsection
