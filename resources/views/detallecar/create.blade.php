@extends('layouts.plantilla')
@section('titulo', 'Detallecarcreate')

@section('contenido')
    <div class="container mt-4">
        <form id="nuevoDetallecarForm" method="POST" action="{{ route('detallecar.store') }}">
            @csrf
            <style>
                .text-center {
                    text-transform: uppercase;
                    letter-spacing: 1px;
                }

                .mb-3 {
                    margin-bottom: 1.5rem;
                }

                .mb-4 {
                    margin-bottom: 2rem;
                }
            </style>
            <div class="card"
                style=" border-radius: 15px;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);background-color: #f9f9f9;  padding: 20px;">

                <div class="card-header text-center"
                    style="background-color: #ffc400b2; color: #ffffff; border-radius: 15px 15px 0 0; padding: 20px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                    <h5 class="mb-0"
                        style="font-size: 1.5rem; font-weight: bold; letter-spacing: 1px; text-transform: uppercase;">
                        Registro de detalle vehicular
                    </h5>
                </div>

                <div class="card-body">
                    <!-- Conductor -->
                    <div class="mb-3">
                        <label for="idempleado" class="form-label"
                            style=" font-weight: bold; color: #333;">Conductor</label>
                        <select class="form-select" id="idempleado" name="idempleado"
                            style=" border-radius: 8px;border: 1px solid #ccc; transition: border-color 0.3s ease;"
                            required>
                            <option value="" selected disabled>Seleccione un Conductor</option>
                            @foreach ($empleados as $empleado)
                                <option value="{{ $empleado->idempleado }}">{{ $empleado->nombres }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Vehiculo -->
                    <div class="mb-3">
                        <label for="idvehiculo" class="form-label" style=" font-weight: bold; color: #333;">Vehiculo</label>
                        <select class="form-select" id="idvehiculo" name="idvehiculo"
                            style=" border-radius: 8px;border: 1px solid #ccc; transition: border-color 0.3s ease;"
                            required>
                            <option value="" selected disabled>Seleccione un vehiculo</option>
                            @foreach ($vehiculos as $vehiculo)
                                <option value="{{ $vehiculo->idvehiculo }}">{{ $vehiculo->marca }} {{ $vehiculo->placa }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <!-- Tabla de Detalles -->
            <div class="card shadow-sm" style="border-radius: 15px; background-color: #343a40; color: #f8f9fa;">
                <div class="card-body">
                    <h5 class="card-title text-center" style="color: #f8f9fa;">Lista de Detalles</h5>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-dark">
                            <thead>
                                <tr>
                                    <th scope="col" style="background: #f8f9fa">N°</th>
                                    <th scope="col" style="background: #f8f9fa">Observacion</th>
                                    <th scope="col" style="background: #f8f9fa">Fecha</th>
                                    <th scope="col" style="background: #f8f9fa">Monto</th>
                                    <th scope="col" style="background: #f8f9fa">Acción</th>
                                </tr>
                            </thead>
                            <tbody id="detalleTableBody">
                                <!-- Aquí se añadirán dinámicamente las filas -->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end"><strong style="color: #f8f9fa;">Total</strong></td>
                                    <td id="montoTotal" style="color: #f8f9fa;">0.00</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Monto, Observacion y Fecha -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label for="observacionInput" class="form-label" style="color: #adb5bd;">Observacion</label>
                            <input type="text" class="form-control" id="observacionInput" style="border-radius: 10px;">
                            <label for="checkboxMantenimiento">Mantenimiento</label>
                            <input type="checkbox" id="checkboxMantenimiento" name="checkboxMantenimiento" onchange="toggleObservacionInput()">
                        
                        </div>
                        <div class="col-md-4">
                            <label for="montoInput" class="form-label" style="color: #adb5bd;">Monto</label>
                            <input type="number" class="form-control" id="montoInput" step="0.01"
                                style="border-radius: 10px;">
                        </div>
                        <div class="col-md-4">
                            <label for="fechaInput" class="form-label" style="color: #adb5bd;">Fecha</label>
                            <input type="date" class="form-control" id="fechaInput" style="border-radius: 10px;">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12 d-flex justify-content-center">
                            <button type="button" class="btn btn-primary" id="addDetalleBtn"
                                style="border-radius: 10px; padding: 10px 20px;">Añadir</button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Guardar Registro -->
            <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-4">
                <button type="submit" class="btn btn-primary me-md-2" id="submitBtn" disabled>Guardar Registro</button>
                <a href="{{ route('cancelardetallecar') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
    <script>
        // Función que se llama cuando se cambia el estado del checkbox
        function toggleObservacionInput() {
            const checkbox = document.getElementById('checkboxMantenimiento');
            const observacionInput = document.getElementById('observacionInput');
            
            if (checkbox.checked) {
                // Si el checkbox está seleccionado, escribimos "Mantenimiento" y bloqueamos el input
                observacionInput.value = "Mantenimiento";
                observacionInput.disabled = true;
            } else {
                // Si el checkbox no está seleccionado, limpiamos el valor y desbloqueamos el input
                observacionInput.value = "";
                observacionInput.disabled = false;
            }
        }
    </script>
    <script>
        let detalleIndex = 1;
        let totalMonto = 0;

        // Función para habilitar o deshabilitar el botón de Guardar Registro
        function toggleSubmitButton() {
            const tableBody = document.getElementById('detalleTableBody');
            const submitButton = document.getElementById('submitBtn');

            // Verificar si la tabla tiene al menos una fila
            if (tableBody.children.length > 0) {
                submitButton.disabled = false;
            } else {
                submitButton.disabled = true;
            }
        }

        // Función para añadir detalle a la tabla
        document.getElementById('addDetalleBtn').addEventListener('click', function(event) {
            event.preventDefault();

            let observacion = document.getElementById('observacionInput').value;
            let monto = parseFloat(document.getElementById('montoInput').value);
            let fecha = document.getElementById('fechaInput').value;

            if (observacion && monto && fecha) {
                let tableBody = document.getElementById('detalleTableBody');
                let newRow = `<tr>
                                <td class="index-col">${detalleIndex}</td>
                                <td><input type="hidden" name="observacion[]" value="${observacion}">${observacion}</td>
                                <td><input type="hidden" name="fecha[]" value="${fecha}">${fecha}</td>
                                <td><input type="hidden" name="monto[]" value="${monto}">${monto.toFixed(2)}</td>
                                <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Eliminar</button></td>
                              </tr>`;
                tableBody.insertAdjacentHTML('beforeend', newRow);
                detalleIndex++;

                // Actualizar total
                totalMonto += monto;
                updateTotal();

                // Limpiar los campos
                document.getElementById('observacionInput').value = '';
                document.getElementById('montoInput').value = '';
                document.getElementById('fechaInput').value = '';
                // Verificar si se puede habilitar el botón de submit
                toggleSubmitButton();
            } else {
                alert('Por favor, complete todos los campos (Observacion, Monto, Fecha) antes de agregar.');
            }
        });

        // Función para eliminar fila y actualizar el índice y total
        function removeRow(button) {
            let row = button.closest('tr');
            let monto = parseFloat(row.querySelector('input[name="monto[]"]').value);

            totalMonto -= monto;
            updateTotal();
            row.remove();
            updateIndices();
            // Verificar si se debe deshabilitar el botón de submit
            toggleSubmitButton();
        }

        function updateIndices() {
            let rows = document.querySelectorAll('#detalleTableBody tr');
            detalleIndex = 1;
            rows.forEach(row => {
                row.querySelector('.index-col').innerText = detalleIndex;
                detalleIndex++;
            });
        }

        function updateTotal() {
            document.getElementById('montoTotal').innerText = totalMonto.toFixed(2);
        }
        // Deshabilitar el botón de submit al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            toggleSubmitButton();
        });
    </script>
@endsection
