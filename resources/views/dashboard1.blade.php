@extends('layouts.app1', ['activePage' => 'dashboard'])
<!-- Aqui se une el navar y sidebar y deja que modifiquemos la parte en blanco-->
@section('content')
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-4">
          <!-- Agregamos un grupo de botones para elegir el tipo de formato-->
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
            <a class="list-group-item list-group-item-action-primary" id="list-clientes-list" data-toggle="list" href="#list-clientes" role="tab" aria-controls="clientes">Reporte de Clientes</a>
            <a class="list-group-item list-group-item-action-primary" id="list-creditos-list" data-toggle="list" href="#list-creditos" role="tab" aria-controls="creditos">Reporte de Creditos</a>
          </div>
        </div>
        <!-- Muestra la opcion de reporte que se escoja y muestra las opciones de porte-->
        <div class="col-8">
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="list-repartidores" role="tabpanel" aria-labelledby="list-repartidores-list">
              <div>
              <h1>REPORTE REPARTIDORES</h1>
              <form method="post" action="pdfrepartidores">
                {{@csrf_field()}}
                <div class="container">
                  <div class="row">
                    <div class="col">
                  <label for="name">FECHA INICIAL</label>
                  <input type="date" id="picker" name="fechai" class="form-control">
                  <br>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <label class="input-group-text" for="inputGroupSelect01">BUSCAR POR STATUS</label>
                    </div>
                    <select class="form-control input" id="inputGroupSelect01" name="status">
                      <option selected></option>
                      <option value="1">Activos</option>
                      <option value="0">Desactivos</option>
                    </select>
                  </div>
                </div>
                <div class="col">
                  <label for="name">FECHA FINAL</label>
                  <input type="date" id="picker" name="fechaf" class="form-control">
                  <label for="name">BUSCAR POR ID</label>
                  <input type="text" class="form-control" id="name" name="id" />
                  <button type="submit" class="btn btn-primary btn-lg btn-block">GENERAR REPORTE</button>
                </div>
              </div>
                </div>
              </form>    
            </div>
          </div>
            
            <div class="tab-pane fade" id="list-proveedores" role="tabpanel" aria-labelledby="list-proveedores-list">
              <h1>REPORTE PROVEEDORES</h1>
              <form method="post" action="pdfproveedores">
                {{@csrf_field()}}
                <div class="container">
                  <div class="row">
                    <div class="col">
                  <label for="name">FECHA INICIAL</label>
                  <input type="date" id="picker" name="fechai" class="form-control">
                  <br>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <label class="input-group-text" for="inputGroupSelect01">BUSCAR POR STATUS</label>
                    </div>
                    <select class="form-control input" id="inputGroupSelect01" name="status">
                      <option selected></option>
                      <option value="1">Activos</option>
                      <option value="0">Desactivos</option>
                    </select>
                  </div>
                </div>
                <div class="col">
                  <label for="name">FECHA FINAL</label>
                  <input type="date" id="picker" name="fechaf" class="form-control">
                  <label for="name">BUSCAR POR ID</label>
                  <input type="text" class="form-control" id="name" name="id" />
                  <button type="submit" class="btn btn-primary btn-lg btn-block">GENERAR REPORTE</button>
                </div>
              </div>
                </div>
              </form>    
            </div>
        

            <div class="tab-pane fade" id="list-productos" role="tabpanel" aria-labelledby="list-productos-list">
              <h1>REPORTE PRODUCTOS</h1>
              <form method="post" action="pdfproductos">
                {{@csrf_field()}}
                <div class="container">
                  <div class="row">
                    <div class="col">
                  <label for="name">FECHA INICIAL</label>
                  <input type="date" id="picker" name="fechai" class="form-control">
                  <label for="name">BUSCAR POR ID DE UNIDAD</label>
                  <input type="text" class="form-control" id="name" name="idu" />
                  <br>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <label class="input-group-text" for="inputGroupSelect01">BUSCAR POR STATUS</label>
                    </div>
                    <select class="form-control input" id="inputGroupSelect01" name="status">
                      <option selected></option>
                      <option value="1">Activos</option>
                      <option value="0">Desactivos</option>
                    </select>
                  </div>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <label class="input-group-text" for="inputGroupSelect01">BUSCAR POR META</label>
                    </div>
                    <select class="form-control input" id="inputGroupSelect01" name="meta">
                      <option selected></option>
                      <option value="1">Activos</option>
                      <option value="0">Desactivos</option>
                    </select>
                  </div>
                </div>
                <div class="col">
                  <label for="name">FECHA FINAL</label>
                  <input type="date" id="picker" name="fechaf" class="form-control">
                  <label for="name">BUSCAR POR ID DE PROVEEDOR</label>
                  <input type="text" class="form-control" id="name" name="idp" />
                  <label for="name">BUSCAR POR NOMBRE</label>
                  <input type="text" class="form-control" id="name" name="nombre" />
                  <button type="submit" class="btn btn-primary btn-lg btn-block">GENERAR REPORTE</button>
                </div>
              </div>
                </div>
              </form>
            </div>

            <div class="tab-pane fade" id="list-entradas" role="tabpanel" aria-labelledby="list-entradas-list">
              <h1>REPORTE ENTRADAS</h1>
              <form method="post" action="pdfalmacen">
                {{@csrf_field()}}
                <div class="container">
                  <div class="row">
                    <div class="col">
                  <label for="name">FECHA INICIAL</label>
                  <input type="date" id="picker" name="fechai" class="form-control">
                </div>
                <div class="col">
                  <label for="name">FECHA FINAL</label>
                  <input type="date" id="picker" name="fechaf" class="form-control">
                  <label for="name">BUSCAR POR ID DEL PROVEEDOR</label>
                  <input type="text" class="form-control" id="name" name="id" />
                  <button type="submit" class="btn btn-primary btn-lg btn-block">GENERAR REPORTE</button>
                </div>
              </div>
                </div>
              </form>      
            </div>

            <div class="tab-pane fade" id="list-almacen" role="tabpanel" aria-labelledby="list-almacen-list">
              <h1>REPORTE ALMACEN</h1>
              <form method="post" action="pdfalmacen">
                {{@csrf_field()}}
                <div class="container">
                  <div class="row">
                    <div class="col">
                  <label for="name">FECHA INICIAL</label>
                  <input type="date" id="picker" name="fechai" class="form-control">
                </div>
                <div class="col">
                  <label for="name">FECHA FINAL</label>
                  <input type="date" id="picker" name="fechaf" class="form-control">
                  <label for="name">BUSCAR POR ID DEL REPARTIDOR</label>
                  <input type="text" class="form-control" id="name" name="id" />
                  <button type="submit" class="btn btn-primary btn-lg btn-block">GENERAR REPORTE</button>
                </div>
              </div>
                </div>
              </form>            
            </div>

            <div class="tab-pane fade" id="list-ventas" role="tabpanel" aria-labelledby="list-ventas-list">
              <h1>REPORTE VENTAS</h1>
              <form method="post" action="pdfventas">
                {{@csrf_field()}}
                <div class="container">
                  <div class="row">
                    <div class="col">
                  <label for="name">FECHA INICIAL</label>
                  <input type="date" id="picker" name="fechai" class="form-control">
                  <label for="name">BUSCAR POR ID DEL CLIENTE</label>
                  <input type="text" class="form-control" id="name" name="idcliente" />
                </div>
                <div class="col">
                  <label for="name">FECHA FINAL</label>
                  <input type="date" id="picker" name="fechaf" class="form-control">
                  <label for="name">BUSCAR POR ID DE LA RUTA</label>
                  <input type="text" class="form-control" id="name" name="idruta" />
                  <button type="submit" class="btn btn-primary btn-lg btn-block">GENERAR REPORTE</button>
                </div>
              </div>
                </div>
              </form>  
            </div>
            
              <div class="tab-pane fade" id="list-gastos" role="tabpanel" aria-labelledby="list-gastos-list">
              <h1>REPORTE GASTOS</h1>
              <form method="post" action="pdfgastos">
                {{@csrf_field()}}
                <div class="container">
                  <div class="row">
                    <div class="col">
                  <label for="name">FECHA INICIAL</label>
                  <input type="date" id="picker" name="fechai" class="form-control">
                  <br>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <label class="input-group-text" for="inputGroupSelect01">BUSCAR POR STATUS</label>
                    </div>
                    <select class="form-control input" id="inputGroupSelect01" name="status">
                      <option selected></option>
                      <option value="1">Activos</option>
                      <option value="0">Desactivos</option>
                    </select>
                  </div>
                </div>
                <div class="col">
                  <label for="name">FECHA FINAL</label>
                  <input type="date" id="picker" name="fechaf" class="form-control">
                  <label for="name">BUSCAR POR ID DEL REPARTIDOR</label>
                  <input type="text" class="form-control" id="name" name="id" />
                  <button type="submit" class="btn btn-primary btn-lg btn-block">GENERAR REPORTE</button>
                </div>
              </div>
                </div>
              </form>   
            </div>

            <div class="tab-pane fade" id="list-metas" role="tabpanel" aria-labelledby="list-metas-list">
              <h1>REPORTE METAS</h1>
              <form method="post" action="pdfmetas">
                {{@csrf_field()}}
                <div class="container">
                  <div class="row">
                    <div class="col">
                  <label for="name">FECHA INICIAL</label>
                  <input type="date" id="picker" name="fechai" class="form-control">
                  <br>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <label class="input-group-text" for="inputGroupSelect01">BUSCAR POR STATUS</label>
                    </div>
                    <select class="form-control input" id="inputGroupSelect01" name="status">
                      <option selected></option>
                      <option value="1">Activos</option>
                      <option value="0">Desactivos</option>
                    </select>
                  </div>
                </div>
                <div class="col">
                  <label for="name">FECHA FINAL</label>
                  <input type="date" id="picker" name="fechaf" class="form-control">
                  <label for="name">BUSCAR POR ID DEL REPARTIDOR</label>
                  <input type="text" class="form-control" id="name" name="id" />
                  <button type="submit" class="btn btn-primary btn-lg btn-block">GENERAR REPORTE</button>
                </div>
              </div>
                </div>
              </form>   
            </div>

            <div class="tab-pane fade" id="list-rutas" role="tabpanel" aria-labelledby="list-rutas-list">
              <h1>REPORTE RUTAS</h1>
              <a class="btn btn-primary btn-lg btn-block" href="/pdfrutas" role="button">Generar Reporte</a>
            </div>

            <div class="tab-pane fade" id="list-clientes" role="tabpanel" aria-labelledby="list-clientes-list">
              <h1>REPORTE CLIENTES</h1>
              <form method="post" action="pdfclientes">
                {{@csrf_field()}}
                <div class="container">
                  <div class="row">
                    <div class="col">
                  <label for="name">FECHA INICIAL</label>
                  <input type="date" id="picker" name="fechai" class="form-control">
                  <br>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <label class="input-group-text" for="inputGroupSelect01">BUSCAR POR STATUS</label>
                    </div>
                    <select class="form-control input" id="inputGroupSelect01" name="status">
                      <option selected></option>
                      <option value="1">Activos</option>
                      <option value="0">Desactivos</option>
                    </select>
                  </div>
                </div>
                <div class="col">
                  <label for="name">FECHA FINAL</label>
                  <input type="date" id="picker" name="fechaf" class="form-control">
                  <label for="name">BUSCAR POR ID DE LA RUTA</label>
                  <input type="text" class="form-control" id="name" name="id" />
                  <label for="name">BUSCAR POR NOMBRE</label>
                  <input type="text" class="form-control" id="name" name="nombre" />
                  <button type="submit" class="btn btn-primary btn-lg btn-block">GENERAR REPORTE</button>
                </div>
              </div>
                </div>
              </form>   
            </div>

            <div class="tab-pane fade" id="list-creditos" role="tabpanel" aria-labelledby="list-creditos-list">
              <h1>REPORTE CREDITOS</h1>
              <form method="post" action="pdfcreditos">
                {{@csrf_field()}}
                <div class="container">
                  <div class="row">
                    <div class="col">
                  <label for="name">FECHA INICIAL</label>
                  <input type="date" id="picker" name="fechai" class="form-control">
                  <br>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <label class="input-group-text" for="inputGroupSelect01">BUSCAR POR STATUS</label>
                    </div>
                    <select class="form-control input" id="inputGroupSelect01" name="status">
                      <option selected></option>
                      <option value="1">Activos</option>
                      <option value="0">Desactivos</option>
                    </select>
                  </div>
                </div>
                <div class="col">
                  <label for="name">FECHA FINAL</label>
                  <input type="date" id="picker" name="fechaf" class="form-control">
                  <label for="name">BUSCAR POR ID DEL CLIENTE</label>
                  <input type="text" class="form-control" id="name" name="id" />
                  <button type="submit" class="btn btn-primary btn-lg btn-block">GENERAR REPORTE</button>
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
