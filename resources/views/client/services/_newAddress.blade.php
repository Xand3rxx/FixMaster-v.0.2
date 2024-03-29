<div class="modal fade" id="add_data_Modal" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content rounded shadow border-0">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Add New Contact</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">   
            <span id="form_result"></span>
                    <form method="post" id="insert_form">  
                    <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group position-relative">
                                            <label>First Name <span class="text-danger">*</span></label>
                                            <input id="first-name" type="text" class="form-control" placeholder="First Name :" autocomplete="off" />
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-md-4">
                                        <div class="form-group position-relative">
                                            <label>Last Name <span class="text-danger">*</span></label>
                                            <input id="last-name" type="text" class="form-control" placeholder="Last Name :" autocomplete="off" />
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group position-relative">
                                            <label>Contact Phone Number <span class="text-danger">*</span></label>
                                            <input type="tel" maxlength="11" id="phone_number" class="form-control phone" placeholder="Phone Number :" autocomplete="off" />
                                        </div>
                                    </div>
                                    <!--end col-->

                                    <div class="col-md-4">
                                        <div class="form-group position-relative">
                                            <label>State <span class="text-danger">*</span></label>
                                            <select class="form-control pl-5 @error('state_id') is-invalid @enderror" id="state_id">
                                                <option selected value="">Select...</option>
                                                @foreach($states as $state)
                                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('state_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!--end col-->

                                    <div class="col-md-4">
                                        <div class="form-group position-relative">
                                            <label>LGA <span class="text-danger">*</span></label>
                                            <select class="form-control pl-5 @error('lga_id') is-invalid @enderror" id="lga_id">
                                                <option selected value="">Select...</option>
                                            </select>
                                            @error('lga_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!--end col-->

                                    <div class="col-md-4">
                                        <div class="form-group position-relative">
                                            <label>Town/City <span class="text-danger">*</span></label>

                                            <select class="form-control pl-5 @error('town_id') is-invalid @enderror" id="town_id">
                                                <option selected value="">Select...</option>
                                            </select>
                                            @error('town_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror

                                            <!-- <input type="text" name="state" id="state" class="form-control" placeholder="State Name :"> -->
                                        </div>
                                    </div>

                                   
                                    
                                    <!--end col-->

                                    <div class="col-12">
                                        <div class="form-group position-relative">
                                            <label>Full Address <span class="text-danger">*</span></label>
                                            <input type="text" id="street-address" class="form-control user_address" placeholder="Full address of contact :" autocomplete="off" >
                                        </div>
                                    </div>
                                    <!--end col-->

                                    <!-- hidden fields -->
                                    <input type="hidden" value="" id="user_latitude" />
                                    <input type="hidden" value="" id="user_longitude" />
                                    <!--end col-->
                                </div>
                        <br />   
                        <input type="submit" name="insert" id="insert" value="Create" class="btn btn-primary" />  
                    </form>  
            </div>  
            {{-- <div class="modal-footer">  
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
            </div>   --}}
        </div>  
    </div> 
</div> 