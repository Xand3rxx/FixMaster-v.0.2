<h3>Invoice building</h3>
<section>
    <small class="text-danger">This portion will be displayed only if the CSE selects "Completed Diganosis" and the
        Client chooses to continue with the Service Request</small>
    <div class="mt-4 form-row">
        <div class="form-group col-md-6">
            <label for="estimated_hours">Estimated Work Hours</label>
            <select id="estimated_work_hours" class="form-control custom-select @error('estimated_work_hours') is-invalid @enderror" name="estimated_work_hours">
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
            <input type="text" class="form-control " readonly
                value="{{ $service_request['service']['category']['name'] }}">
        </div>

        <div class="form-group col-md-6">
            <label for="service_id">Service</label>
            <input type="text" class="form-control " readonly value="{{ $service_request['service']['name'] }}">
        </div>
        <div class="form-group col-md-6 position-relative">
            <label for="sub_service_uuid">Sub Service</label>
            <select class="form-control selectpicker name="sub_service_uuid[]" id="sub_service_uuid" multiple>
                <option disabled value="">Select Sub service</option>
                @foreach ($service_request['sub_services'] as $key => $sub_service_uuid)
                    <option value="{{ $sub_service_uuid }}" data-count="{{ $key }}"
                        data-sub-service-name="{{ \App\Models\SubService::getNameUsingUUID($sub_service_uuid) }}">
                        {{ \App\Models\SubService::getNameUsingUUID($sub_service_uuid) }} </option>
                @endforeach
            </select>
            @error('sub_service_uuid')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <span class="mt-2 sub-service-report"></span>


    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="root_cause">Root Cause <span class="text-danger">*</span></label>
            <textarea rows="3" class="form-control @error('root_cause') is-invalid @enderror" id="root_cause"
                name="root_cause"></textarea>
        </div>
        <div class="form-group col-md-12">
            <label for="comments">Other Comments(Optional)</label>
            <textarea rows="3" class="form-control @error('comments') is-invalid @enderror" id="comments"
                name="comments"></textarea>
        </div>
    </div>

</section>
@push('scripts')
    <script defer>
        $(function() {
            'use strict'
            $(document).on('change', '#sub_service_uuid', function() {
                let $subServiceUuidList = [];
                let $subServiceUuid = $(this).val();
                $subServiceUuidList.push($subServiceUuid);
                let route = '{{ route('cse.sub_service_dynamic_fields', app()->getLocale()) }}';

                $.ajax({
                    url: route,
                    beforeSend: function() {
                        $(".sub-service-report").html(
                            '<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>'
                        );
                    },
                    data: {
                        "sub_service_list": $subServiceUuidList
                    },
                    // return the result
                    success: function(result) {
                        $('.sub-service-report').html('');
                        $('.sub-service-report').html(result);
                    },
                    error: function(jqXHR, testStatus, error) {
                        var message = error +
                            ' An error occured while trying to retireve sub service details.';
                        var type = 'error';
                        displayMessage(message, type);
                        $("#spinner-icon").hide();
                    },
                    timeout: 8000
                })
            });
        });

    </script>
@endpush
