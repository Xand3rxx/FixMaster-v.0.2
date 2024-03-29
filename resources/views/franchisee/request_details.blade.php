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
            <li class="breadcrumb-item"><a href="{{ route('franchisee.index', app()->getLocale()) }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('franchisee.requests', app()->getLocale()) }}">Requests</a></li>
              <li class="breadcrumb-item active" aria-current="page">Request Details</li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1">Job: REF-234234723</h4><hr>
          <div class="media align-items-center">
            <span class="tx-color-03 d-none d-sm-block">
              {{-- <i data-feather="credit-card" class="wd-60 ht-60"></i> --}}
              <img src="{{ asset('assets/images/default-male-avatar.png') }}" class="avatar rounded-circle" alt="Male Avatar">
            </span>
            <div class="media-body mg-sm-l-20">
              <h4 class="tx-18 tx-sm-20 mg-b-2">Kelvin Adesanya</h4>
              <p class="tx-13 tx-color-03 mg-b-0">08173682832</p>
            </div>
          </div><!-- media -->
        </div>
      </div>
     
      <div class="row row-xs">
        <div class="col-lg-12 col-xl-12">
          <div class="card">
            <ul class="nav nav-tabs nav-justified" id="myTab3" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="description-tab3" data-toggle="tab" href="#description3" role="tab" aria-controls="description" aria-selected="true">Description</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" id="media-tab3" data-toggle="tab" href="#media3" role="tab" aria-controls="media" aria-selected="false">Service Request Summary</a>
              </li>
            </ul>
              <div class="tab-content bd bd-gray-300 bd-t-0 pd-20" id="myTabContent3">

                <div class="tab-pane fade show active" id="description3" role="tabpanel" aria-labelledby="description-tab3">

                  <div class="divider-text">Assign CSE</div>

                  <small class="text-danger" >This portion is only visible if no CSE accepts the service request within your region</small>
                  <form method="POST" action="">
                    @csrf
                    <div class="form-row">
                      <div class="form-group col-md-4">
                        <label>CSE List</label>
                        <select class="custom-select" name="cse_id" id="cse_id" required>
                          <option selected>Select...</option>
                          <option value="1">Andrew Nwankwo</option>
                          <option value="2">Taofeek Adedokun</option>
                          <option value="3">Blessing Nnamdi</option>
                          <option value="4">Bidemi George</option>
                          <option value="5">Isaac Johnson</option>
                        </select>
                      </div>

                    </div>


                    <button type="submit" class="btn btn-primary">Assign</button>
                  </form>

                  <div class="divider-text">Service Request Description</div>

                  <h6>SERVICE REQUEST DESCRIPTION</h6>
                  <div class="row row-xs mt-4">
                    <div class="col-lg-12 col-xl-12">
                      <table class="table table-striped table-sm mg-b-0">
                        <tbody>
                          <tr>
                            <td class="tx-medium">Job Reference</td>
                            <td class="tx-color-03">REF-234234723</td>
                          </tr>
                          <tr>
                            <td class="tx-medium">Service Required</td>
                            <td class="tx-color-03">Eletronics (Computer & Laptops)</td>
                          </tr>
                          <tr>
                            <td class="tx-medium">Scheduled Date & Time</td>
                            <td class="tx-color-03">{{ Carbon\Carbon::parse('2020-12-28 16:58:54', 'UTC')->isoFormat('MMMM Do YYYY, h:mm:a') }}</td>
                          </tr>
                          <tr>
                            <td class="tx-medium">Payment Status</td>
                            <td class="tx-color-03"><span class="text-success">Success</span>(Paystack or Flutterwave or E-Wallet or Offline)</td>
                          </tr>
                          <tr>
                            <td class="tx-medium">Initial Service Charge</td>
                            <td class="tx-color-03">₦{{ number_format(10000) }} Standard Price</td>
                          </tr>
                          <tr>
                            <td class="tx-medium">Total Service Charge</td>
                            <td class="tx-color-03">₦{{ number_format(15000) }}</td>
                          </tr>
                          <tr>
                            <td class="tx-medium">Security Code</td>
                            <td class="tx-color-03">SEC-27AEC73E</td>
                          </tr>
                          <tr>
                            <td class="tx-medium">Supervised By</td>
                            <td class="tx-color-03">David Akinsola</td>
                          </tr>
                          <tr>
                            <td class="tx-medium">CSE's Assigned</td>
                            <td class="tx-color-03">
                              (1) Benedict Mayowa<br>
                              (2) Other CSE's Assigned
                            </td>
                          </tr>
                          <tr>
                            <td class="tx-medium">Technicians Assigned</td>
                            <td class="tx-color-03">
                              (1) Jamal Diwa<br>
                              (2) Other technicians Assigned
                            </td>
                          </tr>
                          <tr>
                            <td class="tx-medium">Quality Assurance Managers Assigned</td>
                            <td class="tx-color-03">
                              (1) UNAVAILABLE<br>
                              (2) Other QA's Assigned
                            </td>
                          </tr>
                          <tr>
                            <td class="tx-medium">State</td>
                            <td class="tx-color-03">Lagos</td>
                          </tr>
                          <tr>
                            <td class="tx-medium">L.G.A</td>
                            <td class="tx-color-03">Eti-Osa</td>
                          </tr>
                          <tr>
                            <td class="tx-medium">Town/City</td>
                            <td class="tx-color-03">Ikoyi</td>
                          </tr>
                          <tr>
                            <td class="tx-medium">Request Address</td>
                            <td class="tx-color-03">27B, Bourdillon Road off Falomo, Ikoyi-Lagos.</td>
                          </tr>
                          <tr>
                            <td class="tx-medium">Request Description</td>
                            <td class="tx-color-03">My pc no longer comes on even when plugged into a power source.</td>
                          </tr>

                          {{-- If theres a cancellation, make this row visible --}}
                          {{-- @if(!empty($requestDetail->serviceRequestCancellationReason->reason)) --}}
                          <tr>
                            <td class="tx-medium">Reason for Cancellation </td>
                            <td class="tx-color-03">I'm no longer interested. <span class="text-danger">(Only visible if the request was cancelled)</span></td>
                          </tr>
                          {{-- @endif --}}
                        </tbody>
                      </table>

                      {{-- @if(!empty($requestDetail->serviceRequestDetail->media_file)) --}}
                      <div class="divider-text">Media Files</div>
                        <div class="row">
                          <div class="pd-20 pd-lg-25 pd-xl-30">
                
                            <div class="row row-xs">
                              <div class="col-6 col-sm-6 col-md-6 col-xl mg-t-10 mg-sm-t-0">
                                <div class="card card-file">
                              
                                  
                                  {{-- Media file design will come in here afterwrds --}}
                                  <div class="placeholder-media wd-100p wd-sm-55p wd-md-45p">
                                    <div class="line"></div>
                                  </div>
                                </div>
                              </div><!-- col -->
                              
                            </div><!-- row -->
                            
                          </div>
                        </div>
                      {{-- @endif --}}
                    </div><!-- df-example -->
                  </div>
                </div>

                <div class="tab-pane fade" id="media3" role="tabpanel" aria-labelledby="media-tab3">
                  <h5 class="mt-4 text-primary">Service Request Progress</h5>
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
                    
                          <tr>
                            <td class="tx-color-03 tx-center">1</td>
                            <td class="tx-medium">David Akinsola (CSE)</td>
                            <td class="tx-medium text-success">Enroute to Clien't house</td>
                            <td class="text-center">{{ Carbon\Carbon::parse('2020-12-28 16:58:54', 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                          </tr>
                      </tbody>
                    </table>
                  </div><!-- table-responsive -->

                  <h5 class="mt-4 text-primary">Tool Requests</h5>
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
                        {{-- @foreach($requestDetail->toolRequests as $toolRequest)
                        @php  $z = 0; @endphp
                        <tr>
                          <td class="tx-color-03 tx-center">{{ ++$z }}</td>
                          <td class="tx-medium">{{ $toolRequest->batch_number }}</td>
                          <td class="tx-medium">{{ $toolRequest->serviceRequest->user->fullName->name }}</td>
                          <td class="tx-medium">{{ $toolRequest->approver->fullName->name ?? 'Null' }}</td>
                          <td class="tx-medium">{{ $toolRequest->requester->fullName->name }}</td>
                          @if($toolRequest->status == 'Pending')
                            <td class="text-medium text-warning">Pending</td>
                          @elseif($toolRequest->status == 'Approved')
                            <td class="text-medium text-success">Approved</td>
                          @else
                            <td class="text-medium text-danger">Declined</td>
                          @endif
                          <td class="text-medium">{{ Carbon\Carbon::parse($toolRequest->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                          <td class=" text-center">
                            <a href="#toolsRequestDetails" data-toggle="modal" class="btn btn-sm btn-primary" title="View {{ $toolRequest->batch_number}} details" data-batch-number="{{ $toolRequest->batch_number}}" data-url="{{ route('tool_request_details', $toolRequest->id) }}" id="tool-request-details">Details</a>
                          </td>
                        </tr>
                        @endforeach --}}

                        @php  $z = 0; @endphp
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


                  <h5 class="mt-4 text-primary">Request For Quotation</h5>
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
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php  $y = 0; @endphp
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
  $(function(){
    'use strict'

    $(document).on('click', '#tool-request-details', function(event) {
      event.preventDefault();
      let route = $(this).attr('data-url');
      let batchNumber = $(this).attr('data-batch-number');
      
      $.ajax({
          url: route,
          beforeSend: function() {
            $("#spinner-icon").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>');
          },
          // return the result
          success: function(result) {
              $('#modal-body').modal("show");
              $('#modal-body').html('');
              $('#modal-body').html(result).show();
          },
          complete: function() {
              $("#spinner-icon").hide();
          },
          error: function(jqXHR, testStatus, error) {
              var message = error+ ' An error occured while trying to retireve '+ batchNumber +'  details.';
              var type = 'error';
              displayMessage(message, type);
              $("#spinner-icon").hide();
          },
          timeout: 8000
      })
    });

    $(document).on('click', '#rfq-details', function(event) {
      event.preventDefault();
      let route = $(this).attr('data-url');
      let batchNumber = $(this).attr('data-batch-number');
      
      $.ajax({
          url: route,
          beforeSend: function() {
            $("#spinner-icon").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>');
          },
          // return the result
          success: function(result) {
              $('#modal-body-rfq-details').modal("show");
              $('#modal-body-rfq-details').html('');
              $('#modal-body-rfq-details').html(result).show();
          },
          complete: function() {
              $("#spinner-icon").hide();
          },
          error: function(jqXHR, testStatus, error) {
              var message = error+ ' An error occured while trying to retireve '+ batchNumber +'  details.';
              var type = 'error';
              displayMessage(message, type);
              $("#spinner-icon").hide();
          },
          timeout: 8000
      })
    });

    $('.close').click(function (){
      $(".modal-backdrop").remove();
    });

  });


</script>
@endpush

@endsection