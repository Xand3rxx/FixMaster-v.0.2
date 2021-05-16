    function sortJobAssignedTable($sortLevel, $cseId = null, $jobStatus = null, $dateFrom = null, $dateTo = null) {
        //Get sorting route
        $route = $('#route').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: $route,
            method: 'POST',
            data: {
                "sort_level": $sortLevel,
                "cse_id": $cseId,
                "job_status": $jobStatus,
                "date_from": $dateFrom,
                "date_to": $dateTo
            },
            beforeSend: function() {
                $("#job-assigned-sorting").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>');
            },
            success: function(data) {
                console.log(data);
                return false;
                if (data) {
                    //Replace table with new sorted records
                    $('#job-assigned-sorting').html('');
                    $('#job-assigned-sorting').html(data);

                    //Add sorting class for jQuery datatable
                    $('#basicExample').addClass('basicExample');

                    //Attach JQuery datatable to current sorting
                    if ($('#basicExample').hasClass('basicExample')) {
                        jQuerySort();
                    }
                } else {
                    var message = 'Error occured while trying to sort this table.';
                    var type = 'error';
                    displayMessage(message, type);
                }
            },
            error: function() {
                alert('An error has occurred')
            }
        });
    }