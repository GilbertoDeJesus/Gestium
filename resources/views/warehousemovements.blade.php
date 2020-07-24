<?php
$fecha = date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TABLA DE ALMACEN</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
  <header>
    <br><h5 style="text-align: center"><strong>REPORTE DE ALMACEN</strong></h5><br>
    <p>FECHA DE CREACIÓN: <?= $fecha?></p>
  </header>

      <main>
        <table class="table table-striped text-center">
            <thead>
              <tr class="bg-warning">
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Precio de Venta</th>
                <th scope="col">Cantidad</th>
                <th scope="col">Tipo de Movimiento</th>
                <th scope="col">Fecha de salida</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($warehousemovements as $warehousemovement)
              <tr>
                  <th scope="row">{{ $warehousemovement->id }}</th>
                  <td>{{ $warehousemovement->nombre }}</td>
                  <td>{{ $warehousemovement->precio_venta }}</td>
                  <td>{{ $warehousemovement->cantidad }}</td>
                  <td>{{ $warehousemovement->tipoMovimiento }}</td>
                  <td>{{ $warehousemovement->fecha_salida }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
      </main>    
    </body>
</html>