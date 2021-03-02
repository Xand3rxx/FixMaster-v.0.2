@extends('layouts.client')
@section('title', 'Custom Service Request')
@section('content')
<div class="col-lg-8 col-12">
    <div class="card custom-form border-0">
        <div class="card-body">
            <h5>Custom Service Request</h5>
            
            <form class="rounded shadow p-4">
                <small class="text-danger">Kindly state your request in a detailed mannaer and a CSE will be assigned to you in the shortest possible time.</small>

                <div class="row" id="pills-tab" role="tablist">
                    <ul class="nav nav-pills bg-white nav-justified flex-column mb-0" id="pills-tab" role="tablist">
                        <li class="nav-item bg-light rounded-md">
                            <a class="nav-link rounded-md" id="dashboard" data-toggle="pill" href="#dash-board" role="tab" aria-controls="dash-board" aria-selected="false">
                                <div class="p-3 text-left">
                                    <h5 class="title">Standard</h5>
                                    <p class="text-muted tab-para mb-0">Your job will be evaluated by a CSE and technician within a maximum period of 8 hours.</p>
                                </div>
                            </a><!--end nav link-->
                        </li><!--end nav item-->
                        
                        <li class="nav-item bg-light rounded-md mt-4">
                            <a class="nav-link rounded-md urgent" id="timeline" data-toggle="pill" href="#time-line" role="tab" aria-controls="time-line" aria-selected="false">
                                <div class="p-3 text-left">
                                    <h5 class="title">Urgent</h5>
                                    <p class="text-muted tab-para mb-0">Your job will be evaluated by a CSE and technician within a maximum period of 2 hours</p>
                                </div>
                            </a><!--end nav link-->
                        </li><!--end nav item-->
                        
                        <li class="nav-item bg-light rounded-md mt-4">
                            <a class="nav-link rounded-md" id="paymentmanagement" data-toggle="pill" href="#payment-management" role="tab" aria-controls="payment-management" aria-selected="false">
                                <div class="p-3 text-left">
                                    <h5 class="title">Out of Hours</h5>
                                    <p class="text-muted tab-para mb-0">Our normal working Hours is 7AM to 7PM. A CSE and technician will evaluate your job within a maximum period of 2 hours</p>
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
                            <textarea name="comments" id="comments" rows="4" class="form-control pl-5" placeholder="If there is an equipment involved, do tell us about the equipment e.g. the make, model, age of the equipment etc. "></textarea>
                        </div>
                    </div><!--end col--> 
                    <div class="col-md-6">
                        <div class="form-group position-relative">
                            <label>Date & Time :<span class="text-danger">*</span></label>
                            <i data-feather="calendar" class="fea icon-sm icons"></i>
                            <input name="name" type="text" class="form-control pl-5" placeholder="Click to select :"  id="service-date-time" readonly>
                        </div>
                    </div><!--end col-->
                    <div class="col-md-6">
                        <div class="form-group position-relative">
                            <label>Upload media for evaluation <span class="text-danger">(Optional)</span> :</label>
                            <input type="file" class="form-control-file btn btn-primary btn-sm" id="fileupload">
                        </div>                                                                               
                    </div><!--end col-->

                    <div class="col-md-6 form-group mt-2">
                        <label>Contact Number:<span class="text-danger">*</span></label>

                        <div class="custom-control custom-checkbox form-group position-relative">
                            <input type="radio" id="customRadio1" name="phone_number" class="custom-control-input">
                            <label class="custom-control-label" for="customRadio1">Use my saved Phone Number</label>
                        </div>
                    
                        <div class="custom-control custom-checkbox form-group position-relative">
                            <input type="radio" id="customRadio2" name="phone_number" class="custom-control-input">
                            <label class="custom-control-label" for="customRadio2">No, I have another contact number</label>
                        </div>
                        <div class="form-group position-relative d-none display-phone">
                            <label>Your Phone no. :<span class="text-danger">*</span></label>
                            <i data-feather="phone" class="fea icon-sm icons"></i>
                            <input name="number" id="number" type="tel" class="form-control pl-5" placeholder="Your phone no. :" maxlength="11">
                        </div> 
                    </div><!--end col-->
                        
                    <div class="col-md-6 form-group">
                        <label>Address:<span class="text-danger">*</span></label>

                        <div class="custom-control custom-checkbox form-group position-relative">
                            <input type="radio" id="customRadio3" name="address" class="custom-control-input">
                            <label class="custom-control-label" for="customRadio3">Use my saved Address</label>
                        </div>
                    
                        <div class="custom-control custom-checkbox form-group position-relative">
                            <input type="radio" id="customRadio4" name="address" class="custom-control-input">
                            <label class="custom-control-label" for="customRadio4">No, I have another Address</label>
                        </div>

                        <div class="form-group position-relative d-none display-address">
                            <label>Address</label>
                            <i data-feather="map-pin" class="fea icon-sm icons"></i>
                            <textarea name="comments" id="comments" rows="4" class="form-control pl-5" placeholder="Address of where the service is required :"></textarea>
                        </div>
                    </div><!--end col--> 
                                                       
                    
                        <div class="col-md-12 form-group">
                            <label>Payment Mode:<span class="text-danger">*</span></label>
                        </div>
                            
                        <div class="col-md-4 form-group">
                            <div class="custom-control custom-checkbox form-group position-relative">
                                <input type="radio" id="customRadio5" name="payment_method" class="custom-control-input" >
                                <label class="custom-control-label" for="customRadio5">E-Wallet</label>
                            </div>
                        </div>

                        <div class="col-md-4 form-group">
                            <div class="custom-control custom-checkbox form-group position-relative">
                                <input type="radio" id="customRadio6" name="payment_method" class="custom-control-input">
                                <label class="custom-control-label" for="customRadio6">Pay Online</label>
                            </div>
                        </div>
                        
                        <div class="col-md-4 form-group">
                            <div class="custom-control custom-checkbox form-group position-relative">
                                <input type="radio" id="customRadio7" name="payment_method" class="custom-control-input popup-modal" data-target="modal" href="#offline-payment-modal">
                                <label class="custom-control-label" for="customRadio7">Pay Offline</label>
                            </div>
                        </div>
                        {{-- </div>
                    </div><!--end col--> --}}
                </div><!--end row-->

                
                <div class="example gc3 mb-4">
                    <div class="html-code">
                
                      <div id="offline-payment-modal" class="mfp-hide white-popup-block">
                        <h3>How to make offline payment?</h3>
                        <p class="text-muted">You can make offline payment using the following options</p>
                        <h5 class="text-primary">Pay To The Bank</h5>
                        <p>
                            Pay to into the account details below:<br> Account name: <strong>FCMB</strong><br> Account Number: <strong>1234567890</strong><br> <span class="text-danger">Note: </span> On the teller, please write as depositor's name and add your job reference at the end of the name. E.g.: <span class="text-muted">"Femi Joseph (REF-2E3487AAF23) payment."</span>
                        </p>

                        <h5 class="text-primary">Internet Banking</h5>
                        <p>
                            Make an online transfer to the account details below:<br> Account name: <strong>FCMB</strong><br> Account Number: <strong>1234567890</strong><br> <span class="text-danger">Note: </span> Use the following as transfer note. E.g.: <span class="text-muted">"Femi Joseph (REF-2E3487AAF23) payment."</span>
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

                        <a class="btn btn-primary btn-sm popup-modal-dismiss" href="#">Close</a></p>
                      </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                    <a href="{{ route('client.requests') }}" id="submit" name="send" class="submitBnt btn btn-primary">Submit</a>
                    </div><!--end col-->
                </div><!--end row-->
            </form><!--end form-->
        </div> 
    </div><!--end custom-form-->
</div>
@endsection