@extends('layouts.layout')

@section('title_content_ol', 'SIMULADOR DE PRÉSTAMOS')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h6 class="mb-0 text-uppercase fw-bold text-secondary">Simular préstamo</h6>
</div>
<hr>

<div class="card">
    <div class="card-body">
                <form id="formSimulador" class="row g-3">
                <!-- CLIENTE -->
                <div class="col-md-4">
                    <label for="cliente" class="form-label">Cliente</label>
                    <div class="input-group">
                        <input type="text" id="cliente" class="form-control" placeholder="Ingrese nombre o documento" required>
                        <button type="button" class="btn btn-outline-secondary" id="btnBuscarCliente">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="monto" class="form-label">Monto del préstamo</label>
                    <input type="number" id="monto" class="form-control" placeholder="Ej. 1000" min="0" step="0.01" required>
                </div>

                <div class="col-md-4">
                    <label for="interes" class="form-label">Interés (%)</label>
                    <input type="number" id="interes" class="form-control" placeholder="Ej. 10" min="0" step="0.01" required>
                </div>

                <div class="col-md-4">
                    <label for="cuotas" class="form-label">Número de cuotas</label>
                    <input type="number" id="cuotas" class="form-control" placeholder="Ej. 12" min="1" required>
                </div>

                <div class="col-md-4">
                    <label for="forma_pago" class="form-label">Forma de pago</label>
                    <select id="forma_pago" class="form-select" required>
                        <option value="">-Selecione una forma de pago-</option>
                      @foreach($formas as $forma)
                        <option value="{{ $forma->id }}">{{ $forma->nombre }}</option>
                       @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="moneda" class="form-label">Moneda</label>
                    <select id="moneda" class="form-select" required>
                        <option value="">-Selecione una moneda-</option>
                       @foreach($monedas as $moneda)
                        <option value="{{ $moneda->id }}">{{ $moneda->nombre }}</option>
                       @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="fecha_emision" class="form-label">Fecha de emisión</label>
                    <input type="date" id="fecha_emision" class="form-control" required>
                </div>

              <div class="col-md-6 d-flex align-items-end">
                    <button type="button" id="btnSimular" class="btn btn-primary w-100">
                        Calcular
                    </button>
              </div>
            </form>


      
      <!-- RESULTADOS -->
            <div id="resultado" class="mt-4 d-flex justify-content-center">
                <div class="col-md-6">
                    <div class="card border-0 shadow-lg rounded-4" 
                        style="background: linear-gradient(145deg, #ffffff, #175ec94d); box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);">
                        <div class="card-header text-white text-center fw-bold rounded-top-4"
                            style="background: linear-gradient(90deg, #17a2b8, #0dcaf0); box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);">
                            RESULTADOS DEL PRÉSTAMO
                        </div>
                        <div class="card-body text-center">
                            <table class="table table-borderless mb-3" >
                                <tbody>
                                    <tr>
                                        <td class="fw-bold text-left">Valor por cuota:</td>
                                        <td class="text-start" id="valorCuota">S/ 0.00</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-left">Valor del interés:</td>
                                        <td class="text-start" id="valorInteres">S/ 0.00</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-left">Monto total:</td>
                                        <td class="text-start" id="montoTotal">S/ 0.00</td>
                                    </tr>
                                </tbody>
                            </table>

                            <p class="text-muted small mb-3">
                                Los resultados serán actualizados después de calcular el préstamo.
                            </p>

                            <div class="d-flex justify-content-center gap-2">
                                <button class="btn btn-success px-4 btnConfirmar" id="btnConfirmar">Confirmar préstamo</button>
                                <button class="btn btn-danger px-4" id="btnCancelar">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>













            

        <!-- FIN RESULTADOS -->
    </div>
</div>


<!-- MODAL BUSCAR CLIENTE -->
<div class="modal fade" id="addcliente" tabindex="-1" aria-labelledby="addclienteLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog modal-dialog-scrollable">
    <div class="modal-content shadow-lg border-0 rounded-4">
      <!-- HEADER -->
      <div class="modal-header border-0  text-white py-3 rounded-top-4">
        <h5 class="modal-title fw-semibold" id="addclienteLabel">
         Lista de clientes
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
       <div class="modal-body bg-light">
         <div class="table-responsive">
            <table id="lista_clientes_prestamos" class="table table-striped table-bordered" style="width:100%;font-size: 12px;">
                <thead>
                    <tr>
                        <th width="" class="text-left">Nombre</th>
                        <th width="" class="text-left">N°Documento</th>
                        <th width="" class="text-left">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
       </div>    
    </div>
  </div>
</div>





@endsection
@section('scripts')
@include('prestamos._myjs')
@include('prestamos._table')
@endsection
