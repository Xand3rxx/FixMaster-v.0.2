@extends('layouts.dashboard')
@section('title', 'Dispatched RFQ\'s')
@include('layouts.partials._messages')
@section('content')

<div class="content-body">
  <div class="container pd-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
      <div>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-style1 mg-b-10">
          <li class="breadcrumb-item"><a href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dispatched RFQ's</li>
          </ol>
        </nav>
        <h4 class="mg-b-0 tx-spacing--1">Dispatched RFQ's </h4>
      </div>
    </div>

    <div class="row row-xs">
      <div class="col-lg-12 col-xl-12 mg-t-10">
        <div class="card mg-b-10">
          <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
            <div>
              <h6 class="mg-b-5">Dispatched RFQ's as of {{ date('M, d Y') }}</h6>
              <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all Dispatched RFQ's initiated by you.</p>
            </div>
            
          </div><!-- card-header -->
         
          <div class="table-responsive">
            
            <table class="table table-hover mg-b-0" id="basicExample">
              <thead class="thead-primary">
                <tr>
                  <th class="text-center">#</th>
                  <th>Job Ref.</th>
                  <th>RFQ Batch Number</th>
                  <th>Dispatch Code</th>
                  <th>CSE Status</th>
                  <th>Delivery Status</th>
                  <th>Date Dispatched</th>
                  <th class="text-center">Update Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              {{-- Status: 0 => Awaiting total amount, 1 => Awaiting Client's payment, 2 => Payment received --}}
              <tbody>
                @foreach ($dispatches as $dispatch)
                <tr>
                  <td class="tx-color-03 tx-center">{{ ++$loop->iteration }}</td>
                  {{-- <td class="tx-medium">{{ $rfq->serviceRequest->unique_id }}</td> --}}
                  <td class="tx-medium">{{ $dispatch['rfq']['serviceRequest']['unique_id'] }}</td>
                  <td class="tx-medium">{{ $dispatch['rfq']['unique_id'] }}</td>
                  <td class="tx-medium">{{ $dispatch->unique_id }}</td>
                  @if($dispatch->cse_status == 'Pending')
                    <td class="text-medium text-warning">Pending</td>
                  @elseif($dispatch->cse_status == 'Accepted')
                    <td class="text-medium text-success">Accepted</td>
                  @else
                    <td class="text-medium text-danger">Declined</td>
                  @endif

                  @if($dispatch->supplier_status == 'Processing')
                    <td class="text-medium text-warning">Processing</td>
                  @elseif($dispatch->supplier_status == 'Delivered')
                    <td class="text-medium text-success">Delivered</td>
                  @else
                    <td class="text-medium text-info">In-Transit</td>
                  @endif
                  <td class="text-medium">{{ Carbon\Carbon::parse($dispatch->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                  <td class="text-center">
                    <div class="form-group col-md-12">
                      {{-- <label for="delivery_medium">Update Satus</label> --}}
                      <select name="supplier_status" id="supplier-status" class="form-control @error('supplier_status') is-invalid @enderror supplier-status" required data-url="{{ route('supplier.update_dispatch_status', ['dispatch'=>$dispatch->id, 'locale'=>app()->getLocale()]) }}" data-batch-number="{{ $dispatch->unique_id}}" @if($dispatch->supplier_status == 'Delivered') disabled @endif>
                        <option value="">Select...</option>
                        <option value="Processing">Processing</option>
                        <option value="In-Transit">In-Transit</option>
                        <option value="Delivered" @if($dispatch->supplier_status == 'Delivered') selected @endif>Delivered</option>
                      </select>
                    </div>
                  </td>
                  
                  <td class="text-center">
                    <div class="dropdown-file">
                      <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
                      <div class="dropdown-menu dropdown-menu-right">

                        <a href="#dispatchDetails" data-toggle="modal" class="dropdown-item details text-primary" title="View {{ $dispatch->unique_id}} details" data-batch-number="{{ $dispatch->unique_id}}" data-url="{{ route('supplier.dispatch_details', ['dispatch'=>$dispatch->id, 'locale'=>app()->getLocale()]) }}" id="dispatch-details"><i class="far fa-clipboard"></i> Details</a>
                        
                      </div>
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div><!-- table-responsive -->
        </div><!-- card -->

      </div><!-- col -->
    </div><!-- row -->

  </div><!-- container -->

 

</div>

<div class="modal fade" id="dispatchDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2"> Dispatch Details</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pd-x-25 pd-sm-x-30 pd-t-40 pd-sm-t-20 pd-b-15 pd-sm-b-20" id="modal-body">
          
        </div><!-- modal-body -->
      <div class="modal-footer"></div>
    </div>
  </div>
</div>

@push('scripts')
<script>
  $(document).ready(function() {
    //Get sent invoice quote
    $(document).on('click', '#dispatch-details', function(event) {
      event.preventDefault();
      let route = $(this).attr('data-url');
      let batchNumber = $(this).attr('data-batch-number');
      
      $.ajax({
          url: route,
          beforeSend: function() {
            $("#modal-body").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>');
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

    $(document).on('change', '.supplier-status', function(event) {
      let route = $(this).attr('data-url');
      let batchNumber = $(this).attr('data-batch-number');
      
      $.ajax({
          url: route,
          beforeSend: function() {
            $("#modal-body").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>');
          },
          data: {"supplier_status":$(this).val(), "dispatch_code":batchNumber},
          // return on error
          // return the result
          success: function(result) {
              window.location.reload();
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

  });
</script>

<script>
  $(document).ready(function() {

    $('.close').click(function (){
      $(".modal-backdrop").remove();
    });

  });
</script>
@endpush

@endsection