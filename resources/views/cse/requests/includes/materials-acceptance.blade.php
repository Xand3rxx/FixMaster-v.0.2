<h3>Material Acceptance</h3>
<section>
    <small class="text-danger">This portion will display only if the CSE initially executed a RFQ, the Client paid for
        the components and the Supplier has made the delivery.</small>

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

    <div class="table-responsive mt-4">
        <table class="table table-striped table-sm mg-b-0">
            <tbody>

                <tr>
                    <td class="tx-medium">Supplier Name</td>
                    <td class="tx-color-03">Henry Efe <small class="text-muted">(Business Name: IMPACT)</small></td>
                </tr>
                <tr>
                    <td class="tx-medium">Dispatch Status</td>
                    <td class="text-info">In-Transit</td>
                </tr>
                <tr>
                    <td class="tx-medium">Delivery Status</td>
                    <td class="text-warning">Pending</td>
                </tr>
                <tr>
                    <td class="tx-medium">Delivery Fee</td>
                    <td class="tx-color-03">₦{{ number_format(1500) }}</td>
                </tr>
                <tr>
                    <td class="tx-medium">Delivery Time</td>
                    <td class="tx-color-03">{{ Carbon\Carbon::now('UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                </tr>
                <tr>
                    <td class="tx-medium">Grand Total</td>
                    <td class="tx-color-03">₦{{ number_format(3150) }}</td>
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
                <tr>
                    <td class="tx-color-03 tx-center">1</td>
                    <td class="tx-medium">S-Tek</td>
                    <td class="tx-medium">PC-234234</td>
                    <td class="tx-medium">Power cable</td>
                    <td class="tx-medium text-center">1</td>
                    <td class="tx-medium text-center">0</td>
                    <td class="tx-medium">Meters</td>
                    <td class="text-center">View</td>
                    <td class="tx-medium text-center">₦{{ number_format(450) }}</td>
                    <td class="tx-medium text-center">₦{{ number_format(450) }}</td>
                </tr>
                <tr>
                    <td class="tx-color-03 tx-center">2</td>
                    <td class="tx-medium">Crucial</td>
                    <td class="tx-medium">RM-3242</td>
                    <td class="tx-medium">8GB RAM</td>
                    <td class="tx-medium text-center">2</td>
                    <td class="tx-medium text-center">0</td>
                    <td class="tx-medium">Bytes</td>
                    <td class="text-center">View</td>
                    <td class="tx-medium text-center">₦{{ number_format(600) }}</td>
                    <td class="tx-medium text-center">₦{{ number_format(1200) }}</td>
                </tr>
            </tbody>
        </table>
    </div><!-- table-responsive -->

    <h5>Accept Materials Delivery</h5>
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="accept_materials">Accept Delivery</label>
            <select class="form-control custom-select" id="accept_materials" name="accept_materials">
                <option selected disabled value="" selected>Select...</option>
                <option value="Yes" value="{{ old('Yes') }}"
                    {{ old('accept_materials') == 'Yes' ? 'selected' : '' }}>Yes, all ordered components were
                    delivered</option>
                <option value="No" value="{{ old('No') }}"
                    {{ old('accept_materials') == 'No' ? 'selected' : '' }}>No, all ordered components were not
                    delivered</option>
            </select>
            @error('accept_materials')
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

</section>
