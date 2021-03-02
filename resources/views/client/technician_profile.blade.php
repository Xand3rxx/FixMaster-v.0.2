@include('layouts.partials._client_navbar')
@section('title', 'Technician Profile')
    
<!-- Hero Start -->
<section class="bg-half-260 d-table w-100" style="background: url('{{ asset('assets/images/default-male-avatar.png') }}'); background-repeat: no-repeat; background-position: center; ">
    <div class="bg-overlay"></div>
</section><!--end section-->
<!-- Hero End -->

   <!-- Candidate Detail Start -->
   <section class="section">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-5 col-12">
                <div class="card job-profile shadow border-0">
                    <div class="text-center py-5 border-bottom rounded-top">
                        <img src="{{ asset('assets/images/default-male-avatar.png') }}" class="avatar avatar-medium mx-auto rounded-circle shadow d-block" alt="">
                        <h5 class="mt-3 mb-0">Andrew Nwankwo</h5>
                        <p class="text-muted mb-0">Senior Web Developer</p>
                    </div>                               
                    <div class="card-body">
                        <h5 class="card-title">Personal Details :</h5>
                                                            
                        <ul class="list-unstyled">
                            <li class="h6"><i data-feather="activity" class="fea icon-sm text-warning mr-2"></i><span class="text-muted">Completed Jobs :</span> 26</li>
                            <li class="h6"><i data-feather="gift" class="fea icon-sm text-warning mr-2"></i><span class="text-muted">D.O.B. :</span> 11th Jun, 1986</li>
                            <li class="h6"><i data-feather="home" class="fea icon-sm text-warning mr-2"></i><span class="text-muted">Address :</span> 15 Razaq street, Okota</li>
                            <li class="h6"><i data-feather="map-pin" class="fea icon-sm text-warning mr-2"></i><span class="text-muted">City :</span> Lagos</li>
                            <li class="h6"><i data-feather="globe" class="fea icon-sm text-warning mr-2"></i><span class="text-muted">Country :</span> Nigeria</li>
                            {{-- <li class="h6"><i data-feather="server" class="fea icon-sm text-warning mr-2"></i><span class="text-muted">Postal Code :</span> 521452</li> --}}
                            <li class="h6"><i data-feather="phone" class="fea icon-sm text-warning mr-2"></i><span class="text-muted">Mobile :</span> (+234) 805 4242 309-</li>
                        </ul>
                    </div>
                </div>
            </div><!--end col-->

            <div class="col-lg-8 col-md-7 col-12 mt-4 mt-sm-0 pt-2 pt-sm-0">
                <div class="ml-lg-4">
                    <h4>About Me :</h4>
                    <p class="text-muted"> I'm an experienced Technitian with over 3 years of experience. Experienced with all stages of the development cycle for dynamic web projects. The as opposed to using 'Content here, content here', making it look like readable English.</p>
                </div>
            </div><!--end col-->
        </div><!--enn row-->
    </div><!--end container-->
</section><!--end section-->



    <!-- Footer Start -->
    <footer class="footer footer-bar">
        <div class="container text-center">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <div class="text-sm-left">
                        <p class="mb-0">© {{ date('Y') }} FixMaster. All Rights Reserved.</p>
                    </div>
                </div><!--end col-->
    
                <div class="col-sm-6 mt-4 mt-sm-0 pt-2 pt-sm-0">
                    <ul class="list-unstyled text-sm-right mb-0">
                        <li class="list-inline-item"><a href="javascript:void(0)"><img src="images/payments/american-ex.png" class="avatar avatar-ex-sm" title="American Express" alt=""></a></li>
                        <li class="list-inline-item"><a href="javascript:void(0)"><img src="images/payments/discover.png" class="avatar avatar-ex-sm" title="Discover" alt=""></a></li>
                        <li class="list-inline-item"><a href="javascript:void(0)"><img src="images/payments/master-card.png" class="avatar avatar-ex-sm" title="Master Card" alt=""></a></li>
                        <li class="list-inline-item"><a href="javascript:void(0)"><img src="images/payments/paypal.png" class="avatar avatar-ex-sm" title="Paypal" alt=""></a></li>
                        <li class="list-inline-item"><a href="javascript:void(0)"><img src="images/payments/visa.png" class="avatar avatar-ex-sm" title="Visa" alt=""></a></li>
                    </ul>
                </div><!--end col-->
            </div><!--end row-->
        </div><!--end container-->
    </footer><!--end footer-->
    <!-- Footer End -->
    
    <!-- Back to top -->
    <a href="#" class="btn btn-icon btn-soft-primary back-to-top"><i data-feather="arrow-up" class="icons"></i></a>
    <!-- Back to top -->

    <!-- javascript -->
    <script src="{{asset('assets/frontend/js/jquery-3.5.1.min.js')}}"></script>
    <script src="{{asset('assets/frontend/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/frontend/js/jquery.easing.min.js')}}"></script>
    <script src="{{asset('assets/frontend/js/scrollspy.min.js')}}"></script>
    <!-- Icons -->
    <script src="{{asset('assets/frontend/js/feather.min.js')}}"></script>
    <!-- Switcher -->
    <script src="{{asset('assets/frontend/js/switcher.js')}}"></script>
    <!-- Main Js -->
    <script src="{{asset('assets/frontend/js/app.js')}}"></script>
    <!-- scroll -->
    <script src="{{ asset('assets/frontend/js/scroll.js')}}"></script>
    <script src="{{ asset('assets/frontend/js/typed/lib/typed.js')}}"></script>
</body>
</html>