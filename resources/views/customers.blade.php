<?php
$fecha = date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TABLA DE CLIENTES</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
  <header>
    <br><h5 style="text-align: center"><strong>REPORTE DE CLIENTES</strong></h5><br>
    <p>FECHA DE CREACIÓN: <?= $fecha?></p>
  </header>

      <main>
        <table class="table table-striped text-center">
            <thead>
              <tr class="bg-warning">
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Telefono</th>
                <th scope="col">Direccion</th>
                <th scope="col">Establecimiento</th>
                <th scope="col">Email</th>
                <th scope="col">Status</th>
                <th scope="col">Id de la ruta</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($customers as $customer)
              <tr>
                  <th scope="row">{{ $customer->id }}</th>
                  <td>{{ $customer->nombre }}</td>
                  <td>{{ $customer->telefono }}</td>
                  <td>{{ $customer->direccion }}</td>
                  <td>{{ $customer->establecimiento }}</td>
                  <td>{{ $customer->email }}</td>
                  <td>{{ $customer->status }}</td>
                  <td>{{ $customer->route_id }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
      </main>    
    </body>
</html>