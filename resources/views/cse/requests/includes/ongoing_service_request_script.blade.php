<script src="{{ asset('assets/dashboard/assets/js/bootstrap-multiselect.js') }}"></script>

<script>

    
    
    

    function addTRF(count){
    let html = '<div class="tool-request form-row remove-trf-row"><div class="form-group col-md-4"> <label for="tool_id">Equipment/Tools Name</label> <select class="form-control custom-select @error('tool_id') is-invalid @enderror tool_id" id="tool_id" name="tool_id[]" ><option value="" selected>Select...</option> @foreach($tools as $tool)<option value="{{ $tool->id }}" {{ old('tool_id') == $tool->id ? 'selected' : ''}} data-id="tool_quantity'+count+'">{{ $tool->name }}</option> @endforeach </select> @error('tool_id') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div><div class="form-group quantity-section col-md-2"> <label for="tool_quantity">Quantity</label> <input type="number" class="form-control @error('tool_quantity') is-invalid @enderror tool_quantity" name="tool_quantity[]" id="tool_quantity'+count+'" min="1" pattern="\d*" maxlength="2" value="{{ old('tool_quantity') }}"> @error('tool_quantity') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div><div class="form-group col-md-2 mt-1"> <button class="btn btn-sm pd-x-15 btn-danger btn-uppercase mg-l-5 mt-4 remove-trf" type="button"><i class="fas fa-times" class="wd-10 mg-r-5"></i> </button></div></div>';
    $('.add-trf-row').append(html);
    }

    $(document).ready(function (){
        $('.selectpicker').selectpicker(); //Initiate multiple dropdown select

        $(document).on('change', '#sub_service_uuid', function(){
          
            $subServiceUuidList = [];
            $subServiceUuid = $(this).val();
            $subServiceUuidList.push($subServiceUuid);
            var route = $('#route').val();

            $.ajax({
                url: route,
                beforeSend: function() {
                    $(".sub-service-report").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>');
                },
                data: {"sub_service_list":$subServiceUuidList},
                // return the result
                success: function(result) {
                    $('.sub-service-report').html('');
                    $('.sub-service-report').html(result);
                },
                error: function(jqXHR, testStatus, error) {
                    var message = error+ ' An error occured while trying to retireve sub service details.';
                    var type = 'error';
                    displayMessage(message, type);
                    $("#spinner-icon").hide();
                },
                timeout: 8000
            })
            
        });
    });
</script>