<h3>Project Progress</h3>
<section>
    <p class="mg-b-0">Specify the current progress of the job.</p>
    <div class="form-row mt-4">
        <div class="form-group col-md-12">
            <select required class="form-control custom-select @error('sub_status_uuid') is-invalid @enderror"
                name="sub_status_uuid">
                <option selected disabled value="0">Select...</option>
                @foreach ($ongoingSubStatuses as $status)
                    <option value="{{ $status->uuid }}">{{ $status->name }}</option>
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
