<!-- Navbar de la pagina reportes-->
<nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-dark">
  <div class="container-fluid">
    <div class="navbar-wrapper">
      <a class="navbar-brand" href="{{ route('home') }}"> Aplicación de administración </a>
    </div>
    <div class="navbar-brand" style="color: #FFFFFF">
        <?php
            date_default_timezone_set('America/Mexico_City');
            echo date("d/m/Y");
        ?>
    </div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
        <span class="sr-only">Toggle navigation</span>
        <span class="navbar-toggler-icon icon-bar"></span>
        <span class="navbar-toggler-icon icon-bar"></span>
        <span class="navbar-toggler-icon icon-bar"></span>
    </button>
  </div>
</nav>
