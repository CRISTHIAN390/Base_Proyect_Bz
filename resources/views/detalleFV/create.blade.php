@extends('layouts.plantilla')
@section('titulo', 'Crear Detalle')

@section('contenido')
    <div class="container">
        <h5 class="mt-4">REGISTRO Gasto/Pago</h5>
        <form id="nuevoDetalleForm" method="POST" action="{{ route('detalleFV.store') }}">
            @csrf
            <!-- Conductor -->
            <div class="mb-3">
                <label for="idempleado" class="form-label">Conductor</label>
                <select class="form-select" id="idempleado" name="idempleado" required>
                    <option value="" selected disabled>Seleccione un Conductor</option>
                    @foreach ($empleados as $empleado)
                        <option value="{{ $empleado->idempleado }}">{{ $empleado->nombres }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Flete -->
            <div class="mb-3">
                <label for="idflete" class="form-label">Flete</label>
                <select class="form-select" id="idflete" name="idflete" required>
                    <option value="" selected disabled>Seleccione un flete</option>
                    @foreach ($fletes as $flete)
                        <option value="{{ $flete->idflete }}">{{ $flete->nombre_flete }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Viático -->
            <div class="mb-3">
                <label for="idviatico" class="form-label">Viático</label>
                <select class="form-select" id="idviatico" name="idviatico" required>
                    <option value="" selected disabled>Seleccione un viático</option>
                    @foreach ($viaticos as $viatico)
                        <option value="{{ $viatico->idviatico }}">{{ $viatico->nombre_viatico }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Fecha y Tipo G/I -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="tipoIG" class="form-label">Tipo (G/I)</label>
                    <select class="form-select" id="tipoIG" name="tipoIG" required>
                        <option value="1">Gasto</option>
                        <option value="2">Ingreso</option>
                    </select>
                </div>
            </div>

            <!-- Tabla de Detalles -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Detalle</h5>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">N°</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Importe</th>
                                    <th scope="col">Acción</th>
                                </tr>
                            </thead>
                            <tbody id="detalleTableBody">
                                <!-- Aquí se añadirán dinámicamente las filas -->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Total</strong></td>
                                    <td id="montoTotal">0.00</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Importe, Descripción y Fecha -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="descripcionInput" class="form-label">Descripción</label>
                            <input type="text" class="form-control" id="descripcionInput">
                        </div>
                        <div class="col-md-4">
                            <label for="importeInput" class="form-label">Importe</label>
                            <input type="number" class="form-control" id="importeInput" step="0.01">
                        </div>
                        <div class="col-md-4">
                            <label for="fechaInput" class="form-label">Fecha</label>
                            <input type="date" class="form-control" id="fechaInput">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12 d-flex justify-content-center">
                            <button type="button" class="btn btn-primary" id="addDetalleBtn">Añadir a la lista</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Guardar Registro -->
            <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-4">
                <button type="submit" class="btn btn-primary me-md-2" id="submitBtn" disabled>Guardar Registro</button>
                <a href="{{ route('cancelardetalle') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>

    <script>
        let detalleIndex = 1;
        let totalImporte = 0;

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

            let descripcion = document.getElementById('descripcionInput').value;
            let importe = parseFloat(document.getElementById('importeInput').value);
            let fecha = document.getElementById('fechaInput').value;

            if (descripcion && importe && fecha) {
                let tableBody = document.getElementById('detalleTableBody');
                let newRow = `<tr>
                                <td class="index-col">${detalleIndex}</td>
                                <td><input type="hidden" name="descripcion[]" value="${descripcion}">${descripcion}</td>
                                <td><input type="hidden" name="fecha[]" value="${fecha}">${fecha}</td>
                                <td><input type="hidden" name="importe[]" value="${importe}">${importe.toFixed(2)}</td>
                                <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Eliminar</button></td>
                              </tr>`;
                tableBody.insertAdjacentHTML('beforeend', newRow);
                detalleIndex++;

                // Actualizar total
                totalImporte += importe;
                updateTotal();

                // Limpiar los campos
                document.getElementById('descripcionInput').value = '';
                document.getElementById('importeInput').value = '';
                document.getElementById('fechaInput').value = '';
                // Verificar si se puede habilitar el botón de submit
                toggleSubmitButton();
            } else {
                alert('Por favor, complete todos los campos (Descripción, Importe, Fecha) antes de agregar.');
            }
        });

        // Función para eliminar fila y actualizar el índice y total
        function removeRow(button) {
            let row = button.closest('tr');
            let importe = parseFloat(row.querySelector('input[name="importe[]"]').value);

            totalImporte -= importe;
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
            document.getElementById('montoTotal').innerText = totalImporte.toFixed(2);
        }
        // Deshabilitar el botón de submit al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            toggleSubmitButton();
        });
    </script>
@endsection
