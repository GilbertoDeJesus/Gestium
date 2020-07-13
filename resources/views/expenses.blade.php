<?php
$fecha = date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TABLA DE GASTO</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
  <header>
    <br><h5 style="text-align: center"><strong>REPORTE DE GASTOS</strong></h5><br>
    <p>FECHA DE CREACIÓN: <?= $fecha?></p>
  </header>

      <main>
        <table class="table table-striped text-center">
            <thead>
              <tr class="bg-warning">
                <th scope="col">#</th>
                <th scope="col">Id de Repartidor</th>
                <th scope="col">Descripcion</th>
                <th scope="col">Monto</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($expenses as $expense)
              <tr>
                  <th scope="row">{{ $expense->id }}</th>
                  <td>{{ $expense->deliverer_id }}</td>
                  <td>{{ $expense->descripcion }}</td>
                  <td>{{ $expense->monto }}</td>
                  <td>{{ $expense->status }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
      </main>    
    </body>
</html>