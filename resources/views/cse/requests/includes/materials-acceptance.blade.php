<h3>Material Acceptance</h3>
<section>
    <small class="text-danger">This portion will display only if the CSE initially executed a RFQ, the Client paid for the components and the Supplier has made the delivery.</small>

    
    <div class="table-responsive mt-4">
        <h3>Supplier Details</h3>
        <table class="table table-striped table-sm mg-b-0">
            <tbody>

                <tr>
                    <td class="tx-medium">Supplier Name</td>
                    <td class="tx-color-03">{{ !empty($materials_accepted['rfqSupplier']['supplier']['account']['first_name']) ? Str::title($materials_accepted['rfqSupplier']['supplier']['account']['first_name'] ." ". $materials_accepted['rfqSupplier']['supplier']['account']['last_name']) : 'UNAVAILABLE' }} <small class="text-muted">(Business Name: {{ $materials_accepted['rfqSupplier']['supplier']['supplier']['business_name'] }})</small></td>
                </tr>
                <tr>
                    <td class="tx-medium">Dispatch Status</td>
                    <td class="text-info">In-Transit</td>
                </tr>
                <tr>
                    <td class="tx-medium">Delivery Status</td>
                    @if($materials_accepted['status'] == 'Pending' || $materials_accepted['status'] == 'Awaiting')
                        <td class="text-warning">{{ $materials_accepted['status'] }}</td>
                    @elseif($materials_accepted['status'] == 'Shipped')
                        <td class="text-info">{{ $materials_accepted['status'] }}</td>
                    @elseif($materials_accepted['status'] == 'Delivered')
                        <td class="text-success">{{ $materials_accepted['status'] }}</td>
                    @endif
                </tr>
                <tr>
                    <td class="tx-medium">Delivery Fee</td>
                    <td class="tx-color-03">₦{{ !empty($materials_accepted['rfqSupplier']['devlivery_fee']) ? number_format($materials_accepted['rfqSupplier']['devlivery_fee']) : 0 }}</td>
                </tr>
                <tr>
                    <td class="tx-medium">Delivery Time</td>
                    <td class="tx-color-03">{{ !empty($materials_accepted['rfqSupplier']['delivery_time']) ? Carbon\Carbon::parse($materials_accepted['rfqSupplier']['delivery_time'], 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') : 'UNAVAILABLE' }}</td>
                </tr>
                <tr>
                    <td class="tx-medium">Grand Total</td>
                    <td class="tx-color-03">₦{{ number_format($materials_accepted['total_amount'] + (!empty($materials_accepted['rfqSupplier']['devlivery_fee']) ? $materials_accepted['rfqSupplier']['devlivery_fee'] : 0)) ?? 0 }}</td>
                </tr>

            </tbody>
        </table>
    </div>

    <div class="table-responsive mt-4">
        <table class="table table-hover mg-b-0" id="basicExampl">
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
                    <th class="text-center">Unit Price(₦)</th>
                    <th class="text-center">Amount(₦)</th>
                </tr>
            </thead>
            <tbody>
               
                @foreach ($materials_accepted['rfqBatches'] as $item)
                    <tr>
                        <td class="tx-color-03 tx-center">{{ ++$loop->iteration }}</td>
                        <td class="tx-medium">{{ !empty($item->manufacturer_name) ? $item->manufacturer_name : 'UNAVAILABLE' }}</td>
                        <td class="tx-medium">{{ !empty($item->model_number) ? $item->model_number : 'UNAVAILABLE' }}</td>
                        <td class="tx-medium">{{ !empty($item->component_name) ? $item->component_name : 'UNAVAILABLE' }}</td>
                        <td class="tx-medium text-center">{{ !empty($item->quantity) ? number_format($item->quantity) : '0' }}</td>
                        <td class="tx-medium text-center">{{ !empty($item->size) ? number_format($item->size) : '0' }}</td>
                        <td class="tx-medium">{{ !empty($item->unit_of_measurement) ? $item->unit_of_measurement : 'UNAVAILABLE' }}</td>
                        <td class="text-center">
                            @if(!empty($item->image))
                            <a href="#rfqImageDetails" data-toggle="modal" class="text-info" title="View {{ $item->component_name }} image" data-batch-number="{{ $item->id }}" data-url="{{ route('cse.rfq_details_image', ['image'=>$item->id, 'locale'=>app()->getLocale()]) }}" id="rfq-image-details"> View</a>
                            @else
                                -
                            @endif
                        </td>

                        @foreach($item['supplierInvoiceBatches'] as $amount)
                            <td class="tx-medium text-center">{{ !empty($amount['unit_price']) ? number_format($amount['unit_price']) : '0' }}</td>
                            <td class="tx-medium text-center">{{ !empty($amount['total_amount']) ? number_format($amount['total_amount']) : '0' }}</td>
                        @endforeach

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div><!-- table-responsive -->

    <h5>Update RFQ Status</h5>
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="status">Status</label>
            <select class="form-control custom-select" id="status" name="status">
                <option selected disabled value="" selected>Select...</option>
                <option value="Awaiting" value="{{ old('Awaiting') }}"
                    {{ old('status') == 'Awaiting' ? 'selected' : '' }}>Awaiting</option>
                <option value="Shipped" value="{{ old('Shipped') }}"
                    {{ old('status') == 'Shipped' ? 'selected' : '' }}>Shipped</option>
                <option value="Delivered" value="{{ old('Shipped') }}"
                    {{ old('status') == 'Delivered' ? 'selected' : '' }}>Delivered</option>
            </select>
            @error('status')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    @if($materials_accepted['status'] == 'Delivered')
    <h5>Accept Materials Delivery</h5>
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="accepted">Accept Delivery</label>
            <select class="form-control custom-select" id="accepted" name="accepted">
                <option selected disabled value="" selected>Select...</option>
                <option value="Yes" value="{{ old('Yes') }}"
                    {{ old('accepted') == 'Yes' ? 'selected' : '' }}>Yes, all ordered components were
                    delivered</option>
                <option value="No" value="{{ old('No') }}"
                    {{ old('accepted') == 'No' ? 'selected' : '' }}>No, all ordered components were not
                    delivered</option>
            </select>
            @error('accepted')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group decline-rfq-reason col-md-12">
            <label for="reason">Reason</label>
            <textarea rows="3" class="form-control @error('reason') is-invalid @enderror" id="reason"
                name="reason"></textarea>
        </div>
    </div>
    @endif

</section>

@push('scripts')
<script>
$(document).ready(function() {
    //Get image associated with invoice quote
    $(document).on('click', '#rfq-image-details', function(event) {
      event.preventDefault();
      let route = $(this).attr('data-url');
      let batchNumber = $(this).attr('data-batch-number');
      
      $.ajax({
          url: route,
          beforeSend: function() {
            $("#modal-image-body").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>');
          },
          // return the result
          success: function(result) {
              $('#modal-image-body').modal("show");
              $('#modal-image-body').html('');
              $('#modal-image-body').html(result).show();
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

  });
</script>
  @endpush