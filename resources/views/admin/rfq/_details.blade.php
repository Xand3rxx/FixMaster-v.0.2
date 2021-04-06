<h5>JOB: {{ $rfqDetails->serviceRequest->unique_id }} <br>RFQ: {{ $rfqDetails->unique_id }}</h5>
            <div class="table-responsive mt-4">
              <table class="table table-striped table-sm mg-b-0">
                <tbody>
                  <tr>
                    <td class="tx-medium">Supplier's Name</td>
                    <td class="tx-color-03">{{ Str::title($rfqDetails['rfqSupplier']['supplier']['account']['first_name'] ." ". $rfqDetails['rfqSupplier']['supplier']['account']['last_name']) }}</td>
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
                    <td class="tx-color-03">{{ Str::title($rfqDetails['issuer']['account']['first_name'] ." ". $rfqDetails['issuer']['account']['last_name']) }}</td>
                  </tr>
                  <tr>
                    <td class="tx-medium">Client Name</td>
                    <td class="tx-color-03">{{ Str::title($rfqDetails['client']['account']['first_name'] ." ". $rfqDetails['client']['account']['last_name']) }}</td>
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
                      <th>Component Name</th>
                      <th>Model Number</th>
                      <th class="text-center">Quantity</th>
                      <th class="text-center">Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                      @foreach ($rfqDetails->rfqBatches as $item)
                        <tr>
                            <td class="tx-color-03 tx-center">{{ ++$i }}</td>
                            <td class="tx-medium">{{ $item->component_name }}</td>
                            <td class="tx-medium">{{ $item->model_number }}</td>
                            <td class="tx-medium text-center">{{ $item->quantity }}</td>
                            <td class="tx-medium text-center">₦{{ number_format($item->amount) }}</td>
                        </tr>
                      @endforeach
                  </tbody>
                </table>
            </div><!-- table-responsive -->