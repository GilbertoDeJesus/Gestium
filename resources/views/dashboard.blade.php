@extends('layouts.app', ['activePage' => 'dashboard'])

@section('content')
  <div class="content">
    <div class="container-fluid">
        <router-view></router-view>
    </div>
  </div>
@endsection

@push('js')
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      md.initDashboardPageCharts();
    });
  </script>
{{--
    <script type="text/javascript">
        const user = @json($response);
        console.log(user);
    </script> --}}
@endpush
