@extends('layouts.dashboard')
@section('title', 'Supplier RFQ Invoices')
@include('layouts.partials._messages')
@section('content')

<div class="content-body">
  <div class="container pd-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
      <div>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-style1 mg-b-10">
          <li class="breadcrumb-item"><a href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
            <li class="breadcrumb-item" aria-current="page">RFQ</li>
            <li class="breadcrumb-item active" aria-current="page">Supplier RFQ's Invoices</li>
          </ol>
        </nav>
        <h4 class="mg-b-0 tx-spacing--1">Supplier RFQ's Invoices </h4>
      </div>
    </div>

    <div class="row row-xs">
      <div class="col-lg-12 col-xl-12 mg-t-10">
        <div class="card mg-b-10">
          <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
            <div>
              <h6 class="mg-b-5">Supplier RFQ's Invoices as of {{ date('M, d Y') }}</h6>
              <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all Invoices sent by all FixMaster Suppliers regarding RFQ's initiated by CSE's.</p>
            </div>
            
          </div><!-- card-header -->
         
          <div class="table-responsive">
            
            <table class="table table-hover mg-b-0" id="basicExample">
              <thead class="thead-primary">
                <tr>
                  <th class="text-center">#</th>
                  <th>Job Ref.</th>
                  <th>Batch Number</th>
                  <th>Issued By</th>
                  <th>Supplier</th>
                  {{-- <th>Delivery Fee(₦)</th> --}}
                  <th class="tx-center">Total Amount(₦)</th>
                  <th>Delivery Time</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($rfqs as $rfq)
                <tr>
                  <td class="tx-color-03 tx-center">{{ ++$i }}</td>
                  <td class="tx-medium">{{ $rfq->rfq->serviceRequest->unique_id }}</td>
                  <td class="tx-medium">{{ $rfq->rfq->unique_id }}</td>
                  <td class="tx-medium">{{ Str::title($rfq['rfq']['issuer']['account']['first_name'] ." ". $rfq['rfq']['issuer']['account']['last_name']) }}</td>
                  <td class="tx-medium">{{ Str::title($rfq['supplier']['account']['first_name'] ." ". $rfq['supplier']['account']['last_name']) }}</td>
                  {{-- <td class="tx-medium tx-center">{{ $rfq->delivery_fee }}</td> --}}
                  <td class="tx-medium tx-center">{{ $rfq->total_amount }}</td>
                  <td class="text-medium">{{ Carbon\Carbon::parse($rfq->delivery_time, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>

                  <td class=" text-center">
                    <div class="dropdown-file">
                      <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
                      <div class="dropdown-menu dropdown-menu-right">

                        <a href="#rfqDetails" data-toggle="modal" class="dropdown-item details text-primary" title="View {{ $rfq->rfq->unique_id}} details" data-batch-number="{{ $rfq->rfq->unique_id}}" data-url="{{ route('admin.supplier_invoices_details', ['rfq'=>$rfq->uuid, 'locale'=>app()->getLocale()]) }}" id="rfq-details"><i class="far fa-clipboard"></i> Details</a>
                       
                        @if($rfq->rfq->status == 'Pending')
                      <a href="{{ route('admin.supplier_invoices_acceptance', ['rfq'=>$rfq->uuid, 'locale'=>app()->getLocale()]) }}" class="dropdown-item details text-success" title="Accept {{ $rfq->rfq->unique_id}} invoice"><i class="fas fa-check"></i> Accept</a>
                        @endif
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

  <div class="modal fade" id="rfqDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
      <div class="modal-content tx-14">
        <div class="modal-header">
          <h6 class="modal-title" id="exampleModalLabel2">Supplier Invoice RFQ Details</h6>
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

</div>


@push('scripts')
<script>
  $(document).ready(function() {
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

    $('.close').click(function (){
      $(".modal-backdrop").remove();
    });


  });


  function individualAmount(count)
  {
    var unitPrice = parseFloat(($('#unit-price-'+count).val().replace(/,/g , '')));
    var quantity  = parseInt($('.quantity-'+count).text());
    var totalAmount = (unitPrice * quantity);
    $('#unit-amount-'+count).val(totalAmount);
    $('.amount-'+count).text(numberWithCommas(totalAmount.toFixed(2)));
    getTotalAmount();
  }

  function deliveryFee(){
    // $('#delivery_fee').keyup(function(){
    //     return $(this).val();
    // });
    $('.delivery-fee').text(numberWithCommas($('#delivery_fee').val()));
    getTotalAmount();
  }

  function getTotalAmount()
  {
    var totalEachAmount = 0;
    var totalAmount = 0;

    $('.each-amount').each(function (){
        var total  = parseInt($(this).val());
        if(isNaN(total) == false){
          totalEachAmount += total;
          $('.total-amount').text('₦'+numberWithCommas(totalEachAmount.toFixed(2)));
          $('#total_amount').val(totalEachAmount);
          // return totalEachAmount;
        }
    });
  }

  function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  }
</script>
@endpush

@endsection