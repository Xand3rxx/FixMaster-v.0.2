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
                      

                        <div id="description" class="tab-pane pd-20 pd-xl-25">
                            <div class="divider-text">Service Request Description</div>

                            <h6>SERVICE REQUEST DESCRIPTION</h6>
                            <div class="row row-xs mt-4">
                                <div class="col-lg-12 col-xl-12">
                                    <table class="table table-striped table-sm mg-b-0">
                                        <tbody>
                                            <tr>
                                                <td class="tx-medium">Job Reference</td>
                                                <td class="tx-color-03"> {{$service_request->unique_id}}</td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Service Required</td>
                                                <td class="tx-color-03"> {{$service_request->service->name}}</td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Scheduled Date & Time </td>
                                     <td class="tx-color-03">{{ !empty($service_request->preferred_time) ? Carbon\Carbon::parse($service_request->preferred_time, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') : 'Not Scheduled yet'}} </td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Payment Status </td>
                                                <td class="tx-color-03"><span class="text-success">{{ucfirst($service_request->payment_statuses->status)}}</span>({{ ucfirst($service_request->payment_statuses->payment_channel)}})</td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Initial Service Charge</td>
                                                <td class="tx-color-03">₦{{ number_format($service_request->price->amount) }} Standard Price</td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Total Service Charge</td>
                                                <td class="tx-color-03">₦{{ number_format($service_request->total_amount) }}</td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Security Code</td>
                                                <td class="tx-color-03">{{$service_request->client_security_code}}</td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Supervised By</td>
                                                <td class="tx-color-03">David Akinsola</td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">CSE's Assigned</td>
                                                <td class="tx-color-03">{{CustomHelpers::arrayToList($service_request->service_request_assignees, 'cse-user')}}</td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Technicians Assigned</td>
                                                <td class="tx-color-03">{{CustomHelpers::arrayToList($service_request->service_request_assignees, 'technician-artisans')}}</td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Quality Assurance Managers Assigned</td>
                                                <td class="tx-color-03">{{CustomHelpers::arrayToList($service_request->service_request_assignees, 'quality-assurance-user')}}</td>
                                                
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">State</td>
                                                <td class="tx-color-03">{{$service_request->client->account->state->name??'UNAVAILABLE'}}</td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">L.G.A</td>
                                                <td class="tx-color-03">{{$service_request->client->account->lga->name?? 'UNAVAILABLE'}}</td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Town/City</td>
                                                <td class="tx-color-03">{{$service_request->client->account->town->name?? 'UNAVAIALABLE'}}</td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Request Address</td>
                                                <td class="tx-color-03">{{$service_request->client->account->contact == null ? '': $service_request->client->account->contact->address}}.</td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Request Description</td>
                                                <td class="tx-color-03">{{$service_request->description}}.</td>
                                            </tr>
                                           
                                            @if(!empty($service_request_cancellation->reason))
                                            <tr>
                                                <td class="tx-medium">Reason for Cancellation </td>
                                                <td class="tx-color-03">I'm no longer interested. <span class="text-danger">(Only visible if the request was cancelled)</span></td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>

                                    <div class="divider-text">Media Files</div>
                                    <div class="row row-xs">
                                        <div class="col-6 col-sm-4 col-md-3 col-xl">
                                          <div class="card card-file">
                                            <div class="dropdown-file">
                                              <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
                                              <div class="dropdown-menu dropdown-menu-right">
                                                <a href="#" class="dropdown-item download"><i data-feather="download"></i>Download</a>
                                              </div>
                                            </div><!-- dropdown -->
                                            <div class="card-file-thumb tx-danger">
                                              <i class="far fa-file-pdf"></i>
                                            </div>
                                            <div class="card-body">
                                              <h6><a href="" class="link-02">{{ substr('54c2a6f3-8a9c-411a-bd68-96a3a37617b2', 0, 15) }}.pdf</a></h6>
                                            </div>
                                            <div class="card-footer"><span class="d-none d-sm-inline">Date Created: </span>{{ \Carbon\Carbon::now('UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</div>
                                          </div>
                                        </div><!-- col -->
                                        <div class="col-6 col-sm-4 col-md-3 col-xl">
                                          <div class="card card-file">
                                            <div class="dropdown-file">
                                              <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
                                              <div class="dropdown-menu dropdown-menu-right">
                                                <a href="#" class="dropdown-item download"><i data-feather="download"></i>Download</a>
                                              </div>
                                            </div><!-- dropdown -->
                                            <div class="card-file-thumb tx-primary">
                                              <i class="far fa-file-word"></i>
                                            </div>
                                            <div class="card-body">
                                                <h6><a href="" class="link-02">{{ substr('1c160a9b-8f52-46f5-a687-1dd608da48b3', 0, 15) }}.docx</a></h6>
                                            </div>
                                            <div class="card-footer"><span class="d-none d-sm-inline">Date Created: </span>{{ \Carbon\Carbon::now('UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</div>
                                          </div>
                                        </div><!-- col -->
                                        <div class="col-6 col-sm-4 col-md-3 col-xl mg-t-10 mg-sm-t-0">
                                          <div class="card card-file">
                                            <div class="dropdown-file">
                                              <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
                                              <div class="dropdown-menu dropdown-menu-right">
                                                <a href="#" class="dropdown-item download"><i data-feather="download"></i>Download</a>
                                              </div>
                                            </div><!-- dropdown -->
                                            <div class="card-file-thumb tx-indigo">
                                              <i class="far fa-file-image"></i>
                                            </div>
                                            <div class="card-body">
                                                <h6><a href="" class="link-02">{{ substr('ff9c0bfa-aeed-4724-a8e4-790cf04a9fdd', 0, 15) }}.jpg</a></h6>
                                            </div>
                                            <div class="card-footer"><span class="d-none d-sm-inline">Date Created: </span>{{ \Carbon\Carbon::now('UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</div>
                                          </div>
                                        </div><!-- col -->
                                        <div class="col-6 col-sm-4 col-md-3 col-xl mg-t-10 mg-md-t-0">
                                          <div class="card card-file">
                                            <div class="dropdown-file">
                                              <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
                                              <div class="dropdown-menu dropdown-menu-right">
                                                <a href="#" class="dropdown-item download"><i data-feather="download"></i>Download</a>
                                              </div>
                                            </div><!-- dropdown -->
                                            <div class="card-file-thumb tx-info">
                                              <i class="far fa-file-video"></i>
                                            </div>
                                            <div class="card-body">
                                                <h6><a href="" class="link-02">{{ substr('d886204a-a376-4924-a83b-2d7a7f84df7d', 0, 15) }}.mp4</a></h6>
                                            </div>
                                            <div class="card-footer"><span class="d-none d-sm-inline">Date Created: </span>{{ \Carbon\Carbon::now('UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</div>
                                          </div>
                                        </div><!-- col -->
                                      </div><!-- row -->
                                </div><!-- df-example -->
                            </div>
                        </div>

                        <div id="serviceRequestSummary" class="tab-pane pd-20 pd-xl-25">
                            <div class="divider-text">Diagnostic Reports</div>
                            <div class="card-group">
                                <div class="card">
                                    <div class="card-body shadow-none bd-primary overflow-hidden">
                                        <div class="marker-primary marker-ribbon pos-absolute t-10 l-0">1</div>

                                        <p class="card-text">After discussion with Mr Kelvin Adesanya, tentatively I beleive his laptop has overheating issues. On-premise diagnosis has to be carried out.</p>
                                        <p class="card-text"><small class="text-muted">Date Created: {{ \Carbon\Carbon::now('UTC') }}</small></p>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body shadow-none bd-primary overflow-hidden">
                                        <div class="marker-primary marker-ribbon pos-absolute t-10 l-0">2</div>
                                        <p class="card-text">After discussion with Mr Kelvin Adesanya, tentatively I beleive his laptop has overheating issues. On-premise diagnosis has to be carried out.</p>
                                        <p class="card-text"><small class="text-muted">Date Created: {{ \Carbon\Carbon::now('UTC') }}</small></p>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body shadow-none bd-primary overflow-hidden">
                                        <div class="marker-primary marker-ribbon pos-absolute t-10 l-0">3</div>

                                        <p class="card-text">After discussion with Mr Kelvin Adesanya, tentatively I beleive his laptop has overheating issues. On-premise diagnosis has to be carried out.</p>
                                        <p class="card-text"><small class="text-muted">Date Created: {{ \Carbon\Carbon::now('UTC') }}</small></p>
                                    </div>
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