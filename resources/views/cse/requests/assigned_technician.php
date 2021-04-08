@if (!empty($technicains))
<form class="form-data" method="POST" action="{{route('cse.assign.technician', [app()->getLocale()])}}">
  @csrf
  <div class="form-row mt-4">
    <div class="tx-13 mg-b-25">
      <div id="wizard3">

        <h3>Assign Technician</h3>
        <section>
          <div class="form-row mt-4">
            <div class="form-group col-md-12">
              <label for="name">Assign Technician</label>
              <select required class="form-control custom-select @error('technician_user_id') is-invalid @enderror" name="technician_user_id">
                <option selected disabled value="0" selected>Select...</option>
                @foreach ($technicains as $technicain)
                <option value="{{$technicain['user']['id']}}">{{$technicain['user']['account']['last_name'] .' '. $technicain['user']['account']['first_name']}}</option>
                @endforeach
              </select>
              @error('technician_user_id')
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
@endif