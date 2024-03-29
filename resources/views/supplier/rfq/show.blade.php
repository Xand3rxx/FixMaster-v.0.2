@extends('layouts.dashboard')
@section('title', 'Supplier Requests For Qoute Details')
@include('layouts.partials._messages')
@section('content')

<div class="content-body">
  <div class="container pd-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('supplier.rfq', app()->getLocale()) }}">RFQ's List</a></li>
                <li class="breadcrumb-item active" aria-current="page">New RFQ Details</li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1">New Requests for Quotation(RFQ) Details</h4>
        </div>
      </div>

    <div class="row row-xs">
        <div class="col-12 justify-content-center text-center align-items-center">
        <a href="{{ route('supplier.rfq_send_supplier_invoice', ['rfq'=>$rfqDetails->uuid, 'locale'=>app()->getLocale()]) }}" class="btn btn-primary float-right"><i class="fas fa-file-medical"></i> Send Invoce</a>
        </div>

      <div class="col-lg-12 col-xl-12 mg-t-10">
            <h5>JOB: {{ $rfqDetails->serviceRequest->unique_id }} <br>RFQ: {{ $rfqDetails->unique_id }}</h5>
            <div class="table-responsive mt-4">
              <table class="table table-striped table-sm mg-b-0">
                <tbody>
                  <tr>
                    <td class="tx-medium">Supplier's Name</td>
                    <td class="tx-color-03">
                      {{ !empty($rfqDetails['rfqSupplier']['supplier']['account']['first_name']) ? Str::title($rfqDetails['rfqSupplier']['supplier']['account']['first_name'] ." ". $rfqDetails['rfqSupplier']['supplier']['account']['last_name']) : 'UNAVAILABLE' }}</td>
                  </tr>
                  <tr>
                    <td class="tx-medium">Delivery Fee</td>
                    <td class="tx-color-03">₦{{ number_format($rfqDetails->rfqSupplier->devlivery_fee ?? '0') }}</td>
                  </tr>
                  <tr>
                    <td class="tx-medium">Delivery Time</td>
                    <td class="tx-color-03">{{ Carbon\Carbon::parse($rfqDetails->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                  </tr>
                  <tr>
                    <td class="tx-medium">Issued By</td>
                    <td class="tx-color-03">{{ !empty($rfqDetails['issuer']['account']['first_name']) ? Str::title($rfqDetails['issuer']['account']['first_name'] ." ". $rfqDetails['issuer']['account']['last_name']) : 'UNAVAILABLE' }}</td>
                  </tr>
                  <tr>
                    <td class="tx-medium">Client Name</td>
                    <td class="tx-color-03">{{ !empty($rfqDetails['client']['account']['first_name']) ? Str::title($rfqDetails['client']['account']['first_name'] ." ". $rfqDetails['client']['account']['last_name']) : 'UNAVAILABLE' }}</td>
                  </tr>
                  
                  <tr>
                    <td class="tx-medium">CSE Acceptance</td>
                    @if($rfqDetails->accepted == 'Yes')
                    <td class="tx-color-03">Yes, all ordered components were delivered</td>
                    @elseif($rfqDetails->accepted == 'No')
                      <td class="tx-color-03">No, all ordered components were not delivered</td>
                    @else
                      <td class="tx-color-03">Pending payment</td>
                    @endif
                    <td class="tx-color-03"></td>
                  </tr>
                  
                  <tr>
                    <td class="tx-medium">Grand Total</td>
                    <td class="tx-color-03">₦{{ number_format($rfqDetails->total_amount + (!empty($rfqDetails->rfqSupplier->devlivery_fee) ? $rfqDetails->rfqSupplier->devlivery_fee : 0)) ?? 0 }}</td>
                  </tr>

                </tbody>
              </table>
            </div>

            <div class="table-responsive mt-4">
                <table class="table table-hover mg-b-0" id="basicExample">
                  <thead class="thead-primary">
                    <tr>
                      <th class="text-center">#</th>
                      <th>Manufacturer Name</th>
                      <th>Model Number</th>
                      <th>Component Name</th>
                      <th class="text-center">Quantity</th>
                      <th class="text-center">Size</th>
                      <th>Unit of Measurement</th>
                      <th class="text-center">Image</th>
                      <th class="text-center">Amount(₦)</th>
                    </tr>
                  </thead>
                  <tbody>
                      @foreach ($rfqDetails->rfqBatches as $item)
                        <tr>
                            <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
                            <td class="tx-medium">{{ !empty($item->manufacturer_name) ? $item->manufacturer_name : 'UNAVAILABLE' }}</td>
                            <td class="tx-medium">{{ !empty($item->model_number) ? $item->model_number : 'UNAVAILABLE' }}</td>
                            <td class="tx-medium">{{ !empty($item->component_name) ? $item->component_name : 'UNAVAILABLE' }}</td>
                            <td class="tx-medium text-center">{{ !empty($item->quantity) ? number_format($item->quantity) : '0' }}</td>
                            <td class="tx-medium text-center">{{ !empty($item->size) ? number_format($item->size) : '0' }}</td>
                            <td class="tx-medium">{{ !empty($item->unit_of_measurement) ? $item->unit_of_measurement : 'UNAVAILABLE' }}</td>
                            <td class="text-center">
                              @if(!empty($item->image))
                              <a href="#rfqImageDetails" data-toggle="modal" class="text-info" title="View {{ $item->component_name }} image" data-batch-number="{{ $item->id }}" data-url="{{ route('supplier.rfq_details_image', ['image'=>$item->id, 'locale'=>app()->getLocale()]) }}" id="rfq-image-details"> View</a>
                              @else
                                    -
                              @endif
                            </td>
                            <td class="tx-medium text-center">{{ !empty($item->amount) ? number_format($item->amount) : '0' }}</td>
                        </tr>
                      @endforeach
                  </tbody>
                </table>
            </div><!-- table-responsive -->

      </div><!-- col -->
    </div><!-- row -->

  </div><!-- container -->

</div>

@include('supplier.rfq._rfq_details_modal')

@endsection