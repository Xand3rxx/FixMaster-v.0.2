@extends('layouts.client')
@section('title', 'Service Details')
@section('content')
@include('layouts.partials._messages')

<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css">
<link href="{{ asset('assets/frontend/css/service-details.css') }}" rel="stylesheet" type="text/css"/>


<div class="col-lg-8 col-12" style="margin-top: 3rem;">

    <div class="row mt-4">
        <div class="col-md-5">
            <div class="card blog rounded border-0 shadow">
                <div class="position-relative">
                    @if(empty($service->image))
                        <img src="{{ asset('assets/images/no-image-available.png') }}" alt="Image not available" class="card-img-top rounded-top">
                    @else
                        @if(file_exists(public_path().'/assets/category-images/'.$service->image))
                            <img src="{{ asset('assets/category-images/'.$service->image) }}" alt="{{ $service->name }}" class="card-img-top rounded-top">
                        @else
                        <img src="{{ asset('assets/images/no-image-available.png') }}" alt="Image not available" class="card-img-top rounded-top">
                        @endif
                    @endif
                <div class="overlay rounded-top bg-dark"></div>
                </div>
                
                <div class="author">
                <h4 class="text-light user d-block"><i class="mdi mdi-account"></i> {{ $service->name }}</h4>
                    <small class="text-light date"><i class="mdi mdi-bookmark"></i> {{ $service->requests()->count() }} Requests</small>
                </div>
            </div>
            <div class="mt-4 pt-2">
                <a href="{{ route('client.service_quote', $service->url) }}" class="btn btn-primary">Request Service</a>
            </div>
        </div><!--end col-->

        <div class="col-md-7 mt-4 mt-sm-0 pt-2 pt-sm-0">
            <div class=" ml-md-4">
                <div class="row">
                    <div class="star-main-rating">
                        <div class="inner_game">
                            <div class="rating_game mt-3 text-center">
                                <span class="rating-num">4.5</span>
                                <div class="rating-stars">
                                    {{-- <span><i class="active icon-star text-warning"></i></span>
                                    <span><i class="active icon-star text-warning"></i></span>
                                    <span><i class="active icon-star text-warning"></i></span>
                                    <span><i class="active icon-star text-warning"></i></span>
                                    <span><i class="active icon-star-half-empty text-warning"></i></span> --}}
                                    <ul class="list-unstyled mb-0">
                                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                    </ul>
                                </div>
                                <div class="rating-users text-center"> 1295 total</div>
                            </div>
                        </div>
                    </div>
                
                
                <div class="star-width rating-bars">
                    <div class="rating-holder">
                        <ul>
                            <li class="">
                                <div class="rating-category">
                                    {{-- <span class="rating-digit-holder">5</span> --}}
                                    <span class="rating-star-holder text-warning">★★★★★</span>
                                </div>
                                <div class="col rating-bars ml-5">
                                    <div class="rating-bar-bg"><span style="width: 100%;" class="bar-position green"></span></div>
                                </div>
                                {{-- <div class="">
                                    <div class="rating-total-numbers">&nbsp;898</div>
                                </div> --}}
                            </li>
                            <li class="">
                                <div class="rating-category">
                                    {{-- <span class="rating-digit-holder">4</span> --}}
                                    <span class="rating-star-holder text-warning">★★★★</span>
                                </div>
                                <div class="col rating-bars ml-5">
                                    <div class="rating-bar-bg"><span style="width: 75%;" class="bar-position green"></span></div>
                                </div>
                                {{-- <div class="">
                                    <div class="rating-total-numbers">&nbsp;309</div>
                                </div> --}}
                            </li>
                            <li class="">
                                <div class="rating-category">
                                    {{-- <span class="rating-digit-holder">3</span> --}}
                                    <span class="rating-star-holder text-warning">★★★</span>
                                </div>
                                <div class="col rating-bars ml-5">
                                    <div class="rating-bar-bg"><span style="width: 50%;" class="bar-position green"></span></div>
                                </div>
                                {{-- <div class="">
                                    <div class="rating-total-numbers">&nbsp;283</div>
                                </div> --}}
                            </li>
                            <li class="">
                                <div class="rating-category">
                                    {{-- <span class="rating-digit-holder">2</span> --}}
                                    <span class="rating-star-holder text-warning">★★</span>
                                </div>
                                <div class="col rating-bars ml-5">
                                    <div class="rating-bar-bg"><span style="width: 35%;" class="bar-position red"></span></div>
                                </div>
                                {{-- <div class="">
                                    <div class="rating-total-numbers">&nbsp;125</div>
                                </div> --}}
                            </li>
                            <li class="">
                                <div class="rating-category">
                                    {{-- <span class="rating-digit-holder">1</span> --}}
                                    <span class="rating-star-holder text-warning">★</span>
                                </div>
                                <div class="col rating-bars ml-5">
                                    <div class="rating-bar-bg"><span style="width: 20%;" class="bar-position red"></span></div>
                                </div>
                                {{-- <div class="">
                                    <div class="rating-total-numbers">&nbsp;273</div>
                                </div> --}}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
                
                <br>
                <h5 class="mt-4 py-2">Description :</h5>
                <p class="text-muted">{{ $service->description }}</p>
            
            </div>
        </div><!--end col-->
    </div><!--end row-->

    <div class="row mt-4">
        <div id="customer-testi" class="owl-carousel owl-theme">
            <div class="media customer-testi m-2">
                <img src="{{ asset('assets/images/taju.jpg') }}" class="avatar avatar-small mr-3 rounded shadow" alt="Tajudeen Tijani">
                <div class="media-body content p-3 shadow rounded bg-white position-relative">
                    <ul class="list-unstyled mb-0">
                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                    </ul>
                    <p class="text-muted mt-2">Hi, i am Tajudeen from Aba. My employers used FixMaster for the company”s outdoor advertising project based on my recommendation and they more than delivered. They handled the metal fabrication, hoisting and went on to offer a discount on the banner itself. Now that is what i call service delivery. I wouldn”t hesitate to recommend FixMaster.</p>
                    <h6 class="text-primary">- Tajudeen Tijani <small class="text-muted">C.E.O</small></h6>
                </div>
            </div>

            <div class="media customer-testi m-2">
                <img src="{{ asset('assets/images/ifee.jpg') }}" class="avatar avatar-small mr-3 rounded shadow" alt="Ifeoluwa Ajenifuja">
                <div class="media-body content p-3 shadow rounded bg-white position-relative">
                    <ul class="list-unstyled mb-0">
                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                        <li class="list-inline-item"><i class="mdi mdi-star-half text-warning"></i></li>
                    </ul>
                    <p class="text-muted mt-2">The service is top class. I recommend them if you want to beef up your home, office or company security with top class surveillance systems, electric gates etc. They are the solution to your security problems.</p>
                    <h6 class="text-primary">- Ifeoluwa Ajenifuja <small class="text-muted">M.D</small></h6>
                </div>
            </div>

            <div class="media customer-testi m-2">
                <img src="{{ asset('assets/images/comp.jpg') }}" class="avatar avatar-small mr-3 rounded shadow" alt="Ifeoluwa Ajenifuja">
                <div class="media-body content p-3 shadow rounded bg-white position-relative">
                    <ul class="list-unstyled mb-0">
                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                        <li class="list-inline-item"><i class="mdi mdi-star-half text-warning"></i></li>
                    </ul>
                    <p class="text-muted mt-2">The service is top class. I recommend them if you want to beef up your home, office or company security with top class surveillance systems, electric gates etc. They are the solution to your security problems.</p>
                    <h6 class="text-primary">- Ifeoluwa Ajenifuja <small class="text-muted">M.D</small></h6>
                </div>
            </div>

            <div class="media customer-testi m-2">
                <img src="{{ asset('assets/images/soundsys.jpg') }}" class="avatar avatar-small mr-3 rounded shadow" alt="Ifeoluwa Ajenifuja">
                <div class="media-body content p-3 shadow rounded bg-white position-relative">
                    <ul class="list-unstyled mb-0">
                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                        <li class="list-inline-item"><i class="mdi mdi-star-half text-warning"></i></li>
                    </ul>
                    <p class="text-muted mt-2">The service is top class. I recommend them if you want to beef up your home, office or company security with top class surveillance systems, electric gates etc. They are the solution to your security problems.</p>
                    <h6 class="text-primary">- Ifeoluwa Ajenifuja <small class="text-muted">M.D</small></h6>
                </div>
            </div>
        </div>
    </div>
</div>



@section('scripts')
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> --}}

<script>
    $(document).ready(function() {
        $('.bar span').hide();
        $('#bar-five').animate({
            width: '90%'}, 1000);
        $('#bar-four').animate({
            width: '75%'}, 1000);
        $('#bar-three').animate({
            width: '50%'}, 1000);
        $('#bar-two').animate({
            width: '30%'}, 1000);
        $('#bar-one').animate({
            width: '19%'}, 1000);
        
        setTimeout(function() {
            $('.bar span').fadeIn('slow');
        }, 1000);

    });
   
</script>
@endsection

@endsection