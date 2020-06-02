@include('layouts.navbars.navs.guest')
<div class="wrapper wrapper-full-page" id="app">
    <div class="page-header login-page header-filter" filter-color="black" style="background: url('{{ asset('material') }}/img/coverlogin.png')no-repeat center fixed;background-repeat: no-repeat;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;align-items: center;" data-color="#FF5400">
    <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
    @yield('content')
  </div>
</div>
