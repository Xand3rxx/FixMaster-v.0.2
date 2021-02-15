<!-- Profile Start -->
<section class="section mt-60">
    <div class="container mt-lg-3">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-12 d-lg-block d-none">
                <div class="sidebar sticky-bar p-4 rounded shadow">
                    <h5 class="widget-title">E-Wallet: <strong>{{ $user->user->wallet->wallet_id }}</strong></h5>
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
                                        <p class="text-muted location-time"><span class="text-dark h6">₦{{ number_format($user->wallet->balance) }}</span></p>
                                            <a href="{{ route('client.wallet') }}" class="btn btn-sm btn-outline-primary mouse-down">Fund Account</a>
                                        </div>
                                    </div>
                                    <div class="mt-1">
                                        <small>Last Login: <br>
                                            <strong>@if(!empty($user->last_sign_in)) {{ Carbon\Carbon::parse($user->last_sign_in, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }} @else Never @endif</strong>
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
                            <a href="{{ route('client.home') }}" class="accounts rounded d-block shadow text-center py-3 {{ Route::currentRouteNamed('client.home') ? 'active' : '' }}">
                                    <span class="pro-icons h3 text-muted"><i class="uil uil-user"></i></span>
                                    <h6 class="title text-dark h6 my-0">Dashboard</h6>
                                </a>
                            </div><!--end col-->

                            <div class="col-6 mt-4 pt-2">
                                <a href="{{ route('client.services') }}" class="accounts rounded d-block shadow text-center py-3 {{ Route::currentRouteNamed('client.services', 'client.service_quote', 'client.service_custom', 'client.services_details') ? 'active' : '' }}">
                                    <span class="pro-icons h3 text-muted"><i class="uil uil-calendar-alt"></i></span>
                                    <h6 class="title text-dark h6 my-0">Book a Service</h6>
                                </a>
                            </div><!--end col-->
                            <div class="col-6 mt-4 pt-2">
                                <a href="{{ route('client.requests') }}" class="accounts rounded d-block shadow text-center py-3 {{ Route::currentRouteNamed('client.requests', 'client.request_details', 'client.request_invoice') ? 'active' : '' }}">
                                    <span class="pro-icons h3 text-muted"><i class="uil uil-chart"></i></span>
                                    <h6 class="title text-dark h6 my-0">Requests</h6>
                                </a>
                            </div><!--end col-->

                            <div class="col-6 mt-4 pt-2">
                            <a href="{{ route('client.wallet') }}" class="accounts rounded d-block shadow text-center py-3 {{ Route::currentRouteNamed('client.wallet') ? 'active' : '' }}">
                                    <span class="pro-icons h3 text-muted"><i class="uil uil-file"></i></span>
                                    <h6 class="title text-dark h6 my-0">E-Wallet</h6>
                                </a>
                            </div><!--end col-->

                            <div class="col-6 mt-4 pt-2">
                            <a href="{{ route('client.messages') }}" class="accounts rounded d-block shadow text-center py-3 {{ Route::currentRouteNamed('client.messages') ? 'active' : '' }}">
                                    <span class="pro-icons h3 text-muted"><i class="uil uil-envelope-star @if($user->receivedMessages()->where('is_read', '0')->count()) text-danger" @endif data-toggle="tooltip" title="You have {{ $user->receivedMessages()->where('is_read', '0')->count() }} unread messages"></i></span>
                                    <h6 class="title text-dark h6 my-0">Messages</h6>
                                </a>
                            </div><!--end col-->

                            <div class="col-6 mt-4 pt-2">
                            <a href="{{ route('client.payments') }}" class="accounts rounded d-block shadow text-center py-3 {{ Route::currentRouteNamed('client.payments') ? 'active' : '' }}">
                                    <span class="pro-icons h3 text-muted"><i class="uil uil-transaction"></i></span>
                                    <h6 class="title text-dark h6 my-0">Payments</h6>
                                </a>
                            </div><!--end col-->

                            <div class="col-6 mt-4 pt-2">
                            <a href="{{ route('client.settings') }}" class="accounts rounded d-block shadow text-center py-3 {{ Route::currentRouteNamed('client.settings') ? 'active' : '' }}">
                                    <span class="pro-icons h3 text-muted"><i class="uil uil-setting"></i></span>
                                    <h6 class="title text-dark h6 my-0">Settings</h6>
                                </a>
                            </div><!--end col-->

                            <div class="col-6 mt-4 pt-2">
                            <a href="{{ route('logout') }}" class="accounts rounded d-block shadow text-center py-3">
                                    <span class="pro-icons h3 text-muted"><i class="uil uil-sign-out-alt"></i></span>
                                    <h6 class="title text-dark h6 my-0">Logout</h6>
                                </a>
                            </div><!--end col-->
                        </div><!--end row-->
                    </div>

                    {{-- <div class="widget mt-4 pt-2">
                        <h5 class="widget-title">Follow me :</h5>
                        <ul class="list-unstyled social-icon mb-0 mt-4">
                            <li class="list-inline-item"><a href="javascript:void(0)" class="rounded"><i data-feather="facebook" class="fea icon-sm fea-social"></i></a></li>
                            <li class="list-inline-item"><a href="javascript:void(0)" class="rounded"><i data-feather="instagram" class="fea icon-sm fea-social"></i></a></li>
                            <li class="list-inline-item"><a href="javascript:void(0)" class="rounded"><i data-feather="twitter" class="fea icon-sm fea-social"></i></a></li>
                            <li class="list-inline-item"><a href="javascript:void(0)" class="rounded"><i data-feather="linkedin" class="fea icon-sm fea-social"></i></a></li>
                            <li class="list-inline-item"><a href="javascript:void(0)" class="rounded"><i data-feather="github" class="fea icon-sm fea-social"></i></a></li>
                            <li class="list-inline-item"><a href="javascript:void(0)" class="rounded"><i data-feather="youtube" class="fea icon-sm fea-social"></i></a></li>
                            <li class="list-inline-item"><a href="javascript:void(0)" class="rounded"><i data-feather="gitlab" class="fea icon-sm fea-social"></i></a></li>
                        </ul><!--end icon-->
                    </div> --}}
                </div>
            </div><!--end col-->

            @yield('content')
        </div><!--end row-->
    </div><!--end container-->
</section><!--end section-->
<!-- Profile End -->