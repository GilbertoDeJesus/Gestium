<?php
$fecha = date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TABLA DE PRODUCTOS</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
  <header>
    <br><h5 style="text-align: center"><strong>REPORTE DE PRODUCTOS</strong></h5><br>
    <p>FECHA DE CREACIÓN: <?= $fecha?></p>
  </header>

      <main>
        <table class="table table-striped text-center">
            <thead>
              <tr class="bg-warning">
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Meta</th>
                <th scope="col">Descripción</th>
                <th scope="col">Precio de Compra</th>
                <th scope="col">Precio de Venta</th>
                <th scope="col">Stock</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($products as $product)
              <tr>
                  <th scope="row">{{ $product->id }}</th>
                  <td>{{ $product->nombre }}</td>
                  <td>{{ $product->meta }}</td>
                  <td>{{ $product->descripcion }}</td>
                  <td>{{ $product->precio_compra }}</td>
                  <td>{{ $product->precio_venta }}</td>
                  <td>{{ $product->stock }}</td>}
                  <td>{{ $product->status }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
      </main>    
    </body>
</html>