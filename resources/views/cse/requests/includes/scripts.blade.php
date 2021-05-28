<script src="{{ asset('assets/dashboard/assets/js/bootstrap-multiselect.js') }}"></script>
<script>
    $(function() {
        'use strict'
        // Notify Client to Schedule Date
        $('.notify-client-schedule-date').on('click', function(e) {
            // Trigger Ajax call to send notification
            $.ajax({
                url: "{{ route('cse.notify.client', app()->getLocale()) }}",
                method: "POST",
                dataType: "JSON",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "service_request": $(this).data('service')
                },
                success: function(data) {
                    console.log(data);
                    displayMessage(data, 'success');
                },
                catch: function(error) {
                    alert(error.data);
                }
            });
            // User service requuest client_id
            // return respose of either success or failed
        });
        $('.sub_service_picker').selectpicker();
        // Re-Categorization
        // $('.sub_service_picker').selectpicker(); //Initiate multiple dropdown select
        
        const services_list = @json($services, JSON_PRETTY_PRINT);
        const category_list = @json($categories, JSON_PRETTY_PRINT);
        // console.log(services_list, category_list);

        $(document).on('change', '#catogorized-category', function() {
            let selected_category_uuid = $(this).val();
            let selectedCategory = category_list.find(function(category, index, arr){
                return category.uuid === selected_category_uuid
            })
            let selected_category_service =  services_list.filter(function(service, index, arr){
                return service.category_id === selectedCategory.id
            }, selectedCategory);

            $('#service_uuid').find('option').not(':first').remove();
            selected_category_service.forEach((service, index) => { 
                $('#service_uuid').append(new Option(service.name, service.uuid));
            })
        });
        // End Re-Categorization

        $(document).on('change', '#service_uuid', function() {
            let selected_service_uuid = $(this).val();
            let selectedService = services_list.find(function(service, index, arr){
                return service.uuid === selected_service_uuid 
            })
            $.ajax({
            url: "{{ route('cse.needed.sub_service', app()->getLocale()) }}",
            method: "POST",
            dataType: "JSON",
            data: {
                "_token": "{{ csrf_token() }}",
                "service_id": selectedService.id
            },
            success: function(data) {
                $('#sub_service_uuid').find('option').remove();
                data.sub_services.forEach((sub_service, index) => { 
                    $('#sub_service_uuid').append(new Option(sub_service.name, sub_service.uuid));
                })
                $('.sub_service_picker').selectpicker('refresh');
            },
            catch: function(error) {
                   return displayMessage('Error finding Sub Service List ', 'error');
            }
        })

        });

        $('#wizard3').steps({
            headerTag: 'h3',
            bodyTag: 'section',
            autoFocus: true,
            titleTemplate: '<span class="number">#index#</span> <span class="title">#title#</span>',
            loadingTemplate: '<span class="spinner"></span> #text#',
            labels: {
                // current: "current step:",
                // pagination: "Pagination",
                finish: "Update Job Progress",
                // next: "Next",
                // previous: "Previous",
                loading: "Loading ..."
            },
            stepsOrientation: 1,
            // transitionEffect: "fade",
            // transitionEffectSpeed: 200,
            showFinishButtonAlways: false,
            onFinished: function(event, currentIndex) {
                $('#update-progress').trigger('click');
            },
        });
        
        // RFQ begin
        $('#rfqYes').change(function() {
            console.log('yes');

            if ($(this).prop('checked')) {
                $('.d-rfq').removeClass('d-none');
            }
        });
        $('#rfqNo').change(function() {
            if ($(this).prop('checked')) {
                $('.d-rfq').addClass('d-none');
            }
        });
        let count = 1;
        function addRFQ(count){
            let html = '<div class="form-row remove-rfq-row"><div class="form-group col-md-4"> <label for="manufacturer_name">Manufacturer Name</label> <input type="text" class="form-control @error('manufacturer_name') is-invalid @enderror" id="manufacturer_name" name="manufacturer_name[]" value="{{ old('manufacturer_name[]') }}"> @error('manufacturer_name[]') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div><div class="form-group col-md-3"> <label for="model_number">Model Number</label> <input type="text" class="form-control @error('model_number') is-invalid @enderror" id="model_number" name="model_number[]" placeholder="" value="{{ old('model_number[]') }}"> @error('model_number[]') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div><div class="form-group col-md-4"> <label for="component_name">Component Name</label> <input type="text" class="form-control @error('component_name') is-invalid @enderror" id="component_name" name="component_name[]" value="{{ old('component_name[]') }}"> @error('component_name[]') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div><div class="form-group col-md-2"> <label for="quantity">Quantity</label> <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity[]" min="1" pattern="d*" maxlength="2" value="{{ old('quantity[]') }}"> @error('quantity[]') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div><div class="form-group col-md-2"> <label for="size">Size</label> <input type="number" class="form-control @error('size') is-invalid @enderror" id="size" name="size[]" min="1" pattern="d*" maxlength="2" value="{{ old('size[]') }}"> @error('size[]') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div><div class="form-group col-md-4"> <label for="unit_of_measurement">Unit of Measurement</label> <input type="text" class="form-control @error('unit_of_measurement') is-invalid @enderror" id="unit_of_measurement" name="unit_of_measurement[]" value="{{ old('unit_of_measurement[0]') }}"> @error('unit_of_measurement[]') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div><div class="form-group col-md-3"> <label>Image</label><div class="custom-file"> <input type="file" accept="image/*" class="custom-file-input @error('image.*') is-invalid @enderror" name="image[]" id="image"> <label class="custom-file-label" for="image">Component Image</label> @error('image.*') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div></div><div class="form-group col-md-1 mt-1"> <button class="btn btn-sm pd-x-15 btn-danger btn-uppercase mg-l-5 mt-4 remove-rfq" type="button"><i class="fas fa-times" class="wd-10 mg-r-5"></i></button></div></div>';
            $('.add-rfq-row').append(html);
        }
        //Add and Remove Request for
        $(document).on('click', '.add-rfq', function() {
            count++;
            addRFQ(count);
        });
        $(document).on('click', '.remove-rfq', function() {
            count--;
            $(this).closest(".remove-rfq-row").remove();
        });
        // End RFQ

        // Tool Request Begin
        $('#trfYes').change(function() {
            if ($(this).prop('checked')) {
                $('.d-trf').removeClass('d-none');
            }
        });
        $('#trfNo').change(function() {
            if ($(this).prop('checked')) {
                $('.d-trf').addClass('d-none');
            }
        });
        
        function addTRF(count){
            let html = '<div class="tool-request form-row remove-trf-row"><div class="form-group col-md-4"> <label for="tool_id">Equipment/Tools Name</label> <select class="form-control custom-select @error('tool_id') is-invalid @enderror tool_id" id="tool_id" name="tool_id[]" ><option value="" selected>Select...</option> @foreach($tools as $tool)<option value="{{ $tool->id }}" {{ old('tool_id') == $tool->id ? 'selected' : ''}} data-id="tool_quantity'+count+'">{{ $tool->name }}</option> @endforeach </select> @error('tool_id') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div><div class="form-group quantity-section col-md-2"> <label for="tool_quantity">Quantity</label> <input type="number" class="form-control @error('tool_quantity') is-invalid @enderror tool_quantity" name="tool_quantity[]" id="tool_quantity'+count+'" min="1" pattern="\d*" maxlength="2" value="{{ old('tool_quantity') }}"> @error('tool_quantity') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div><div class="form-group col-md-2 mt-1"> <button class="btn btn-sm pd-x-15 btn-danger btn-uppercase mg-l-5 mt-4 remove-trf" type="button"><i class="fas fa-times" class="wd-10 mg-r-5"></i> </button></div></div>';
            $('.add-trf-row').append(html);
        }
        let addTRFcount = 1;
        //Add and Remove Tools request form
        $(document).on('click', '.add-trf', function() {
            addTRFcount++;
            addTRF(addTRFcount);
        });
        $(document).on('click', '.remove-trf', function() {
            addTRFcount--;
            $(this).closest(".remove-trf-row").remove();
        });
        // End Tools Request
        
        //Hide and Unhide Work Experience form
        $('#work_experience_yes').change(function() {
            if ($(this).prop('checked')) {
                $('.previous-employment').removeClass('d-none');
            }
        });
        $('#work_experience_no').change(function() {
            if ($(this).prop('checked')) {
                $('.previous-employment').addClass('d-none');
            }
        });
        
        
        $(document).on('click', '#tool-request-details', function(event) {
            event.preventDefault();
            let route = $(this).attr('data-url');
            let batchNumber = $(this).attr('data-batch-number');
            $.ajax({
                url: route,
                beforeSend: function() {
                    $("#spinner-icon").html(
                        '<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>'
                    );
                },
                // return the result
                success: function(result) {
                    $('#modal-body').modal("show");
                    $('#modal-body').html('');
                    $('#modal-body').html(result).show();
                },
                complete: function() {
                    $("#spinner-icon").hide();
                },
                error: function(jqXHR, testStatus, error) {
                    var message = error + ' An error occured while trying to retireve ' +
                        batchNumber + '  details.';
                    var type = 'error';
                    displayMessage(message, type);
                    $("#spinner-icon").hide();
                },
                timeout: 8000
            })
        });
        $(document).on('click', '#rfq-details', function(event) {
            event.preventDefault();
            let route = $(this).attr('data-url');
            let batchNumber = $(this).attr('data-batch-number');
            $.ajax({
                url: route,
                beforeSend: function() {
                    $("#spinner-icon").html(
                        '<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>'
                    );
                },
                // return the result
                success: function(result) {
                    $('#modal-body-rfq-details').modal("show");
                    $('#modal-body-rfq-details').html('');
                    $('#modal-body-rfq-details').html(result).show();
                },
                complete: function() {
                    $("#spinner-icon").hide();
                },
                error: function(jqXHR, testStatus, error) {
                    var message = error + ' An error occured while trying to retireve ' +
                        batchNumber + '  details.';
                    var type = 'error';
                    displayMessage(message, type);
                    $("#spinner-icon").hide();
                },
                timeout: 8000
            })
        });
        $('.close').click(function() {
            $(".modal-backdrop").remove();
        });
    });
    //Get available quantity of a particular tool.
    $(document).on('change', '.tool_id', function() {
        let toolId = $(this).find('option:selected').val();
        let toolName = $(this).children('option:selected').text();
        let quantityName = $(this).children('option:selected').data('id');
        $.ajax({
            url: "{{ route('cse.available.tools', app()->getLocale()) }}",
            method: "POST",
            dataType: "JSON",
            data: {
                "_token": "{{ csrf_token() }}",
                "tool_id": toolId
            },
            success: function(data) {
                if (data) {
                    $('#' + quantityName + '').attr({
                        "value": data,
                        "max": data,
                    });
                } else {
                    var message = 'Error occured while trying to get ' + toolName +
                        ' available quantity';
                    var type = 'error';
                    displayMessage(message, type);
                }
            },
        })
    });

</script>
