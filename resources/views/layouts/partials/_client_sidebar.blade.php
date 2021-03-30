<!-- Profile Start -->
<section class="section mt-60">
    <div class="container mt-lg-3">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-12 d-lg-block d-none">
                <div class="sidebar sticky-bar p-4 rounded shadow">
                    <h5 class="widget-title">E-Wallet: <strong>WAL-23782382</strong></h5>
                    <div class="widget">
                        <div class="row mt-4  text-center">
                            <div class="card event-schedule rounded border">
                                <div class="card-body event-width">
                                    <div class="media">
                                        {{-- <ul class="date text-center text-primary mr-3 mb-0 list-unstyled">
                                        <li class="day font-weight-bold mb-2">{{ date('d') }}</li>
                                            <li class="month font-weight-bold">{{ date('M') }}</li>
                                            <li class="month font-weight-bold">{{ date('Y') }}</li>
                                        </ul> --}}

                                        <div class="media-body content">
                                            <h4><a href="javascript:void(0)" class="text-dark title">Balance</a></h4>
                                        <p class="text-muted location-time"><span class="text-dark h6">₦{{ $myWallet[0]['closing_balance'] ?? number_format(0) }}</span></p>
                                            <a href="#" class="btn btn-sm btn-outline-primary mouse-down">Fund Account</a>
                                        </div>
                                    </div>
                                    <div class="mt-1">
                                        <small>Last Login: <br>
                                            <strong>January 18th 2021, 11:19:56am</strong>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="widget mt-4 pt-2">
                        <h5 class="widget-title">Profile :</h5>
                    </div>

                    <div class="widget">
                        <div class="row">
                            <div class="col-6 mt-4 pt-2">
                            <a href="{{ route('client.index', app()->getLocale()) }}" class="accounts rounded d-block shadow text-center py-3 {{ Route::currentRouteNamed('client.index') ? 'active' : '' }}">
                                    <span class="pro-icons h3 text-muted"><i class="uil uil-user"></i></span>
                                    <h6 class="title text-dark h6 my-0">Dashboard</h6>
                                </a>
                            </div><!--end col-->

                            <div class="col-6 mt-4 pt-2">
                            <a href="{{ route('client.services.list', app()->getLocale()) }}" class="accounts rounded d-block shadow text-center py-3 {{ Route::currentRouteNamed('client.services.list', 'client.services.details', 'client.services.quote') ? 'active' : '' }}">
                                    <span class="pro-icons h3 text-muted"><i class="uil uil-calendar-alt"></i></span>
                                    <h6 class="title text-dark h6 my-0">Book a Service</h6>
                                </a>
                            </div><!--end col-->
                            <div class="col-6 mt-4 pt-2">
                                <a href="#" class="accounts rounded d-block shadow text-center py-3 {{ Route::currentRouteNamed('') ? 'active' : '' }}">
                                    <span class="pro-icons h3 text-muted"><i class="uil uil-chart"></i></span>
                                    <h6 class="title text-dark h6 my-0">Requests</h6>
                                </a>
                            </div><!--end col-->

                            <div class="col-6 mt-4 pt-2">
                            <a href="{{ route('client.wallet', app()->getLocale()) }}" class="accounts rounded d-block shadow text-center py-3 {{ Route::currentRouteNamed('client.wallet') ? 'active' : '' }}">
                                    <span class="pro-icons h3 text-muted"><i class="uil uil-file"></i></span>
                                    <h6 class="title text-dark h6 my-0">E-Wallet</h6>
                                </a>
                            </div><!--end col-->

                            <div class="col-6 mt-4 pt-2">
                            <a href="#" class="accounts rounded d-block shadow text-center py-3 {{ Route::currentRouteNamed('') ? 'active' : '' }}">
                                    <span class="pro-icons h3 text-muted"><i class="uil uil-envelope-star text-danger" data-toggle="tooltip" title="You have 0 unread messages"></i></span>
                                    <h6 class="title text-dark h6 my-0">Messages</h6>
                                </a>
                            </div><!--end col-->

                            <div class="col-6 mt-4 pt-2">
                            <a href="#" class="accounts rounded d-block shadow text-center py-3 {{ Route::currentRouteNamed('') ? 'active' : '' }}">
                                    <span class="pro-icons h3 text-muted"><i class="uil uil-transaction"></i></span>
                                    <h6 class="title text-dark h6 my-0">Payments</h6>
                                </a>
                            </div><!--end col-->

                            <div class="col-6 mt-4 pt-2">
                            <a href="#" class="accounts rounded d-block shadow text-center py-3 {{ Route::currentRouteNamed('') ? 'active' : '' }}">
                                    <span class="pro-icons h3 text-muted"><i class="uil uil-setting"></i></span>
                                    <h6 class="title text-dark h6 my-0">Settings</h6>
                                </a>
                            </div><!--end col-->

                            <div class="col-6 mt-4 pt-2">
                            <a href="#" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();" href="{{ route('logout', app()->getLocale()) }}" class="accounts rounded d-block shadow text-center py-3">
                                    <span class="pro-icons h3 text-muted"><i class="uil uil-sign-out-alt"></i></span>
                                    <h6 class="title text-dark h6 my-0">Logout</h6>
                                </a>

                                {{-- <form id="logout-form" action="{{ route('logout', app()->getLocale()) }}" method="POST" style="display: none;">
                                    @csrf
                                </form> --}}
                            </div><!--end col-->
                        </div><!--end row-->
                    </div>

                </div>
            </div><!--end col-->

            @yield('content')
            <button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#modalDet">Open
                Modal</button>

            <div class="modal fade" id="modalDet" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg wd-sm-650" role="document">
                    <div class="modal-content">
                        <div class="modal-body pd-x-25 pd-sm-x-30 pd-t-40 pd-sm-t-20 pd-b-15 pd-sm-b-20">
                            <a href="" role="button" class="close pos-absolute t-15 r-15" data-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </a>

            <h6 class="text-center">Kindly rate and review to get a 10% loyalty reward</h6>
                <form action="" method="POST" id="cse_form">
                    @csrf
                    <div class="row">
                <div class="col-md-12 col-lg-12 col-12">
                    <div class="row">
                         <div class="col-md-4 col-lg-4 col-4">
                       <p id="cse" style="margin-top:20px;"></p>
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
                                <input type="hidden" name="cse_id" id="cse_id" readonly>
                            </div>
                         </div>
                    </div>


                    <div class="row">
                        <div class="col-md-4 col-lg-4 col-4">
                      <p style="margin-top:20px;">CSE Job Diagnosis</p>
                        </div>

                        <div class="col-md-8 col-lg-8 col-8 pull-left">
                           <div class="tx-40 text-center" id="rates">
                               <i class="icon ion-md-star rats lh-0 tx-gray-300" data-int="1"></i>
                               <i class="icon ion-md-star rats lh-0 tx-gray-300" data-int="2"></i>
                               <i class="icon ion-md-star rats lh-0 tx-gray-300" data-int="3"></i>
                               <i class="icon ion-md-star rats lh-0 tx-gray-300" data-int="4"></i>
                               <i class="icon ion-md-star rats lh-0 tx-gray-300" data-int="5"></i>
                               <input type="hidden" name="star1" id="star1" readonly>
                           </div>
                        </div>
                   </div>
                        </div>

                            <div class="form-group col-md-12 col-lg-12">
                                <label>Leave a review</label>
                                <textarea name="review" class="form-control" rows="4"
                                    placeholder=""></textarea>
                            </div>
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
        </div><!--end row-->
    </div><!--end container-->
</section><!--end section-->
<!-- Profile End -->
@yield('scripts')
 @stack('scripts')

 @if (\Request::filled('results') && \Request::filled('users'))
 <script>
     console.log('{{\Request::get('results')}}');
     const data = @json(\Request::get('users'));
     $.each(data.users, function( key, value ) {
     //console.log(value.roles);
     //console.log(value.account.first_name+" "+value.account.last_name); // get the user name
     $.each(value.roles, function( key, res ) {
      if(res.name == "Ordinary Clients"){
         $("#cse").html(value.account.first_name+" "+value.account.last_name+" "+"("+res.url+")");
         $("#cse_id").val(value.account.user_id);
         $("#cse_form").show();
         $("#modalDet").modal({show:true});
      }

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
         $(this).parent().children().removeClass('tx-orange').addClass('tx-gray-300');
         $(this).prevUntil("#rates").removeClass('tx-gray-300').addClass('tx-orange');
         $(this).removeClass('tx-gray-300').addClass('tx-orange');
     });
 //});
 </script>
@endif
