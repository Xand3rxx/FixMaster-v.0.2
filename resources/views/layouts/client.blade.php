<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

  <head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | FixMaster.ng - We Fix, You Relax!</title>
    <meta name="Author" content="Anthony Joboy (Lagos, Nigeria)" />
    <meta name="Telephone" content="Tel: +234 903 554 7107" />
    <meta name="description" content="FixMaster is your best trusted one-call solution for a wide range of home maintenance, servicing and repair needs. Our well-trained & certified uniformed technicians are fully insured professionals with robust experience to provide home services to fully meet your needs with singular objective to make you totally relax while your repair requests are professionally handled." />
    <meta name="keywords" content="Home-fix, Home-improvement, Home-repairs, Cleaning-services, Modern" />
    <meta name="email" content="info@fixmaster.com.ng" />
    <meta name="website" content="https://www.fixmaster.com.ng" />
    <meta name="Version" content="v0.0.1" />

    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/png" sizes="16x16">
    <!-- Bootstrap -->
    <link href="{{ asset('assets/client/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons -->
    <link href="{{ asset('assets/client/css/materialdesignicons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Slider -->
    <link rel="stylesheet" href="{{ asset('assets/client/css/owl.carousel.min.css') }}" />
    {{-- <link rel="stylesheet" href="{{ asset('assets/client/css/owl.theme.default.min.css') }}" /> --}}
    <!-- Main Css -->
    <link href="{{ asset('assets/client/css/style.css') }}" rel="stylesheet" type="text/css" id="theme-opt" />
    <link href="{{ asset('assets/client/css/colors/default.css') }}" rel="stylesheet" id="color-opt">
    <link rel="stylesheet" href="{{ asset('assets/client/css/jquery.datetimepicker.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/client/datatables/dataTables.bs4.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/client/datatables/dataTables.bs4-custom.css') }}" />
    <link href="{{ asset('assets/client/css/magnific-popup.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/client/css/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.9/css/unicons.css">

    <style>
      .card {
        /* border: 1px solid rgba(233,125,31,0.2) !important; */
        box-shadow: 0 2px 5px rgba(233, 125, 31, 0.2) !important;
      }

      .shadow {
        box-shadow: 0 2px 5px rgba(233, 125, 31, 0.2) !important;
      }
    </style>
  </head>

  <body>

    <div id="preloader">
      <div id="status">
          <div class="spinner">
              <div class="double-bounce1"></div>
              <div class="double-bounce2"></div>
          </div>
      </div>
  </div>

    @include('layouts.partials._messages')
    @include('layouts.partials._client_header')
    @include('layouts.partials._client_sidebar')
    @include('layouts.partials._client_footer')


    <script src="{{asset('assets/frontend/js/jquery-3.5.1.min.js')}}"></script>
    {{-- <script src="{{asset('assets/client/js/jquery.min.js')}}"></script> --}}
    <script src="{{asset('assets/frontend/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/frontend/js/jquery.easing.min.js')}}"></script>
    <script src="{{asset('assets/frontend/js/scrollspy.min.js')}}"></script>
    <!-- SLIDER -->
    <script src="{{asset('assets/frontend/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('assets/frontend/js/owl.init.js')}}"></script>
    <!-- Icons -->
    <script src="{{asset('assets/frontend/js/feather.min.js')}}"></script>
    <!-- Switcher -->
    <script src="{{asset('assets/frontend/js/switcher.js')}}"></script>
    <!-- Main Js -->
    <script src="{{asset('assets/frontend/js/app.js')}}"></script>
    <!-- scroll -->
    <script src="{{ asset('assets/frontend/js/scroll.js')}}"></script>
    <script src="{{ asset('assets/frontend/js/typed/lib/typed.js')}}"></script>
    <script src="{{ asset('assets/client/datatables/dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/client/datatables/dataTables.bootstrap.min.js') }}"></script>
    <!-- Datepicker -->
    <script src="{{ asset('assets/client/js/jquery.datetimepicker.full.min.js') }}"></script>
    <script src="{{ asset('assets/client/js/moment.js') }}"></script>
    <script src="{{ asset('assets/client/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/client/js/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/client/js/polyfill.js') }}"></script>
    <script src="https://unicons.iconscout.com/release/v2.1.9/script/monochrome/bundle.js"></script>
    <script src="{{ asset('assets/client/js/sweetalert2.min.js') }}"></script>

    <script src="{{ asset('assets/dashboard/assets/js/jquery.tinymce.min.js') }}"></script>
    
    <script>
      tinymce.init({
        selector: '#message_body',
        height: 200,
        theme: 'modern',
        plugins: [
          'advlist autolink lists charmap hr anchor pagebreak',
          'searchreplace wordcount visualblocks visualchars',
          'insertdatetime nonbreaking save table contextmenu directionality',
          'emoticons paste textcolor colorpicker textpattern'
        ],
        toolbar1: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent',
        toolbar2: 'forecolor backcolor emoticons',
        image_advtab: true
      });
    </script>


    <script>
        function displayMessage(message, type){
      
          const Toast = swal.mixin({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 8000,
              timerProgressBar: true,
              didOpen: (toast) => {
                  toast.addEventListener('mouseenter', Swal.stopTimer)
                  toast.addEventListener('mouseleave', Swal.resumeTimer)
              }
          });
          Toast.fire({
                  icon: type,
                //   type: 'success',
                  title: message
          });
      
        }
    </script>
 
 @yield('scripts')
 @stack('scripts')

    <script>
      $(document).ready(function () {

        // Basic DataTable
        $('#basicExample').DataTable({
          'iDisplayLength': 10,
          language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthMenu: '_MENU_ Items/page',
              }
        });


        //Prevent characters or string asides number in ohone number input field 
        $("#number, #phone_number, #alternate_phone_number").on("keypress keyup blur", function(event) {
            $(this).val($(this).val().replace(/[^\d].+/, ""));
            if ((event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });  

        // Url for more info on datepicker options https://xdsoft.net/jqplugins/datetimepicker/
        $(document).on('click', '#service-date-time', function(){
          $('#service-date-time').datetimepicker({
              // format: 'L', //LT for time only
              // inline: true,
              // sideBySide: true,
              format:'Y/m/d H:i',
              formatDate:'Y/m/d',
              minDate:'-1970/01/02', // yesterday is minimum date
              mask: true,
          });
        });


        $('#customRadio1').change(function () {
            if ($(this).prop('checked')) {
                $('.display-phone').addClass('d-none');    
            }else {
                $('.display-phone').removeClass('d-none');            
            }
        });

        $('#customRadio2').change(function () {
            if ($(this).prop('checked')) {
                $('.display-phone').removeClass('d-none');    
            }
        });

        $('#customRadio3').change(function () {
            if ($(this).prop('checked')) {
                $('.display-address').addClass('d-none');    
            }else {
                $('.display-address').removeClass('d-none');            
            }
        });

        $('#customRadio4').change(function () {
            if ($(this).prop('checked')) {
                $('.display-address').removeClass('d-none');    
            }
        });

        $('#customRadio33').change(function () {
            if ($(this).prop('checked')) {
                $('.add-card').addClass('d-none');    
            }else {
                $('.add-card').removeClass('d-none');            
            }
        });

        $('#customRadio34').change(function () {
            if ($(this).prop('checked')) {
                $('.add-card').removeClass('d-none');    
            }
        });

      //   $('.video-play-icon').magnificPopup({
      //     disableOn: 375,
      //     type: 'iframe',
      //     mainClass: 'mfp-fade',
      //     removalDelay: 160,
      //     preloader: false,
      //     fixedContentPos: false,
      // });

      $(function () {
        $('.popup-modal').magnificPopup({
          type: 'inline',
          preloader: false,
          focus: '#username',
          modal: true
        });
        $(document).on('click', '.popup-modal-dismiss', function (e) {
          e.preventDefault();
          $.magnificPopup.close();
        });
      });

      // $('.urgent').click(function(){
      //   alert('Urgent Service Required');

      // })

      
      
      });
    </script>
   

  </body>
</html>
