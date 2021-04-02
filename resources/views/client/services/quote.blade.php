@extends('layouts.client')
@section('title', 'Service Quote')
@section('content')
@include('layouts.partials._messages')
<style>
    .blog .author { opacity: 1 !important; }
    .blog .overlay { opacity: 0.6 !important; }
    .avatar.avatar-ex-smm { max-height: 75px; }
</style>

<style>
.cc-selector input{
    margin:0;padding:0;
    -webkit-appearance:none;
       -moz-appearance:none;
            appearance:none;
}
.paystack{background-image:url({{ asset('assets/images') }}/paystack.png);}
.flutter{background-image:url({{ asset('assets/images') }}/flutter.png);}

.cc-selector input:active +.drinkcard-cc{opacity: .5;}
.cc-selector input:checked +.drinkcard-cc{
    -webkit-filter: none;
       -moz-filter: none;
            filter: none;
}
.drinkcard-cc{
    cursor:pointer;
    background-size:contain;
    background-repeat:no-repeat;
    display:inline-block;
    width:100px;height:10em;
    -webkit-transition: all 100ms ease-in;
       -moz-transition: all 100ms ease-in;
            transition: all 100ms ease-in;
    -webkit-filter: brightness(1.8) grayscale(1) opacity(.7);
       -moz-filter: brightness(1.8) grayscale(1) opacity(.7);
            filter: brightness(1.8) grayscale(1) opacity(.7);
}
.drinkcard-cc:hover{
    -webkit-filter: brightness(1.2) grayscale(.5) opacity(.9);
       -moz-filter: brightness(1.2) grayscale(.5) opacity(.9);
            filter: brightness(1.2) grayscale(.5) opacity(.9);
}

