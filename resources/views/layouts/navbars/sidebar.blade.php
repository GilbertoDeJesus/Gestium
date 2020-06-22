<div class="sidebar" data-color="white" data-background-color="danger" data-image="{{ asset('material') }}/img/sidebar-3.jpg">
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"
      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo">
    <a href="{{ route('home') }}" class="simple-text logo-normal">
      {{ __('Gestium') }}
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
        <li class="nav-item">
            <router-link to="/home" class="nav-link" title="Usuarios">
                <i class="material-icons">account_box</i>
                <p>Usuarios</p>
            </router-link>
          </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#customers" aria-expanded="true">
          {{-- <i><img style="width:25px" src="{{ asset('material') }}/img/laravel.svg"></i> --}}
          <i class="material-icons">supervised_user_circle</i>
          <p>{{ __('Clientes') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse" id="customers">
          <ul class="nav">
            <li class="nav-item">
                <router-link to="/customers" class="nav-link" title="Registro de clientes">
                    <i class="material-icons">folder_shared</i>
                    <p>Registros</p>
                </router-link>
            </li>
            <li class="nav-item">
                <router-link to="/credits" class="nav-link" title="Creditos">
                    <i class="material-icons">payment</i>
                    <p>Creditos</p>
                </router-link>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#products" aria-expanded="true">
          {{-- <i><img style="width:25px" src="{{ asset('material') }}/img/laravel.svg"></i> --}}
          <i class="material-icons">local_mall</i>
          <p>{{ __('Productos') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse" id="products">
          <ul class="nav">
            <li class="nav-item">
                <router-link to="/products" class="nav-link" title="Registro de productos">
                    <i class="material-icons">domain</i>
                    <p>Almacen</p>
                </router-link>
            </li>
            <li class="nav-item">
                <router-link to="/warehouse_movement" class="nav-link" title="Salidas">
                    <i class="material-icons">assignment_turned_in</i>
                    <p>Salidas</p>
                </router-link>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <router-link to="/providers" class="nav-link" title="Proveedores">
            <i class="material-icons">store_mall_directory</i>
            <p>Proveedores</p>
        </router-link>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#deliverer" aria-expanded="true">
          {{-- <i><img style="width:25px" src="{{ asset('material') }}/img/laravel.svg"></i> --}}
          <i class="material-icons">local_shipping</i>
          <p>{{ __('Repartidores') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse" id="deliverer">
          <ul class="nav">
            <li class="nav-item">
                <router-link to="/deliverers" class="nav-link" title="Registro de empleados">
                    <i class="material-icons">folder_shared</i>
                    <p>Registro de empleados</p>
                </router-link>
            </li>
            <li class="nav-item">
                <router-link to="/routes" class="nav-link" title="Rutas">
                    <i class="material-icons">directions</i>
                    <p>Rutas</p>
                </router-link>
            </li>
            <li class="nav-item">
                <router-link to="/about_compone" class="nav-link" title="Ventas">
                    <i class="material-icons">shopping_cart</i>
                    <p>Ventas</p>
                </router-link>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('logout') }}"
            onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
          <i class="material-icons">exit_to_app</i>
          <p>{{ __('Salir') }}</p>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
      </li>
    </ul>
  </div>
</div>
