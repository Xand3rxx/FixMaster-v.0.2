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

        let count = 1;
        //Add and Remove Request for
        $(document).on('click', '.add-rfq', function() {
            count++;
            addRFQ(count);
        });
        $(document).on('click', '.remove-rfq', function() {
            count--;
            $(this).closest(".remove-rfq-row").remove();
            // $(this).closest('tr').remove();
        });
        //Add and Remove Tools request form
        $(document).on('click', '.add-trf', function() {
            count++;
            addTRF(count);
        });
        $(document).on('click', '.remove-trf', function() {
            count--;
            $(this).closest(".remove-trf-row").remove();
        });
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
        //Hide and Unhide RFQ
        $('#rfqYes').change(function() {
            if ($(this).prop('checked')) {
                $('.d-rfq').removeClass('d-none');
            }
        });
        $('#rfqNo').change(function() {
            if ($(this).prop('checked')) {
                $('.d-rfq').addClass('d-none');
            }
        });
        //Hide and Unhide TRF
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
            url: "{{ route('available_quantity', app()->getLocale()) }}",
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
