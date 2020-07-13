<?php
$fecha = date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TABLA DE VENTAS</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
  <header>
    <br><h5 style="text-align: center"><strong>REPORTE DE VENTAS</strong></h5><br>
    <p>FECHA DE CREACIÓN: <?= $fecha?></p>
  </header>

      <main>
        <table class="table table-striped text-center">
            <thead>
              <tr class="bg-warning">
                <th scope="col">#</th>
                <th scope="col">Id de Repartidor</th>
                <th scope="col">Id de Cliente</th>
                <th scope="col">Fecha</th>
                <th scope="col">Monto</th>
                <th scope="col">Observacion</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($sales as $sale)
              <tr>
                  <th scope="row">{{ $sale->id }}</th>
                  <td>{{ $sale->deliverer_id }}</td>
                  <td>{{ $sale->customer_id }}</td>
                  <td>{{ $sale->fecha }}</td>
                  <td>{{ $sale->monto }}</td>
                  <td>{{ $sale->observacion }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
      </main>    
    </body>
</html>