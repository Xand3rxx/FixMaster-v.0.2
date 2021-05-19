$(document).ready(function () {
    $('#client_decline').on('click', function () {
        $route = $('#decision-route').val()
        $invoiceUUID = $('#invoice_uuid').val()

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: $route,
            method: 'POST',
            data: {'invoiceUUID': $invoiceUUID},
            beforeSend: function() {
                $("#job-assigned-sorting").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>');
            },
            success: function (data) {
                if(data) {
                    console.log(data)
                    location.reload()
                }else{
                    console.log('unpopulated')
                }
            }
        })
    })
})
