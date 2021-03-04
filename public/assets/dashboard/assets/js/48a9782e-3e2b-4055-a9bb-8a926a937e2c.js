$(document).ready(function () {

    // Basic DataTable
    $('#basicExample, #demoRequests #paymentExample').DataTable({
      "iDisplayLength": 10,
      "language": {
            "searchPlaceholder": 'Search...',
            "sSearch": '',
            "lengthMenu": '_MENU_ items/page',
            // "lengthMenu": "Display _MENU_ records per page",
            "zeroRecords": "No matching records found",
            // "info": "Showing page _PAGE_ of _PAGES_",
            "infoEmpty": "No records available",
            "infoFiltered": "(filtered from _MAX_ total records)"
          },
      "dom": 'Bfrtip',
      "buttons": [
          'copy', 'csv', 'excel', 'pdf', 'print'
      ],
      "processing": true,
      // "scrollY":        "200px",
      // "scrollCollapse": true,
    });

    // Url for more info on datepicker options https://xdsoft.net/jqplugins/datetimepicker/
    $(document).on('click', '#service-date-time', function(){
      $('#service-date-time').datetimepicker({
          // format: 'L', //LT for time only
          // inline: true,
          // sideBySide: true,
          format:'Y/m/d H:i',
          formatDate:'Y/m/d',
          minDate:'-1970/01/02', // yesterday is minimum date
          mask: true,
      });
    });


    //Prevent characters or string asides number in ohone number input field
    $("#phone_number, #other_phone_number, #account_number, .amount").on("keypress keyup blur", function(event) {
        $(this).val($(this).val().replace(/[^\d].+/, ""));
        if ((event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });
    
    //Close bootstrap modal backdrop on click
    $('.close').click(function (){
      $(".modal-backdrop").remove();
    });

    //Set Payment max date to Today's date
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0');
    var yyyy = today.getFullYear();
    today = yyyy + '-' + mm + '-' + dd;
    $('#payment_date, #date_to, #date_from, #specific_date').attr('max', today);

    //Delete feature sweetalert dialog
    $(document).on('click', '.delete-entity', function(e){
        e.preventDefault();
        var route = $(this).data('url');
        var title = $(this).attr('title');

        Swal.fire({
            title: title+'?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#E97D1F',
            cancelButtonColor: '#7987a1',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value == true) {
                window.location.href = route;
            }
        });
    });

    //Deactivate feature sweetalert dialog
    $(document).on('click', '.deactivate-entity', function(e){
        e.preventDefault();
        var route = $(this).data('url')
        var title = $(this).attr('title');

        Swal.fire({
            title: title+'?',
            text: "You will be able to reinstate afterwards!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#E97D1F',
            cancelButtonColor: '#7987a1',
            confirmButtonText: 'Yes, deactivate it!'
        }).then((result) => {
            if (result.value == true) {
                window.location.href = route;
            }
        });
    });

  });
  
//Initialise TinyMCE editor
tinymce.init({
    selector: '#message_body',
    height: 200,
    theme: 'modern',
    plugins: [
        'advlist autolink lists charmap hr anchor pagebreak',
        'searchreplace wordcount visualblocks visualchars',
        'insertdatetime nonbreaking save table contextmenu directionality',
        'emoticons paste textcolor colorpicker textpattern'
    ],
    toolbar1: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent',
    toolbar2: 'forecolor backcolor emoticons',
    image_advtab: true
});

//Feedback from session message to be displayed with Sweet Alert
function displayMessage(message, type){
    const Toast = swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 8000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
    Toast.fire({
            icon: type,
            //   type: 'success',
            title: message
    });
}