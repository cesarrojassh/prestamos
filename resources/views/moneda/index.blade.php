@extends('layouts.layout')

@section('title_content_ol', 'ADMINISTRACION DE MONEDAS')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h6 class="mb-0 text-uppercase fw-bold text-secondary">Lista de monedas</h6>
    <div class="d-flex gap-2">
        <button class="btn btn-grd btn-grd-royal px-5 add_moneda"><i class="bi bi-plus-lg me-2"></i>Add Monedas</button>
    </div>
</div>
<hr>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="lista_monedas" class="table table-striped table-bordered" style="width:100%;font-size: 12px;">
                <thead>
                    <tr>
                        <th width="5%" class="text-center">Acciones</th>
                        <th width="" class="text-left">Nombre</th>
                        <th width="" class="text-left">Simbolo</th>
                        <th width="" class="text-left">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
@section('scripts')
    @include('moneda._myjs')
    @include('moneda._table')
@endsection