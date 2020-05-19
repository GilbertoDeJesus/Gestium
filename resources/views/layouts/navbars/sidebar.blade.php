<div class="sidebar" data-color="purple" data-background-color="white" data-image="{{ asset('material') }}/img/sidebar-3.jpg">
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
            <router-link to="/home" class="nav-link" title="Home">
                <i class="material-icons">home</i>
                <p>Home</p>
            </router-link>
          </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#laravelExample" aria-expanded="true">
          {{-- <i><img style="width:25px" src="{{ asset('material') }}/img/laravel.svg"></i> --}}
          <i class="material-icons">widgets</i>
          <p>{{ __('Dropdown Menu') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse" id="laravelExample">
          <ul class="nav">
            <li class="nav-item">
                <router-link to="/test_component" class="nav-link" title="Testing">
                    <i class="material-icons">extension</i>
                    <p>Testing</p>
                </router-link>
            </li>
            <li class="nav-item">
                <router-link to="/about_component" class="nav-link" title="About">
                    <i class="material-icons">content_paste</i>
                    <p>About</p>
                </router-link>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <router-link to="/example_component" class="nav-link" title="Example">
            <i class="material-icons">assignment</i>
            <p>Example</p>
        </router-link>
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
