<h5>
  Issuer: {{ Str::title($rfqDetails['issuer']['account']['first_name'] ." ". $rfqDetails['issuer']['account']['last_name']) }}<br>
  Service: {{ $rfqDetails->serviceRequest->service->name }}
</h5>
            <div class="table-responsive mt-4">
                <table class="table table-hover mg-b-0" id="basicExample">
                  <thead class="thead-primary">
                    <tr>
                      <th class="text-center">#</th>
                      <th width="30%">Component Name</th>
                      <th width="15%">Model Number</th>
                      <th width="5%" class="text-center">Quantity</th>
                      <th width="25%" class="text-center">Unit Price</th>
                      <th width="25%" class="text-center">Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    <form>
                      @foreach ($rfqDetails->rfqBatches as $item)

                      <input value="{{ $item->id }}" type="hidden" name="rfq_batch_id[]" class="d-none">
                      <input value="{{ $item->id }}" type="hidden" name="quantity[]" 
                      class="d-none">
                        <tr>
                            <td class="tx-color-03 tx-center">{{ ++$i }}</td>
                            <td class="tx-medium">{{ $item->component_name }}</td>
                            <td>{{ $item->model_number }}</td>
                            <td class="tx-medium text-center quantity-{{$item->id}}">{{ $item->quantity }}</td>
                            <td class="tx-medium text-center">
                            <input type="number" maxlength="7" min="1" name="unit_price[]" class="form-control" id="unit-price-{{$item->id}}" value="{{ old('unit_price[]') }}" onkeyup="individualAmount({{ $item->id }})" autocomplete="off">
                            </td>
                          <td class="tx-medium text-center each-amount amount-{{$item->id}}">0</td>
                        </tr>
                      @endforeach
                      <thead class="thead-primary">
                        <tr>
                          <th colspan="2">#</th>
                          <th width="20%">Delivery Fee</th>
                          <th width="20%">Delivery Time</th>
                          <th colspan="2"></th>
                        </tr>
                      </thead>
                      <tr>
                        <td colspan="2">1</td>
                      <td><input class="form-control" name="devlivery_fee" id="devlivery_fee" type="number" maxlength="7" min="1" value="{{ old('devlivery_fee') }}" autocomplete="off"></td>
                        <td><input class="form-control" name="delivery_time" id="delivery_time" type="datetime-local" value="{{ old('delivery_time') }}"></td>
                        <td colspan="2"></td>
                      </tr>
                      <tr>
                        <td colspan="4"></td>
                        <td class="tx-medium text-center">Total</td>
                        <td class="tx-medium text-center total-amount">₦0</td>
                      </tr>
                    </form>
                  </tbody>
                </table>
            </div><!-- table-responsive -->