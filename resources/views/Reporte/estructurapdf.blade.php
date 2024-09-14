<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte PDF</title>
    <style>
        @page {
            margin: 100px 50px;
        }
        body {
            margin: 0;
            padding: 0;
        }
        header {
            position: fixed;
            top: -80px;
            left: 0;
            right: 0;
            height: 50px;
            text-align: center;
            line-height: 35px;
        }
        footer {
            position: fixed;
            bottom: -50px;
            left: 0;
            right: 0;
            height: 50px;
            text-align: center;
            font-size: 12px;
        }
        footer .pagenum:before {
            content: "Página " counter(page);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #0fb6ed; /* Color celeste */
        }
        .date-right {
            text-align: right;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <header>
        <h1 style="text-align: center">REPORTE</h1>
        <p class="date-right"><strong>Fecha:</strong> {{ now()->format('d/m/Y') }}</p>
    </header>

    <!-- Footer Section -->
    <footer>
        <div class="pagenum"></div>
    </footer>

    <!-- Body Content -->
    <p><strong>Desde:</strong> {{ $fechaInicio }} <strong>Hasta:</strong> {{ $fechaFin }}</p>
    <p><strong>Gastos Totales:</strong>S/. {{ $GastoTotalFiltrado }}</p>
    <p><strong>Ingresos Totales:</strong> S/.{{ $IngresoTotalFiltrado }}</p>
    <p><strong>Monto Restante:</strong>    S/.
        @if ($MontoRestante < 0)
            <span style="color: red; font-weight: bold;">{{ $MontoRestante }}</span>
        @else
            {{ $MontoRestante }}
        @endif</p>

    <table>
        <thead>
            <tr>
                <th>N°</th>
                <th>Flete</th>
                <th>Viatico</th>
                <th>Trabajador</th>
                <th>Fecha</th>
                <th>Descripcion</th>
                <th>Importe (S/.)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($detallegeneral as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->Flete->nombre_flete }}</td>
                    <td>{{ $item->Viatico->nombre_viatico }}</td>
                    <td>{{ $item->Empleado->nombres }}</td>
                    <td>{{ $item->fecha }}</td>
                    <td>{{ $item->descripcion }}</td>
                    <td>{{ $item->importe }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>