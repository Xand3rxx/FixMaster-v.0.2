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
    <meta name="description"
        content="FixMaster is your best trusted one-call solution for a wide range of home maintenance, servicing and repair needs. Our well-trained & certified uniformed technicians are fully insured professionals with robust experience to provide home services to fully meet your needs with singular objective to make you totally relax while your repair requests are professionally handled." />
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

        button.dt-button,
        div.dt-button,
        a.dt-button,
        input.dt-button {
            font-size: inherit !important;
            color: #fff !important;
            background-color: #E97D1F !important;
            background: linear-gradient(to bottom, rgb(233 125 31) 0%, rgb(233 125 31) 100%);
            border-color: #E97D1F !important;
            display: inline-block !important;
            font-weight: 400 !important;
            text-align: center !important;
            vertical-align: middle !important;
            user-select: none !important;
            background-color: transparent !important;
            border: 1px solid transparent !important;
            padding: 0.46875rem 0.9375rem !important;
            font-size: 0.875rem !important;
            line-height: 1.5 !important;
            border-radius: 0.25rem !important;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out !important;
            line-height: 1.5 i !important;
            text-decoration: none;
            outline: none;
            text-overflow: ellipsis;
        }

        button.dt-button:hover,
        div.dt-button:hover,
        a.dt-button:hover,
        input.dt-button:hover {
            color: #fff !important;
            background-color: #E97D1F !important;
            background: linear-gradient(to bottom, rgb(233 125 31) 0%, rgb(233 125 31) 100%);
            border-color: #E97D1F !important;
        }

    </style>

    @include('layouts.partials._dashboard_sidebar')

    <div class="content ht-100v pd-0">
        @include('layouts.partials._dashboard_header')
        @yield('content')
        <div class="modal fade" id="modalDetails" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg wd-sm-650" role="document">
                <div class="modal-content">
                    <div class="modal-body pd-x-25 pd-sm-x-30 pd-t-40 pd-sm-t-20 pd-b-15 pd-sm-b-20">
                        <a href="" role="button" class="close pos-absolute t-15 r-15" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>

            {{-- <h6 class="text-center">Kindly rate and review to get a 10% loyalty reward</h6> --}}
            <form action="{{url('cse/submit_ratings', app()->getLocale())}}" method="POST" id="cse_form">
                @csrf
                <div class="row">
            <div class="col-md-12 col-lg-12 col-12">
                <div class="row">
                     <div class="col-md-4 col-lg-4 col-4">
                   <p id="user0" style="margin-top:20px;"></p>
                     </div>

                     <div class="col-md-8 col-lg-8 col-8">
                        <div class="tx-40 text-center" id="rate">
                            <i class="icon ion-md-star rat lh-0 tx-gray-300" data-number="1"></i>
                            {{-- <i class="icon ion-md-star lh-0 tx-orange"></i> --}}
                            <i class="icon ion-md-star rat lh-0 tx-gray-300" data-number="2"></i>
                            <i class="icon ion-md-star rat lh-0 tx-gray-300" data-number="3"></i>
                            <i class="icon ion-md-star rat lh-0 tx-gray-300" data-number="4"></i>
                            <i class="icon ion-md-star rat lh-0 tx-gray-300" data-number="5"></i>
                            <input type="hidden" name="star" id="star" readonly>
                            <input type="hidden" name="technician" id="technician_id" readonly>
                        </div>
                     </div>
                </div>


                <div class="row">
                    <div class="col-md-4 col-lg-4 col-4">
                  <p id="user1" style="margin-top:20px;"></p>
                    </div>

                    <div class="col-md-8 col-lg-8 col-8 pull-left">
                       <div class="tx-40 text-center" id="rates">
                           <i class="icon ion-md-star rats lh-0 tx-gray-300" data-int="1"></i>
                           <i class="icon ion-md-star rats lh-0 tx-gray-300" data-int="2"></i>
                           <i class="icon ion-md-star rats lh-0 tx-gray-300" data-int="3"></i>
                           <i class="icon ion-md-star rats lh-0 tx-gray-300" data-int="4"></i>
                           <i class="icon ion-md-star rats lh-0 tx-gray-300" data-int="5"></i>
                           <input type="hidden" name="star1" id="star1" readonly>
                           <input type="hidden" name="technician" id="qa_id" readonly>
                       </div>
                    </div>
               </div>

               <div class="row">
                <div class="col-md-4 col-lg-4 col-4">
              <p id="user2" style="margin-top:20px;"></p>
                </div>

                <div class="col-md-8 col-lg-8 col-8 pull-left">
                   <div class="tx-40 text-center" id="rated">
                       <i class="icon ion-md-star ratd lh-0 tx-gray-300" data-inte="1"></i>
                       <i class="icon ion-md-star ratd lh-0 tx-gray-300" data-inte="2"></i>
                       <i class="icon ion-md-star ratd lh-0 tx-gray-300" data-inte="3"></i>
                       <i class="icon ion-md-star ratd lh-0 tx-gray-300" data-inte="4"></i>
                       <i class="icon ion-md-star ratd lh-0 tx-gray-300" data-inte="5"></i>
                       <input type="hidden" name="star2" id="star2" readonly>
                       <input type="hidden" name="technician" id="client_id" readonly>
                   </div>
                </div>
           </div>
                    </div>

                        {{-- <div class="form-group col-md-12 col-lg-12">
                            <label>Leave a review</label>
                            <textarea name="review" class="form-control" rows="4"
                                placeholder=""></textarea>
                        </div> --}}
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                            Skip
                            </button>
                    </div>

                </div>
            </form>
                    </div><!-- modal-body -->
                </div><!-- modal-content -->
            </div><!-- modal-dialog -->
        </div><!-- modal -->
    </div>

    <script src="{{ asset('assets/dashboard/lib/jquery/jquery.min.js') }}"></script>
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
    <script src="{{ asset('assets/frontend/js/custom.js') }}"></script>
    <script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDeDLVAiaU13p2O0d3jfcPjscsbVsCQUzc&v=3.exp&libraries=places">
    </script>
    <script src="{{ asset('assets/dashboard/assets/js/48a9782e-3e2b-4055-a9bb-8a926a937e2c.js') }}"></script>

    @yield('scripts')
    @stack('scripts')

    @if (\Request::filled('results') && \Request::filled('users'))
        <script>
            console.log('{{\Request::get('results')}}');
            const data = @json(\Request::get('users'));
            console.log(data);
            $.each(data.users, function( key, value ) {
            //console.log();


            $.each(value.roles, function( key, res ) {
               if(res.name == "Technicians & Artisans"){
                $("#user0").html(value.account.first_name+" "+value.account.last_name+" "+"("+res.url+")");
                 $("#technician_id").val(value.account.user_id);
             }

             if(res.name == "Quality Assurance Manager"){
                $("#user1").html(value.account.first_name+" "+value.account.last_name+" "+"("+res.url+")");
                $("#qa_id").val(value.account.user_id);
             }

             if(res.name == "Ordinary Clients"){
                $("#user2").html(value.account.first_name+" "+value.account.last_name+" "+"("+res.url+")");
                $("#client_id").val(value.account.user_id);
             }
            //  else if(res.name == "Ordinary Clients"){

            //     $("#cse").html(value.account.first_name+" "+value.account.last_name+" "+"("+res.url+")");
            //     // $("#cse_id").val(value.account.user_id);
            //     // $("#cse_form").show();
            //     $("#modalDet").modal({show:true});
            //  }

            });

            });


                $('.rat').on('click', function(){
                $("#star").val(($(this).data('number')));
                $(this).parent().children().removeClass('tx-orange').addClass('tx-gray-300');
                $(this).prevUntil("#rate").removeClass('tx-gray-300').addClass('tx-orange');
                $(this).removeClass('tx-gray-300').addClass('tx-orange');
            });


            $('.rats').on('click', function(){
                $("#star1").val(($(this).data('int')));
                $("#aq_id").val(value.account.user_id);
                $(this).parent().children().removeClass('tx-orange').addClass('tx-gray-300');
                $(this).prevUntil("#rates").removeClass('tx-gray-300').addClass('tx-orange');
                $(this).removeClass('tx-gray-300').addClass('tx-orange');
            });

            $('.ratd').on('click', function(){
                $("#star2").val(($(this).data('inte')));
                $("#client_id").val(value.account.user_id);
                $(this).parent().children().removeClass('tx-orange').addClass('tx-gray-300');
                $(this).prevUntil("#rated").removeClass('tx-gray-300').addClass('tx-orange');
                $(this).removeClass('tx-gray-300').addClass('tx-orange');
            });

            $("#modalDetails").modal({show:true});
        //});
        </script>
    @endif

</body>

</html>
