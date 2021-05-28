<h3>Re-Categorization </h3>
<section>
    <div class="mt-4 form-row">
        <div class="form-group col-md-6">
            <label for="category_uuid">Category</label>
            <select id="catogorized-category" class="form-control custom-select @error('category_uuid') is-invalid @enderror"
                name="category_uuid">
                <option selected disabled value="0" selected>Select Category</option>
                @foreach ($categories as $key => $category)
                    <option value="{{ $category['uuid'] }}">{{ $category['name'] }} </option>
                @endforeach
            </select>
            @error('category_uuid')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group col-md-6">
            <label for="service_uuid">Service</label>
            <select id="service_uuid" class="form-control custom-select @error('service_uuid') is-invalid @enderror" name="service_uuid">
                <option selected disabled value="0" selected>Select Service</option>
                @foreach ($services as $key => $service)
                    <option value="{{ $service['uuid'] }}">{{ $service['name'] }} </option>
                @endforeach
            </select>
            @error('service_uuid')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group col-md-12 position-relative">
            <label for="sub_service_uuid">Sub Service</label>
            <select id="sub_service_uuid" class="form-control sub_service_picker @error('sub_service_uuid') is-invalid @enderror"
                name="sub_service_uuid" id="sub_service_uuid" multiple>
                <option disabled value="0">Select Sub service</option>
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
    
</section>
