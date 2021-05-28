<h3>Invoice building</h3>
<section>
    <small class="text-danger">This portion will be displayed only if the CSE selects "Completed Diganosis" and the
        Client chooses to continue with the Service Request</small>
    <div class="mt-4 form-row">
        <div class="form-group col-md-6">
            <label for="estimated_hours">Estimated Work Hours</label>
            <select class="form-control custom-select @error('estimated_work_hours') is-invalid @enderror"
                name="estimated_work_hours">
                <option value="" selected>Select...</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
            </select>
            @error('estimated_hours')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group col-md-6">
            <label for="category_id">Category</label>
            <select class="form-control custom-select @error('category_id') is-invalid @enderror" name="category_id">
                <option selected disabled value="0" selected>Select Category</option>
                @foreach ($service_request['service']['subServices'] as $key => $sub_service)
                    <option value="{{ $sub_service['uuid'] }}">{{ $sub_service['name'] }} </option>
                @endforeach
            </select>
            @error('category_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group col-md-6">
            <label for="service_id">Service</label>
            <select class="form-control custom-select @error('service_id') is-invalid @enderror" name="service_id">
                <option selected disabled value="0" selected>Select Service</option>
                @foreach ($service_request['service']['subServices'] as $key => $sub_service)
                    <option value="{{ $sub_service['uuid'] }}">{{ $sub_service['name'] }} </option>
                @endforeach
            </select>
            @error('service_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group col-md-6 position-relative">
            <label for="sub_service_uuid">Sub Service</label>
            <select class="form-control selectpicker @error('sub_service_uuid') is-invalid @enderror"
                name="sub_service_uuid" id="sub_service_uuid" multiple>
                <option disabled value="">Select Sub service</option>
                @foreach ($service_request['service']['subServices'] as $key => $sub_service)
                    <option value="{{ $sub_service['uuid'] }}" data-count="{{ $key }}"
                        data-sub-service-name="{{ $sub_service['name'] }}">{{ $sub_service['name'] }} </option>
                @endforeach
            </select>
            @error('sub_service_uuid')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="root_cause">Root Cause <span class="text-danger">*</span></label>
            <textarea rows="3" class="form-control @error('root_cause') is-invalid @enderror" id="root_cause"
                name="root_cause"></textarea>
        </div>
        <div class="form-group col-md-12">
            <label for="other_comments">Other Comments(Optional)</label>
            <textarea rows="3" class="form-control @error('other_comments') is-invalid @enderror" id="other_comments"
                name="other_comments"></textarea>
        </div>
    </div>
    <span class="mt-2 sub-service-report"></span>

</section>
