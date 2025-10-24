@extends('layouts.layout')

@section('title_content_ol', 'ADMINISTRACION DE USUARIOS')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h6 class="mb-0 text-uppercase fw-bold text-secondary">Lista de Usuarios</h6>
    <div class="d-flex gap-2">
        <button class="btn btn-grd btn-grd-royal px-5 add_usuario"><i class="bi bi-plus-lg me-2"></i>Add usuario</button>
    </div>
</div>
<hr>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="lista_usuarios" class="table table-striped table-bordered" style="width:100%;font-size: 12px;">
                <thead>
                    <tr>
                        <th width="10%" class="text-center">Acciones</th>
                        <th width="" class="text-center">Nombres</th>
                        <th width="" class="text-center">Perfiles</th>
                        <th width="" class="text-center">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- MODAL REGISTRAR CLIENTE -->
<div class="modal fade" id="addusuarios" tabindex="-1" aria-labelledby="addclienteLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog modal-dialog-scrollable">
    <div class="modal-content shadow-lg border-0 rounded-4">
      <!-- HEADER -->
      <div class="modal-header border-0  text-white py-3 rounded-top-4">
        <h5 class="modal-title fw-semibold" id="addclienteLabel">
          <i class="bi bi-person-plus me-2"></i>Registrar Usuarios
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <!-- BODY -->
      <div class="modal-body bg-light">
        <form id="form_usuario" class="row g-3 p-2">
          <div class="col-md-6">
            <label for="cli_numdoc" class="form-label fw-semibold">Número de Documento</label>
            <div class="input-group">
              <input type="text" class="form-control" id="user_numdoc" name="user_numdoc" placeholder="Ingrese número">
            </div>         
          </div>
          <div class="col-md-6">
            <label for="cli_nom" class="form-label fw-semibold">Nombre / Razón Social</label>
            <input type="text" class="form-control" id="user_nom" name="user_nom" placeholder="Nombres o Razón Social">
          </div>
           <div class="col-md-6">
            <label for="cli_nom" class="form-label fw-semibold">Usuario</label>
            <input type="text" class="form-control" id="user_usuario" name="user_usuario" placeholder="Nombres o Razón Social">
          </div>
           <div class="col-md-6">
            <label for="cli_nom" class="form-label fw-semibold">Password</label>
            <input type="password" class="form-control" id="user_password" name="cli_password" placeholder="Nombres o Razón Social">
          </div>
           <div class="col-md-6">
            <label for="cli_nom" class="form-label fw-semibold">Perfil</label>
            <select type="text" class="form-control" id="idperfil" name="idperfil">
              <option>[Seleccione]</option>
              <option>SUPERVISOR</option>
            </select>
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

<div class="modal fade" id="editusuarios" tabindex="-1" aria-labelledby="addclienteLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog modal-dialog-scrollable">
    <div class="modal-content shadow-lg border-0 rounded-4">
      <!-- HEADER -->
      <div class="modal-header border-0  text-white py-3 rounded-top-4">
        <h5 class="modal-title fw-semibold" id="addclienteLabel">
          <i class="bi bi-person-plus me-2"></i>Editar  Usuarios
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <!-- BODY -->
      <div class="modal-body bg-light">
        <form id="form_usuario_edit" class="row g-3 p-2">
          <div class="col-md-6">
            <label for="cli_numdoc" class="form-label fw-semibold">Número de Documento</label>
            <div class="input-group">
              <input type="text" class="form-control" id="edit_numdoc" name="edit_numdoc" placeholder="Ingrese número">
            </div>         
          </div>
          <div class="col-md-6">
            <label for="cli_nom" class="form-label fw-semibold">Nombre / Razón Social</label>
            <input type="text" class="form-control" id="edit_nom" name="edit_nom" placeholder="Nombres o Razón Social">
          </div>
           <div class="col-md-6">
            <label for="cli_nom" class="form-label fw-semibold">Usuario</label>
            <input type="text" class="form-control" id="edit_usuario" name="edit_usuario" placeholder="Nombres o Razón Social">
          </div>
           <div class="col-md-6">
            <label for="cli_nom" class="form-label fw-semibold">Password</label>
            <input type="password" class="form-control" id="edit_password" name="edit_password" placeholder="Nombres o Razón Social">
          </div>
           <div class="col-md-6">
            <label for="cli_nom" class="form-label fw-semibold">Perfil</label>
            <select type="text" class="form-control" id="editidperfil" name="editidperfil">
              <option>[Seleccione]</option>
              <option>SUPERVISOR</option>
            </select>
          </div>
       
        </form>
      </div>

      <!-- FOOTER -->
      <div class="modal-footer border-0 bg-light rounded-bottom-4">
        <button type="button" class="btn btn-success px-4 btn_update">
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
  @include('usuarios._myjs')
  @include('usuarios.table')
@endsection