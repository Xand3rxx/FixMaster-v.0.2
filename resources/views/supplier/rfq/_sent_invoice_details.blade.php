<h5>JOB: {{ $rfqDetails->rfq->serviceRequest->unique_id }} <br>RFQ: {{ $rfqDetails->rfq->unique_id }}</h5>
{{-- {{dd($supplierInvoice->supplierInvoiceBatches->count())}} --}}
<div class="table-responsive mt-4">
  <table class="table table-striped table-sm mg-b-0">
    <tbody>
      <tr>
        <td class="tx-medium">Issued By</td>
        <td class="tx-color-03">{{ Str::title($rfqDetails['rfq']['issuer']['account']['first_name'] ." ". $rfqDetails['rfq']['issuer']['account']['last_name']) }}(Client Service Executive)</td>
      </tr>
      <tr>
        <td class="tx-medium">Client Name</td>
        <td class="tx-color-03">{{ Str::title($rfqDetails['rfq']['client']['account']['first_name'] ." ". $rfqDetails['rfq']['client']['account']['last_name']) }}</td>
      </tr>
      <tr>
        <td class="tx-medium">Delivery Fee</td>
        <td class="tx-color-03">₦{{ number_format($rfqDetails->delivery_fee) ?? '0' }}</td>
      </tr>
      <tr>
        <td class="tx-medium">Delivery Time</td>
        <td class="tx-color-03">{{ Carbon\Carbon::parse($rfqDetails->delivery_time, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
      </tr>
      <tr>
        <td class="tx-medium">Grand Total</td>
        <td class="tx-color-03">₦{{ number_format($rfqDetails->total_amount) ?? 0 }}</td>
      </tr>

    </tbody>
  </table>
</div>

<div class="table-responsive mt-4">
  <table class="table table-hover mg-b-0" id="basicExample">
    <thead class="thead-primary">
      <tr>
        <th class="text-center">#</th>
        <th>Component Name</th>
        <th>Model Number</th>
        <th class="text-center">Quantity</th>
        <th class="text-center">Unit Price(₦)</th>
        <th class="text-center">Amount(₦)</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($rfqDetails->supplierInvoiceBatches as $item)
          <tr>
              <td class="tx-color-03 tx-center">{{ ++$i }}</td>
              <td class="tx-medium">{{ $item->rfqBatch->component_name }}</td>
              <td class="tx-medium">{{ $item->rfqBatch->model_number }}</td>
              <td class="tx-medium text-center">{{ $item->quantity }}</td>
              <td class="tx-medium text-center">₦{{ number_format($item->unit_price) }}</td>
              <td class="tx-medium text-center">₦{{ number_format($item->total_amount) }}</td>
          </tr>
        @endforeach
    </tbody>
  </table>
</div><!-- table-responsive -->