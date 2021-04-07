<form class="form-data" method="POST" action="{{route('cse.project.progress.update', [app()->getLocale()])}}">
    @csrf
    <div class="form-row mt-4">
        <div class="tx-13 mg-b-25">
            <div id="wizard3">

                <h3>Project Progress</h3>
                <section>
                    <p class="mg-b-0">Specify the current progress of the job.</p>
                    <div class="form-row mt-4">
                        <div class="form-group col-md-12">
                            {{-- This portion will display only Ongoing Status Sub statuses<br> --}}

                            <select class="form-control custom-select @error('sub_status_uuid') is-invalid @enderror" name="sub_status_uuid">
                                <option selected disabled value="0">Select...</option>
                                @foreach($ongoingSubStatuses as $status)
                                {{-- @if($status->id > 6) --}}
                                <option value="{{ $status->uuid }}">{{ $status->name }}</option>
                                {{-- @endif --}}
                                @endforeach
                            </select>
                            @error('sub_status_uuid')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </section>

                @if($latest_service_request_progress->sub_status_id > 9)
                <h3>New RFQ</h3>
                <section>
                    <p class="mg-b-0">A request for quotation is a business process in which a company or public entity requests a quote from a supplier for the purchase of specific products or services.</p>
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
                                <input type="radio" class="custom-control-input" id="rfqNo" name="intiate_rfq" value="no">
                                <label class="custom-control-label" for="rfqNo">No</label><br>
                            </div>
                        </div>
                    </div>

                    <div class="d-none d-rfq">
                        <h4 id="section1" class="mt-4 mb-2">Make Request</h4>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="component_name">Component Name</label>
                                <input type="text" class="form-control @error('component_name') is-invalid @enderror" id="component_name" name="component_name[]" value="{{ old('component_name') }}">
                                @error('component_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-3">
                                <label for="model_number">Model Number</label>
                                <input type="text" class="form-control @error('model_number') is-invalid @enderror" id="model_number" name="model_number[]" placeholder="" value="{{ old('model_number') }}">
                                @error('model_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-2">
                                <label for="quantity">Quantity</label>
                                <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity[]" min="1" pattern="\d*" maxlength="2" value="{{ old('quantity') }}">
                                @error('quantity')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-1 mt-1">
                                <button class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5 mt-4 add-rfq" type="button"><i class="fas fa-plus" class="wd-10 mg-r-5"></i></button>
                            </div>
                        </div>

                        <span class="add-rfq-row"></span>

                    </div>
                </section>

                <h3>New Tools Request</h3>
                <section>
                    <p class="mg-b-0">A request form to procure tools and equipments from <span>FixMaster</span> to properly carry out a Service Request.</p>

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
                                <select class="form-control custom-select @error('tool_id') is-invalid @enderror tool_id" id="tool_id" name="tool_id[]">
                                    <option value="" selected>Select...</option>
                                    @foreach($tools as $tool)
                                    <option value="{{ $tool->id }}" {{ old('tool_id') == $tool->id ? 'selected' : ''}} data-id="tool_quantity">{{ $tool->name }}</option>
                                    @endforeach
                                </select>
                                @error('tool_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group quantity-section col-md-2">
                                <label for="tool_quantity">Quantity</label>
                                <input type="number" class="form-control @error('tool_quantity') is-invalid @enderror tool_quantity" name="tool_quantity[]" id="tool_quantity" min="1" pattern="\d*" maxlength="2" value="{{ old('tool_quantity') }}">
                                @error('tool_quantity')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-2 mt-1">
                                <button class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5 mt-4 add-trf" type="button"><i class="fas fa-plus" class="wd-10 mg-r-5"></i></button>
                            </div>
                        </div>
                        <span class="add-trf-row"></span>
                    </div>
                </section>
                @endif

                <h3>Assign Additional Technician</h3>
                <section>
                    <div class="form-group col-md-12">
                        <label for="name">Assign Technician</label>
                        <select class="form-control custom-select @error('technician_user_uuid') is-invalid @enderror" name="technician_user_uuid">
                            <option selected value="">Select...</option>
                            @foreach ($technicains as $technicain)
                            <option value="{{$technicain['user']['uuid']}}">{{$technicain['user']['account']['last_name'] .' '. $technicain['user']['account']['first_name']}}</option>
                            @endforeach
                        </select>
                        @error('technician_user_uuid')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </section>

            </div>
        </div>
    </div><!-- df-example -->

    <input type="hidden" value="{{$service_request->uuid}}" name="service_request_uuid">

    <button type="submit" class="btn btn-primary d-none" id="update-progress">Update Progress</button>

</form>
