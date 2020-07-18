<?php
$fecha = date('Y-m-d');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TABLA DE REPARTIDORES</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
  <header>
    <br><h5 style="text-align: center"><strong>REPORTE DE REPARTIDORES</strong></h5><br>
    <p>FECHA DE CREACIÓN: <?= $fecha?></p>
    <p>FECHA INICIAL: <?= $fechai?> </p>
    <p>FECHA FINAL: <?= $fechaf?> </p>
  </header>

  @if (empty($fechai && $fechaf))
  <main>
    <table class="table table-striped text-center">
        <thead>
          <tr class="bg-warning">
            <th scope="col">#</th>
            <th scope="col">Nombre</th>
            <th scope="col">Apellido paterno</th>
            <th scope="col">Apellido materno</th>
            <th scope="col">Fecha de Nacimiento</th>
            <th scope="col">Fecha de Contratacion</th>
            <th scope="col">Telefono</th>
            <th scope="col">Email</th>
            <th scope="col">Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($deliverers as $deliverer)
          <tr>
              <th scope="row">{{ $deliverer->id }}</th>
              <td>{{ $deliverer->nombre }}</td>
              <td>{{ $deliverer->aPaterno }}</td>
              <td>{{ $deliverer->aMaterno }}</td>
              <td>{{ $deliverer->fecha_nacimiento }}</td>
              <td>{{ $deliverer->fecha_contratacion }}</td>
              <td>{{ $deliverer->telefono }}</td>
              <td>{{ $deliverer->email }}</td>
              <td>{{ $deliverer->status }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
  </main> 
  @elseif(!empty($fechai && $fechaf && $id))
  <main>
    <table class="table table-striped text-center">
        <thead>
          <tr class="bg-warning">
            <th scope="col">#</th>
            <th scope="col">Nombre</th>
            <th scope="col">Apellido paterno</th>
            <th scope="col">Apellido materno</th>
            <th scope="col">Fecha de Nacimiento</th>
            <th scope="col">Fecha de Contratacion</th>
            <th scope="col">Telefono</th>
            <th scope="col">Email</th>
            <th scope="col">Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($deliverers as $deliverer)
          <tr>
              <th scope="row">{{ $deliverer->id }}</th>
              <td>{{ $deliverer->nombre }}</td>
              <td>{{ $deliverer->aPaterno }}</td>
              <td>{{ $deliverer->aMaterno }}</td>
              <td>{{ $deliverer->fecha_nacimiento }}</td>
              <td>{{ $deliverer->fecha_contratacion }}</td>
              <td>{{ $deliverer->telefono }}</td>
              <td>{{ $deliverer->email }}</td>
              <td>{{ $deliverer->status }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
  </main> 
  @elseif(!empty($fechai && $fechaf))   
  <main>
    <table class="table table-striped text-center">
        <thead>
          <tr class="bg-warning">
            <th scope="col">#</th>
            <th scope="col">Nombre</th>
            <th scope="col">Apellido paterno</th>
            <th scope="col">Apellido materno</th>
            <th scope="col">Fecha de Nacimiento</th>
            <th scope="col">Fecha de Contratacion</th>
            <th scope="col">Telefono</th>
            <th scope="col">Email</th>
            <th scope="col">Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($deliverers as $deliverer)
          <tr>
              <th scope="row">{{ $deliverer->id }}</th>
              <td>{{ $deliverer->nombre }}</td>
              <td>{{ $deliverer->aPaterno }}</td>
              <td>{{ $deliverer->aMaterno }}</td>
              <td>{{ $deliverer->fecha_nacimiento }}</td>
              <td>{{ $deliverer->fecha_contratacion }}</td>
              <td>{{ $deliverer->telefono }}</td>
              <td>{{ $deliverer->email }}</td>
              <td>{{ $deliverer->status }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
  </main> 
  @endif 
      <script>
        function enviarTexto()
        {
          var texto=external
        }
      </script>
    </body>
</html>