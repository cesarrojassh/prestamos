@extends('layouts.layout')

@section('title_content_ol', 'ADMINISTRACION DE MODULOS')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h6 class="mb-0 text-uppercase fw-bold text-secondary">Lista de modulos</h6>
    <div class="d-flex gap-2">
        <button class="btn btn-grd btn-grd-royal px-5 add_modulo"><i class="bi bi-plus-lg me-2"></i>Add Modulo</button>
    </div>
</div>
<hr>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="lista_modulos" class="table table-striped table-bordered" style="width:100%;font-size: 12px;">
                <thead>
                    <tr>
                        <th width="" class="text-left">Acciones</th>
                        <th width="10%" class="text-center">Tipo</th>
                        <th width="" class="text-left">Descripcion</th>
                        <th width="" class="text-left">Url</th>
                        <th width="" class="text-left">Estado</th>

                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addmodulo" tabindex="-1" aria-labelledby="addModuloLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog modal-dialog-scrollable">
    <div class="modal-content shadow-lg border-0 rounded-4">

      <div class="modal-header border-0 text-white py-3 rounded-top-4">
        <h5 class="modal-title fw-semibold" id="addModuloLabel">
          <i class="material-icons-outlined me-1">add_box</i>
          Registrar Módulo
        </h5>
      </div>

      <div class="modal-body bg-light">
        <form id="form_modulo" class="row g-3 p-2">
          
          <div class="col-md-6">
            <label for="modulo_nombre" class="form-label fw-semibold">Descripción (Nombre) <span class="text-danger">*</span></label>
            <div class="input-group">
              <span class="input-group-text"><i class="material-icons-outlined">label</i></span>
              <input type="text" class="form-control" id="modulo_nombre" name="nombre" placeholder="Ej: Gestión de Usuarios">
            </div>
          </div>

          <div class="col-md-6">
            <label for="modulo_padre" class="form-label fw-semibold">Módulo Padre (Sub-módulo de) <span class="text-danger">*</span></label>
            <select class="form-select" id="modulo_padre" name="parent_id">
                <option value="0" selected>-- Ninguno (Este es un Módulo Padre) --</option>
                @foreach($modulos as $modulo)
                  <option value="{{ $modulo->id}}">{{ $modulo->modulo_nombre}}</option>
                @endforeach 
                </select>
          </div>

          <div class="col-md-6">
            <label for="modulo_ruta" class="form-label fw-semibold">URL (Ruta)</label>
            <div class="input-group">
                <span class="input-group-text"><i class="material-icons-outlined">link</i></span>
                <input type="text" class="form-control" id="modulo_ruta" name="ruta" placeholder="Ej: usuarios.index">
            </div>
            <small class="form-text text-muted">Usar '#' si es un Módulo Padre que solo despliega un menú.</small>
          </div>

          <div class="col-md-3">
            <label for="modulo_icono" class="form-label fw-semibold">Icono</label>
            <div class="input-group">
                <span class="input-group-text"><i class="material-icons-outlined">mood</i></span>
                <input type="text" class="form-control" id="modulo_icono" name="icono" placeholder="Ej: widgets">
            </div>
            <small class="form-text text-muted">El nombre del Material Icon.</small>
          </div>

          <div class="col-md-3">
            <label for="modulo_orden" class="form-label fw-semibold">Orden <span class="text-danger">*</span></label>
            <input type="number" class="form-control" id="modulo_orden" name="orden" value="100">
          </div>

        </form>
      </div>

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

<div class="modal fade" id="editmodulo" tabindex="-1" aria-labelledby="addModuloLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog modal-dialog-scrollable">
    <div class="modal-content shadow-lg border-0 rounded-4">

      <div class="modal-header border-0 text-white py-3 rounded-top-4">
        <h5 class="modal-title fw-semibold" id="addModuloLabel">
          <i class="material-icons-outlined me-1">add_box</i>
          Registrar Módulo
        </h5>
      </div>

      <div class="modal-body bg-light">
        <form id="form_modulo_edit" class="row g-3 p-2">
          
          <div class="col-md-6">
            <label for="modulo_nombre" class="form-label fw-semibold">Descripción (Nombre) <span class="text-danger">*</span></label>
            <div class="input-group">
              <span class="input-group-text"><i class="material-icons-outlined">label</i></span>
              <input type="text" class="form-control" id="editmodulo_nombre" name="editnombre" placeholder="Ej: Gestión de Usuarios">
            </div>
          </div>

          <div class="col-md-6">
            <label for="modulo_padre" class="form-label fw-semibold">Módulo Padre (Sub-módulo de) <span class="text-danger">*</span></label>
            <select class="form-select" id="editmodulo_padre" name="editparent_id">
                <option value="0" selected>-- Ninguno (Este es un Módulo Padre) --</option>
                @foreach($modulos as $modulo)
                  <option value="{{ $modulo->id}}">{{ $modulo->modulo_nombre}}</option>
                @endforeach 
                </select>
          </div>

          <div class="col-md-6">
            <label for="modulo_ruta" class="form-label fw-semibold">URL (Ruta)</label>
            <div class="input-group">
                <span class="input-group-text"><i class="material-icons-outlined">link</i></span>
                <input type="text" class="form-control" id="editmodulo_ruta" name="editruta" placeholder="Ej: usuarios.index">
            </div>
            <small class="form-text text-muted">Usar '#' si es un Módulo Padre que solo despliega un menú.</small>
          </div>

          <div class="col-md-3">
            <label for="modulo_icono" class="form-label fw-semibold">Icono</label>
            <div class="input-group">
                <span class="input-group-text"><i class="material-icons-outlined">mood</i></span>
                <input type="text" class="form-control" id="editmodulo_icono" name="editicono" placeholder="Ej: widgets">
            </div>
            <small class="form-text text-muted">El nombre del Material Icon.</small>
          </div>

          <div class="col-md-3">
            <label for="modulo_orden" class="form-label fw-semibold">Orden <span class="text-danger">*</span></label>
            <input type="number" class="form-control" id="editmodulo_orden" name="editorden" value="100">
          </div>

        </form>
      </div>

      <div class="modal-footer border-0 bg-light rounded-bottom-4">
        <button type="button" class="btn btn-success px-4 btn_update">
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
    @include('modulos._myjs')
    @include('modulos.table')
@endsection