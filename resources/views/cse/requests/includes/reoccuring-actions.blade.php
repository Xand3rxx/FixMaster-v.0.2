{{-- Comments --}}
<h3>{{ $contents['comment']['name'] }}</h3>
<section>
    <div class="mt-4 form-row">
        <div class="form-group col-md-12">
            <label
                for="{{ $contents['comment']['button']['name'] }}">{{ $contents['comment']['button']['label'] }}</label>
            <textarea {{ $contents['comment']['button']['required'] }} rows="3"
                class="form-control @error($contents['comment']['button']['name']) is-invalid @enderror"
                id="{{ $contents['comment']['button']['id'] }}"
                name="{{ $contents['comment']['button']['name'] }}"></textarea>
        </div>
    </div>
</section>
{{-- End Comments --}}

{{-- New RFQ --}}
<h3>New RFQ</h3>
<section>
    <p class="mg-b-0">A request for quotation is a business process in which a company or public entity
        requests a quote from a supplier for the purchase of specific products or services.</p>
    <h4 id="section1" class="mt-4 mb-2">Initiate RFQ?</h4>

    <div class="form-row mt-4">
        <div class="form-group col-md-4">
            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" id="rfqYes" name="intiate_rfq" value="yes">
                <label class="custom-control-label" for="rfqYes">Yes</label><br>
            </div>
        </div>
        <div class="form-group col-md-4 d-flex align-items-end">
            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" id="rfqNo" name="intiate_rfq" value="">
                <label class="custom-control-label" for="rfqNo">No</label><br>
            </div>
        </div>
    </div>

    <div class="d-none d-rfq">
        <h4 id="section1" class="mt-4 mb-2">Make Request</h4>
        <div class="form-row">

            <div class="form-group col-md-4">
                <label for="manufacturer_name">Manufacturer Name</label>
                <input type="text" class="form-control @error('manufacturer_name') is-invalid @enderror"
                    id="manufacturer_name" name="manufacturer_name[]" value="{{ old('manufacturer_name[0]') }}">
                @error('manufacturer_name[0]')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group col-md-3">
                <label for="model_number">Model Number</label>
                <input type="text" class="form-control @error('model_number') is-invalid @enderror" id="model_number"
                    name="model_number[]" placeholder="" value="{{ old('model_number[0]') }}">
                @error('model_number[0]')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group col-md-4">
                <label for="component_name">Component Name</label>
                <input type="text" class="form-control @error('component_name') is-invalid @enderror"
                    id="component_name" name="component_name[]" value="{{ old('component_name[0]') }}">
                @error('component_name[0]')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group col-md-2">
                <label for="quantity">Quantity</label>
                <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity"
                    name="quantity[]" min="1" pattern="\d*" maxlength="2" value="{{ old('quantity[0]') }}">
                @error('quantity[0]')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group col-md-2">
                <label for="size">Size</label>
                <input type="number" class="form-control @error('size') is-invalid @enderror" id="size" name="size[]"
                    min="1" pattern="\d*" maxlength="2" value="{{ old('size[0]') }}">
                @error('size[0]')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group col-md-4">
                <label for="unit_of_measurement">Unit of Measurement</label>
                <input type="text" class="form-control @error('unit_of_measurement') is-invalid @enderror"
                    id="unit_of_measurement" name="unit_of_measurement[]"
                    value="{{ old('unit_of_measurement[0]') }}">
                @error('unit_of_measurement[0]')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group col-md-3">
                <label>Image</label>
                <div class="custom-file">
                    <input type="file" accept="image/*" class="custom-file-input @error('image.*') is-invalid @enderror"
                        name="image[]" id="image">
                    <label class="custom-file-label" for="image">Component Image</label>
                    @error('image.*')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-group col-md-1 mt-1">
                <button class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5 mt-4 add-rfq" type="button"><i
                        class="fas fa-plus" class="wd-10 mg-r-5"></i></button>
            </div>
        </div>
        <span class="add-rfq-row"></span>
    </div>
</section>
{{-- End New RFQ --}}

