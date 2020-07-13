<div class="sidebar" data-color="purple" data-background-color="black" data-image="{{ asset('material') }}/img/sidebar-4.jpg">
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"
      Tip 2: you can also add an image using data-image tag
      Este es el sidebar que se genera el vista de reportes para simular la vista de vuetify
  -->
  <div class="logo">
    <a href="{{ route('home') }}" class="simple-text logo-normal" style="padding: 3px 0px;">
        <i><img style="width: 80px; display: block; margin-left: auto; margin-right: auto; padding-bottom: 5px;" src="{{ asset('material') }}/img/iconoGestium.ico"></i>
      {{ __('Gestium') }}
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
        <li class="nav-item">
          <a href="{{ route('home') }}" class="nav-link">
            <i class="material-icons">account_box</i>
          {{ __('Usuarios') }}
        </a>
          </li>
      </li>
      <li class="nav-item">
        <a href="{{ route('reportes') }}" class="nav-link">
          <i class="material-icons">assignment</i>
        {{ __('Reportes') }}
      </a>
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
