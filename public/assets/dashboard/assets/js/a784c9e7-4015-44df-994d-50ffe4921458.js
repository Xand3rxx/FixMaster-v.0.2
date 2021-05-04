$(document).ready(function() {
    $(document).on('click', '#rfq-details', function(event) {
      event.preventDefault();
      let route = $(this).attr('data-url');
      let batchNumber = $(this).attr('data-batch-number');
      
      $.ajax({
          url: route,
          beforeSend: function() {
            $("#spinner-icon").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>');
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
              var message = error+ ' An error occured while trying to retireve '+ batchNumber +'  details.';
              var type = 'error';
              displayMessage(message, type);
              $("#spinner-icon").hide();
          },
          timeout: 8000
      })
    });

    $('.close').click(function (){
      $(".modal-backdrop").remove();
    });


  });


  function individualAmount(count)
  {
    var unitPrice = parseFloat(($('#unit-price-'+count).val().replace(/,/g , '')));
    var quantity  = parseInt($('.quantity-'+count).text());
    var totalAmount = (unitPrice * quantity);
    $('#unit-amount-'+count).val(totalAmount);
    $('.amount-'+count).text(numberWithCommas(totalAmount.toFixed(2)));
    getTotalAmount();
  }

  function deliveryFee(){
    // $('#delivery_fee').keyup(function(){
    //     return $(this).val();
    // });
    $('.delivery-fee').text(numberWithCommas($('#delivery_fee').val()));
    getTotalAmount();
  }

  function getTotalAmount()
  {
    var totalEachAmount = 0;
    var totalAmount = 0;

    $('.each-amount').each(function (){
        var total  = parseInt($(this).val());
        if(isNaN(total) == false){
          totalEachAmount += total;
          $('.total-amount').text('₦'+numberWithCommas(totalEachAmount.toFixed(2)));
          $('#total_amount').val(totalEachAmount);
          // return totalEachAmount;
        }
    });
  }

  function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  }