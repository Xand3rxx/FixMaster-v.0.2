<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>@yield('title') | FixMaster.ng - We Fix, You Relax!</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  {{-- <meta name="Author" content="Anthony Joboy (Lagos, Nigeria)" />
    <meta name="Telephone" content="Tel: +234 903 554 7107" /> --}}
  <meta name="description" content="FixMaster is your best trusted one-call solution for a wide range of home maintenance, servicing and repair needs. Our well-trained & certified uniformed technicians are fully insured professionals with robust experience to provide home services to fully meet your needs with singular objective to make you totally relax while your repair requests are professionally handled." />
  <meta name="keywords" content="Home-fix, Home-improvement, Home-repairs, Cleaning-services, Modern" />
  <meta name="email" content="info@homefix.ng" />
  <meta name="website" content="https://www.fixmaster.com.ng" />
  <meta name="Version" content="v0.0.1" />

  <!-- Favicon -->
  <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/png" sizes="16x16">

  <!-- vendor css -->
  <link href="{{ asset('assets/dashboard/lib/fontawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/dashboard/lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">

  <!-- DashForge CSS -->
  <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/css/dashforge.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/css/dashforge.demo.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/css/dashforge.dashboard.css') }}">

  <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/datatables/dataTables.bs4.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/datatables/dataTables.bs4-custom.css') }}" />
  <link href="{{ asset('assets/dashboard/lib/select2/css/select2.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/dashboard/lib/prismjs/themes/prism-vs.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/client/css/jquery.datetimepicker.min.css') }}">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    @yield('css')

</head>

<body class="app-mail">
    <style>
      div.dt-buttons {
        margin-top: 1em;
        margin-left: 1.5em;
      }
    </style>

    @include('layouts.partials._dashboard_sidebar')
    {{-- @include('layouts.partials._qa_sidebar') --}}

    <div class="content ht-100v pd-0">
      @include('layouts.partials._dashboard_header')
      @yield('content')
    {{-- </div> --}}
    </div>

    <script src="{{ asset('assets/dashboard/lib/jquery/jquery.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/frontend/js/jquery-3.5.1.min.js') }}"></script> --}}
    <script src="{{ asset('assets/dashboard/lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/assets/js/dashforge.settings.js') }}"></script>
    <script src="{{ asset('assets/dashboard/assets/js/dashforge.js') }}"></script>
    <script src="{{ asset('assets/dashboard/assets/js/dashforge.aside.js') }}"></script>
    <script src="{{ asset('assets/dashboard/assets/js/dashforge.sampledata.js') }}"></script>
    <script src="{{ asset('assets/dashboard/lib/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/lib/cleave.js/cleave.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/lib/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/lib/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>

    <script src="{{ asset('assets/dashboard/lib/jquery.flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('assets/dashboard/lib/jquery.flot/jquery.flot.stack.js') }}"></script>
    <script src="{{ asset('assets/dashboard/lib/jquery.flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('assets/dashboard/lib/chart.js/Chart.bundle.min.js') }}"></script>

    <!-- append theme customizer -->
    <script src="{{ asset('assets/dashboard/lib/js-cookie/js.cookie.js') }}"></script>

    <script src="{{ asset('assets/dashboard/assets/datatables/dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/assets/datatables/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/lib/jquery-steps/build/jquery.steps.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/dashboard/assets/js/custom.js') }}"></script> --}}
    <script src="{{ asset('assets/client/js/sweetalert2.min.js') }}"></script>
    <input type="hidden" class="d-none" id="path_backEnd" value="{{ url('/') }}">

    <script src="{{ asset('assets/client/js/jquery.datetimepicker.full.min.js') }}"></script>
    <script src="{{ asset('assets/client/js/moment.js') }}"></script>

    <script src="{{ asset('assets/dashboard/assets/js/jquery.tinymce.min.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
    <script src="{{asset('assets/frontend/js/custom.js')}}"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDeDLVAiaU13p2O0d3jfcPjscsbVsCQUzc&v=3.exp&libraries=places"></script>
    <script src="{{asset('assets/frontend/js/geolocation.js')}}"></script>
    <script src="{{ asset('assets/dashboard/assets/js/48a9782e-3e2b-4055-a9bb-8a926a937e2c.js') }}"></script>

    @yield('scripts')
    @stack('scripts')

  </body>
</html>