{{-- New Tools Request --}}
<h3>New Tools Request</h3>
<section>
    <p class="mg-b-0">A request form to procure tools and equipments from <span>FixMaster</span> to properly
        carry out a Service Request.</p>

    <h4 id="section1" class="mt-4 mb-2">Initiate Tools Request?</h4>
    <div class="form-row mt-4 ">
        <div class="form-group col-md-4">
            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" id="trfYes" name="intiate_trf" value="yes">
                <label class="custom-control-label" for="trfYes">Yes</label><br>
            </div>
        </div>
        <div class="form-group col-md-4 d-flex align-items-end">
            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" id="trfNo" name="intiate_trf" value="no">
                <label class="custom-control-label" for="trfNo">No</label><br>
            </div>
        </div>
    </div>

    <div class="d-none d-trf">
        <h4 id="section1" class="mt-4 mb-2">Make Request</h4>
        <div class="form-row tool-request">
            <div class="form-group col-md-4">
                <label for="tool_id">Equipment/Tools Name</label>
                <select class="form-control custom-select @error('tool_id') is-invalid @enderror tool_id" id="tool_id"
                    name="tool_id[]">
                    <option value="" selected>Select...</option>
                    @foreach ($tools as $tool)
                        <option value="{{ $tool->id }}" {{ old('tool_id[0]') == $tool->id ? 'selected' : '' }}
                            data-id="tool_quantity">{{ $tool->name }}</option>
                    @endforeach
                </select>
                @error('tool_id[0]')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group quantity-section col-md-2">
                <label for="tool_quantity">Quantity</label>
                <input type="number" class="form-control @error('tool_quantity[0]') is-invalid @enderror tool_quantity"
                    name="tool_quantity[]" id="tool_quantity" min="1" pattern="\d*" maxlength="2"
                    value="{{ old('tool_quantity[0]') }}">
                @error('tool_quantity[0]')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group col-md-2 mt-1">
                <button class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5 mt-4 add-trf" type="button"><i
                        class="fas fa-plus" class="wd-10 mg-r-5"></i></button>
            </div>
        </div>
        <span class="add-trf-row"></span>
    </div>
</section>
{{-- End Tools Request --}}

{{-- New Request QA --}}
<h3>Request QA</h3>
<section>
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="qa_user_uuid">Assign QA</label>
            <select required class="form-control custom-select @error('qa_user_uuid') is-invalid @enderror"
                name="qa_user_uuid">
                <option selected disabled value="0" selected>Select...</option>
                @foreach ($qaulity_assurances['users'] as $qaulity_assurance)
                    <option value="{{ $qaulity_assurance['uuid'] }}">
                        {{ !empty($qaulity_assurance['account']['first_name']) ? Str::title($qaulity_assurance['account']['first_name'] . ' ' . $qaulity_assurance['account']['last_name']) : 'UNAVAILABLE' }}
                    </option>
                @endforeach
            </select>
            @error('qa_user_uuid')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
{{-- 
        <div class="form-group col-md-6">
            <label for="assistive_role">Assitive Role</label>
            <select required class="form-control custom-select 
                        @error('assistive_role') is-invalid @enderror" name="assistive_role">
                <option selected disabled value="0" selected>Select...</option>
                <option value="Consultant">Consultant</option>
                <option value="Technician">Technician</option>
            </select>
            @error('assistive_role')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div> --}}
    </div>
</section>
{{-- End Request QA --}}

{{-- Assign a New Technician --}}
<h3>Assign New Technician</h3>
<section>
    <div class="form-group col-md-12">
        <ul class="list-group wd-md-100p">
            @foreach ($technicians as $technicain)
                <li class="list-group-item d-flex align-items-center">
                    <div class="form-row">
                        <img src="{{ asset('assets/images/default-male-avatar.png') }}"
                            class="wd-30 rounded-circle mg-r-15" alt="Technician Avatar">

                        <div class="col-md-6 col-sm-6">
                            <h6 class="tx-13 tx-inverse tx-semibold mg-b-0">
                                {{ $technicain['user']['account']['first_name'] . ' ' . $technicain['user']['account']['last_name'] }}
                            </h6>

                            <span class="d-block tx-11 text-muted">
                                <i class="icon ion-md-star lh-0 tx-orange"></i>
                                <span
                                    class="font-weight-bold ml-2">{{ \App\Traits\CalculateDistance::getDistanceBetweenPoints($service_request['client']['contact']['address_latitude'], $service_request['client']['contact']['address_longitude'], $technicain['user']['contact']['address_latitude'], $technicain['user']['contact']['address_longitude']) }}
                                    km</span>
                            </span>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-row">
                                <div class="form-group col-1 col-md-1 col-sm-1" style="margin-left: 3rem !important;">
                                    <a href="tel:{{ $technicain['user']['contact']['phone_number'] }}"
                                        class="btn btn-primary btn-icon"> <i class="fas fa-phone"></i></a>
                                </div>
                                <div class="form-group col-1 col-md-1 col-sm-1">
                                    <div class="custom-control custom-radio mt-2">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input"
                                                id="technician{{ $loop->iteration }}" name="technician_user_uuid"
                                                value="{{ $technicain['user']['uuid'] }}">
                                            <label class="custom-control-label"
                                                for="technician{{ $loop->iteration }}"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</section>
{{-- End Assign New Technician --}}

