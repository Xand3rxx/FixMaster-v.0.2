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
<h3>Add Technician</h3>
<section>
    <div class="form-group col-md-12">
        <ul class="list-group wd-md-100p">
            @foreach ($technicians as $technicain)
                <li class="list-group-item d-flex align-items-center">
                    <div class="form-row">
                        <div class="col-md-1 col-sm-1">
                            <img src="{{ asset('assets/images/default-male-avatar.png') }}"
                            class="wd-30 rounded-circle mg-r-15" alt="Technician Avatar">
                        </div>
                        <div class="col-md-5 col-sm-5">
                            <h6 class="tx-13 tx-inverse tx-semibold mg-b-0">
                                {{ $technicain['user']['account']['first_name'] . ' ' . $technicain['user']['account']['last_name'] }}
                            </h6>

                            <span class="d-block tx-11 text-muted">
                                <i class="icon ion-md-star lh-0 tx-orange"></i>
                                <span class="font-weight-bold ml-2">
                                    {{ \App\Traits\CalculateDistance::getDistanceBetweenPoints($service_request['client']['contact']['address_latitude'], $service_request['client']['contact']['address_longitude'], $technicain['user']['contact']['address_latitude'], $technicain['user']['contact']['address_longitude']) }} km |                                 </span>
                                    <div class="mt-1">
                                        @foreach ( $technicain['services'] as $service)
                                        <span class="font-weight-bold ml-2"> {{Str::title($service['service']['name'])}} {{$loop->last ? '' : ' - '}} </span>
                                        @endforeach
                                    </div>
                                    
                            </span>
                        </div>
                        <div class="col-md-5 col-sm-5">
                            <div class="form-row">
                                <div class="form-group col-1 col-md-1 col-sm-1">
                                    <a href="tel:{{ $technicain['user']['contact']['phone_number'] }}" class="btn btn-primary btn-icon"> 
                                        <i class="fas fa-phone"> </i>
                                    </a>
                                </div>
                                <div class="form-group col-1 col-md-1 col-sm-1">
                                    <div class="custom-control custom-radio mt-2">
                                        <div class="custom-control custom-radio">
                                            <input type="checkbox" class="custom-control-input"
                                                id="technician{{ $loop->iteration }}" name="add_technician_user_uuid[]"
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
    
    });
</script>
@endpush