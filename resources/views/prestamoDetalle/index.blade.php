@extends('layouts.layout')

@section('title_content_ol', 'LISTA DE DETALLES DE PRESTAMOS')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="mb-0 text-uppercase fw-bold text-secondary">Lista de Prestamos</h6>
        <div class="d-flex gap-2">
        <a href="{{ route('prestamos.index')}}" class="btn btn-grd btn-grd-royal px-5"><i class="bi bi-plus-lg me-2"></i>Simular Prestamo</a>
    </div>
</div>
<hr>


<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="listar_prestamos" class="table table-striped table-bordered text-uppercase" style="width:100%;font-size: 10px;">
                <thead>
                    <tr style="background-color: #49496d;">
                        <th width="10%" class="text-center">N° Prestamo</th>
                        <th width="" class="text-center">Cliente</th>
                        <th width="" class="text-center">Monto</th>
                        <th width="" class="text-center">Interes</th>
                        <th width="" class="text-center">Cuotas</th>
                        <th width="" class="text-center">Forma Pago</th>
                        <th width="" class="text-center">Usuario</th>
                        <th width="" class="text-center">Fecha Emision</th>
                        <th width="" class="text-center">Estado</th>
                        <th width="10%" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Detalle Prestamos -->
<div class="modal fade" id="modal_detalle_prestamos" tabindex="-1" role="dialog" aria-labelledby="modal_detalle_prestamos_label" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header text-white">
        <h5 class="modal-title" id="modal_detalle_prestamos_label" style="font-size: 15px">Detalle de Préstamo</h5>
      </div>

      <div class="modal-body">
        <div id="detalle_prestamo_content">

          <!-- 🔹 Información general del préstamo -->
          <div class="row g-2 mb-3">
            <div class="col-md-4">
              <label class="form-label small mb-1">N° Préstamo</label>
              <input type="text" id="nro_prestamo" class="form-control form-control-sm" disabled>
            </div>
            <div class="col-md-8">
              <label class="form-label small mb-1">Cliente</label>
              <input type="text" id="cliente" class="form-control form-control-sm" disabled>
            </div>
            <div class="col-md-2">
              <label class="form-label small mb-1">Monto Total</label>
              <input type="text" id="monto_total" class="form-control form-control-sm text-end" disabled>
            </div>
            <div class="col-md-2">
              <label class="form-label small mb-1">Interés (%)</label>
              <input type="text" id="interes" class="form-control form-control-sm text-end" disabled>
            </div>
            <div class="col-md-2">
              <label class="form-label small mb-1">Cuotas</label>
              <input type="text" id="cuotas" class="form-control form-control-sm text-center" disabled>
            </div>
            <div class="col-md-2">
              <label class="form-label small mb-1">Forma de Pago</label>
              <input type="text" id="forma_pago" class="form-control form-control-sm" disabled>
            </div>
            <div class="col-md-4">
              <label class="form-label small mb-1">Fecha Emisión</label>
              <input type="text" id="fecha_emision" class="form-control form-control-sm" disabled>
            </div>
            <div class="col-md-4">
              <label class="form-label small mb-1">Monto Cuota</label>
              <input type="text" id="monto_cuota" class="form-control form-control-sm text-center" disabled>
            </div>
             <div class="col-md-4">
              <label class="form-label small mb-1">Cuotas pagadas</label>
              <input type="text" id="cuotas_pagadas" class="form-control form-control-sm text-center" disabled>
            </div>
            <div class="col-md-4">
              <label class="form-label small mb-1">Usuario</label>
              <input type="text" id="usuario" class="form-control form-control-sm text-center" disabled>
            </div>
           </div>
            <hr>
          <!-- 🔹 Tabla de cuotas -->
          <div class="table-responsive">
            <table id="listar_cuotas" class="table table-striped table-bordered text-uppercase" style="width:100%; font-size: 11px;">
              <thead>
                <tr style="background-color: #49496d;">
                  <th width="10%" class="text-center">N° Cuota</th>
                  <th class="text-center">Fecha</th>
                  <th class="text-center">Monto</th>
                  <th class="text-center">Estado</th>
                  <th class="text-center">Opciones</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>

        </div>
      </div>
        <div class="modal-footer border-0 bg-light rounded-bottom-4">
        <button type="button" class="btn btn-outline-secondary px-4 btn_cancelar" data-bs-dismiss="modal">
          <i class="bi bi-x-circle me-1"></i>Cancelar
        </button>
      </div>
    </div>
  </div>
</div>



@endsection
@section('scripts')
  @include('prestamoDetalle._myjs')
  @include('prestamoDetalle.table')
@endsection