@extends('layouts.app1', ['activePage' => 'dashboard'])

@section('content')
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-4">
          <div class="list-group" id="list-tab" role="tablist">
            <a class="list-group-item list-group-item-action-primary active" id="list-repartidores-list" data-toggle="list" href="#list-repartidores" role="tab" aria-controls="repartidores">Reporte de Repartidores</a>
            <a class="list-group-item list-group-item-action-primary" id="list-proveedores-list" data-toggle="list" href="#list-proveedores" role="tab" aria-controls="proveedores">Reporte de Proveedores</a>
            <a class="list-group-item list-group-item-action-primary" id="list-productos-list" data-toggle="list" href="#list-productos" role="tab" aria-controls="productos">Reporte de Productos</a>
            <a class="list-group-item list-group-item-action-primary" id="list-entradas-list" data-toggle="list" href="#list-entradas" role="tab" aria-controls="entradas">Reporte de Entradas</a>
            <a class="list-group-item list-group-item-action-primary" id="list-almacen-list" data-toggle="list" href="#list-almacen" role="tab" aria-controls="almacen">Reporte de Almacen</a>
            <a class="list-group-item list-group-item-action-primary" id="list-ventas-list" data-toggle="list" href="#list-ventas" role="tab" aria-controls="ventas">Reporte de Ventas</a>
            <a class="list-group-item list-group-item-action-primary" id="list-gastos-list" data-toggle="list" href="#list-gastos" role="tab" aria-controls="gastos">Reporte de Gastos</a>
            <a class="list-group-item list-group-item-action-primary" id="list-metas-list" data-toggle="list" href="#list-metas" role="tab" aria-controls="metas">Reporte de Metas</a>
            <a class="list-group-item list-group-item-action-primary" id="list-rutas-list" data-toggle="list" href="#list-rutas" role="tab" aria-controls="rutas">Reporte de Rutas</a>
          </div>
        </div>
        <div class="col-8">
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade" id="list-repartidores" role="tabpanel" aria-labelledby="list-repartidores-list">
              <div>
              <h1>REPORTE REPARTIDORES</h1>
              <form method="POST" action="repartidores">
                <div class="col-md-6">
                  <label for="name">BUSCAR POR FECHA</label>
                  <input type="date" id="picker" name="picker" class="form-control">
                  <label for="name">BUSCAR POR NOMBRE</label>
                  <input type="text" class="form-control" id="name" name="titulo" />
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <label class="input-group-text" for="inputGroupSelect01">BUSCAR POR STATUS</label>
                    </div>
                    <select class="custom-select" id="inputGroupSelect01">
                      <option selected></option>
                      <option value="1">Activos</option>
                      <option value="2">Desactivos</option>
                    </select>
                  </div>
                </div>
                  <a class="btn btn-primary" href="/pdfrepartidores" role="button">Generar Reporte</a>
              </form>    
            </div>
          </div>
            <div class="tab-pane fade" id="list-proveedores" role="tabpanel" aria-labelledby="list-proveedores-list">
              <h1>REPORTE PROVEEDORES</h1>
              <input type="date" id="picker" name="picker" class="form-control">
              <a class="btn btn-primary btn-lg btn-block" href="/pdfrepartidores" role="button">Generar Reporte</a>
            </div>
            <div class="tab-pane fade" id="list-productos" role="tabpanel" aria-labelledby="list-productos-list">
              <h1>REPORTE PRODUCTOS</h1>
              
              <div class="col-md-6">
                <label for="name">BUSCAR POR NOMBRE DEL PRODUCTO</label>
                <input type="text" class="form-control" id="name" name="titulo" />
              </div>
              <div class="col-md-6">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">BUSCAR POR STATUS</label>
                  </div>
                  <select class="custom-select" id="inputGroupSelect01">
                    <option selected></option>
                    <option value="1">Activos</option>
                    <option value="2">Desactivos</option>
                  </select>
                </div>
              </div>
              <a class="btn btn-primary btn-lg btn-block" href="/pdfproductos" role="button">Generar Reporte</a>
            </div>
            <div class="tab-pane fade" id="list-entradas" role="tabpanel" aria-labelledby="list-entradas-list">
              <h1>REPORTE ENTRADAS</h1>
              <div class="col-md-6">
                <label for="name">BUSCAR POR FECHA</label>
                <input type="date" id="picker" name="picker" class="form-control">
              </div>
              <a class="btn btn-primary btn-lg btn-block" href="/pdfentradas" role="button">Generar Reporte</a>
            </div>
            <div class="tab-pane fade" id="list-almacen" role="tabpanel" aria-labelledby="list-almacen-list">
              <h1>REPORTE ALMACEN</h1>
              <div class="col-md-6">
                <label for="name">BUSCAR POR FECHA DE SALIDA</label>
                <input type="date" id="picker" name="picker" class="form-control">
              </div>
              <a class="btn btn-primary btn-lg btn-block" href="/pdfalmacen" role="button">Generar Reporte</a>
            </div>
            <div class="tab-pane fade" id="list-ventas" role="tabpanel" aria-labelledby="list-ventas-list">
              <h1>REPORTE VENTAS</h1>
              <div class="col-md-6">
                <label for="name">BUSCAR POR FECHA</label>
                <input type="date" id="picker" name="picker" class="form-control">
              </div>
              <a class="btn btn-primary btn-lg btn-block" href="/pdfventas" role="button">Generar Reporte</a></div>
            <div class="tab-pane fade" id="list-gastos" role="tabpanel" aria-labelledby="list-gastos-list">
              <h1>REPORTE GASTOS</h1>
              <div class="col-md-6">
                <label for="name">BUSCAR POR FECHA</label>
                <input type="date" id="picker" name="picker" class="form-control">
              </div>
              <div class="col-md-6">
                <label for="name">BUSCAR POR ID REPARTIDOR</label>
                <input type="text" class="form-control" id="name" name="titulo" />
              </div>
              <div class="col-md-6">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">BUSCAR POR STATUS</label>
                  </div>
                  <select class="custom-select" id="inputGroupSelect01">
                    <option selected></option>
                    <option value="1">Activos</option>
                    <option value="2">Desactivos</option>
                  </select>
                </div>
              </div>
              <a class="btn btn-primary btn-lg btn-block" href="/pdfgastos" role="button">Generar Reporte</a>
            </div>
            <div class="tab-pane fade" id="list-metas" role="tabpanel" aria-labelledby="list-metas-list">
              <h1>REPORTE METAS</h1>
              <div class="col-md-6">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">BUSCAR POR STATUS</label>
                  </div>
                  <select class="custom-select" id="inputGroupSelect01">
                    <option selected></option>
                    <option value="1">Activos</option>
                    <option value="2">Desactivos</option>
                  </select>
                </div>
              </div>
              <a class="btn btn-primary btn-lg btn-block" href="/pdfmetas" role="button">Generar Reporte</a>
            </div>
            <div class="tab-pane fade" id="list-rutas" role="tabpanel" aria-labelledby="list-rutas-list">
              <h1>REPORTE RUTAS</h1>
              <a class="btn btn-primary btn-lg btn-block" href="/pdfrutas" role="button">Generar Reporte</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('js')
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      md.initDashboardPageCharts();
    });
  </script>
{{--
    <script type="text/javascript">
        const user = @json($response);
        console.log(user);
    </script> --}}
@endpush
