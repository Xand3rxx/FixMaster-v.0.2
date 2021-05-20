@extends('layouts.app')
@section('title', 'Join Us')
@section('contents')
@include('layouts.partials._messages')

<section class="section bg-light">
    <div class="container" style="margin-top: 3rem;">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="section-title text-center mb-4 pb-2">
                    <h4 class="title mb-4">We are Hiring!</h4>
                    <p class="text-muted para-desc mx-auto mb-0"> <span>FixMaster</span> is always looking for service professionals who are experts in their trade and provide great service to their customers ranging from Customer Service Executives(CSE's) to Technicians to Suppliers. The best home service professionals use <span>FixMaster</span> for the great pay and flexible scheduling.</p>
                </div>
            </div>
        </div>
        <div class="row float-center text-center justify-content-center align-items-center mt-100">
            <div class="col-md-3 col-12">
                <div class="features">
                    <div class="icons rounded h1 text-center text-primary px-3 position-relative d-inline-block">
                        <i class="uil uil-channel-add"></i>
                    </div>

                    <div class="content mt-4">
                        <h4 class="title-2">Customer Service Executive(CSE)</h4>
                        <p class="text-muted mb-0">Brief description here...</p>
                        <div class="mt-4">
                            <button type="button" class="btn btn-prim mt-2 mr-2 js-scroll-trigger register-cse">Apply</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->

            <div class="col-md-3 col-12 mt-5 mt-sm-0">
                <div class="features">
                    <div class="icons rounded h1 text-center text-primary px-3 position-relative d-inline-block">
                        <i class="uil uil-truck-loading"></i>
                    </div>

                    <div class="content mt-4">
                        <h4 class="title-2">Technicians & Artisans</h4>
                        <p class="text-muted mb-0">Brief description here...</p>
                        <div class="mt-4">
                            <button type="button" class="btn btn-prim mt-2 mr-2 js-scroll-trigger register-technician">Apply</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->

            <div class="col-md-3 col-12 mt-5 mt-sm-0">
                <div class="features">
                    <div class="icons rounded h1 text-center text-primary px-3 position-relative d-inline-block">
                        <i class="uil uil-shopping-cart"></i>
                    </div>

                    <div class="content mt-4">
                        <h4 class="title-2">Suppliers</h4>
                        <p class="text-muted mb-0">Brief job description here...</p>
                        <div class="mt-4">
                            <button type="button" class="btn btn-prim mt-2 mr-2 js-scroll-trigger register-supplier">Apply</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-12 mt-5 mt-sm-0">
                <div class="features">
                    <div class="icons rounded h1 text-center text-primary px-3 position-relative d-inline-block">
                        <i class="uil uil-shopping-cart"></i>
                    </div>

                    <div class="content mt-4">
                        <h4 class="title-2">Estate</h4>
                        <p class="text-muted mb-0">Estate description here...</p>
                        <div class="mt-4">
                            <button type="button" class="btn btn-prim mt-2 mr-2 js-scroll-trigger register-estate">Apply</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
        </div>
    </div>

    <div class="container mt-100 mt-60">
        {{-- CSE Registration Start --}}
        <div class="row justify-content-center cse-registration d-none down">
            <div class="col-lg-10 col-md-12">
                <div class="card custom-form border-0">
                    <div class="card-body">
                        <h4 class="title mb-4"> {{__('CSE Application Form')}} </h4>

                        <form id="cse_applicant_form" class="rounded shadow p-4" method="POST" action="{{route('frontend.customer-service-executive.store', app()->getLocale())}}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group position-relative">
                                        <label> {{__('First Name')}} <span class="text-danger">*</span></label>
                                        <i data-feather="user" class="fea icon-sm icons"></i>
                                        <input name="first_name_cse" value="{{old('first_name_cse')}}" id="first_name_cse" type="text" class="form-control pl-5">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group position-relative">
                                        <label>Last Name <span class="text-danger">*</span></label>
                                        <i data-feather="user" class="fea icon-sm icons"></i>
                                        <input name="last_name_cse" id="last_name_cse" type="text" class="form-control pl-5">
                                    </div>
                                </div>
                            </div>
                            <!--end row-->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group position-relative">
                                        <label>Phone Number <span class="text-danger">*</span></label>
                                        <i data-feather="phone" class="fea icon-sm icons"></i>
                                        <input name="phone_cse" id="phone_cse" type="tel" class="form-control pl-5">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group position-relative">
                                        <label>Email <span class="text-danger">*</span></label>
                                        <i data-feather="mail" class="fea icon-sm icons"></i>
                                        <input type="email" name="email_cse" id="email_cse" class="form-control pl-5">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group position-relative">
                                        <label>Gender </label>
                                        <i data-feather="user" class="fea icon-sm icons"></i>
                                        <select required name="gender_cse" class="form-control custom-select pl-5" id="Sortbylist-Shop">
                                            <option selected disabled value="0">Select...</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="others">Others</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group position-relative">
                                        <label>Date of Birth <span class="text-danger">*</span></label>
                                        <i data-feather="calendar" class="fea icon-sm icons"></i>
                                        <input type="date" max="{{now()->subYears(18)->toDateString()}}" name="date_of_birth_cse" id="date_of_birth_cse" class="form-control pl-5">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group position-relative">
                                        <label>Residential Address <span class="text-danger">* <span style="font-size: 10px;">Use auto complete feature after typing to select your address</span></span></label>
                                        <i data-feather="map-pin" class="fea icon-sm icons"></i>
                                        <textarea required name="address_cse" id="user_address" rows="3" class="user_address form-control pl-5" placeholder="Your residential address :"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group position-relative">
                                        <label>Upload Your Cv(DOC, DOCX or PDF) : <span class="text-danger">* <span style="font-size: 10px;">Maximum size of 3mb</span></span> </label>
                                        <input name="cv_cse" type="file" accept="application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document" class="form-control-file" id="fileupload">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group position-relative">
                                        <label>Referral Code </label>
                                        <i data-feather="key" class="fea icon-sm icons"></i>
                                        <input type="text" class="form-control pl-5 " placeholder="Enter Referral Code" name="referral_code_cse" id="referral_code">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group position-relative">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="terms_cse" class="form-control custom-control-input" id="customCheck1">

                                            <label class="custom-control-label" for="customCheck1">I Accept <a data-toggle="modal" data-target="#terms" href="javascript:void(0)" class="texty">Terms And Condition</a></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <input type="submit" id="submit" name="send" class="submitBnt btn btn-primary" value="Apply Now">
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->

                        </form>
                        <!--end form-->
                    </div>
                </div>
            </div>
        </div>
        {{-- End of CSE Registration --}}

        {{-- Estate Adding --}}
        <div class="row justify-content-center estate-registration d-none down-3">
            <div class="col-lg-10 col-md-12">
                <div class="card custom-form border-0">
                    <div class="card-body">
                        <h4 class="title mb-4">Estate Registration Form</h4>
                        <form action="{{ route('frontend.store_estate', app()->getLocale()) }}" method="POST" class="rounded shadow p-4">
                            @csrf
                            <fieldset class="form-group border p-4">
                                <legend class="w-auto px-2">Personal Details</legend>
                                <div class="row row-xs">
                                    <div class="col-md-12">
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="first_name">First name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" placeholder="First name">
                                                @error('first_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="middle_name">Middle name</label>
                                                <input type="text" class="form-control @error('middle_name') is-invalid @enderror" id="middle_name" name="middle_name" placeholder="Middle name">
                                                @error('middle_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="last_name">Last name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" placeholder="Last name">
                                                @error('last_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="email">E-mail <span class="text-danger">*</span></label>
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="E-mail">
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="phone_number">Phone Number <span class="text-danger">*</span></label>
                                                <input type="tel" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" placeholder="Phone Number">
                                                @error('phone_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="date_of_birth">Date of Birth <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" id="date_of_birth" name="date_of_birth" placeholder="Date of Birth">
                                                @error('date_of_birth')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label>Identification <strong>(ID)</strong> Type <span class="text-danger">*</span></label>
                                                <select class="custom-select @error('identification_type') is-invalid @enderror" name="identification_type">
                                                    <option>Select...</option>
                                                    <option value="National ID">National ID</option>
                                                    <option value="International Passport">Internation Passport</option>
                                                    <option value="Voters Card">Voters Card</option>
                                                    <option value="Drivers License">Drivers License</option>
                                                </select>
                                                @error('identification_type')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>Identification <strong>(ID)</strong> Number <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('identification_number') is-invalid @enderror" id="identification_number" name="identification_number" placeholder="Identification Number">
                                                @error('identification_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="expiry_date">Expiry Date <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control @error('expiry_date') is-invalid @enderror" id="expiry_date" name="expiry_date" placeholder="Expiry Date">
                                                @error('expiry_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="full_address">Address <span class="text-danger">*</span></label>
                                                <textarea class="form-control @error('full_address') is-invalid @enderror" id="full_address" name="full_address" placeholder="Address"></textarea>
                                                @error('full_address')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="form-group border p-4">
                                <legend class="w-auto px-2">Estate Details</legend>
                                <div class="row row-xs">
                                    <div class="col-md-12">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="estate_name">Estate name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('estate_name') is-invalid @enderror" id="estate_name" name="estate_name" placeholder="Estate name">
                                                @error('estate_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="state_id">State <span class="text-danger">*</span></label>
                                                <select class="custom-select @error('state_id') is-invalid @enderror" id="state_id" name="state_id">
                                                    <option>Select...</option>
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
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="lga_id">L.G.A <span class="text-danger">*</span></label>
                                                <select class="custom-select @error('lga_id') is-invalid @enderror" id="lga_id" name="lga_id">
                                                    <option>Select...</option>
                                                    @error('lga_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="town">Town <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('town') is-invalid @enderror" id="town" name="town" placeholder="Town">
                                                @error('town')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="landmark">Nearest Landmark <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('landmark') is-invalid @enderror" id="landmark" name="landmark" placeholder="Nearest Landmark">
                                                @error('landmark')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <!--end row-->

                            <div class="row">
                                <div class="col-sm-12">
                                    <input type="submit" id="submit" name="send" class="submitBnt btn btn-primary" value="Register">
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->

                        </form>
                        <!--end form-->
                    </div>
                </div>
                <!--end custom-form-->
            </div>
        </div>
        {{-- End of Estate Adding --}}

    </div>
</section>

<!-- Modal Content Start -->
<div class="modal fade" id="terms" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content rounded shadow border-0">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Terms & Conditions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <h5>CSE Application Terms & Conditions</h5>
                <ul class="list-unstyled text-mute">
                    <li><i data-feather="arrow-right" class="fea icon-sm mr-2"></i>I certify that the information contained in this application is true and complete.</li>
                    <li><i data-feather="arrow-right" class="fea icon-sm mr-2"></i>I understand that false information may be grounds for not hiring me or for immediate termination of the contract, if selected.</li>
                    <li><i data-feather="arrow-right" class="fea icon-sm mr-2"></i>I understand that if I am invited for an interview, I will need to bring the printed application form, 2 passport photographs, a formal proof of my identity and proof of my address.</li>
                    <li><i data-feather="arrow-right" class="fea icon-sm mr-2"></i>I understand that I will need to provide at least 1 guarantor who must be between 30 - 70 years old and must be one of the following:</li>
                    <ul class="list-unstyled text-muted">
                        <li class="ml-4"><i data-feather="arrow-right" class="fea icon-sm"></i> Civil Servant e.g., Principals, Teachers, State/Local Government Staff, etc.</li>
                        <li class="ml-4"><i data-feather="arrow-right" class="fea icon-sm"></i> Banker.</li>
                        <li class="ml-4"><i data-feather="arrow-right" class="fea icon-sm"></i> A practising professional such as Lawyer, Doctor, Pilot, Chartered Accountant,
                            Registered Engineer, etc.</li>
                        <li class="ml-4"><i data-feather="arrow-right" class="fea icon-sm"></i> Lecturer II & above in a reputable Higher Institution.</li>
                        <li class="ml-4"><i data-feather="arrow-right" class="fea icon-sm"></i> An Entrepreneur with a registered business that has been operating for at least 5 years.</li>
                    </ul>

                    <li><i data-feather="arrow-right" class="fea icon-sm mr-2"></i>I authorise <span class="text-primary">FixMaster</span> to verify any or all of the information provided above, using all appropriate means.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Modal Content End -->

@push('scripts')
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDeDLVAiaU13p2O0d3jfcPjscsbVsCQUzc&v=3.exp&libraries=places"></script>
<script src="{{ asset('assets/js/geolocation.js') }}"></script>
<script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/js/applicants.js') }}"></script>
<script>
    $(document).ready(function() {
        //Get list of L.G.A's in a particular state.
        $('#state_id').on('change', function() {
            let stateId = $('#state_id').find('option:selected').val();
            $.ajax({
                url: "{{ route('lga_list', app()->getLocale()) }}"
                , method: "POST"
                , dataType: "JSON"
                , data: {
                    "_token": "{{ csrf_token() }}"
                    , "state_id": stateId
                }
                , success: function(data) {
                    if (data) {
                        $('#lga_id').html(data.lgaList);
                    } else {
                        let stateName = $('#state_id').find('option:selected').text();
                        displayMessage('Error occured while trying to get L.G.A`s in ' + stateName + ' state', 'error');
                    }
                }
            , })
        });
    });

</script>
@endpush
@push('css')
<style>
    .invalid-response {
        color: #e43f52;
    }

</style>
@endpush
@endsection
