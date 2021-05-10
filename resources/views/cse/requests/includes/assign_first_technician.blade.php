<form class="form-data" method="POST" action="{{route('cse.assign.technician', [app()->getLocale()])}}">
    @csrf
    <div class="mt-4">
        <div class="tx-13 mg-b-25">
            <div id="wizard3">
                <h3>Report</h3>
                <section>
                    <div class="mt-4 form-row">
                        <div class="form-group col-md-12">
                            <label for="comment">Diagnostic Report</label>
                            <textarea rows="3" class="form-control @error('comment') is-invalid @enderror" id="comment" name="comment"></textarea>
                        </div>
                    </div>
                </section>
                @if(is_null($service_request['preferred_time']))
                <h3>Scheduled Date</h3>
                <section>
                    <div class="mt-4 form-row">
                        <div class="form-group col-md-12">
                            <label for="preferred_time">Scheduled Date & Time</label>
                            <input id="service-date-time" type="text" readonly min="{{ \Carbon\Carbon::now()->isoFormat('2021-04-13 00:00:00') }}" class="form-control @error('preferred_time') is-invalid @enderror" name="preferred_time" placeholder="Click to Enter Scheduled Date & Time" value="{{ old('preferred_time') }}">
                            
                            @error('preferred_time')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </section>
                @endif
                <h3>Assign Technician</h3>
                <section>
                    <div class="form-row mt-4">
                        <div class="form-group col-md-12">
                            {{-- <label for="name">Assign Technician</label>
                            <select required class="form-control custom-select @error('technician_user_uuid') is-invalid @enderror" name="technician_user_uuid">
                                <option selected disabled value="0" selected>Select...</option>
                                @foreach ($technicains as $technicain)
                                <option value="{{$technicain['user']['uuid']}}">{{$technicain['user']['account']['last_name'] .' '. $technicain['user']['account']['first_name']}}</option>
                                @endforeach
                            </select>
                            @error('technician_user_uuid')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror --}}

                            <ul class="list-group wd-md-100p">
                                @foreach ($technicains as $technicain)
                                <li class="list-group-item d-flex align-items-center">
                                  
                                 <div class="form-row">
                                    <img src="{{ asset('assets/images/default-male-avatar.png') }}" class="wd-30 rounded-circle mg-r-15" alt="Technician Avatar">
                                  
                                  <div class="col-md-6 col-sm-6">
                                    <h6 class="tx-13 tx-inverse tx-semibold mg-b-0">{{$technicain['user']['account']['first_name'] .' '. $technicain['user']['account']['last_name']}}</h6>
                                    
                                    <span class="d-block tx-11 text-muted">
                                        @foreach ($technicains as $technicain)
                                            <i class="icon ion-md-star lh-0 tx-orange"></i>
                                        @endforeach
                                        <span class="font-weight-bold ml-2">0.6km</span>
                                    </span>
                                  </div>
                                  <div class="col-md-6 col-sm-6">
                                    <div class="form-row">
                                        <div class="form-group col-1 col-md-1 col-sm-1" style="margin-left: 3rem !important;">
                                            <a href="tel:08124483438" class="btn btn-primary btn-icon"><i class="fas fa-phone"></i></a>
                                        </div>
                                        <div class="form-group col-1 col-md-1 col-sm-1">
                                            <div class="custom-control custom-radio mt-2">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input" id="{{ $loop->iteration }}" name="technician_user_uuid" value="{{ $technicain['user']['uuid'] }}">
                                                    <label class="custom-control-label" for="{{ $loop->iteration }}"></label>
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
                    </div>
                </section>


            </div>
        </div>
    </div><!-- df-example -->

    <input type="hidden" value="{{$service_request->uuid}}" name="service_request_uuid">

    <button type="submit" class="btn btn-primary d-none" id="update-progress">Update Progress</button>

</form>
