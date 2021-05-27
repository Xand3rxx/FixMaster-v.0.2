<div class="mt-4">
    <div class="tx-13 mg-b-25">
        <div id="wizard3">
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
                                id="manufacturer_name" name="manufacturer_name[]"
                                value="{{ old('manufacturer_name[0]') }}">
                            @error('manufacturer_name[0]')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-3">
                            <label for="model_number">Model Number</label>
                            <input type="text" class="form-control @error('model_number') is-invalid @enderror"
                                id="model_number" name="model_number[]" placeholder=""
                                value="{{ old('model_number[0]') }}">
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
                            <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                id="quantity" name="quantity[]" min="1" pattern="\d*" maxlength="2"
                                value="{{ old('quantity[0]') }}">
                            @error('quantity[0]')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-2">
                            <label for="size">Size</label>
                            <input type="number" class="form-control @error('size') is-invalid @enderror" id="size"
                                name="size[]" min="1" pattern="\d*" maxlength="2" value="{{ old('size[0]') }}">
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
                                <input type="file" accept="image/*" class="custom-file-input @error('image.*') is-invalid @enderror" name="image[]" id="image">
                                <label class="custom-file-label" for="image">Component Image</label>
                                @error('image.*')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group col-md-1 mt-1">
                            <button class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5 mt-4 add-rfq"
                                type="button"><i class="fas fa-plus" class="wd-10 mg-r-5"></i></button>
                        </div>
                    </div>
                    <span class="add-rfq-row"></span>
                </div>
            </section>
            @push('scripts')
                <script>
                    $(function() {
                        let count = 1;
                        function addRFQ(count){
                            let html = '<div class="form-row remove-rfq-row"><div class="form-group col-md-4"> <label for="manufacturer_name">Manufacturer Name</label> <input type="text" class="form-control @error('manufacturer_name') is-invalid @enderror" id="manufacturer_name" name="manufacturer_name[]" value="{{ old('manufacturer_name[]') }}"> @error('manufacturer_name[]') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div><div class="form-group col-md-3"> <label for="model_number">Model Number</label> <input type="text" class="form-control @error('model_number') is-invalid @enderror" id="model_number" name="model_number[]" placeholder="" value="{{ old('model_number[]') }}"> @error('model_number[]') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div><div class="form-group col-md-4"> <label for="component_name">Component Name</label> <input type="text" class="form-control @error('component_name') is-invalid @enderror" id="component_name" name="component_name[]" value="{{ old('component_name[]') }}"> @error('component_name[]') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div><div class="form-group col-md-2"> <label for="quantity">Quantity</label> <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity[]" min="1" pattern="d*" maxlength="2" value="{{ old('quantity[]') }}"> @error('quantity[]') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div><div class="form-group col-md-2"> <label for="size">Size</label> <input type="number" class="form-control @error('size') is-invalid @enderror" id="size" name="size[]" min="1" pattern="d*" maxlength="2" value="{{ old('size[]') }}"> @error('size[]') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div><div class="form-group col-md-4"> <label for="unit_of_measurement">Unit of Measurement</label> <input type="text" class="form-control @error('unit_of_measurement') is-invalid @enderror" id="unit_of_measurement" name="unit_of_measurement[]" value="{{ old('unit_of_measurement[0]') }}"> @error('unit_of_measurement[]') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div><div class="form-group col-md-3"> <label>Image</label><div class="custom-file"> <input type="file" accept="image/*" class="custom-file-input @error('image.*') is-invalid @enderror" name="image[]" id="image"> <label class="custom-file-label" for="image">Component Image</label> @error('image.*') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div></div><div class="form-group col-md-1 mt-1"> <button class="btn btn-sm pd-x-15 btn-danger btn-uppercase mg-l-5 mt-4 remove-rfq" type="button"><i class="fas fa-times" class="wd-10 mg-r-5"></i></button></div></div>';
                            $('.add-rfq-row').append(html);
                        }
                        //Add and Remove Request for
                        $(document).on('click', '.add-rfq', function() {
                            count++;
                            addRFQ(count);
                        });
                    });

                </script>
            @endpush
            {{-- End New RFQ --}}

        </div>
    </div>
</div><!-- df-example -->
