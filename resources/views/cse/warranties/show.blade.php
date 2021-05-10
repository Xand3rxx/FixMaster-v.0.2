@extends('layouts.dashboard')
@section('title', 'Warranty Claim Details')
@include('layouts.partials._messages')
@section('content')
<link rel="stylesheet" href="{{ asset('assets/dashboard/assets/css/dashforge.filemgr.css') }}">

<div class="content-body">
    <div class="container pd-x-0">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item"><a href="{{ route('cse.index', app()->getLocale()) }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('cse.requests.index', app()->getLocale()) }}">Requests</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Request Details</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Job: REF-234234723</h4>
                <hr>
                <div class="media align-items-center">
                    <span class="tx-color-03 d-none d-sm-block">
                        {{-- <i data-feather="credit-card" class="wd-60 ht-60"></i> --}}
                        <img src="{{ asset('assets/images/default-male-avatar.png') }}" class="avatar rounded-circle" alt="Male Avatar">
                    </span>
                    <div class="media-body mg-sm-l-20">
                        <h4 class="tx-18 tx-sm-20 mg-b-2">Kelvin Adesanya</h4>
                                        
                        <p class="tx-13 tx-color-03 mg-b-0">08173682832 
                            <a href="tel:08173682832" class="btn btn-primary btn-icon"><i class="fas fa-phone"></i> Call Client</a>
                        </p>
                    </div>
                </div><!-- media -->
            </div>
        </div>

        <div class="row row-xs">
            <div class="col-lg-12 col-xl-12">

                <div class="contact-content-header mt-4">
                    <nav class="nav">
                        <a href="#serviceRequestActions" class="nav-link active" data-toggle="tab">Actions</a>
                        <a href="#description" class="nav-link" data-toggle="tab"><span> Description</a>
                        <a href="#serviceRequestSummary" class="nav-link" data-toggle="tab"><span>Summary</a>
                    </nav>
                    {{-- <a href="" id="contactOptions" class="text-secondary mg-l-auto d-xl-none"><i data-feather="more-horizontal"></i></a> --}}
                </div><!-- contact-content-header -->

                <div class="contact-content-body">
                    <div class="tab-content">
                        <div id="serviceRequestActions" class="tab-pane show active pd-20 pd-xl-25">
                            <small class="text-danger">This tab is only visible once if a Warranty claim has not been marked as resolved or is still ongoing.</small>
                           {{-- {{  dd($technicians) }} --}}
        <form class="form-data" method="POST" action="{{route('cse.assign.technician', [app()->getLocale()])}}">
            @csrf
            <div class="mt-4">
                <div class="tx-13 mg-b-25">
                    <div id="wizard3">

                        <h3>Contact Collaborators</h3>
                        <section>
                            <div class="form-row mt-4">
                                <div class="form-group col-md-12">
                                    This show's a list of all FixMaster Collaborators that worked on the clients service request initially.
                                    <div class="divider-text">Technicians </div>

                                    <ul class="list-group wd-md-100p">
                                        <li class="list-group-item d-flex align-items-center">
                                            
                                            <div class="form-row">
                                            <img src="{{ asset('assets/images/default-male-avatar.png') }}" class="wd-30 rounded-circle mg-r-15" alt="Technician Avatar">
                                            
                                            <div class="col-md-6 col-sm-6">
                                            <h6 class="tx-13 tx-inverse tx-semibold mg-b-0">Jamal Diwa</h6>
                                            
                                            <span class="d-block tx-11 text-muted">
                                                    <i class="icon ion-md-star lh-0 tx-orange"></i>
                                                    <i class="icon ion-md-star lh-0 tx-orange"></i>
                                                    <i class="icon ion-md-star lh-0 tx-orange"></i>
                                                <span class="font-weight-bold ml-2">0.6km</span>
                                            </span>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                            <div class="form-row">
                                                <div class="form-group col-1 col-md-1 col-sm-1" style="margin-left: 3rem !important;">
                                                    <a href="tel:08124483438" class="btn btn-primary btn-icon"><i class="fas fa-phone"></i></a>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        </li>
                                    </ul>

                                    <div class="divider-text">Quality Assurance Managers </div>

                                    <ul class="list-group wd-md-100p">
                                        <li class="list-group-item d-flex align-items-center">
                                            
                                            <div class="form-row">
                                            <img src="{{ asset('assets/images/default-male-avatar.png') }}" class="wd-30 rounded-circle mg-r-15" alt="Technician Avatar">
                                            
                                            <div class="col-md-6 col-sm-6">
                                            <h6 class="tx-13 tx-inverse tx-semibold mg-b-0">Desmond John</h6>
                                            
                                            <span class="d-block tx-11 text-muted">
                                                    <i class="icon ion-md-star lh-0 tx-orange"></i>
                                                    <i class="icon ion-md-star lh-0 tx-orange"></i>
                                                    <i class="icon ion-md-star lh-0 tx-orange"></i>
                                                <span class="font-weight-bold ml-2">0.6km</span>
                                            </span>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                            <div class="form-row">
                                                <div class="form-group col-1 col-md-1 col-sm-1" style="margin-left: 3rem !important;">
                                                    <a href="tel:08124483438" class="btn btn-primary btn-icon"><i class="fas fa-phone"></i></a>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        </li>
                                    </ul>

                                    <div class="divider-text">Suppliers </div>
                                    <ul class="list-group wd-md-100p">
                                        <li class="list-group-item d-flex align-items-center">
                                            
                                            <div class="form-row">
                                            <img src="{{ asset('assets/images/default-male-avatar.png') }}" class="wd-30 rounded-circle mg-r-15" alt="Technician Avatar">
                                            
                                            <div class="col-md-6 col-sm-6">
                                            <h6 class="tx-13 tx-inverse tx-semibold mg-b-0">Henry Efe</h6>
                                            
                                            <span class="d-block tx-11 text-muted">
                                                    <i class="icon ion-md-star lh-0 tx-orange"></i>
                                                    <i class="icon ion-md-star lh-0 tx-orange"></i>
                                                    <i class="icon ion-md-star lh-0 tx-orange"></i>
                                                <span class="font-weight-bold ml-2">0.6km</span>
                                            </span>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                            <div class="form-row">
                                                <div class="form-group col-1 col-md-1 col-sm-1" style="margin-left: 3rem !important;">
                                                    <a href="tel:08124483438" class="btn btn-primary btn-icon"><i class="fas fa-phone"></i></a>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </section>

                        <h3>Report</h3>
                        <section>
                            <div class="mt-4 form-row">
                                <div class="form-group col-md-12">
                                    <label for="cse_comment">Diagnostic Report</label>
                                    <textarea rows="3" class="form-control @error('cse_comment ') is-invalid @enderror" id="cse_comment " name="cse_comment"></textarea>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-11">
                                    <label>Faulty Image</label>
                                    <div class="custom-file">
                                        <input type="file" accept="image/*" class="custom-file-input @error('image[0]') is-invalid @enderror" name="image[]" id="image">
                                        <label class="custom-file-label" for="image">Upload faulty parts image</label>
                                        @error('image[0]')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group col-md-1 mt-1">
                                    <button class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5 mt-4 add-image" type="button"><i class="fas fa-plus" class="wd-10 mg-r-5"></i></button>
                                </div>
                            </div>

                            <span class="add-image-row"></span>

                        </section>
                        {{-- @if(is_null($service_request['preferred_time'])) --}}
                        <h3>Scheduled Fix Date</h3>
                        <section>
                        
                            <div class="mt-4 form-row">
                                <div class="form-group col-md-12">
                                    <label for="preferred_time">Scheduled Fix Date & Time</label>
                                    <input id="service-date-time" type="text" readonly min="{{ \Carbon\Carbon::now()->isoFormat('2021-04-13 00:00:00') }}" class="form-control @error('preferred_time') is-invalid @enderror" name="preferred_time" placeholder="Click to Enter Scheduled Date & Time" value="{{ old('preferred_time') }}">
                                    
                                    @error('preferred_time')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </section>
                        {{-- @endif --}}

                        <h3>New RFQ</h3>
                    <section>
                        <p class="mg-b-0">A request for quotation is a business process in which a company or public entity requests a quote from a supplier for the purchase of specific products or services.</p>
                        <h4 id="section1" class="mt-4 mb-2">Initiate RFQ?</h4>

                        <div class="form-row mt-4">
                            <div class="form-group col-md-4">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="rfqYes" name="intiate_rfq" value="yes">
                                    <label class="custom-control-label" for="rfqYes">Yes</label><br>
                                </div>
                            </div>
                            <div class="form-group col-md-4 d-flex align-items-end">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="rfqNo" name="intiate_rfq" value="no">
                                    <label class="custom-control-label" for="rfqNo">No</label><br>
                                </div>
                            </div>
                        </div>

                        <div class="d-none d-rfq">
                            <h4 id="section1" class="mt-4 mb-2">Make Request</h4>
                            <div class="form-row">

                                <div class="form-group col-md-4">
                                    <label for="manufacturer_name">Manufacturer Name</label>
                                    <input type="text" class="form-control @error('manufacturer_name') is-invalid @enderror" id="manufacturer_name" name="manufacturer_name[]" value="{{ old('manufacturer_name[0]') }}">
                                    @error('manufacturer_name[0]')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="model_number">Model Number</label>
                                    <input type="text" class="form-control @error('model_number') is-invalid @enderror" id="model_number" name="model_number[]" placeholder="" value="{{ old('model_number[0]') }}">
                                    @error('model_number[0]')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="component_name">Component Name</label>
                                    <input type="text" class="form-control @error('component_name') is-invalid @enderror" id="component_name" name="component_name[]" value="{{ old('component_name[0]') }}">
                                    @error('component_name[0]')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="quantity">Quantity</label>
                                    <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity[]" min="1" pattern="\d*" maxlength="2" value="{{ old('quantity[0]') }}">
                                    @error('quantity[0]')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="size">Size</label>
                                    <input type="number" class="form-control @error('size') is-invalid @enderror" id="size" name="size[]" min="1" pattern="\d*" maxlength="2" value="{{ old('size[0]') }}">
                                    @error('size[0]')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="unit_of_measurement">Unit of Measurement</label>
                                    <input type="text" class="form-control @error('unit_of_measurement') is-invalid @enderror" id="unit_of_measurement" name="unit_of_measurement[]" value="{{ old('unit_of_measurement[0]') }}">
                                    @error('unit_of_measurement[0]')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Image</label>
                                    <div class="custom-file">
                                        <input type="file" accept="image/*" class="custom-file-input @error('image') is-invalid @enderror" name="image" id="image">
                                        <label class="custom-file-label" for="image">Component Image</label>
                                        @error('image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group col-md-1 mt-1">
                                    <button class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5 mt-4 add-rfq" type="button"><i class="fas fa-plus" class="wd-10 mg-r-5"></i></button>
                                </div>
                            </div>

                            <span class="add-rfq-row"></span>

                        </div>
                    </section>

                        <h3>Assign New Technician</h3>
                        <section>
                            <div class="form-row mt-4">
                                <div class="form-group col-md-12">
                                    <ul class="list-group wd-md-100p">
                                        @foreach ($technicians as $technician)
                                        <li class="list-group-item d-flex align-items-center">
                                            
                                            <div class="form-row">
                                            <img src="{{ asset('assets/images/default-male-avatar.png') }}" class="wd-30 rounded-circle mg-r-15" alt="Technician Avatar">
                                            
                                            <div class="col-md-6 col-sm-6">
                                            <h6 class="tx-13 tx-inverse tx-semibold mg-b-0">{{ !empty($technician['user']['account']['first_name']) ? $technician['user']['account']['first_name'] .' '. $technician['user']['account']['last_name'] : 'UNAVAILABLE'}}</h6>
                                            
                                            <span class="d-block tx-11 text-muted">
                                                @foreach ($technicians as $item)
                                                    <i class="icon ion-md-star lh-0 tx-orange"></i>
                                                @endforeach
                                                <span class="font-weight-bold ml-2">0.6km</span>
                                            </span>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                            <div class="form-row">
                                                <div class="form-group col-1 col-md-1 col-sm-1" style="margin-left: 3rem !important;">
                                                    <a href="tel:08124483438" class="btn btn-primary btn-icon"><i class="fas fa-phone"></i></a>
                                                </div>
                                                <div class="form-group col-1 col-md-1 col-sm-1">
                                                    <div class="custom-control custom-radio mt-2">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input" id="{{ $loop->iteration }}" name="technician_user_uuid" value="">
                                                            <label class="custom-control-label" for="{{ $loop->iteration }}"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </section>
        
        
                    </div>
                </div>
            </div><!-- df-example -->
        
            {{-- <input type="hidden" value="{{$service_request->uuid}}" name="service_request_uuid"> --}}
        
            <button type="submit" class="btn btn-primary d-none" id="update-progress">Update Progress</button>
        
        </form>

                            <small class="text-danger">This tab is only visible once a Warranty claim has been marked as resolved.</small>
                            <h4> This Warranty Claim has been resolved. </h4>
                        </div>

                        <div id="description" class="tab-pane pd-20 pd-xl-25">
                            <div class="divider-text">Warranty Claim  Description</div>

                            <h6>Warranty Claim Description</h6>
                            <div class="row row-xs mt-4">
                                <div class="col-lg-12 col-xl-12">
                                    <table class="table table-striped table-sm mg-b-0">
                                        <tbody>
                                            <tr>
                                                <td class="tx-medium">Job Reference</td>
                                                <td class="tx-color-03">REF-234234723</td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Service Required</td>
                                                <td class="tx-color-03">Eletronics (Computer & Laptops)</td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Warranty Scheduled Date & Timr</td>
                                                <td class="tx-color-03">To be updated by the CSE</td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Warranty Start Date</td>
                                                <td class="tx-color-03">{{ Carbon\Carbon::now('UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                                            </tr>

                                            <tr>
                                                <td class="tx-medium">Warranty End Date</td>
                                                <td class="tx-color-03">{{ Carbon\Carbon::now('UTC')->addDays(7)->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Warranty Issued Date</td>
                                                <td class="tx-color-03">{{ Carbon\Carbon::now('UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Amount</td>
                                                <td class="tx-color-03">₦{{ number_format(1000) }}</td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Status</td>
                                                <td class="text-success">Used</td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Security Code</td>
                                                <td class="tx-color-03">SEC-27AEC73E</td>
                                            </tr>
                                            
                                            <tr>
                                                <td class="tx-medium">Initial Technicians Assigned</td>
                                                <td class="tx-color-03">List all Technicians's assigned</td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Initial Quality Assurance Managers Assigned</td>
                                                <td class="tx-color-03">List all QA's assigned</td>
                                            </tr>
                                           
                                            <tr>
                                                <td class="tx-medium">Initial Request Address</td>
                                                <td class="tx-color-03">27B, Bourdillon Road off Falomo, Ikoyi-Lagos.</td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Request Description</td>
                                                <td class="tx-color-03">My pc no longer comes on even when plugged into a power source.</td>
                                            </tr>

                                        </tbody>
                                    </table>

                                    
                                </div><!-- df-example -->
                            </div>
                        </div>

                        <div id="serviceRequestSummary" class="tab-pane pd-20 pd-xl-25">
                            <div class="divider-text">Diagnostic Reports</div>
                            <div class="card-group">
                                <div class="card">
                                    <div class="card-body shadow-none bd-primary overflow-hidden">
                                        <div class="marker-primary marker-ribbon pos-absolute t-10 l-0">1</div>

                                        <p class="card-text">After discussion with Mr Kelvin Adesanya, tentatively I beleive his laptop has overheating issues. On-premise diagnosis has to be carried out.</p>
                                        <p class="card-text"><small class="text-muted">Date Created: {{ \Carbon\Carbon::now('UTC') }}</small></p>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body shadow-none bd-primary overflow-hidden">
                                        <div class="marker-primary marker-ribbon pos-absolute t-10 l-0">2</div>
                                        <p class="card-text">After discussion with Mr Kelvin Adesanya, tentatively I beleive his laptop has overheating issues. On-premise diagnosis has to be carried out.</p>
                                        <p class="card-text"><small class="text-muted">Date Created: {{ \Carbon\Carbon::now('UTC') }}</small></p>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body shadow-none bd-primary overflow-hidden">
                                        <div class="marker-primary marker-ribbon pos-absolute t-10 l-0">3</div>

                                        <p class="card-text">After discussion with Mr Kelvin Adesanya, tentatively I beleive his laptop has overheating issues. On-premise diagnosis has to be carried out.</p>
                                        <p class="card-text"><small class="text-muted">Date Created: {{ \Carbon\Carbon::now('UTC') }}</small></p>
                                    </div>
                                </div>
                            </div>

                            <div class="divider-text">Faulty Part Images</div>
                            <div class="row row-xs">
                                <div class="col-6 col-sm-4 col-md-3 col-xl">
                                    <div class="card card-file">
                                    <div class="dropdown-file">
                                        <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                        <a href="#" class="dropdown-item download"><i data-feather="download"></i>Download</a>
                                        </div>
                                    </div><!-- dropdown -->
                                    <div class="card-file-thumb tx-danger">
                                        <i class="far fa-file-pdf"></i>
                                    </div>
                                    <div class="card-body">
                                        <h6><a href="" class="link-02">{{ substr('54c2a6f3-8a9c-411a-bd68-96a3a37617b2', 0, 15) }}.pdf</a></h6>
                                    </div>
                                    <div class="card-footer"><span class="d-none d-sm-inline">Date Created: </span>{{ \Carbon\Carbon::now('UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</div>
                                    </div>
                                </div><!-- col -->
                            </div><!-- row -->

                            <div class="divider-text">RFQ's</div>
                            <h5 class="mt-4">Request For Quotation</h5>
                            <div class="table-responsive">

                                <table class="table table-hover mg-b-0 mt-4">
                                    <thead class="">
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Batch Number</th>
                                            <th>Client</th>
                                            <th>Issued By</th>
                                            <th>Status</th>
                                            <th class="text-center">Total Amount</th>
                                            <th>Date Created</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $y = 0; @endphp
                                        <tr>
                                            <td class="tx-color-03 tx-center">{{ ++$y }}</td>
                                            <td class="tx-medium">RFQ-C85BEA04 </td>
                                            <td class="tx-medium">Kelvin Adesanya</td>
                                            <td class="tx-medium">David Akinsola</td>
                                            <td class="text-medium text-success">Payment received</td>
                                            <td class="tx-medium text-center">₦{{ number_format(5000) ?? 'Null'}}</td>
                                            <td class="text-medium">{{ Carbon\Carbon::parse('2020-12-28 16:58:54', 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                                            <td class=" text-center">
                                                <a href="#rfqDetails" data-toggle="modal" class="btn btn-sm btn-primary" title="View RFQ-C85BEA04 details" data-batch-number="RFQ-C85BEA04" data-url="#" id="rfq-details"></i> Details</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div><!-- table-responsive -->

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


@push('scripts')

<script>
    $(function() {
        'use strict'
        $('#wizard3').steps({
            headerTag: 'h3'
            , bodyTag: 'section'
            , autoFocus: true
            , titleTemplate: '<span class="number">#index#</span> <span class="title">#title#</span>'
            , loadingTemplate: '<span class="spinner"></span> #text#'
            , labels: {
                // current: "current step:",
                // pagination: "Pagination",
                finish: "Update Job Progress",
                // next: "Next",
                // previous: "Previous",
                loading: "Loading ..."
            }
            , stepsOrientation: 1,
            // transitionEffect: "fade",
            // transitionEffectSpeed: 200,
            showFinishButtonAlways: false
            , onFinished: function(event, currentIndex) {
                $('#update-progress').trigger('click');
            }
        , });

        let count = 1;
        //Add and Remove Request for qoute form
        $(document).on('click', '.add-rfq', function() {
            count++;
            addRFQ(count);
        });
        $(document).on('click', '.remove-rfq', function() {
            count--;
            $(this).closest(".remove-rfq-row").remove();
            // $(this).closest('tr').remove();
        });

        //Add and Remove image row form
        $(document).on('click', '.add-image', function() {
            count++;
            newImageRow(count);
        });
        $(document).on('click', '.remove-image', function() {
            count--;
            $(this).closest(".remove-image-row").remove();
            // $(this).closest('tr').remove();
        });

        //Hide and Unhide RFQ
        $('#rfqYes').change(function() {
            if ($(this).prop('checked')) {
                $('.d-rfq').removeClass('d-none');
            }
        });
        $('#rfqNo').change(function() {
            if ($(this).prop('checked')) {
                $('.d-rfq').addClass('d-none');
            }
        });
        
    });

    function addRFQ(count){
        let html = '<div class="form-row remove-rfq-row"><div class="form-group col-md-4"> <label for="manufacturer_name">Manufacturer Name</label> <input type="text" class="form-control @error('manufacturer_name') is-invalid @enderror" id="manufacturer_name" name="manufacturer_name[]" value="{{ old('manufacturer_name[]') }}"> @error('manufacturer_name[]') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div><div class="form-group col-md-3"> <label for="model_number">Model Number</label> <input type="text" class="form-control @error('model_number') is-invalid @enderror" id="model_number" name="model_number[]" placeholder="" value="{{ old('model_number[]') }}"> @error('model_number[]') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div><div class="form-group col-md-4"> <label for="component_name">Component Name</label> <input type="text" class="form-control @error('component_name') is-invalid @enderror" id="component_name" name="component_name[]" value="{{ old('component_name[]') }}"> @error('component_name[]') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div><div class="form-group col-md-2"> <label for="quantity">Quantity</label> <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity[]" min="1" pattern="d*" maxlength="2" value="{{ old('quantity[]') }}"> @error('quantity[]') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div><div class="form-group col-md-2"> <label for="size">Size</label> <input type="number" class="form-control @error('size') is-invalid @enderror" id="size" name="size[]" min="1" pattern="d*" maxlength="2" value="{{ old('size[]') }}"> @error('size[]') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div><div class="form-group col-md-4"> <label for="unit_of_measurement">Unit of Measurement</label> <input type="text" class="form-control @error('unit_of_measurement') is-invalid @enderror" id="unit_of_measurement" name="unit_of_measurement[]" value="{{ old('unit_of_measurement[0]') }}"> @error('unit_of_measurement[]') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div><div class="form-group col-md-3"> <label>Image</label><div class="custom-file"> <input type="file" accept="image/*" class="custom-file-input @error('image') is-invalid @enderror" name="image[]" id="image"> <label class="custom-file-label" for="image">Component Image</label> @error('image[]') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div></div><div class="form-group col-md-1 mt-1"> <button class="btn btn-sm pd-x-15 btn-danger btn-uppercase mg-l-5 mt-4 remove-rfq" type="button"><i class="fas fa-times" class="wd-10 mg-r-5"></i></button></div></div>';

        $('.add-rfq-row').append(html);
    }

    function newImageRow(count){
        let html = '<div class="form-row remove-image-row"><div class="form-group col-md-11"> <label>Faulty Image</label><div class="custom-file"> <input type="file" accept="image/*" class="custom-file-input @error('image[]') is-invalid @enderror" name="image[]" id="image"> <label class="custom-file-label" for="image">Upload faulty parts image</label> @error('image[]') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div></div><div class="form-group col-md-1 mt-1"> <button class="btn btn-sm pd-x-15 btn-danger btn-uppercase mg-l-5 mt-4 remove-image" type="button"><i class="fas fa-times" class="wd-10 mg-r-5"></i></button></div></div>';

        $('.add-image-row').append(html);

    }
    
</script>

@endpush

@endsection