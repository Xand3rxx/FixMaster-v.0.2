@extends('layouts.client') 
@section('title', 'Request Details') 
@section('content')
@include('layouts.partials._messages')

<div class="col-lg-8 col-12">
    <div class="float-right mt-4">
        <a href="{{ route('client.requests') }}" class="btn btn-sm btn-primary">Back </a>
        @if($requestDetail->service_request_status_id == '1')
        <a href="#editRequest" id="edit-request" data-toggle="modal" data-url="{{ route('client.edit_request', $requestDetail->id) }}" data-job-reference="{{ $requestDetail->job_reference }}" class="btn btn-sm btn-warning">Edit Request </a>

        <a href="#cancelRequest" id="cancel-request" data-toggle="modal" data-url="{{ route('client.cancel_request', $requestDetail->id) }}" data-job-reference="{{ $requestDetail->job_reference }}" class="btn btn-sm btn-danger">Cancel Request </a>
        @endif
    </div>

    <div class="ml-lg-4">
        <h5 class="mt-4">Service Request: {{ $requestDetail->job_reference }}</h5>

        <div class="border-bottom pb-4 row">
            <div class="col-md-6">
                <div class="media key-feature align-items-center p-3 rounded shadow mt-4">
                    <img src="{{ asset('assets/images/job/Eslint.svg') }}" class="avatar avatar-ex-sm" alt="" />
                    <div class="media-body content ml-3">
                        <h4 class="title mb-0">Service</h4>
                        <p class="text-muted mb-0">{{ $requestDetail->service->name }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="media key-feature align-items-center p-3 rounded shadow mt-4">
                    <img src="{{ asset('assets/images/job/Gradle.svg') }}" class="avatar avatar-ex-sm" alt="" />
                    <div class="media-body content ml-3">
                        <h4 class="title mb-0">Category</h4>
                        <p class="text-muted mb-0">{{ $requestDetail->category->name }}</p>
                    </div>
                </div>
            </div>
        </div>

        @if(!empty($requestDetail->cse_id))
        <h5 class="mt-4">CSE Assigned</h5>
        <div class="col-lg-12 col-12 mt-4">
            <div class="card rounded bg-light overflow-hidden border-0 m-2">
                <div class="row align-items-center no-gutters">
                    <div class="col-md-5">
                        {{-- <img src="{{ asset('assets/images/default-male-avatar.png') }}" class="img-fluid" alt="" /> --}} @if(!empty($requestDetail->cse->avatar) &&
                        file_exists(public_path().'/assets/cse-technician-images/'.$requestDetail->cse->avatar))
                        <img src="{{ asset('assets/cse-technician-images/'.$requestDetail->cse->avatar) }}" class="img-fluid" alt="" />
                        @else @if($requestDetail->cse->gender == 'Male')
                        <img src="{{ asset('assets/images/default-male-avatar.png') }}" alt="Default male profile avatar" class="img-fluid" />
                        @else
                        <img src="{{ asset('assets/images/default-female-avatar.png') }}" alt="Default female profile avatar" class="img-fluid" />
                        @endif @endif
                    </div>
                    <!--end col-->

                    <div class="col-md-7">
                        <div class="card-body">
                            <h6 class="text-primary font-weight-bold">{{ $requestDetail->cse->first_name.' '.$requestDetail->cse->last_name }} <small class="text-muted d-block">CSE | FixMaster</small></h6>
                            <ul class="list-unstyled mb-0">
                                <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                            </ul>
                            <p class="h6 mb-0">Security Code</p>
                            <p class="text-muted mb-0 font-weight-bold">{{ $requestDetail->security_code }}</p>
                            <div class="mt-4">
                                {{-- <a href="{{ route('client.technician_profile') }}" class="btn btn-sm btn-outline-primary">View Profile</a> --}}
                                <a href="#validateSecurityCode" data-toggle="modal" class="btn btn-sm btn-outline-primary">CSE & Technician Profiles</a>

                                @if($requestDetail->service_request_status_id != '3')
                                    <a href="#" data-toggle="modal" data-target="#message-modal" class="btn btn-sm btn-primary">Send Message </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->
            </div>
        </div>
        @endif

        <h5 class="mt-4">Location & Time</h5>
        <p style="font-size: 10px;" class="text-muted">Location and appointemnt time as specified by you.</p>
        <ul class="list-unstyled">
            <li class="text-muted"><i data-feather="map-pin" class="fea icon-sm text-primary mr-2"></i>{{ $requestDetail->serviceRequestDetail->address }}</li>
            <li class="text-muted"><i data-feather="calendar" class="fea icon-sm text-primary mr-2"></i>{{ $requestDetail->serviceRequestDetail->timestamp }}</li>
        </ul>

        <h5 class="mt-4">Service Charge (Urgent):</h5>
        <ul class="list-unstyled">
            <li class="text-muted">
                <i data-feather="arrow-right" class="fea icon-sm text-primary mr-2"></i>
                @if(!empty($requestDetail->serviceRequestDetail->discount_service_fee)) ₦{{ number_format($requestDetail->serviceRequestDetail->discount_service_fee) }}
                <sup style="font-size: 10px;" class="text-success">Discount</sup>
                @else ₦{{ number_format($requestDetail->serviceRequestDetail->initial_service_fee) }} @endif
            </li>
        </ul>

        <h5 class="mt-4">Status</h5>
        <ul class="list-unstyled">
            @if($requestDetail->service_request_status_id == '1')
            <li class="text-warning"><i data-feather="arrow-right" class="fea icon-sm text-primary mr-2"></i>Pending</li>
            @elseif($requestDetail->service_request_status_id > '3')
            <li class="text-info"><i data-feather="arrow-right" class="fea icon-sm text-primary mr-2"></i>Ongoing</li>
            @elseif($requestDetail->service_request_status_id == '3')
            <li class="text-success"><i data-feather="arrow-right" class="fea icon-sm text-primary mr-2"></i>Completed</li>
            @elseif($requestDetail->service_request_status_id == '2')
            <li class="text-danger"><i data-feather="arrow-right" class="fea icon-sm text-primary mr-2"></i>Cancelled</li>
            @endif
        </ul>

        <h5 class="mt-4">Payment Method</h5>
        <ul class="list-unstyled">
            <li class="text-muted"><i data-feather="arrow-right" class="fea icon-sm text-primary mr-2"></i>Payment Method: {{ $requestDetail->serviceRequestDetail->payment_method }}</li>
            {{--
            <li class="text-muted">
                <i data-feather="arrow-right" class="fea icon-sm text-primary mr-2"></i>Payment Gateway: PayStack
                <img src="{{ asset('assets/images/payments/payment/master-card.jpg') }}" class="img-fluid avatar avatar-small mx-2 rounded-circle shadow" />
            </li>
            --}}
        </ul>

        <h5>Request Description</h5>
        <ul class="list-unstyled">
            <li class="text-muted"><i data-feather="arrow-right" class="fea icon-sm text-primary mr-2"></i> {{ $requestDetail->serviceRequestDetail->description }}</li>
        </ul>

        @if(!empty($requestDetail->serviceRequestCancellationReason->reason))
        <h5>Cancellation Reason</h5>
        <ul class="list-unstyled">
            <li class="text-muted"><i data-feather="arrow-right" class="fea icon-sm text-primary mr-2"></i> {{ $requestDetail->serviceRequestCancellationReason->reason }}</li>
        </ul>
        @endif
    </div>
</div>
<!--end col-->

<!-- Modal Content Start -->
<div class="modal fade" id="message-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content rounded shadow border-0">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Send Message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
            <form class="rounded shadow p-4" method="POST" action="{{ route('client.send_messages') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                        <input name="recipient_id" id="recipient_id" type="hidden" class="form-control pl-5 d-none @error('recipient_id') is-invalid @enderror" value="{{ old('recipient_id') ?? $requestDetail->cse_id }}" required/>

                            <div class="form-group position-relative">
                                <label>Subject <span class="text-danger">*</span></label>
                                <i data-feather="alert-circle" class="fea icon-sm icons"></i>
                                <input name="subject" id="subject" type="text" class="form-control pl-5 @error('subject') is-invalid @enderror"/>
                                @error('subject')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!--end col-->

                        <div class="col-md-12">
                            <div class="form-group position-relative">
                                <label>Message <span class="text-danger">*</span></label>
                                <i data-feather="message-circle" class="fea icon-sm icons"></i>
                                <textarea name="message" id="message_body" rows="4" class="form-control pl-5 @error('message') is-invalid @enderror" placeholder="Your message :"></textarea>
                                @error('message')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!--end row-->

                    <div class="row">
                        <div class="col-sm-12">
                            <button type="submit" id="submit" class=" btn btn-primary">Submit</button>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </form>
                <!--end form-->
            </div>
        </div>
    </div>
</div>
<!-- Modal Content End -->

<div class="modal fade" id="validateSecurityCode" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content rounded shadow border-0">
            <div class="modal-header">
                <h5 class="modal-title">Validate CSE & Technician</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" class="d-none" id="security-code" readonly value="{{ $requestDetail->security_code }}" />
                <div class="col-md-12">
                    <div class="form-group position-relative">
                        <label>Security Code:<span class="text-danger">*</span></label>
                        <i data-feather="lock" class="fea icon-sm icons"></i>
                        <input name="security_code" type="text" class="form-control pl-5" placeholder="Security Code:" id="security_code" value="" required />
                        <small style="font-size: 10px;" class="text-danger">Securoty Code must be in uppercase.<small>
                    </div>
                </div>
                <!--end col-->
                <div class="col-md-2">
                    <button type="button" class="btn btn-primary verify-security-code">Verify</button>
                </div>
            </div>
        </div>
        <!-- modal-body -->
    </div>
    <!-- modal-content -->
</div>
<!-- modal-dialog -->

<div class="modal fade" id="editRequest" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content rounded shadow border-0">
            <div class="modal-header">
                {{--
                <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
                --}}
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-edit-request">
                <!-- Modal displays here -->
                <div id="spinner-icon"></div>
            </div>
        </div>
        <!-- modal-body -->
    </div>
    <!-- modal-content -->
</div>
<!-- modal-dialog -->

<div class="modal fade" id="cancelRequest" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content rounded shadow border-0">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Kindly state your reason for cancellation</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" id="modal-cancel-request">
            <form class="p-4" method="POST" id="cancel-request-form">
                @csrf
                <div class="row">
                    
                    <div class="col-md-12">
                        <div class="form-group position-relative">
                            <label>Reason</label>
                            <i data-feather="info" class="fea icon-sm icons"></i>
                            <textarea name="reason" id="reason" rows="3" class="form-control pl-5 @error('reason') is-invalid @enderror" placeholder="">{{ old('reason')  }}</textarea>
                            @error('reason')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div><!--end col--> 
            
                {{-- </div><!--end row--> --}}
            
                    <div class="col-sm-12">
                    <button type="submit" class="submitBnt btn btn-primary">Update</button>
                    </div><!--end col-->
                </div><!--end row-->
            </form><!--end form-->
        </div>
        </div><!-- modal-body -->
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->

@if(!empty($requestDetail->cse_id))

<div class="modal fade" id="cseTechnicianModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content rounded shadow border-0">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">CSE & Technician Profiles</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                {{-- CSE Profile --}}

                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-12 mt-4 pt-2 text-center">
                        <ul class="nav nav-pills nav-justified flex-column flex-sm-row rounded" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link rounded active" id="inbox-tab" data-toggle="pill" href="#cseTab" role="tab" aria-controls="inbox" aria-selected="false">
                                    <div class="text-center pt-1 pb-1">
                                        <h4 class="title font-weight-normal mb-0">CSE</h4>
                                    </div>
                                </a>
                                <!--end nav link-->
                            </li>
                            <!--end nav item-->

                            <li class="nav-item">
                                <a class="nav-link rounded" id="sent-tab" data-toggle="pill" href="#technicianTab" role="tab" aria-controls="sent" aria-selected="false">
                                    <div class="text-center pt-1 pb-1">
                                        <h4 class="title font-weight-normal mb-0">Technician</h4>
                                    </div>
                                </a>
                                <!--end nav link-->
                            </li>
                            <!--end nav item-->
                        </ul>
                        <!--end nav pills-->
                    </div>
                </div>

                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="cseTab" role="tabpanel" aria-labelledby="cseTab-tab">
                        <div class="col-lg-12 col-12 mt-4">
                            <div class="card rounded bg-light overflow-hidden border-0 m-2">
                                <div class="row align-items-center no-gutters">
                                    <div class="col-md-5">
                                        @if(!empty($requestDetail->cse->avatar) && file_exists(public_path().'/assets/cse-technician-images/'.$requestDetail->cse->avatar))
                                        <img src="{{ asset('assets/cse-technician-images/'.$requestDetail->cse->avatar) }}" class="img-fluid" alt="" />
                                        @else @if($requestDetail->cse->gender == 'Male')
                                        <img src="{{ asset('assets/images/default-male-avatar.png') }}" alt="Default male profile avatar" class="img-fluid" />
                                        @else
                                        <img src="{{ asset('assets/images/default-female-avatar.png') }}" alt="Default female profile avatar" class="img-fluid" />
                                        @endif @endif
                                    </div>

                                    <div class="col-md-7">
                                        <div class="card-body">
                                            <h6 class="text-primary font-weight-bold">{{ $requestDetail->cse->first_name.' '.$requestDetail->cse->last_name }} <small class="text-muted d-block">CSE | FixMaster</small></h6>
                                            <ul class="list-unstyled mb-0">
                                                <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                                <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                                <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                                <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                                <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                            </ul>

                                            <ul class="list-unstyled">
                                                <li class="h6">
                                                    <i data-feather="activity" class="fea icon-sm text-warning mr-2"></i><span class="text-muted">Completed Jobs :</span> {{ $requestDetail->cse->requests()->where('service_request_status_id',
                                                    '3')->count() }}
                                                </li>
                                                <li class="h6"><i data-feather="map-pin" class="fea icon-sm text-warning mr-2"></i><span class="text-muted">State :</span> {{ $requestDetail->cse->state->name }}</li>
                                                <li class="h6"><i data-feather="map-pin" class="fea icon-sm text-warning mr-2"></i><span class="text-muted">Town/City :</span> {{ $requestDetail->cse->town }}</li>
                                                <li class="h6"><i data-feather="home" class="fea icon-sm text-warning mr-2"></i><span class="text-muted">Address :</span> {{ $requestDetail->cse->full_address }}</li>

                                                <li class="h6"><i data-feather="phone" class="fea icon-sm text-warning mr-2"></i><span class="text-muted">Mobile :</span> {{ $requestDetail->cse->phone_number }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade show" id="technicianTab" role="tabpanel" aria-labelledby="technicianTab-tab">
                        <div class="col-lg-12 col-12 mt-4">
                            <div class="card rounded bg-light overflow-hidden border-0 m-2">
                                <div class="row align-items-center no-gutters">
                                    <div class="col-md-5">
                                        @if(!empty($requestDetail->technician->avatar) && file_exists(public_path().'/assets/cse-technician-images/'.$requestDetail->cse->avatar))
                                        <img src="{{ asset('assets/cse-technician-images/'.$requestDetail->technician->avatar) }}" class="img-fluid" alt="" />
                                        @else @if($requestDetail->technician->gender == 'Male')
                                        <img src="{{ asset('assets/images/default-male-avatar.png') }}" alt="Default male profile avatar" class="img-fluid" />
                                        @else
                                        <img src="{{ asset('assets/images/default-female-avatar.png') }}" alt="Default female profile avatar" class="img-fluid" />
                                        @endif @endif
                                    </div>

                                    <div class="col-md-7">
                                        <div class="card-body">
                                            <h6 class="text-primary font-weight-bold">
                                                {{ $requestDetail->technician->first_name.' '.$requestDetail->technician->last_name }} <small class="text-muted d-block">Technician | FixMaster</small>
                                            </h6>
                                            <ul class="list-unstyled mb-0">
                                                <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                                <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                                <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                                <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                            </ul>

                                            <ul class="list-unstyled">
                                                <li class="h6">
                                                    <i data-feather="activity" class="fea icon-sm text-warning mr-2"></i><span class="text-muted">Completed Jobs :</span> {{
                                                    $requestDetail->technician->requests()->where('service_request_status_id', '3')->count() }}
                                                </li>
                                                <li class="h6"><i data-feather="map-pin" class="fea icon-sm text-warning mr-2"></i><span class="text-muted">State :</span> {{ $requestDetail->technician->state->name }}</li>
                                                <li class="h6"><i data-feather="map-pin" class="fea icon-sm text-warning mr-2"></i><span class="text-muted">Town/City :</span> {{ $requestDetail->technician->town }}</li>
                                                <li class="h6"><i data-feather="home" class="fea icon-sm text-warning mr-2"></i><span class="text-muted">Address :</span> {{ $requestDetail->technician->full_address }}</li>

                                                <li class="h6"><i data-feather="phone" class="fea icon-sm text-warning mr-2"></i><span class="text-muted">Mobile :</span> {{ $requestDetail->technician->phone_number }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endif 
@push('scripts')
<script>
    $(document).ready(function () {
        $(document).on("click", "#edit-request", function (event) {
            event.preventDefault();
            let route = $(this).attr("data-url");
            let jobReference = $(this).attr("data-job-reference");

            $.ajax({
                url: route,
                beforeSend: function () {
                    $("#spinner-icon").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>');
                },
                // return the result
                success: function (result) {
                    $("#modal-edit-request").modal("show");
                    $("#modal-edit-request").html("");
                    $("#modal-edit-request").html(result).show();
                },
                complete: function () {
                    $("#spinner-icon").hide();
                },
                error: function (jqXHR, testStatus, error) {
                    var message = error + "An error occured while trying to retireve " + jobReference + " service request details.";
                    var type = "error";
                    displayMessage(message, type);
                    $("#spinner-icon").hide();
                },
                timeout: 8000,
            });
        });

        $(".close").click(function () {
            $(".modal-backdrop").remove();
        });

        $(document).on("click", ".verify-security-code", function () {
            if ($("#security_code").val() == $("#security-code").val()) {
                $("#security_code").val("");
                $("#validateSecurityCode").modal("hide");

                $("#cseTechnicianModal").modal("show");
            } else {
                var message = "Invalid Security code";
                var type = "error";
                displayMessage(message, type);
            }
        });

        $(document).on('click', '#cancel-request', function(event) {
            event.preventDefault();
            let route = $(this).attr('data-url');
            let jobReference = $(this).attr('data-job-reference');

            $('#cancel-request-form').attr('action', route);
        });
    });
</script>
@endpush 
@endsection
