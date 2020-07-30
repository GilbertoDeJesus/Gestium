@extends('layouts.app1', ['activePage' => 'dashboard'])
<!-- Aqui se une el navar y sidebar y deja que modifiquemos la parte en blanco-->
@section('content')
<script type="application/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="application/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="application/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-12 ">
          <!-- Agregamos un grupo de botones para elegir el tipo de formato-->
          <div class="list-group" id="list-tab" role="tablist">
            <a class="list-group-item list-group-item-action active" id="list-repartidores-list" data-toggle="list" href="#list-repartidores" role="tab" aria-controls="repartidores">Reporte de Repartidores</a>
            <a class="list-group-item list-group-item-action" id="list-proveedores-list" data-toggle="list" href="#list-proveedores" role="tab" aria-controls="proveedores" style="border-top-width: 1px;">Reporte de Proveedores</a>
            <a class="list-group-item list-group-item-action" id="list-productos-list" data-toggle="list" href="#list-productos" role="tab" aria-controls="productos" style="border-top-width: 1px;">Reporte de Productos</a>
            <a class="list-group-item list-group-item-action" id="list-entradas-list" data-toggle="list" href="#list-entradas" role="tab" aria-controls="entradas" style="border-top-width: 1px;">Reporte de Entradas</a>
            <a class="list-group-item list-group-item-action" id="list-almacen-list" data-toggle="list" href="#list-almacen" role="tab" aria-controls="almacen" style="border-top-width: 1px;">Reporte de Salidas</a>
            <a class="list-group-item list-group-item-action" id="list-ventas-list" data-toggle="list" href="#list-ventas" role="tab" aria-controls="ventas" style="border-top-width: 1px;">Reporte de Ventas</a>
            <a class="list-group-item list-group-item-action" id="list-rutas-list" data-toggle="list" href="#list-rutas" role="tab" aria-controls="rutas" style="border-top-width: 1px;">Reporte de Rutas</a>
            <a class="list-group-item list-group-item-action" id="list-clientes-list" data-toggle="list" href="#list-clientes" role="tab" aria-controls="clientes" style="border-top-width: 1px;">Reporte de Clientes</a>
            <a class="list-group-item list-group-item-action" id="list-creditos-list" data-toggle="list" href="#list-creditos" role="tab" aria-controls="creditos" style="border-top-width: 1px;">Reporte de Creditos</a>
          </div>
        </div>
        <!-- Muestra la opcion de reporte que se escoja y muestra las opciones de porte-->
        <div class="col-lg-9 col-md-8 col-sm-12">
          <div class="tab-content shadow p-3 mb-5 bg-white rounded" id="nav-tabContent" style="border-left: 5px solid #ff4500;">
            <div class="tab-pane fade show active" id="list-repartidores" role="tabpanel" aria-labelledby="list-repartidores-list">
              <div>
              <h1 style="color: #00000099;">REPORTE DE REPARTIDORES</h1>
              <form method="post" method="get" action="pdfrepartidores" target="somewhere_new">
                {{@csrf_field()}}
                <div class="container">
                  <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                  <label for="name">FECHA INICIAL</label>
                  <input type="date" id="picker" name="fechai" class="form-control">
                  <label for="name">BUSCAR POR STATUS</label>
                  <select name="status" id="input" class="form-control">
                      <option value="" selected>-- Seleccione un status --</option>
                      <option value="1">Activos</option>
                      <option [ngValue]="0">Inactivos</option>
                  </select>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                  <label for="name">FECHA FINAL</label>
                  <input type="date" id="picker" name="fechaf" class="form-control">
                  <label for="name">BUSCAR POR NOMBRE</label>
                  <select name="id" id="input" class="form-control">
                    <option value="" selected>-- Seleccione un nombre --</option>
                    @foreach ($deliverers as $item)
                      <option value="{{$item['id']}}">{{ $item['nombre']}}</option>
                    @endforeach
                  </select>
                  <button type="submit" class="btn router-link-exact-active btn-lg btn-block">GENERAR REPORTE</button>
                </div>
              </div>
                </div>
              </form>
            </div>
          </div>

            <div class="tab-pane fade" id="list-proveedores" role="tabpanel" aria-labelledby="list-proveedores-list">
              <h1 style="color: #00000099;">REPORTE DE PROVEEDORES</h1>
              <form method="post" action="pdfproveedores" target="somewhere_new">
                {{@csrf_field()}}
                <div class="container">
                  <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                  <label for="name">FECHA INICIAL</label>
                  <input type="date" id="picker" name="fechai" class="form-control">
                  <label for="name">BUSCAR POR STATUS</label>
                  <select name="status" id="input" class="form-control">
                      <option value="" selected>-- Seleccione un status --</option>
                      <option value="1">Activos</option>
                      <option [ngValue]="0">Inactivos</option>
                  </select>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                  <label for="name">FECHA FINAL</label>
                  <input type="date" id="picker" name="fechaf" class="form-control">
                  <label for="name">BUSCAR POR NOMBRE</label>
                  <select name="id" id="input" class="form-control">
                    <option value="" selected>-- Seleccione un nombre --</option>
                    @foreach ($provider as $item)
                      <option value="{{$item['id']}}">{{ $item['nombre']}}</option>
                    @endforeach
                  </select>
                  <button type="submit" class="btn router-link-exact-active btn-lg btn-block">GENERAR REPORTE</button>
                </div>
              </div>
                </div>
              </form>
            </div>


            <div class="tab-pane fade" id="list-productos" role="tabpanel" aria-labelledby="list-productos-list">
              <h1 style="color: #00000099;">REPORTE DE PRODUCTOS</h1>
              <form method="post" action="pdfproductos" target="somewhere_new">
                {{@csrf_field()}}
                <div class="container">
                  <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                  <label for="name">FECHA INICIAL</label>
                  <input type="date" id="picker" name="fechai" class="form-control">
                  <label for="name">BUSCAR POR NOMBRE</label>
                  <select name="id" id="input" class="form-control">
                    <option value="" selected>-- Seleccione un nombre --</option>
                    @foreach ($product as $item)
                      <option value="{{$item['id']}}">{{ $item['nombre']}}</option>
                    @endforeach
                  </select>
                  <label for="name">BUSCAR POR META</label>
                  <select name="meta" id="input" class="form-control">
                    <option value="" selected>-- Elija una opcion --</option>
                    <option value="1">Activos</option>
                    <option [ngValue]="0">Inactivos</option>
                </select>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                  <label for="name">FECHA FINAL</label>
                  <input type="date" id="picker" name="fechaf" class="form-control">
                  <label for="name">BUSCAR POR PROVEEDOR</label>
                  <select name="idp" id="input" class="form-control">
                    <option value="" selected>-- Escoja un Proveedor--</option>
                    @foreach ($provider as $item)
                      <option value="{{$item['id']}}">{{ $item['nombre']}}</option>
                    @endforeach
                  </select>
                  <button type="submit" class="btn router-link-exact-active btn-lg btn-block">GENERAR REPORTE</button>
                </div>
              </div>
                </div>
              </form>
            </div>

            <div class="tab-pane fade" id="list-entradas" role="tabpanel" aria-labelledby="list-entradas-list">
              <h1 style="color: #00000099;">REPORTE DE ENTRADAS</h1>
              <form method="post" action="pdfentradas" target="somewhere_new">
                {{@csrf_field()}}
                <div class="container">
                  <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                  <label for="name">FECHA INICIAL</label>
                  <input type="date" id="picker" name="fechai" class="form-control">
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                  <label for="name">FECHA FINAL</label>
                  <input type="date" id="picker" name="fechaf" class="form-control">
                  <label for="name">BUSCAR POR PROVEEDOR</label>
                  <select name="id" id="input" class="form-control">
                    <option value="" selected>-- Escoja un Proveedor--</option>
                    @foreach ($provider as $item)
                      <option value="{{$item['id']}}">{{ $item['nombre']}}</option>
                    @endforeach
                  </select>
                  <button type="submit" class="btn router-link-exact-active btn-lg btn-block">GENERAR REPORTE</button>
                </div>
              </div>
                </div>
              </form>
            </div>

            <div class="tab-pane fade" id="list-almacen" role="tabpanel" aria-labelledby="list-almacen-list">
              <h1 style="color: #00000099;">REPORTE DE SALIDAS</h1>
              <form method="post" action="pdfalmacen" target="somewhere_new">
                {{@csrf_field()}}
                <div class="container">
                  <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                  <label for="name">FECHA INICIAL</label>
                  <input type="date" id="picker" name="fechai" class="form-control">
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                  <label for="name">FECHA FINAL</label>
                  <input type="date" id="picker" name="fechaf" class="form-control">
                  <label for="name">BUSCAR POR REPARTIDOR</label>
                  <select name="id" id="input" class="form-control">
                    <option value="" selected>-- Escoja un Proveedor--</option>
                    @foreach ($deliverers as $item)
                      <option value="{{$item['id']}}">{{ $item['nombre']}}</option>
                    @endforeach
                  </select>
                  <button type="submit" class="btn router-link-exact-active btn-lg btn-block">GENERAR REPORTE</button>
                </div>
              </div>
                </div>
              </form>
            </div>

            <div class="tab-pane fade" id="list-ventas" role="tabpanel" aria-labelledby="list-ventas-list">
              <h1 style="color: #00000099;">REPORTE DE VENTAS</h1>
              <form method="post" action="pdfventas" target="somewhere_new">
                {{@csrf_field()}}
                <div class="container">
                  <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                  <label for="name">FECHA INICIAL</label>
                  <input type="date" id="picker" name="fechai" class="form-control">
                  <label for="name">BUSCAR POR CLIENTE</label>
                  <select name="id" id="input" class="form-control">
                    <option value="" selected>-- Escoja un Cliente--</option>
                    @foreach ($customer as $item)
                      <option value="{{$item['id']}}">{{ $item['nombre']}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                  <label for="name">FECHA FINAL</label>
                  <input type="date" id="picker" name="fechaf" class="form-control">
                  <button type="submit" class="btn router-link-exact-active btn-lg btn-block">GENERAR REPORTE</button>
                </div>
              </div>
                </div>
              </form>
            </div>

            <div class="tab-pane fade" id="list-rutas" role="tabpanel" aria-labelledby="list-rutas-list">
              <h1 style="color: #00000099;">REPORTE DE RUTAS</h1>
              <form method="post" action="pdfrutas" target="somewhere_new">
                {{@csrf_field()}}
                <div class="container">
                  <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                  <label for="name">FECHA INICIAL</label>
                  <input type="date" id="picker" name="fechai" class="form-control">
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                  <label for="name">FECHA FINAL</label>
                  <input type="date" id="picker" name="fechaf" class="form-control">
                  <button type="submit" class="btn router-link-exact-active btn-lg btn-block">GENERAR REPORTE</button>
                </div>
              </div>
                </div>
              </form>
           </div>

            <div class="tab-pane fade" id="list-clientes" role="tabpanel" aria-labelledby="list-clientes-list">
              <h1 style="color: #00000099;">REPORTE DE CLIENTES</h1>
              <form method="post" action="pdfclientes" target="somewhere_new">
                {{@csrf_field()}}
                <div class="container">
                  <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                  <label for="name">FECHA INICIAL</label>
                  <input type="date" id="picker" name="fechai" class="form-control">
                  <label for="name">BUSCAR POR STATUS</label>
                  <select name="status" id="input" class="form-control">
                      <option value="" selected>-- Inserte un status --</option>
                      <option value="1">Activos</option>
                      <option [ngValue]="0">Inactivos</option>
                  </select>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                  <label for="name">FECHA FINAL</label>
                  <input type="date" id="picker" name="fechaf" class="form-control">
                  <label for="name">BUSCAR POR RUTA</label>
                  <select name="id" id="input" class="form-control">
                    <option value="" selected>-- Escoja una Ruta--</option>
                    @foreach ($route as $item)
                      <option value="{{$item['id']}}">{{ $item['municipio']}}</option>
                    @endforeach
                  </select> 
                  <label for="name">BUSCAR POR NOMBRE</label>
                  <select name="nombre" id="input" class="form-control">
                    <option value="" selected>-- Escoja un Cliente--</option>
                    @foreach ($customer as $item)
                      <option value="{{$item['nombre']}}">{{ $item['nombre']}}</option>
                    @endforeach
                  </select>
                  <button type="submit" class="btn router-link-exact-active btn-lg btn-block">GENERAR REPORTE</button>
                </div>
              </div>
                </div>
              </form>
            </div>

            <div class="tab-pane fade" id="list-creditos" role="tabpanel" aria-labelledby="list-creditos-list">
              <h1 style="color: #00000099;">REPORTE DE CREDITOS</h1>
              <form method="post" action="pdfcreditos" target="somewhere_new">
                {{@csrf_field()}}
                <div class="container">
                  <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                  <label for="name">FECHA INICIAL</label>
                  <input type="date" id="picker" name="fechai" class="form-control">
                  <label for="name">BUSCAR POR STATUS</label>
                  <select name="status" id="input" class="form-control">
                      <option value="" selected>-- Inserte un status --</option>
                      <option value="1">Activos</option>
                      <option [ngValue]="0">Inactivos</option>
                  </select>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                  <label for="name">FECHA FINAL</label>
                  <input type="date" id="picker" name="fechaf" class="form-control">
                  <label for="name">BUSCAR POR CLIENTE</label>
                  <select name="id" id="input" class="form-control">
                    <option value="" selected>-- Escoja un Cliente--</option>
                    @foreach ($customer as $item)
                      <option value="{{$item['id']}}">{{ $item['nombre']}}</option>
                    @endforeach
                  </select>
                  <button type="submit" class="btn router-link-exact-active btn-lg btn-block">GENERAR REPORTE</button>
                </div>
              </div>
                </div>
              </form>
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
