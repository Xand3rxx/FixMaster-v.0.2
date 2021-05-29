<script src="{{ asset('assets/dashboard/assets/js/bootstrap-multiselect.js') }}"></script>

<script defer>
    $(function() {
        'use strict'
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
    });
</script>
