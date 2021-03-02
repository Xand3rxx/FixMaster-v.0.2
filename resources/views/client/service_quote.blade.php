@extends('layouts.client')
@section('title', 'Service Quote')
@section('content')
@include('layouts.partials._messages')
<script src="https://js.paystack.co/v1/inline.js"></script>

<div class="col-lg-8 col-12">
    <div class="card custom-form border-0">
        <div class="card-body">
            <h5>{{ $serviceQuote->name }} Service Request</h5>
            <div class="example gc3 mb-4">
               
            </div>

            <form class="rounded shadow p-4" method="POST" action="{{ route('client.book_services') }}" enctype="multipart/form-data">
                @csrf
                <small class="text-danger">A booking deposit is required to validate this order and enable us assign a CSE to your Job.</small>

                <input type="hidden" class="d-none" value="{{ $serviceQuote->service_id }}" name="service_id">
                <input type="hidden" class="d-none" value="{{ $serviceQuote->id }}" name="category_id">

                <div class="row" id="pills-tab" role="tablist">
                    <ul class="nav nav-pills bg-white nav-justified flex-column mb-0" id="pills-tab" role="tablist">
                        <li class="nav-item bg-light rounded-md">
                            <a class="nav-link rounded-md @if(old('service_fee') == $serviceQuote->standard_fee) active @endif"  id="dashboard" data-toggle="pill" href="#dash-board" role="tab" aria-controls="dash-board" aria-selected="false">
                                <div class="p-3 text-left">
                                <h5 class="title">Standard: ₦{{ number_format($serviceQuote->standard_fee) }}</h5>
                                    <p class="text-muted tab-para mb-0">Your job will be evaluated by a CSE and technician within a maximum period of 8 hours.</p>
                                    <input type="radio" name="service_fee" value="{{ $serviceQuote->standard_fee }}" class="custom-control-input service-fee" @if(old('service_fee') == $serviceQuote->standard_fee) checked @endif>

                                    <input type="radio" name="service_fee_name" value="Standard" class="custom-control-input service-fee-name" @if(old('service_fee') == $serviceQuote->standard_fee) checked @endif>

                                </div>
                            </a><!--end nav link-->
                        </li><!--end nav item-->
                        
                        <li class="nav-item bg-light rounded-md mt-4">
                            <a class="nav-link rounded-md urgent @if(old('service_fee') == $serviceQuote->urgent_fee) active @endif" id="timeline" data-toggle="pill" href="#time-line" role="tab" aria-controls="time-line" aria-selected="false">
                                <div class="p-3 text-left">
                                <h5 class="title">Urgent - ₦{{ number_format($serviceQuote->urgent_fee) }}</h5>
                                    <p class="text-muted tab-para mb-0">Your job will be evaluated by a CSE and technician within a maximum period of 2 hours</p>
                                    <input type="radio" name="service_fee" value="{{ $serviceQuote->urgent_fee }}" class="custom-control-input service-fee" @if(old('service_fee') == $serviceQuote->urgent_fee) checked @endif>

                                    <input type="radio" name="service_fee_name" value="Urgent" class="custom-control-input service-fee-name" @if(old('service_fee') == $serviceQuote->urgent_fee) checked @endif>
                                </div>
                            </a><!--end nav link-->
                        </li><!--end nav item-->
                        
                        <li class="nav-item bg-light rounded-md mt-4">
                            <a class="nav-link rounded-md @if(old('service_fee') == $serviceQuote->ooh_fee) active @endif" id="paymentmanagement" data-toggle="pill" href="#payment-management" role="tab" aria-controls="payment-management" aria-selected="false">
                                <div class="p-3 text-left">
                                <h5 class="title">Out of Hours - ₦{{ number_format($serviceQuote->ooh_fee) }}</h5>
                                    <p class="text-muted tab-para mb-0">Our normal working Hours is 7AM to 7PM. A CSE and technician will evaluate your job within a maximum period of 2 hours</p>
                                    <input type="radio" name="service_fee" value="{{ $serviceQuote->ooh_fee }}" class="custom-control-input service-fee" @if(old('service_fee') == $serviceQuote->ooh_fee) checked @endif>

                                    <input type="radio" name="service_fee_name" value="Out of Hours" class="custom-control-input service-fee-name" @if(old('service_fee') == $serviceQuote->ooh_fee) checked @endif>

                                </div>
                            </a><!--end nav link-->
                        </li><!--end nav item-->
                        
                    
                    </ul><!--end nav pills-->
                </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="form-group position-relative">
                            <label>Tell us more about the service you need :</label>
                            <i data-feather="message-circle" class="fea icon-sm icons"></i>
                            <textarea name="description" id="description" rows="4" class="form-control pl-5 @error('description') is-invalid @enderror" placeholder="If there is an equipment involved, do tell us about the equipment e.g. the make, model, age of the equipment etc. ">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div><!--end col--> 
                    <div class="col-md-6">
                        <div class="form-group position-relative">
                            <label>Date & Time :<span class="text-danger">*</span></label>
                            <i data-feather="calendar" class="fea icon-sm icons"></i>
                            <input name="timestamp" type="text" class="form-control pl-5 @error('timestamp') is-invalid @enderror" placeholder="Click to select :" id="service-date-time" readonly value="{{ old('timestamp') }}">
                            @error('timestamp')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div><!--end col-->
                    <div class="col-md-6">
                        <div class="form-group position-relative">
                            <label>Upload file for evaluation <span class="text-danger">(Optional)</span> :</label>
                            <input type="file" class="form-control-file btn btn-primary btn-sm" id="fileupload" name="media_file" accept="image/*,.txt,.doc,.docx,.pdf">
                            <small style="font-size: 10px;" class="text-muted">File must not be more than 2MB</small>
                        </div>                                                                               
                    </div><!--end col-->

                    <div class="col-md-6 form-group mt-2">
                        <label>Contact Number:<span class="text-danger">*</span></label>

                        <div class="custom-control custom-checkbox form-group position-relative">
                            <input type="radio" id="customRadio1" name="phone_number" value="yes" class="custom-control-input">
                            <label class="custom-control-label" for="customRadio1">Use my saved Phone Number</label>
                        </div>
                    
                        <div class="custom-control custom-checkbox form-group position-relative">
                            <input type="radio" id="customRadio2" name="phone_number" value="no" class="custom-control-input">
                            <label class="custom-control-label" for="customRadio2">No, I have another contact number</label>
                        </div>
                        <div class="form-group position-relative d-none display-phone">
                            <label>Your Phone no. :<span class="text-danger">*</span></label>
                            <i data-feather="phone" class="fea icon-sm icons"></i>
                            <input name="alternate_phone_number" id="alternate_phone_number" type="tel" class="form-control pl-5 @error('alternate_phone_number') is-invalid @enderror" placeholder="Your Phone No. :" maxlength="11" value="{{ old('alternate_phone_number') }}" autocomplete="off">
                            @error('alternate_phone_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div> 
                    </div><!--end col-->
                        
                    <div class="col-md-6 form-group">
                        <label>Address:<span class="text-danger">*</span></label>

                        <div class="custom-control custom-checkbox form-group position-relative">
                            <input type="radio" id="customRadio3" name="address" class="custom-control-input" value="yes">
                            <label class="custom-control-label" for="customRadio3">Use my saved Address</label>
                        </div>
                    
                        <div class="custom-control custom-checkbox form-group position-relative">
                            <input type="radio" id="customRadio4" name="address" class="custom-control-input" value="no">
                            <label class="custom-control-label" for="customRadio4">No, I have another Address</label>
                        </div>

                        <div class="form-group position-relative d-none display-address">
                            <label>Address</label>
                            <i data-feather="map-pin" class="fea icon-sm icons"></i>
                            <textarea name="alternate_address" id="alternate_address" rows="4" class="form-control pl-5 @error('alternate_address') is-invalid @enderror" placeholder="Address of where the service is required">{{ old('alternate_address') }}</textarea>
                            @error('alternate_address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div><!--end col--> 
                                                       
                    
                        <div class="col-md-12 form-group">
                            <label>Payment Mode:<span class="text-danger">*</span></label>
                        </div>
                            
                        <div class="col-md-4 form-group">
                            <div class="custom-control custom-checkbox form-group position-relative">
                                <input type="radio" id="customRadio5" name="payment_method" class="custom-control-input" value="Wallet">
                                <label class="custom-control-label" for="customRadio5">E-Wallet</label>
                            </div>
                        </div>

                        <div class="col-md-4 form-group">
                            <div class="custom-control custom-checkbox form-group position-relative">
                                <input type="radio" onclick="payWithPaystack()" id="paystack_option" name="payment_method" class="custom-control-input" value="Online">
                                <label class="custom-control-label" for="paystack_option">Pay Online</label>
                            </div>
                        </div>
                        
                        <div class="col-md-4 form-group">
                            <div class="custom-control custom-checkbox form-group position-relative">
                                <input type="radio" id="pay_offline" name="payment_method" class="custom-control-input" data-toggle="modal" href="#payOffline" value="Offline">
                                <label class="custom-control-label" for="pay_offline">Pay Offline</label>
                            </div>
                        </div>
                        {{-- </div>
                    </div><!--end col--> --}}
                </div><!--end row-->

                

                {{-- REQUIREMENTS FOR PAYMENT GATWAYS  --}}
                <input type="hidden" class="d-none" value="{{ old('email') ?? $email }}" id="email" name="email">
                <input type="hidden" class="d-none" value="{{ old('client_discount') ?? $clientDiscount }}" id="client_discount" name="client_discount">
                <input type="hidden" class="d-none" value="{{ old('client_phone_number') ?? $clientPhoneNumber }}" id="client_phone_number" name="client_phone_number">

                {{-- Values are to be provided by the payment gateway using jQuery or Vanilla JS --}}
                <input type="hidden" class="d-none" value="{{ old('payment_response_message') }}" id="payment_response_message" name="payment_response_message">
                <input type="hidden" class="d-none" value="{{ old('payment_reference') }}" id="payment_reference" name="payment_reference">

                
                <div class="row">
                    <div class="col-sm-12">
                    <button type="submit" class="submitBnt btn btn-primary">Submit</button>
                    </div><!--end col-->
                </div><!--end row-->
            </form><!--end form-->
        </div> 
    </div><!--end custom-form-->
</div>

<div class="modal fade" id="payOffline" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content rounded shadow border-0">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">How to make offline payment? </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
                {{-- <h3>How to make offline payment?</h3> --}}
                <p class="text-muted">You can make offline payment using the following options</p>
                <h5 class="text-primary">Pay To The Bank</h5>
                <p>
                    Pay to into the account details below:<br> Account name: <strong>FCMB</strong><br> Account Number: <strong>1234567890</strong><br> <span class="text-danger">Note: </span> On the teller, please write as depositor's name and add your job reference at the end of the name. E.g.: <span class="text-muted">"{{ Auth::user()->fullName->name }} (REF-2E3487AAF23) payment."</span>
                </p>

                <h5 class="text-primary">Internet Banking</h5>
                <p>
                    Make an online transfer to the account details below:<br> Account name: <strong>FCMB</strong><br> Account Number: <strong>1234567890</strong><br> <span class="text-danger">Note: </span> Use the following as transfer note. E.g.: <span class="text-muted">"{{ Auth::user()->fullName->name }} (REF-2E3487AAF23) payment."</span>
                </p>

                <div class="col-md-12 col-12 mt-4 mb-4 pt-2">
                    <div class="media">
                        <i data-feather="help-circle" class="fea icon-ex-md text-primary mr-2 mt-1"></i>
                        <div class="media-body">
                            <h5 class="mt-0">Once your payment is successfully made, kindly notify us by:</h5>
                            <p class="answer text-muted mb-0">
                                1. Call Us on <strong>08132863878</strong><br>
                                2. Send an SMS of your service Reference Code <strong>(REF-2E3487AAF23)</strong> and amount paid to <strong>08132863878</strong><br>
                                3. E-Mail Us on <a href="mailto:info@fixmaster.com.ng">info@fixmaster.com.ng</a> with your service Reference Code and amount paid.<br>
                                4. <a class="btn btn-primary btn-sm"> Notify Us Online</a>
                            </p>
                        </div>
                    </div>
                </div><!--end col-->
        </div>
        </div><!-- modal-body -->
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->

@php
$paystackInfo = json_decode($paystack->information, true);
@endphp

@push('scripts')
<script>
    $(document).ready(function (){

        $(document).on('click', '.nav-item', function(){
            // console.log($(this).closest('a').find('.service-fee').val());
            // console.log($(this).find('.service-fee').val());

            $(this).find('.service-fee').prop('checked', true);
            $(this).find('.service-fee-name').prop('checked', true);

        });

        $('#pay_offline').on('change', function (){  
            $('#pay_offline').attr('checked', 'checked');
        });

        $('.close').click(function (){
            $(".modal-backdrop").remove();
        });

        //PAYMENR GATEWAY
        $('#paystack_option').on('change', function (){  

            // var clientEmail = $('#email').val();
            // var clientDiscount = $('#client_discount').val();
            // var serviceFee = $('.service-fee').val();
            // var amount;

            // //ADD VALUE FROM PAYSTACK
            // var paymentResponseMessage = $('#payment_response_message');
            // var paymentReference = $('#payment_reference');

            // if(clientDiscount == 0){
            //     //If client still has a discount of 5%
            //     var discountServiceFee = 0.95 * serviceFee;
            //     amount = discountServiceFee;
            // }else{
            //     amount = serviceFee;
            // }

            // //IF client has no discount seviceFee and amount should be the same value
            //  console.log(clientEmail, clientDiscount, serviceFee, amount);

            // //DENK your CODE continues from here. Cheers
        });

        // payment_response_message
// payment_reference


    });
</script>

<script>
    function payWithPaystack(){

        var clientEmail = $('#email').val();
        var clientDiscount = $('#client_discount').val();
        var clientPhoneNumber = $('#client_phone_number').val();
        var amount;
        var serviceFee = $("input[name='service_fee']:checked").val();

        if($.trim(serviceFee).length < 1){

            $('#paystack_option').prop('checked', false);

            var message = 'Please select a Service Fee Type.';
            var type = 'error';
            displayMessage(message, type);

            return false;
        }

        //ADD VALUE FROM PAYSTACK
        var paymentResponseMessage = $('#payment_response_message');
        var paymentReference = $('#payment_reference');

        if(clientDiscount == 0){
            //If client still has a discount of 5%
            var discountServiceFee = 0.95 * serviceFee;
            amount = discountServiceFee;
        }else{
            amount = serviceFee;
        }

        var handler = PaystackPop.setup({
            key:"{{ $paystackInfo['public_key'] }}",
            // key: 'pk_test_41ada297a2a2953f9d42e125713644baccd0658c',
            email: clientEmail,
            amount: amount * 100,
            currency: "NGN",
            ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
            metadata: {
            custom_fields: [
                {
                    display_name: "Mobile Number",
                    variable_name: "mobile_number",
                    value: clientPhoneNumber,
                }
            ]
            },
            callback: function(response){
                // sendResponseToController(response);
                // alert('success. transaction ref is ' + response.reference);
                $('#payment_reference').val(response.reference);
                $('#payment_response_message').val('success');

                // console.log($('#payment_reference').val());
                $('.submitBnt').trigger('click');

            },
            onClose: function(){
                // alert('window closed');

                var message = 'Closing payment gateway window.';
                var type = 'success';
                displayMessage(message, type);
            }
        });
        handler.openIframe();
    }

  </script>

@endpush
@endsection