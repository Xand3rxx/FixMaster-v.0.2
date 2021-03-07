@extends('layouts.dashboard')
@section('title', 'E-Wallet')
@section('content')
@include('layouts.partials._messages')

<style>
    [type=radio] { 
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    /* IMAGE STYLES */
    [type=radio] + img {
        cursor: pointer;
    }

    /* CHECKED STYLES */
    [type=radio]:checked + img {
        outline: 2px solid #E97D1F;
        outline-style: dashed;
    }
</style>
<div class="col-lg-8 col-12">
  

    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-12 mt-4 pt-2 text-center">
            <ul class="nav nav-pills nav-justified flex-column flex-sm-row rounded" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link rounded active" id="fund-account-tab" data-toggle="pill" href="#fund-account" role="tab" aria-controls="fund-account" aria-selected="false">
                        <div class="text-center pt-1 pb-1">
                            <h4 class="title font-weight-normal mb-0">Fund Account</h4>
                        </div>
                    </a><!--end nav link-->
                </li><!--end nav item-->
                
                
            </ul><!--end nav pills-->
        </div>
    </div>
    {{ $message ?? '' }}
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="fund-account" role="tabpanel" aria-labelledby="fund-account-tab">
            <div class="col-md-12 mt-4 pt-2">
                <h5>Fund Account :</h5>
        
                <form id="fund-wallet" action="{{ url('client/initiatetransaction', app()->getLocale()) }}" method="post">
                @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                            
                                <label for="amount">Amount <span>(required)</span></label>
                                <input name="amount" id="amount" type="text" class="form-control font-weight-bold" required placeholder="Amount : " required>
                            </div>
                        </div><!--end col-->
                        <div class="col-md-6">
                            <div class="form-group">
                                
                                <input name="email" id="email" type="hidden" value="iclaudpat@gmail.com" class="form-control font-weight-bold" readonly required placeholder="Amount : ">
                                <input name="status" id="status" type="hidden" value="0" class="form-control font-weight-bold" readonly required placeholder="Amount : ">
                                <input name="internal_reference" id="internal_reference" type="hidden" value="{{ Str::random(6) }}" class="form-control font-weight-bold" readonly required>
                            </div>
                        </div><!--end col-->

                        <div class="col-md-6">
                            <label>Payment Gateway : </label>
                                <br>
                            <label>
                                <input type="radio" name="profile_avatar" value="">
                                <img src="{{ asset('assets/images/paystack.png') }}" alt="" class="img-fluid avatar avatar-small mx-2 mt-4 rounded-circl shadow">
                            </label>
        
                            
        
                        </div><!--end col-->
                        <div class="col-md-12 form-group">
                            <div class="col-md-6 custom-control custom-checkbox form-group position-relative">
                                <input type="radio" id="customRadio33" name="customRadio" class="custom-control-input">
                                <label class="custom-control-label" for="customRadio33">Use my saved card</label>
                            </div>
                        
                            <div class="col-md-6 custom-control custom-checkbox form-group position-relative">
                                <input type="radio" id="customRadio34" name="customRadio" class="custom-control-input">
                                <label class="custom-control-label" for="customRadio34">No, I have another card</label>
                            </div>
                        </div>
                    </div>
                
                    <div class="row d-none add-card mt-b col-md-6">
                       
                        
                        

                    </div><!--end row-->
                    <div class="row mb-4">
                        <div class="col-md-12">
                        
                            <button type="button" id="submit" name="send" class="submitBnt btn btn-primary" value="Make Payment">Make Payment</button>
                          
                            
                            <!-- <input type="submit" id="submit" name="send" class="submitBnt btn btn-primary" onclick="payWithPaystack()" value="Make Payment"> -->
                        </div><!--end col-->
                     </div><!--end row--> 
                </form><!--end form-->
            </div><!--end col-->
        </div>

       
        
                
            </div>
        </div>
    </div>


    

    
</div><!--end col-->

@section('scripts')
<script>
    $(document).ready(function() {
        $('#request-sorting').on('change', function (){        
                let option = $("#request-sorting").find("option:selected").val();

                if(option === 'None'){
                    $('.specific-date, .sort-by-year, .date-range').addClass('d-none');
                }

                if(option === 'Date'){
                    $('.specific-date').removeClass('d-none');
                    $('.sort-by-year, .date-range').addClass('d-none');
                }

                if(option === 'Month'){
                    $('.sort-by-year').removeClass('d-none');
                    $('.specific-date, .date-range').addClass('d-none');
                }

                if(option === 'Date Range'){
                    $('.date-range').removeClass('d-none');
                    $('.specific-date, .sort-by-year').addClass('d-none');
                }
        });
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js" integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg==" crossorigin="anonymous"></script>
<script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://js.paystack.co/v1/inline.js"></script>

<script> const paymentForm = document.getElementById('submit');
 
paymentForm.addEventListener("click", payWithPaystack, false);
function payWithPaystack(e) {
 e.preventDefault();
 
 var amount = $('#amount').val();


 $.ajax({
          url: "{{ route('client.initiate_wallet_transaction', app()->getLocale()) }}",//"{{'initiate_wallet_transaction' }}",
          type:"POST",
          data:{
           "_token": "{{ csrf_token() }}",
            amount:amount,
           
          }  
        });
   

 let handler = PaystackPop.setup({
    key: 'pk_test_41ada297a2a2953f9d42e125713644baccd0658c', // Replace with your public key
    email: document.getElementById("email").value,
    internal_reference: document.getElementById("internal_reference").value,
    amount: document.getElementById("amount").value * 100,
    ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
   
    

    onClose: function(){
       
       
    swal("Cancelled!", "Transaction cancelled!", "Cancel");
                
    },
    callback: function(response){
        console.log(response)
      let message = 'Payment complete! Reference: ' + response.reference;

      window.location = {"{{ route('client.verify_transaction', app()->getLocale()) }}", "response":reference},      
     alert(message);
    
    }
  });

  handler.openIframe();
}

//window.location = "http://localhost/paystack/index.php?transaction=cancel";
</script>
@endsection

@endsection