@extends('layouts.layout')

@section('title_content_ol', 'ADMINISTRACION DE CLIENTES')

@section('content')
<style>
 
  #addcliente input:focus, 
  #addcliente select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13,110,253,0.15);
  }
  #addcliente .btn-outline-primary:hover {
    background-color: #0d6efd;
    color: #fff;
  }
  #addcliente .btn-success {
    background: linear-gradient(90deg, #198754, #20c997);
    border: none;
  }
  #addcliente .btn-success:hover {
    background: linear-gradient(90deg, #157347, #198754);
  }
</style>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h6 class="mb-0 text-uppercase fw-bold text-secondary">Lista de clientes</h6>
    <div class="d-flex gap-2">
        <button class="btn btn-grd btn-grd-royal px-5 add_cliente"><i class="bi bi-plus-lg me-2"></i>Add Clientes</button>
    </div>
</div>
<hr>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="lista_clientes" class="table table-striped table-bordered" style="width:100%;font-size: 12px;">
                <thead>
                    <tr>
                        <th width="5%" class="text-center">Acciones</th>
                        <th width="" class="text-left">Nombre</th>
                        <th width="" class="text-left">N°Documento</th>
                        <th width="" class="text-left">Celular</th>
                        <th width="" class="text-left">Direccion</th>
                        <th width="" class="text-left">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- MODAL REGISTRAR CLIENTE -->
<div class="modal fade" id="addcliente" tabindex="-1" aria-labelledby="addclienteLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog modal-dialog-scrollable">
    <div class="modal-content shadow-lg border-0 rounded-4">
      <!-- HEADER -->
      <div class="modal-header border-0  text-white py-3 rounded-top-4">
        <h5 class="modal-title fw-semibold" id="addclienteLabel">
          <i class="bi bi-person-plus me-2"></i>Registrar Cliente
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <!-- BODY -->
      <div class="modal-body bg-light">
        <form id="form_cliente" class="row g-3 p-2">
          <div class="col-md-4">
            <label for="cli_numdoc" class="form-label fw-semibold">Número de Documento</label>
            <div class="input-group">
              <input type="text" class="form-control" id="cli_numdoc" name="cli_numdoc" placeholder="Ingrese número">
              <button class="btn btn-outline-primary btn-reniec"  type="button" id="btnBuscarDoc">
                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                <span class="text-login_reniec">RENIEC</span>
              </button>
            </div>
          </div>

          <div class="col-md-4">
            <label for="cli_tipodoc" class="form-label fw-semibold">Tipo Documento</label>
            <select id="cli_tipodoc" name="cli_tipodoc" class="form-select">
              <option value="0" selected>Seleccione...</option>
              <option value="DNI">DNI</option>
              <option value="RUC">RUC</option>
              <option value="CE">C. EXTRANJERIA</option>
            </select>
          </div>

          <div class="col-md-4">
            <label for="cli_nom" class="form-label fw-semibold">Nombre / Razón Social</label>
            <input type="text" class="form-control" id="cli_nom" name="cli_nom" placeholder="Nombres o Razón Social">
          </div>

          <div class="col-md-6">
            <label for="cli_direcion" class="form-label fw-semibold">Dirección</label>
            <input type="text" class="form-control" id="cli_direcion" name="cli_direcion" placeholder="Ej. Av. Siempre Viva 742">
          </div>

          <div class="col-md-6">
            <label for="cli_telefono" class="form-label fw-semibold">Teléfono</label>
            <input type="text" class="form-control" id="cli_telefono" name="cli_telefono" placeholder="Ej. 999 999 999">
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






@endsection

@section('scripts')
    @include('clientes._myjs')
    @include('clientes._table')
@endsection