@push('scripts')
<script defer>
    $(function() {
    'use strict'
    // RFQ begin
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

    let count = 1;
    function addRFQ(count){
        let html = '<div class="form-row remove-rfq-row"><div class="form-group col-md-4"> <label for="manufacturer_name">Manufacturer Name</label> <input type="text" class="form-control  id="manufacturer_name" name="manufacturer_name[]" value=""> </div><div class="form-group col-md-3"> <label for="model_number">Model Number</label> <input type="text" class="form-control  id="model_number" name="model_number[]" placeholder="" value=""> </div><div class="form-group col-md-4"> <label for="component_name">Component Name</label> <input type="text" class="form-control" id="component_name" name="component_name[]" value=""> </div><div class="form-group col-md-2"> <label for="quantity">Quantity</label> <input type="number" class="form-control " id="quantity" name="quantity[]" min="1" pattern="d*" maxlength="2" value=""> </div><div class="form-group col-md-2"> <label for="size">Size</label> <input type="number" class="form-control " id="size" name="size[]" min="1" pattern="d*" maxlength="2" value=""> </div><div class="form-group col-md-4"> <label for="unit_of_measurement">Unit of Measurement</label> <input type="text" class="form-control " id="unit_of_measurement" name="unit_of_measurement[]" value=""> </div><div class="form-group col-md-3"> <label>Image</label><div class="custom-file"> <input type="file" accept="image/*" class="custom-file-input " name="image[]" id="image"> <label class="custom-file-label" for="image">Component Image</label> </div></div><div class="form-group col-md-1 mt-1"> <button class="btn btn-sm pd-x-15 btn-danger btn-uppercase mg-l-5 mt-4 remove-rfq" type="button"><i class="fas fa-times" class="wd-10 mg-r-5"></i></button></div></div>';
        $('.add-rfq-row').append(html);
    }
        
    //Add and Remove Request for
    $(document).on('click', '.add-rfq', function() {
        count++;
        addRFQ(count);
    });
    $(document).on('click', '.remove-rfq', function() {
        count--;
        $(this).closest(".remove-rfq-row").remove();
    });
    // End RFQ

    // Tool Request Begin
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

    let addTRFcount = 1;
    function addTRF(count){
        let html = '<div class="tool-request form-row remove-trf-row"><div class="form-group col-md-4"> <label for="tool_id">Equipment/Tools Name</label> <select class="form-control custom-select tool_id" id="tool_id" name="tool_id[]" ><option value="0" selected>Select...</option> @foreach($tools as $tool)<option value="{{ $tool->id }}" data-id="tool_quantity'+count+'">{{ $tool->name }}</option> @endforeach </select> </div><div class="form-group quantity-section col-md-2"> <label for="tool_quantity">Quantity</label> <input type="number" class="form-control tool_quantity" name="tool_quantity[]" id="tool_quantity'+count+'" min="1" pattern="\d*" maxlength="2" value=""> </div><div class="form-group col-md-2 mt-1"> <button class="btn btn-sm pd-x-15 btn-danger btn-uppercase mg-l-5 mt-4 remove-trf" type="button"><i class="fas fa-times" class="wd-10 mg-r-5"></i> </button></div></div>';
        $('.add-trf-row').append(html);
    }
    //Add and Remove Tools request form
    $(document).on('click', '.add-trf', function() {
        addTRFcount++;
        addTRF(addTRFcount);
    });
    $(document).on('click', '.remove-trf', function() {
        addTRFcount--;
        $(this).closest(".remove-trf-row").remove();
    });
    // End Tools Request
    });
</script>
@endpush