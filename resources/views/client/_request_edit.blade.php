<form class="p-4" method="POST" action="{{ route('client.update_request', $userServiceRequest->id) }}">
    @csrf @method('PUT')

    <div class="row">
    <h5 class="ml-3">Editing {{ $userServiceRequest->job_reference }} Service request details</h5>
        
        <div class="col-md-6">
            <div class="form-group position-relative">
                <label>Date & Time :<span class="text-danger">*</span></label>
                <i data-feather="calendar" class="fea icon-sm icons"></i>
                <input name="timestamp" type="text" class="form-control pl-5 @error('timestamp') is-invalid @enderror" placeholder="Click to select :" id="service-date-time" readonly value="{{ old('timestamp') ?? \Carbon\Carbon::parse($userServiceRequest->serviceRequestDetail->timestamp, 'UTC')->isoFormat('YYYY/MM/DD HH:mm') }}">
                @error('timestamp')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div><!--end col-->

        <div class="col-md-6">
            <div class="form-group position-relative">
                <label>Your Phone no. :<span class="text-danger">*</span></label>
                <i data-feather="phone" class="fea icon-sm icons"></i>
                <input name="phone_number" id="phone_number" type="tel" class="form-control pl-5 @error('phone_number') is-invalid @enderror" placeholder="Your Phone No. :" maxlength="11" value="{{ old('phone_number') ?? $userServiceRequest->serviceRequestDetail->phone_number }}" autocomplete="off">
                @error('phone_number')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div> 
        </div><!--end col-->
        
        <div class="col-md-12">
            <div class="form-group position-relative">
                <label>Address</label>
                <i data-feather="map-pin" class="fea icon-sm icons"></i>
                <textarea name="address" id="address" rows="3" class="form-control pl-5 @error('address') is-invalid @enderror" placeholder="Address of where the service is required">{{ old('address') ?? $userServiceRequest->serviceRequestDetail->address }}</textarea>
                @error('address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div><!--end col--> 

        <div class="col-md-12">
            <div class="form-group position-relative">
                <label>Tell us more about the service you need :</label>
                <i data-feather="message-circle" class="fea icon-sm icons"></i>
                <textarea name="description" id="description" rows="3" class="form-control pl-5 @error('description') is-invalid @enderror" placeholder="If there is an equipment involved, do tell us about the equipment e.g. the make, model, age of the equipment etc. ">{{ old('description') ?? $userServiceRequest->serviceRequestDetail->description }}</textarea>
                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div><!--end col--> 

        
                                           
        
    </div><!--end row-->

    <div class="row">
        <div class="col-sm-12">
        <button type="submit" class="submitBnt btn btn-primary">Update</button>
        </div><!--end col-->
    </div><!--end row-->
</form><!--end form-->