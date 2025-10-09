@extends('layouts.layout')

@section('title_content_ol', 'Tablero principal')

@section('content')
    <div class="row">
        <div class="col-xxl-8 d-flex align-items-stretch">
            <div class="card w-100 overflow-hidden rounded-4">
                <div class="card-body position-relative p-4">
                    <div class="row">
                        <div class="col-12 col-sm-7">
                            <div class="d-flex align-items-center gap-3 mb-5">
                                <img src="assets/images/user.png" class="rounded-circle bg-grd-info p-1" width="60" height="60" alt="user">
                                <div>
                                    <p class="mb-0 fw-semibold">Bienvenido:</p>
                                    <h4 class="fw-semibold mb-0 fs-4">{{ session('nombre') }}</h4>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-5">
                                <div>
                                    <h4 class="mb-1 fw-semibold d-flex align-content-center"><i class="ti ti-arrow-up-right fs-5 lh-base text-success"></i></h4>
                                    <p class="mb-3">Ventas totales</p>
                                    <div class="progress mb-0" style="height:5px;">
                                        <div class="progress-bar bg-grd-success" role="progressbar" style="width: 60%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="vr"></div>
                                <div>
                                    <h4 class="mb-1 fw-semibold d-flex align-content-center"><i class="ti ti-arrow-up-right fs-5 lh-base text-success"></i></h4>
                                    <p class="mb-3">Ventas por día</p>
                                    <div class="progress mb-0" style="height:5px;">
                                        <div class="progress-bar bg-grd-danger" role="progressbar" style="width: 60%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-5">
                            <div class="welcome-back-img pt-4">
                                <img src="assets/images/gallery/welcome-back-3.png" height="180" alt="">
                            </div>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-xxl-4 d-flex align-items-stretch">
            <div class="card w-100 rounded-4">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <h5 class="mb-0 fw-bold">Productos con menor stok</h5>
                    </div>
                   
                        <div class="d-flex flex-column justify-content-between gap-4">
                            <div class="d-flex align-items-center gap-4">
                                <div class="d-flex align-items-center gap-3 flex-grow-1">
                                    <img src="{{ asset('assets/images/apps/03.png') }}" width="32" alt="Ícono">
                                    <div>
                                        <p class="mb-0 fw-bold"></p>
                                        <small class="text-danger"></small>
                                    </div>
                                </div>
                                <div>
                                   
                                </div>
                            </div>
                        </div>
                  
                        <div class="alert alert-success">Todos los productos tienen suficiente stock.</div>
                  

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="card rounded-4">
                <div class="card-header py-3">
                    <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Top ventas por categorias </h5>
                    </div>
                </div>
                <div class="card-body">
                    <div id="chart4"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card rounded-4">
              <div class="card-header py-3">
                <div class="d-flex align-items-center justify-content-between">
                  <h5 class="mb-0">Grafico ventas por mes</h5>
                </div>
              </div>
              <div class="card-body">
                <div id="chart3"></div>
              </div>
            </div>
          </div>
    </div>
          
@endsection
@section('scripts')
   
@endsection