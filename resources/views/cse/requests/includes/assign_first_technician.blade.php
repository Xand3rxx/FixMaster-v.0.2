<form class="form-data" method="POST" action="{{route('cse.assign.technician', [app()->getLocale()])}}">
    @csrf
    <div class="form-row mt-4">
        <div class="tx-13 mg-b-25">
            <div id="wizard3">
                @if(is_null($service_request['preferred_time']))
                <h3>Update Scheduled Date</h3>
                <section>
                    <div class="mt-4 form-row">
                        <div class="form-group col-md-12">
                            <label for="preferred_time">Scheduled Date & Time</label>
                            <input id="service-date-time" type="text" readonly min="{{ \Carbon\Carbon::now()->isoFormat('2021-04-13 00:00:00') }}" class="form-control @error('preferred_time') is-invalid @enderror" name="preferred_time" placeholder="Enter Scheduled Date & Time" value="{{ old('preferred_time') }}">
                            
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
                            <label for="name">Assign Technician</label>
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
                            @enderror
                        </div>
                    </div>
                </section>


            </div>
        </div>
    </div><!-- df-example -->

    <input type="hidden" value="{{$service_request->uuid}}" name="service_request_uuid">

    <button type="submit" class="btn btn-primary d-none" id="update-progress">Update Progress</button>

</form>