/* Extras */
a:visited{color:#888}
a{color:#999;text-decoration:none;}
p{margin-bottom:.3em;}

.address-hide{
    display:none;
}
</style>

<div class="col-lg-8 col-12">
    <div class="card custom-form border-0">
        <div class="card-body mt-4">
            {{-- <h5><span class="font-weight-bold">{{ $service->name }}</span> Service Request</h5> --}}
            <div class="card blog">
            <!-- <div class="position-relative" style="height: 100px !important">
                @if(empty($service->image))
                        <img src="{{ asset('assets/images/no-image-available.png') }}" alt="Image not available" class="card-img-top rounded-top" height="100px !important">
                @else
                    @if(file_exists(public_path().'/assets/service-images/'.$service->image))
                        <img src="{{ asset('assets/service-images/'.$service->image) }}" alt="{{ !empty($service->name) ? $service->name : 'UNAVAILABLE'  }}" class="card-img-top rounded-top">
                    @else
                        <img src="{{ asset('assets/images/no-image-available.png') }}" alt="Image not available" class="card-img-top rounded-top" height="100px !important">
                    @endif
                @endif
                <div class="overlay rounded-top bg-dark"></div>
            </div> -->

            <div class="author">
                <h4 class="text-light user d-block"><i class="mdi mdi-bookmark"></i> {{ !empty($service->name) ? $service->name : 'UNAVAILABLE' }}</h4>
                <small class="text-light date"><i class="mdi mdi-bookmark"></i> {{ $service->serviceRequests()->count() ?? '0' }} Requests</small>
            </div>
            </div>

            <form class="rounded p-4" method="POST" action="{{ route('client.services.serviceRequest', app()->getLocale()) }}" enctype="multipart/form-data">
                @csrf
                <small class="text-danger">A Booking Fee deposit is required to validate this order and enable our AI assign a Customer Service Executice(CSE) to your Job.</small>

                <input type="hidden" class="d-none" value="{{ $service->id }}" name="service_id">

                <div class="row" id="pills-tab" role="tablist">
                    <ul class="nav nav-pills bg-white nav-justified flex-column mb-0" id="pills-tab" role="tablist">
                        @foreach($bookingFees as $bookingFee)
                            <li class="nav-item bg-light rounded-md mt-4">
                                <a class="nav-link rounded-md @if(old('price_id') == $bookingFee->id) active @endif"  id="dashboard-{{$bookingFee->id}}" data-toggle="pill" href="#dash-board-{{$bookingFee->id}}" role="tab" aria-controls="dash-board-{{$bookingFee->id}}" aria-selected="false">
                                    <div class="p-3 text-left">
                                    <h5 class="title">{{ !empty($bookingFee->name) ? $bookingFee->name : 'UNAVAILABLE' }}: ₦{{ number_format(!empty($bookingFee->amount) ? $bookingFee->amount : '0') }}</h5>
                                        <p class="text-muted tab-para mb-0">{{ !empty($bookingFee->description) ? $bookingFee->description : 'No description found' }}</p>
                                        <input type="radio" name="price_id" value="{{ old('price_id') ?? $bookingFee->id }}" class="custom-control-input booking-fee" >
                                        <input type="radio" name="booking_fee" value="{{ old('booking_fee') ?? $bookingFee->amount }}" class="custom-control-input booking-fee" >
                                    </div>
                                </a><!--end nav link-->
                            </li><!--end nav item-->
                        @endforeach
                    </ul><!--end nav pills-->
                </div>


                <div class="d-flex border-bottom bg-light p-3">

    <!-- <div class="row delivery-address">
                                        <span class="form-group edit-delete">
                                            <button
                                                class="btn editAddress"
                                                data-data='{"id":"1331","user_id":"477","type":"Home","name":"fsdfsdfsd","country_code":"","mobile":"8254644644","alternate_mobile":"456454464545","address":"5","landmark":"55","area_id":"228","city_id":"119","pincode":"56446","state":"fsfsd","country":"sdfsfsd","latitude":"0","longitude":"0","is_default":"0","date_created":"2021-03-25 17:43:34","city_name":"Bhuj","area_name":"Jubulee Circle","minimum_free_delivery_order_amount":"500","delivery_charges":"10"}'
                                            >
                                                <em class="fa fa-pencil-alt"></em>
                                            </button>
                                            <a href="https://webekart.wrteam.in/address/remove/1331" class="btn"> <em class="fas fa-times text-danger"></em></a>
                                        </span>
                                        <span class="form-group ml-2">
                                            <input type="radio" name="id" value="1331" />
                                            <label>
                                                <strong>fsdfsdfsd</strong><br />
                                                <label class="badge badge-primary">Home</label>
                                                5, Jubulee Circle<br />
                                                Bhuj - 56446<br />
                                                Mobile: 8254644644
                                            </label>
                                        </span>
                                    </div> -->

    </div> 

</div>

<!-- new end -->

</div>        





<div class="row">
<!-- first div -->
<div class="col-lg-12 col-md-12" id="address">
    <div class="table-responsive bg-white shadow rounded mt-4" >
        <table class="table mb-0 table-center">
            <thead class="bg-light">
                <tr>
                    <th scope="col" >Contact</th>
                     </tr>
            </thead>
            <tbody>
            
            <?php echo $myContacts?>
            @if($myContacts)
            @foreach($myContacts as $k=>$myContact)
                <tr>
                    <td>
                        <div class="media">
                            <div class="custom-control custom-radio custom-control-inline">
                                            <div class="form-group mb-0">
                                                <input type="radio" id="chaquepayment" name="customRadio" class="custom-control-input">
                                                <label class="custom-control-label" for="chaquepayment">Landrick</label>
                                            </div>
                                        </div>

                                <div class="content ml-3">
                                <a href="f" class="forum-title text-primary font-weight-bold">Introductions: Landrick</a>
                                <p class="text-muted small mb-0 mt-2">Start working with Landrick that can provide everything you need to generate awareness, drive traffic, connect.</p>
                            </div>

                        </div>
                    </td>
                </tr>
                @endforeach
                @endif

                
            </tbody>
        </table>

        <div class="d-flex align-items-center justify-content-between mt-4 col-lg-12">                                
         <a onclick="address()" href="javascript:void(0)" class="btn btn-success btn-lg btn-block">Add New Address</a>
         <!-- <a href="javascript:void(0)" class="btn btn-primary" id="edit">Confirm</a> -->
       </div>
       
    </div>

</div>
    <!-- second div -->
    <!-- new one starts2 -->
    <div class="row">
        <div class="col-lg-12 col-md-12" id="editAddress">
            <div class="rounded shadow-lg p-4">
                <h5 class="mb-0">Enter new Details :</h5>

                <form class="mt-4">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group position-relative">
                                <label>Your Name <span class="text-danger">*</span></label>
                                <input name="name" id="firstname" type="text" class="form-control" placeholder="First Name :">
                            </div>
                        </div><!--end col-->
                        <div class="col-6">
                            <div class="form-group position-relative">
                                <label>Last Name <span class="text-danger">*</span></label>
                                <input name="name" id="lastname" type="text" class="form-control" placeholder="Last Name :">
                            </div>
                        </div><!--end col-->
                        <div class="col-12">
                            <div class="form-group position-relative">
                                <label>Street address <span class="text-danger">*</span></label>
                                <input type="text" name="address1" id="address1" class="form-control" placeholder="House number and street name :">
                            </div>
                        </div><!--end col-->
                        <div class="col-12">
                            <div class="form-group position-relative">
                                <label>Phone Number <span class="text-danger">*</span></label>
                                <input type="text" name="address1" id="address1" class="form-control" placeholder="09094927392">
                            </div>
                        </div><!--end col-->

                        <div class="col-md-6">
                            <div class="form-group position-relative">
                                <label>State <span class="text-danger">*</span></label>
                                <select class="form-control custom-select">
                                    <option selected="">India</option>
                                    <option value="AF">Afghanistan</option>
                                </select>
                            </div>
                        </div><!--end col-->

                        <div class="col-md-6">
                            <div class="form-group position-relative">
                                <label>LGA <span class="text-danger">*</span></label>
                                <input type="text" name="state" id="state" class="form-control" placeholder="State Name :">
                            </div>
                        </div><!--end col-->

                        <div class="col-md-6">
                            <div class="form-group position-relative">
                                <label>Town/City <span class="text-danger">*</span></label>
                                <input type="text" name="state" id="state" class="form-control" placeholder="State Name :">
                            </div>
                        </div> <!--end col-->
                        
                    </div><!--end row-->
                    <div class="d-flex align-items-center justify-content-between mt-4 col-lg-12">                                
                        <!-- <a onclick="address()" href="javascript:void(0)" class="btn btn-primary">Add New Address</a> -->
                        <a href="javascript:void(0)" class="btn btn-success btn-lg btn-block" id="edit">Confirm</a>
                    </div>
                </form><!--end form-->
            </div>

        </div><!--end col-->


    </div>
    <!-- new one ends2 -->




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
                            <input type="radio" id="customRadio1" name="use_my_phone_number" value="yes" class="custom-control-input">
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
                            <input type="radio" id="customRadio3" name="use_my_address" class="custom-control-input" value="yes">
                            <label class="custom-control-label" for="customRadio3">Use my saved Address</label>
                        </div>
                    
                        <div class="custom-control custom-checkbox form-group position-relative">
                            <input type="radio" id="customRadio4" name="address" class="custom-control-input" value="no">
                            <label class="custom-control-label" for="customRadio4">No, I have another Address</label>
                        </div>

                        <div class="form-group position-relative d-none display-address">
                            <label>Address</label>
                            <i data-feather="map-pin" class="fea icon-sm icons"></i>
                            <textarea name="alternate_address" id="alternate_address" rows="4" class="form-control pl-5 user_address @error('alternate_address') is-invalid @enderror" placeholder="Address of where the service is required">{{ old('alternate_address') }}</textarea>
                            @error('alternate_address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div><!--end col--> 
                    
                    @if($discounts->count() > 0)
                    <div class="col-md-12 form-group">
                        <h5><span class="font-weight-bold">Available Discounts</span></h5>
                        <small class="text-danger">The selected discount will be applied on final invoice.</small>
                    </div>

                        @foreach($discounts as $discount)
                            <div class="col-md-4 form-group">
                                <div class="custom-control custom-radio form-group position-relative">
                                <input type="radio" id="discount-{{ $discount->id }}" name="client_discount_id" class="custom-control-input" value="{{ $discount->id }}" @if(empty($discount->discount->name)) disabled @endif>
                                <label class="custom-control-label" for="discount-{{ $discount->id }}">{{ $discount->discount->name ?? 'UNAVAILABLE' }}(<small class="text-danger">{{ $discount->discount->rate ?? '0.00' }}%</small>)</label>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    
                    <div class="col-md-12 form-group">
                        <h5><span class="font-weight-bold">Payment Options</span></h5>
                    </div>
                        
                    <div class="col-md-4 form-group">
                        <div class="custom-control custom-radio form-group position-relative">
                            <input type="radio" id="customRadio5" name="payment_method" class="custom-control-input" value="Wallet">
                            <label class="custom-control-label" for="customRadio5">E-Wallet</label>
                        </div>
                    </div>

                    <div class="col-md-4 form-group">
                        <div class="custom-control custom-radio form-group position-relative">
                            <input type="radio" id="payment_gateway_option" name="payment_method" class="custom-control-input" onclick="displayPaymentGateways()" value="Online">
                            <label class="custom-control-label" for="payment_gateway_option">Pay Online</label>
                        </div>
                    </div>
                    
                    <div class="col-md-4 form-group">
                        <div class="custom-control custom-radio form-group position-relative">
                            <input type="radio" id="pay_offline" name="payment_method" class="custom-control-input" data-toggle="modal" href="#payOffline" value="Offline">
                            <label class="custom-control-label" for="pay_offline">Pay Offline</label>
                        </div>
                    </div>
                    <input type="hidden" value="{{!empty($balance->closing_balance) ? $balance->closing_balance : '0'}}" name="balance">
                    <!-- <div class="row d-none payment-options">
                        <div class="col-md-6">
                            <div class="media key-feature align-items-center p-3 rounded shadow mt-4">
                                <a href="#" data-toggle="modal" data-target="#modal-form">
                                    <img src="{{ asset('assets/images/flutter.png')}}" class="avatar avatar-ex-smm" alt="">
                                </a>
                                <a href="javascript:void(0)" class="text-primary">
                                    <div class="media-body content ml-2">
                                        <a href="#" data-toggle="modal" data-target="#modal-form" >
                                            <h4 class="title mb-0">Flutter</h4>
                                        </a>
                                    </div>
                                </a>
                            </div>
                        </div>
                            <div class="col-md-6">
                                <div class="media key-feature align-items-center p-3 rounded shadow mt-4">
                                    <a href="#" data-toggle="modal" data-target="#modal-form">
                                        <img src="{{ asset('assets/images/paystack.png')}}" class="avatar avatar-ex-smm" alt="">
                                    </a>
                                    <a href="javascript:void(0)" class="text-primary">
                                        <div class="media-body content ml-2">
                                            <a href="#" data-toggle="modal" data-target="#modal-form" >
                                                <h4 class="title mb-0">Paystack</h4>
                                            </a>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div> -->


         @foreach($gateways as $val) 
            <div class="col-md-6 cc-selector d-none payment-options">
                      <!-- <input id="{{$val->name}}" type="radio" name="credit-card" value="{{$val->name}}" />
                      <label class="drinkcard-cc {{$val->name}}" for="{{$val->name}}"></label> -->
                <div class="media key-feature align-items-center p-3 rounded shadow mt-4">
                <a href="#" data-toggle="modal" data-target="#modal-form{{$val->id}}" >
                    <img src="{{ asset('assets/images') }}/{{$val->name}}.png" class="avatar avatar-ex-smm" alt="">
                </a>
                <a href="javascript:void(0)" class="text-primary">
                <div class="media-body content ml-3">
                <a href="#" data-toggle="modal" data-target="#modal-form{{$val->id}}" >
                    <h4 class="title mb-0">{{$val->name}}</h4>
                    </a>
                </div>
                </a>
                </div>
            </div>
        @endforeach


    <!-- <div class="col-md-6 cc-selector d-none payment-options">
        @foreach($gateways as $val) 
          <input id="{{$val->name}}" type="radio" name="credit-card" value="{{$val->name}}" />
          <label class="drinkcard-cc {{$val->name}}" for="{{$val->name}}"></label>
        @endforeach
    </div> -->


                    </div>
                        {{-- </div>
                    </div><!--end col--> --}}
                </div><!--end row-->

                

                <div class="row ml-4 mb-4">
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
                    Pay to into the account details below:<br> Account name: <strong>FCMB</strong><br> Account Number: <strong>1234567890</strong><br> <span class="text-danger">Note: </span> On the teller, please write as depositor's name and add your job reference at the end of the name. E.g.: <span class="text-muted">"{{ Auth::user()->account->first_name.' '.Auth::user()->account->last_name }} (REF-2E3487AAF23) payment."</span>
                </p>

                <h5 class="text-primary">Internet Banking</h5>
                <p>
                    Make an online transfer to the account details below:<br> Account name: <strong>FCMB</strong><br> Account Number: <strong>1234567890</strong><br> <span class="text-danger">Note: </span> Use the following as transfer note. E.g.: <span class="text-muted">"{{ Auth::user()->account->first_name.' '.Auth::user()->account->last_name }} (REF-2E3487AAF23) payment."</span>
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

@push('scripts')
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDeDLVAiaU13p2O0d3jfcPjscsbVsCQUzc&v=3.exp&libraries=places"></script>

    <script>
        $(document).ready(function (){
            let autocomplete;
            initialize();

            function initialize() {
                // Create the autocomplete object, restricting the search to geographical location types.
                autocomplete = new google.maps.places.Autocomplete((document.querySelector('.user_address')), {
                    types: ['geocode']
                });
               
                // Chain request to html element on the page
                google.maps.event.addDomListener(document.querySelector('.user_address'), 'focus');
            }

            $(document).on('click', '.nav-item', function(){
                $(this).find('.booking-fee').prop('checked', true);
            });

            $('#pay_offline').on('change', function (){  
                $('#pay_offline').attr('checked', 'checked');
                $('.payment-options').addClass('d-none');
            });

            $('.close').click(function (){
                $(".modal-backdrop").remove();
            });
            
        });

        function displayPaymentGateways(){
            $('.payment-options').removeClass('d-none');
        }

        $("#editAddress").addClass("address-hide"); 

        function address() {
            // if ($("#address").hasClass('address-show')) {
            //     $("#editAddress").removeClass("address-hide");
            //     $("#editAddress").addClass("address-show");
            //     $("#address").removeClass("address-show");
            //     $("#address").addClass("address-hide");
            // } else {
                $("#address").addClass("address-hide");
                $("#editAddress").removeClass("address-hide");
            }


    </script>
@endpush

@endsection