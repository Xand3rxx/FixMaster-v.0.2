@foreach($service['subServices'] as $subService)
    <div class="form-row mt-4">
    <div class="form-group col-md-3">
        <label for="sub_service_name">Sub Service Name</label>
        <input type="text" class="form-control @error('sub_service_name') is-invalid @enderror" name="sub_service_name[]" id="sub_service_name" placeholder="Name" value="{{ old('sub_service_name') ?? !empty($subService->name) ? $subService->name : 'UNAVAILABLE' }}" autocomplete="off">
        @error('sub_service_name')
            <x-alert :message="$message" />
        @enderror
    </div>
    
    <div class="form-group col-md-3">
        <label for="first_hour_charge">First Hour Charge</label>
        <input type="number" min="1" maxlength="5" class="form-control @error('first_hour_charge') is-invalid @enderror" name="first_hour_charge[]" id="first_hour_charge" placeholder="First Hour Charge" value="{{ old('first_hour_charge') ?? !empty($subService->first_hour_charge) ? $subService->first_hour_charge : '0' }}" autocomplete="off">
        @error('first_hour_charge')
            <x-alert :message="$message" />
        @enderror
    </div>

    <div class="form-group col-md-3">
        <label for="subsequent_hour_charge">Subsequent Hour Charge</label>
        <input type="number" min="1" maxlength="5" class="form-control @error('subsequent_hour_charge') is-invalid @enderror" name="subsequent_hour_charge[]" id="subsequent_hour_charge" placeholder="Subsequent Hour Charge" value="{{ old('subsequent_hour_charge') ?? !empty($subService->subsequent_hour_charge) ? $subService->subsequent_hour_charge : '0' }}" autocomplete="off">
        @error('subsequent_hour_charge')
        <x-alert :message="$message" />
        @enderror
    </div>
    <div class="form-group col-md-3">
        <a data-url="{{ route('admin.services.delete_sub_service', ['subService'=>$subService->uuid, 'locale'=>app()->getLocale()]) }}" class="delete-entity" title="Delete {{ $subService->name}}"><i class="fas fa-times text-danger" style="margin-top: 2.5rem !important;"></i></a>
    </div>

    <input type="hidden" class="d-none" name="sub_service_id[]" id="sub_service_id"  autocomplete="off" value="{{ json_encode($subService->id, TRUE)}}">
    
    </div>
    @endforeach

    <span class="add-new-sub-service"></span>