@extends('layouts.dashboard')
@section('title', 'Request Details')
@include('layouts.partials._messages')
@section('content')
<link rel="stylesheet" href="{{ asset('assets/dashboard/assets/css/dashforge.filemgr.css') }}">

<div class="content-body">
    <div class="container pd-x-0">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item"><a href="{{ route('cse.index', app()->getLocale()) }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('cse.requests.index', app()->getLocale()) }}">Requests</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Request Details</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Job: {{$service_request->unique_id}}</h4>
                <hr>
                <div class="media align-items-center">
                    <span class="tx-color-03 d-none d-sm-block">
                        {{-- <i data-feather="credit-card" class="wd-60 ht-60"></i> --}}
                        <img src="{{ asset('assets/images/default-male-avatar.png') }}" class="avatar rounded-circle" alt="Male Avatar">
                    </span>
                    <div class="media-body mg-sm-l-20">
                        <h4 class="tx-18 tx-sm-20 mg-b-2">{{ucfirst($service_request->client->account->first_name)}}
                        {{ucfirst($service_request->client->account->last_name)}}</h4>
                                        
                        <p class="tx-13 tx-color-03 mg-b-0">{{$service_request->client->account->contact->phone_number}}
                            <a href="tel:{{$service_request->client->account->contact->phone_number}}" class="btn btn-primary btn-icon"><i class="fas fa-phone"></i> Call Client</a>
                        </p>
                    </div>
                </div><!-- media -->
            </div>
        </div>

        <div class="row row-xs">
            <div class="col-lg-12 col-xl-12">

                <div class="contact-content-header mt-4">
                    <nav class="nav">
                
                        <a href="#serviceRequestActions" class="nav-link active" data-toggle="tab">Service Request Actions</a>
                      
                        <a href="#description" class="nav-link" data-toggle="tab"><span>Job Description</a>
                        <a href="#serviceRequestSummary" class="nav-link" data-toggle="tab"><span>Service Request Summary</a>
                    </nav>
                    {{-- <a href="" id="contactOptions" class="text-secondary mg-l-auto d-xl-none"><i data-feather="more-horizontal"></i></a> --}}
                </div><!-- contact-content-header -->

                <div class="contact-content-body">
                    <div class="tab-content">
                  
                        <div id="serviceRequestActions" class="tab-pane show active pd-20 pd-xl-25">
                            <small class="text-danger">This tab is only visible once the Service request has an Ongoing status. Which logically is updated by the system or the CSE Coordinator by assigning a CSE to the request</small>
                            @if ($service_request->status_id == 1)
                            @include('cse.requests.includes.assign_first_technician')
                            @elseif($service_request->status_id == 2)
                            @include('cse.requests.includes.ongoing_service_request')
                            @push('scripts')
                            @include('cse.requests.includes.ongoing_service_request_script')
                            @endpush
                            @else
                            <h4> Completed the Service Request </h4>
                            @endif
                        </div>
                    </div><!-- media -->

                    <div class="contact-content-header mt-4">
                        <nav class="nav">
                            <a href="#serviceRequestActions" class="nav-link active" data-toggle="tab">Service Request
                                Actions</a>
                            <a href="#description" class="nav-link" data-toggle="tab"><span>Job Description</a>
                            <a href="#serviceRequestSummary" class="nav-link" data-toggle="tab"><span>Service Request
                                    Summary</a>
                        </nav>
                    </div><!-- contact-content-header -->

                    <div class="contact-content-body">
                        <div class="tab-content">

                            {{-- Service Request Actions --}}
                            <form class="form-data" enctype="multipart/form-data" method="POST"
                                action="{{ route('cse.service.request.action', ['locale' => app()->getLocale(), 'service_request' => $service_request->uuid]) }}">
                                @csrf
                                <div id="serviceRequestActions" class="tab-pane show active pd-20 pd-xl-25">
                                    <div class="mt-4">
                                        <div class="tx-13 mg-b-25">
                                            <div id="wizard3">
                                                @if(is_null($service_request['preferred_time']))
                                                @include('cse.requests.includes.schedule_date')
                                                @endif
                                                @include('cse.requests.includes.reoccuring_actions')
                                            </div>
                                        </div>
                                    </div><!-- df-example -->

                                </div>
                            </div>

                            <div class="divider-text">Service Request Progress</div>
                            <h5 class="mt-4">Service Request Progress</h5>
                            <div class="table-responsive mb-4">
                                <table class="table table-hover mg-b-0">
                                    <thead class="">
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Author</th>
                                            <th>Status</th>
                                            <th class="text-center">Timestamp</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($request_progress as $key => $progress)
                                        <tr>
                                            <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
                                            <td class="tx-medium">{{ Str::title($progress['user']['account']['last_name'] . ' '.$progress['user']['account']['first_name'])  }} ({{$progress['user']['roles'][0]['name']}})</td>
                                            <td class="tx-medium text-success"> {{$progress['substatus']['name']}} </td>
                                            <td class="text-center">{{ Carbon\Carbon::parse($progress['created_at'], 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div><!-- table-responsive -->

                            <div class="divider-text">Tools Request</div>
                            <h5 class="mt-4">Tools Requests</h5>
                            <div class="table-responsive mb-4">
                                <table class="table table-hover mg-b-0">
                                    <thead class="">
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Batch Number</th>
                                            <th>Client</th>
                                            <th>Approved By</th>
                                            <th>Requested By</th>
                                            <th>Status</th>
                                            <th>Date Requested</th>
                                            <th>Action</th>
                                         
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @php $z = 0; @endphp
                                        <tr>
                                            <td class="tx-color-03 tx-center">{{ ++$z }}</td>
                                            <td class="tx-medium">TRF-C85BEA04</td>
                                            <td class="tx-medium">Kelvin Adesanya</td>
                                            <td class="tx-medium">Charles Famoriyo</td>
                                            <td class="tx-medium">David Akinsola (CSE)</td>
                                            <td class="text-medium text-success">Approved</td>

                                            <td class="text-medium">{{ Carbon\Carbon::parse('2020-12-28 16:58:54', 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                                            <td class=" text-center">
                                                <a href="#toolsRequestDetails" data-toggle="modal" class="btn btn-sm btn-primary" title="View TRF-C85BEA04 details" data-batch-number="TRF-C85BEA04" data-url="#" id="tool-request-details">Details</a>
                                            </td>
                                            
                                        </tr>
                                    </tbody>
                                </table>
                            </div><!-- table-responsive -->

                            <div class="divider-text">RFQ's</div>
                            <h5 class="mt-4">Request For Quotation</h5>
                            <div class="table-responsive">

                                <table class="table table-hover mg-b-0 mt-4">
                                    <thead class="">
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Batch Number</th>
                                            <th>Client</th>
                                            <th>Issued By</th>
                                            <th>Status</th>
                                            <th class="text-center">Total Amount</th>
                                            <th>Date Created</th>
                                            @if(Auth::user()->type->url != 'admin')
                                            <th>Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $y = 0; @endphp
                                        <tr>
                                            <td class="tx-color-03 tx-center">{{ ++$y }}</td>
                                            <td class="tx-medium">RFQ-C85BEA04 </td>
                                            <td class="tx-medium">Kelvin Adesanya</td>
                                            <td class="tx-medium">David Akinsola</td>
                                            <td class="text-medium text-success">Payment received</td>
                                            <td class="tx-medium text-center">₦{{ number_format(5000) ?? 'Null'}}</td>
                                            <td class="text-medium">{{ Carbon\Carbon::parse('2020-12-28 16:58:54', 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                                          
                                            <td class=" text-center">
                                                <a href="#rfqDetails" data-toggle="modal" class="btn btn-sm btn-primary" title="View RFQ-C85BEA04 details" data-batch-number="RFQ-C85BEA04" data-url="#" id="rfq-details"></i> Details</a>
                                            </td>
                                            
                                        </tr>
                                    </tbody>
                                </table>
                            </div><!-- table-responsive -->
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="toolsRequestDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content tx-14">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel2">Tools Request</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-body">
                <!-- Modal displays here -->
                <div id="spinner-icon"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="rfqDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content tx-14">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel2">RFQ Details</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-body-rfq-details">
                <!-- Modal displays here -->
                <div id="spinner-icon"></div>
            </div>
        </div>
    </div>
</div>

@push('scripts')

<script>
    $(function() {
        'use strict'
        $('#wizard3').steps({
            headerTag: 'h3'
            , bodyTag: 'section'
            , autoFocus: true
            , titleTemplate: '<span class="number">#index#</span> <span class="title">#title#</span>'
            , loadingTemplate: '<span class="spinner"></span> #text#'
            , labels: {
                // current: "current step:",
                // pagination: "Pagination",
                finish: "Update Job Progress",
                // next: "Next",
                // previous: "Previous",
                loading: "Loading ..."
            }
            , stepsOrientation: 1,
            // transitionEffect: "fade",
            // transitionEffectSpeed: 200,
            showFinishButtonAlways: false
            , onFinished: function(event, currentIndex) {
                $('#update-progress').trigger('click');
            }
        , });
        let count = 1;
        //Add and Remove Request for
        $(document).on('click', '.add-rfq', function() {
            count++;
            addRFQ(count);
        });
        $(document).on('click', '.remove-rfq', function() {
            count--;
            $(this).closest(".remove-rfq-row").remove();
            // $(this).closest('tr').remove();
        });
        //Add and Remove Tools request form
        $(document).on('click', '.add-trf', function() {
            count++;
            addTRF(count);
        });
        $(document).on('click', '.remove-trf', function() {
            count--;
            $(this).closest(".remove-trf-row").remove();
        });
        //Hide and Unhide Work Experience form
        $('#work_experience_yes').change(function() {
            if ($(this).prop('checked')) {
                $('.previous-employment').removeClass('d-none');
            }
        });
        $('#work_experience_no').change(function() {
            if ($(this).prop('checked')) {
                $('.previous-employment').addClass('d-none');
            }
        });
        //Hide and Unhide RFQ
        $('#rfqYes').change(function() {
            if ($(this).prop('checked')) {
                $('.d-rfq').removeClass('d-none');
            }
        });
        $('#rfqNo').change(function() {
            if ($(this).prop('checked')) {
                $('.d-rfq').addClass('d-none');
            }
        });
        //Hide and Unhide TRF
        $('#trfYes').change(function() {
            if ($(this).prop('checked')) {
                $('.d-trf').removeClass('d-none');
            }
        });
        $('#trfNo').change(function() {
            if ($(this).prop('checked')) {
                $('.d-trf').addClass('d-none');
            }
        });
        $(document).on('click', '#tool-request-details', function(event) {
            event.preventDefault();
            let route = $(this).attr('data-url');
            let batchNumber = $(this).attr('data-batch-number');
            $.ajax({
                url: route
                , beforeSend: function() {
                    $("#spinner-icon").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>');
                },
                // return the result
                success: function(result) {
                    $('#modal-body').modal("show");
                    $('#modal-body').html('');
                    $('#modal-body').html(result).show();
                }
                , complete: function() {
                    $("#spinner-icon").hide();
                }
                , error: function(jqXHR, testStatus, error) {
                    var message = error + ' An error occured while trying to retireve ' + batchNumber + '  details.';
                    var type = 'error';
                    displayMessage(message, type);
                    $("#spinner-icon").hide();
                }
                , timeout: 8000
            })
        });
        $(document).on('click', '#rfq-details', function(event) {
            event.preventDefault();
            let route = $(this).attr('data-url');
            let batchNumber = $(this).attr('data-batch-number');
            $.ajax({
                url: route
                , beforeSend: function() {
                    $("#spinner-icon").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>');
                },
                // return the result
                success: function(result) {
                    $('#modal-body-rfq-details').modal("show");
                    $('#modal-body-rfq-details').html('');
                    $('#modal-body-rfq-details').html(result).show();
                }
                , complete: function() {
                    $("#spinner-icon").hide();
                }
                , error: function(jqXHR, testStatus, error) {
                    var message = error + ' An error occured while trying to retireve ' + batchNumber + '  details.';
                    var type = 'error';
                    displayMessage(message, type);
                    $("#spinner-icon").hide();
                }
                , timeout: 8000
            })
        });
        $('.close').click(function() {
            $(".modal-backdrop").remove();
        });
    });
    //Get available quantity of a particular tool.
    $(document).on('change', '.tool_id', function() {
        let toolId = $(this).find('option:selected').val();
        let toolName = $(this).children('option:selected').text();
        let quantityName = $(this).children('option:selected').data('id');
        $.ajax({
            url: "{{ route('available_quantity', app()->getLocale()) }}"
            , method: "POST"
            , dataType: "JSON"
            , data: {
                "_token": "{{ csrf_token() }}"
                , "tool_id": toolId
            }
            , success: function(data) {
                if (data) {
                    $('#' + quantityName + '').attr({
                        "value": data
                        , "max": data
                    , });
                } else {
                    var message = 'Error occured while trying to get ' + toolName + ' available quantity';
                    var type = 'error';
                    displayMessage(message, type);
                }
            }
        , })
    });
</script>
@endpush

@endsection
