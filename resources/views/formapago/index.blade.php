@extends('layouts.layout')

@section('title_content_ol', 'ADMINISTRACION DE FORMAS DE PAGO')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h6 class="mb-0 text-uppercase fw-bold text-secondary">Lista de Formas de Pago</h6>
    <div class="d-flex gap-2">
        <button class="btn btn-grd btn-grd-royal px-5 add_forma"><i class="bi bi-plus-lg me-2"></i>Add Formas</button>
    </div>
</div>
<hr>


<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="lista_formas_pago" class="table table-striped table-bordered" style="width:100%;font-size: 12px;">
                <thead>
                    <tr>
                        <th width="10%" class="text-center">Acciones</th>
                        <th width="" class="text-center">Nombre</th>
                     
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addformapago" tabindex="-1" aria-labelledby="addformapagoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog modal-dialog-scrollable">
    <div class="modal-content shadow-lg border-0 rounded-4">
      <!-- HEADER -->
      <div class="modal-header border-0  text-white py-3 rounded-top-4">
        <h5 class="modal-title fw-semibold" id="addformapagoLabel">
         Registrar Formas de pago
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <!-- BODY -->
      <div class="modal-body bg-light">
        <form id="form_forma_pago" class="row g-3 p-2">
          <div class="col-md-12">
            <label for="forma_pago_nombre" class="form-label fw-semibold">Nombre forma de pago</label>
            <div class="input-group">
              <input type="text" class="form-control" id="forma_pago_nombre" name="forma_pago_nombre" placeholder="Ingrese nombre">
            </div>
          </div>
        </form>
      </div>
        <!-- FOOTER -->
      <div class="modal-footer border-0 bg-light rounded-bottom-4">
        <button type="button" class="btn btn-success px-4 btn_save">
          <i class="bi bi-check-circle me-1"></i><span class="text-login">Guardar</span>
        </button>
        <button type="button" class="btn btn-outline-secondary px-4 btn_cancelar" data-bs-dismiss="modal">
          <i class="bi bi-x-circle me-1"></i>Cancelar
        </button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editformapago" tabindex="-1" aria-labelledby="editformapagoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog modal-dialog-scrollable">
    <div class="modal-content shadow-lg border-0 rounded-4">
      <!-- HEADER -->
      <div class="modal-header border-0  text-white py-3 rounded-top-4">
        <h5 class="modal-title fw-semibold" id="addmonedaLabel">
         Editar Forma de Pago
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <!-- BODY -->
      <div class="modal-body bg-light">
        <form id="form_edit_moneda" class="row g-3 p-2">
          <div class="col-md-12">
            <label for="moneda_nombre" class="form-label fw-semibold">Nombre moneda</label>
            <div class="input-group">
              <input type="text" class="form-control" id="editar_nombre_forma" name="editar_nombre_forma">
            </div>
          </div>
        </form>
      </div>
        <!-- FOOTER -->
      <div class="modal-footer border-0 bg-light rounded-bottom-4">
        <button type="button" class="btn btn-success px-4 btn_edit">
          <i class="bi bi-check-circle me-1"></i><span class="text-login">Actualizar</span>
        </button>
        <button type="button" class="btn btn-outline-secondary px-4 btn_cancelar" data-bs-dismiss="modal">
          <i class="bi bi-x-circle me-1"></i>Cancelar
        </button>
      </div>
    </div>
  </div>
</div>



@endsection
@section('scripts')
    @include('formapago._myjs')
    @include('formapago.table')
@endsection