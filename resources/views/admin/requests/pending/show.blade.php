@extends('layouts.dashboard')
@section('title', 'Pending Request Details')
@include('layouts.partials._messages')
@section('content')
<link rel="stylesheet" href="{{ asset('assets/dashboard/assets/css/dashforge.filemgr.css') }}">

<div class="content-body">
    <div class="container pd-x-0">
      <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item"><a href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.requests.index', app()->getLocale()) }}">Requests</a></li>
              <li class="breadcrumb-item active" aria-current="page">Pending Request Details</li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1">Job: REF-234234723</h4><hr>
          <div class="media align-items-center">
            <span class="tx-color-03 d-none d-sm-block">
              {{-- <i data-feather="credit-card" class="wd-60 ht-60"></i> --}}
              <img src="{{ asset('assets/images/default-male-avatar.png') }}" class="avatar rounded-circle" alt="Male Avatar">
            </span>
            <div class="media-body mg-sm-l-20">
              <h4 class="tx-18 tx-sm-20 mg-b-2">Kelvin Adesanya</h4>
              <p class="tx-13 tx-color-03 mg-b-0">08173682832</p>
            </div>
          </div><!-- media -->
        </div>
      </div>
     
      <div class="row row-xs">
        <div class="col-lg-12 col-xl-12">

            <div class="contact-content-header mt-4">
                <nav class="nav">
                    <a href="#description" class="nav-link active" data-toggle="tab"><span>Job Description</a>
                    <a href="#notifyCSE" class="nav-link" data-toggle="tab"><span>Assign CSE</a>
                </nav>
            </div><!-- contact-content-header -->

            <div class="contact-content-body">
                <div class="tab-content">

                    <div id="description" class="tab-pane show active pd-20 pd-xl-25">
                        <div class="divider-text">Service Request Description</div>

                        <h6>SERVICE REQUEST DESCRIPTION</h6>
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
                                    <td class="tx-medium">Scheduled Date & Time</td>
                                    <td class="tx-color-03">{{ Carbon\Carbon::parse('2020-12-28 16:58:54', 'UTC')->isoFormat('MMMM Do YYYY, h:mm:a') }}</td>
                                  </tr>
                                  <tr>
                                    <td class="tx-medium">Payment Status</td>
                                    <td class="tx-color-03"><span class="text-success">Success</span>(Paystack or Flutterwave or E-Wallet or Offline)</td>
                                  </tr>
                                  <tr>
                                    <td class="tx-medium">Initial Service Charge</td>
                                    <td class="tx-color-03">₦{{ number_format(10000) }} Standard Price</td>
                                  </tr>
                                  <tr>
                                    <td class="tx-medium">Total Service Charge</td>
                                    <td class="tx-color-03">₦{{ number_format(15000) }}</td>
                                  </tr>
                                  <tr>
                                    <td class="tx-medium">Security Code</td>
                                    <td class="tx-color-03">SEC-27AEC73E</td>
                                  </tr>
                                  <tr>
                                    <td class="tx-medium">Supervised By</td>
                                    <td class="tx-color-03">David Akinsola</td>
                                  </tr>
                                  <tr>
                                    <td class="tx-medium">CSE's Assigned</td>
                                    <td class="tx-color-03">
                                      (1) Benedict Mayowa<br>
                                      (2) Other CSE's Assigned
                                    </td>
                                  </tr>
                                  <tr>
                                    <td class="tx-medium">Technicians Assigned</td>
                                    <td class="tx-color-03">
                                      (1) Jamal Diwa<br>
                                      (2) Other technicians Assigned
                                    </td>
                                  </tr>
                                  <tr>
                                    <td class="tx-medium">Quality Assurance Managers Assigned</td>
                                    <td class="tx-color-03">
                                      (1) UNAVAILABLE<br>
                                      (2) Other QA's Assigned
                                    </td>
                                  </tr>
                                  <tr>
                                    <td class="tx-medium">State</td>
                                    <td class="tx-color-03">Lagos</td>
                                  </tr>
                                  <tr>
                                    <td class="tx-medium">L.G.A</td>
                                    <td class="tx-color-03">Eti-Osa</td>
                                  </tr>
                                  <tr>
                                    <td class="tx-medium">Town/City</td>
                                    <td class="tx-color-03">Ikoyi</td>
                                  </tr>
                                  <tr>
                                    <td class="tx-medium">Request Address</td>
                                    <td class="tx-color-03">27B, Bourdillon Road off Falomo, Ikoyi-Lagos.</td>
                                  </tr>
                                  <tr>
                                    <td class="tx-medium">Request Description</td>
                                    <td class="tx-color-03">My pc no longer comes on even when plugged into a power source.</td>
                                  </tr>
        
                                  {{-- If theres a cancellation, make this row visible --}}
                                  {{-- @if(!empty($requestDetail->serviceRequestCancellationReason->reason)) --}}
                                  <tr>
                                    <td class="tx-medium">Reason for Cancellation </td>
                                    <td class="tx-color-03">I'm no longer interested. <span class="text-danger">(Only visible if the request was cancelled)</span></td>
                                  </tr>
                                  {{-- @endif --}}
                                </tbody>
                              </table>
        
                              <div class="divider-text">Media Files</div>
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
                              <div class="col-6 col-sm-4 col-md-3 col-xl">
                                <div class="card card-file">
                                  <div class="dropdown-file">
                                    <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                      <a href="#" class="dropdown-item download"><i data-feather="download"></i>Download</a>
                                    </div>
                                  </div><!-- dropdown -->
                                  <div class="card-file-thumb tx-primary">
                                    <i class="far fa-file-word"></i>
                                  </div>
                                  <div class="card-body">
                                      <h6><a href="" class="link-02">{{ substr('1c160a9b-8f52-46f5-a687-1dd608da48b3', 0, 15) }}.docx</a></h6>
                                  </div>
                                  <div class="card-footer"><span class="d-none d-sm-inline">Date Created: </span>{{ \Carbon\Carbon::now('UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</div>
                                </div>
                              </div><!-- col -->
                              <div class="col-6 col-sm-4 col-md-3 col-xl mg-t-10 mg-sm-t-0">
                                <div class="card card-file">
                                  <div class="dropdown-file">
                                    <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                      <a href="#" class="dropdown-item download"><i data-feather="download"></i>Download</a>
                                    </div>
                                  </div><!-- dropdown -->
                                  <div class="card-file-thumb tx-indigo">
                                    <i class="far fa-file-image"></i>
                                  </div>
                                  <div class="card-body">
                                      <h6><a href="" class="link-02">{{ substr('ff9c0bfa-aeed-4724-a8e4-790cf04a9fdd', 0, 15) }}.jpg</a></h6>
                                  </div>
                                  <div class="card-footer"><span class="d-none d-sm-inline">Date Created: </span>{{ \Carbon\Carbon::now('UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</div>
                                </div>
                              </div><!-- col -->
                              <div class="col-6 col-sm-4 col-md-3 col-xl mg-t-10 mg-md-t-0">
                                <div class="card card-file">
                                  <div class="dropdown-file">
                                    <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                      <a href="#" class="dropdown-item download"><i data-feather="download"></i>Download</a>
                                    </div>
                                  </div><!-- dropdown -->
                                  <div class="card-file-thumb tx-info">
                                    <i class="far fa-file-video"></i>
                                  </div>
                                  <div class="card-body">
                                      <h6><a href="" class="link-02">{{ substr('d886204a-a376-4924-a83b-2d7a7f84df7d', 0, 15) }}.mp4</a></h6>
                                  </div>
                                  <div class="card-footer"><span class="d-none d-sm-inline">Date Created: </span>{{ \Carbon\Carbon::now('UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</div>
                                </div>
                              </div><!-- col -->
                            </div><!-- row -->
                            </div><!-- df-example -->
                          </div>
                    </div>

                    <div id="notifyCSE" class="tab-pane pd-20 pd-xl-25">
                        <div class="divider-text">Assign CSE</div>

                        <ul class="list-group wd-md-100p">
                            @foreach ($cses['users'] as $cse)
                            <li class="list-group-item d-flex align-items-center">
                                
                                <div class="form-row">
                                <img src="{{ asset('assets/images/default-male-avatar.png') }}" class="wd-30 rounded-circle mg-r-15" alt="Technician Avatar">
                                
                                <div class="col-md-6 col-sm-6">
                                <h6 class="tx-13 tx-inverse tx-semibold mg-b-0">{{ !empty($cse['account']['first_name']) ? $cse['account']['first_name'] .' '. $cse['account']['last_name'] : 'UNAVAILABLE'}}</h6>
                                
                                <span class="d-block tx-11 text-muted">
                                    @for ($i = 0; $i < round($cse['ratings']->avg('star')); $i++)
                                    <i class="icon ion-md-star lh-0 tx-orange"></i>
                                    @endfor
                                    @for ($x = 0; $x < (5 - round($cse['ratings']->avg('star'))); $x++)
                                        <i class="icon ion-md-star lh-0 tx-gray-300"></i>
                                    @endfor

                                    {{-- @foreach (round($cse['ratings']->avg('star')) as $item)
                                        <i class="icon ion-md-star lh-0 tx-orange"></i>
                                    @endforeach --}}
                                    <span class="font-weight-bold ml-2">0.6km</span>
                                </span>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                <div class="form-row">
                                    <div class="form-group col-1 col-md-1 col-sm-1" style="margin-left: 3rem !important;">
                                    <a href="tel:{{ $cse['contact']['phone_number'] }}" class="btn btn-primary btn-icon"><i class="fas fa-phone"></i></a>
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
            </div>

        </div>
        </div>
      
    </div>
</div>

@endsection