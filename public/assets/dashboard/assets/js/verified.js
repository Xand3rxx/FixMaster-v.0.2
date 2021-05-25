

var token = $('.get_token').attr('data-token');
var get_users = $('#get_users').attr('data-users');
var get_url = $('#get_url').attr('data-url');
var name = $('#get_name').attr('data-name');


    $.ajax({
        url: get_url,
        method: "GET",
         dataType: "JSON",
       
        data: {
            "_token": token,
            "user": get_users
           
        },
        success: function(data) {
            if (data === '1') {
                message= "Welcome ," + name + "please check your email for a registration discount and your referral code";
                setTimeout(() => {
                    displayMessage(message, 'success'); 
                }, 2000);
               
            } else {
                var message =
                    'Error occured while trying to get Enity Parameter List`s in ';
                var type = 'error';
                displayMessage(message, type);
            }
        },
        error: function(xhr, status, error) {
    console.log(error, xhr, status, '100' )
   }
    })