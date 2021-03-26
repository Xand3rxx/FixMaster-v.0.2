@extends('layouts.client')
@section('title', 'Home')
@section('content')
@include('layouts.partials._messages')
{{-- {{ dd($user->state) }} --}}

<div class="col-lg-8 col-12">
    <div class="border-bottom pb-4 row">
        {{-- <h5>Femi Joseph</h5>
        <p class="text-muted mb-0">I have started my career as a trainee and prove my self and achieve all the milestone with good guidance and reach up to the project manager. In this journey, I understand all the procedure which make me a good developer, team leader, and a project manager.</p>--}}
        <div class="col-md-4 mt-4">
            <div class="media key-feature align-items-center p-3 rounded shadow mt-4">
                <img src="{{ asset('assets/images/job/Circleci.svg') }}" class="avatar avatar-ex-sm" alt="">
                <div class="media-body content ml-3">
                    <h4 class="title mb-0">Service Requests</h4>
                    <p class="text-muted mb-0">{{ $totalRequests }} </p>
                    {{-- <p class="text-muted mb-0"><a href="javascript:void(0)" class="text-primary">CircleCi</a> @London, UK</p>     --}}
                </div>
            </div>

        </div>

        <div class="col-md-4 mt-4">
            <div class="media key-feature align-items-center p-3 rounded shadow mt-4">
                <img src="{{ asset('assets/images/job/Circleci.svg') }}" class="avatar avatar-ex-sm" alt="">
                <div class="media-body content ml-3">
                    <h4 class="title mb-0">Completed</h4>
                <p class="text-muted mb-0">{{ $completedRequests }}</p>
                    {{-- <p class="text-muted mb-0"><a href="javascript:void(0)" class="text-primary">CircleCi</a> @London, UK</p>     --}}
                </div>
            </div>
        </div>

        <div class="col-md-4 mt-4">
            <div class="media key-feature align-items-center p-3 rounded shadow mt-4">
                <img src="{{ asset('assets/images/job/Circleci.svg') }}" class="avatar avatar-ex-sm" alt="">
                <div class="media-body content ml-3">
                    <h4 class="title mb-0">Pending</h4>
                <p class="text-muted mb-0">{{ $cancelledRequests }}</p>
                    {{-- <p class="text-muted mb-0"><a href="javascript:void(0)" class="text-primary">CircleCi</a> @London, UK</p>     --}}
                </div>
            </div>
        </div>
    </div> 
    
    <div class="border-bottom pb-4">
        <div class="row">
            <div class="col-md-6 mt-4">
                <h5>Personal Details :</h5>
                <div class="mt-4">
                    <div class="media align-items-center">
                        <i data-feather="mail" class="fea icon-ex-md text-muted mr-3"></i>
                        <div class="media-body">
                            <h6 class="text-primary mb-0">Email :</h6>
                        <a href="javascript:void(0)" class="text-muted">{{ $user->user->email }}</a>
                        </div>
                    </div>
                    <div class="media align-items-center mt-3">
                        <i data-feather="phone" class="fea icon-ex-md text-muted mr-3"></i>
                        <div class="media-body">
                            <h6 class="text-primary mb-0">Phone No :</h6>
                        <a href="javascript:void(0)" class="text-muted">{{ $client['phone_number'] }}</a>
                        </div>
                    </div>
                    <div class="media align-items-center mt-3">
                        <i data-feather="bookmark" class="fea icon-ex-md text-muted mr-3"></i>
                        <div class="media-body">
                            <h6 class="text-primary mb-0">Occupation :</h6>
                        <a href="javascript:void(0)" class="text-muted">{{ $user->profession->name ?? 'Not Selected' }}</a>
                        </div>
                    </div>
                    <div class="media align-items-center mt-3">
                        <i data-feather="map" class="fea icon-ex-md text-muted mr-3"></i>
                        <div class="media-body">
                            <h6 class="text-primary mb-0">State :</h6>
                        <p class="text-muted mb-0">{{ $user->state->name ?? 'Lagos State' }}</p>
                        </div>
                    </div>


                    <div class="media align-items-center mt-3">
                        <i data-feather="map-pin" class="fea icon-ex-md text-muted mr-3"></i>
                        <div class="media-body">
                            <h6 class="text-primary mb-0">L.G.A :</h6>
                        <p class="text-muted mb-0">{{ $user->lga->name ?? "Ikeja" }}</p>
                        </div>
                    </div>

                    <div class="media align-items-center mt-3">
                        <i data-feather="map-pin" class="fea icon-ex-md text-muted mr-3"></i>
                        <div class="media-body">
                            <h6 class="text-primary mb-0">Town/City :</h6>
                        <p class="text-muted mb-0">{{ $client->town ?? "Opebi" }}</p>
                        </div>
                    </div>
                    <div class="media align-items-center mt-3">
                        <i data-feather="map" class="fea icon-ex-md text-muted mr-3"></i>
                        <div class="media-body">
                            <h6 class="text-primary mb-0">Full Address :</h6>
                        <a href="javascript:void(0)" class="text-muted">{{ $client->full_address ?? "30, Opebi Road, Lagos" }}</a>
                        </div>
                    </div>
                </div>
            </div><!--end col-->

            <div class="col-md-6 mt-4 pt-2 pt-sm-0">
                <h5>Recent Requests :</h5>
                    <div class="media key-feature align-items-center p-3 rounded shadow mt-4">
                        <img src="images/job/Circleci.svg" class="avatar avatar-ex-sm" alt="">
                        <div class="media-body content ml-3">
                            <h4 class="title mb-0">Electronics(Computer & Laptops)</h4>
                            <p class="text-muted mb-0"><span>Amount:</span>₦{{ number_format(5000) }}</p>
                            <p class="mb-0"><a href="#" style="color: #161c2d" title="View Service request details">CSE: <span class="text-muted">Andrew Nkwankwo</span></a></p>    
                            <p class="mb-0">Status: <span class="text-warning">Pending</span></p>    
                        </div>
                    </div>

                    <div class="media key-feature align-items-center p-3 rounded shadow mt-4">
                        <img src="images/job/Circleci.svg" class="avatar avatar-ex-sm" alt="">
                        <div class="media-body content ml-3">
                            <h4 class="title mb-0">Plumbing(Bath-Tubs, Pipes, Kitchen Sink)</h4>
                            <p class="text-muted mb-0"><span>Amount:</span>₦{{ number_format(3500) }}</p>
                            <p class="mb-0"><a href="#" style="color: #161c2d" title="View Service request details">CSE: <span class="text-muted">Jubril Diwa</span></a></p>    
                            <p class="mb-0">Status: <span class="text-info">Ongoing</span></p>    
                        </div>
                    </div>

                    <div class="media key-feature align-items-center p-3 rounded shadow mt-4">
                        <img src="images/job/Circleci.svg" class="avatar avatar-ex-sm" alt="">
                        <div class="media-body content ml-3">
                            <h4 class="title mb-0">Plumbing(Drainage, Shower, Soak-Away)</h4>
                            <p class="text-muted mb-0"><span>Amount:</span>₦{{ number_format(7500) }}</p>
                            <p class="mb-0"><a href="#" style="color: #161c2d" title="View Service request details">CSE: <span class="text-muted">Mayowa Benedict</span></a></p>    
                            <p class="mb-0">Status: <span class="text-success">Completed</span></p>    
                        </div>
                    </div>
                {{-- @foreach ($userServiceRequests as $userServiceRequest)
                <div class="media key-feature align-items-center p-3 rounded shadow mt-4">
                    <img src="images/job/Circleci.svg" class="avatar avatar-ex-sm" alt="">
                    <div class="media-body content ml-3">
                        <h4 class="title mb-0">{{ $userServiceRequest->service->name }}({{ $userServiceRequest->category->name }})</h4>
                        <p class="text-muted mb-0"><span>Amount:</span> 
                            @if(!empty($userServiceRequest->serviceRequestDetail->discount_service_fee))
                                ₦{{ number_format($userServiceRequest->serviceRequestDetail->discount_service_fee) }}
                                <sup style="font-size: 10px;" class="text-success">Discount</sup>
                            @else
                                ₦{{ number_format($userServiceRequest->serviceRequestDetail->initial_service_fee) }}
                            @endif 
                            ({{ $userServiceRequest->serviceRequestDetail->service_fee_name }})
                        </p>
                        <p class="mb-0"><a href="{{ route('client.request_details', $userServiceRequest->id) }}" style="color: #161c2d" title="View Service request details">CSE: <span class="text-muted">
                            @if(!empty($userServiceRequest->cse_id)) {{ $userServiceRequest->cse->first_name.' '.$userServiceRequest->cse->last_name }} @else Not Assigned @endif
                        </span></a></p>    
                        <p class="mb-0">Status: 
                            @if($userServiceRequest->service_request_status_id == '1')
                                <span class="text-warning">Pending</span>
                            @elseif($userServiceRequest->service_request_status_id > '3')
                                <span class="text-info">Ongoing</span>
                            @elseif($userServiceRequest->service_request_status_id == '3')
                                <span class="text-success">Completed</span>
                            @elseif($userServiceRequest->service_request_status_id == '2')
                                <span class="text-danger">Cancelled</span>
                            @endif
                        </p>    
                    </div>
                </div>
                @endforeach --}}
            </div><!--end col-->
        </div><!--end row-->
    </div>

    <h5 class="mt-4 mb-0">Popular Requests :</h5>
    <div class="row">
        
        @foreach ($popularRequests as $popularRequest)
        <div class="col-md-4 mt-4 pt-2">
            <div class="card blog rounded border-0 shadow">
                <div class="position-relative">
                    @if(empty($popularRequest->image))
                        <img src="{{ asset('assets/images/no-image-available.png') }}" alt="Image not available" class="card-img-top rounded-top">
                    @else
                        @if(file_exists(public_path().'/assets/service-images/'.$popularRequest->image))
                            <img src="{{ asset('assets/service-images/'.$popularRequest->image) }}" alt="{{ $popularRequest->name }}" class="card-img-top rounded-top">
                        @else
                            <img src="{{ asset('assets/images/no-image-available.png') }}" alt="Image not available" class="card-img-top rounded-top">
                        @endif
                    @endif
                <div class="overlay rounded-top bg-dark"></div>
                </div>
                <div class="card-body content">
                <h5><a href="javascript:void(0)" class="card-title title text-dark">{{ !empty($popularRequest->name) ? $popularRequest->name : 'UNAVAILABLE' }}</a> <a href="#" title="View {{ $popularRequest->name }} service details"> <i data-feather="info" class="text-primary"></i></a></h5>
                    <div class="post-meta d-flex justify-content-between mt-3">
                        <a href="{{ route('client.services.quote', ['service'=>$popularRequest->uuid, 'locale'=>app()->getLocale()]) }}" class="text-muted readmore">Request Service <i class="mdi mdi-chevron-right"></i></a>
                    </div>
                </div>
                <div class="author">
                <small class="text-light date"><i class="mdi mdi-calendar"></i> Requests: 12</small><br>
                <small class="text-light date"><i class="mdi mdi-credit-card"></i> Basic Price: ₦{{ number_format(3500) }}</small>

                </div>
            </div>
        </div><!--end col-->
        @endforeach
        
    </div><!--end row-->
</div><!--end col-->
@endsection