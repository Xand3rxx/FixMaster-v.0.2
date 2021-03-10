@extends('layouts.dashboard')
@section('title', 'Profile')
@include('layouts.partials._messages')
@section('content')

<div class="content-body pd-0">
    <div class="contact-wrapper contact-wrapper-two">
      <div class="contact-content">
        <div class="contact-content-header">
          <nav class="nav">
            {{-- <h4><a href="#contactInformation" class="nav-link active" data-toggle="tab">Contact Info<span>rmation</span></a></h4> --}}
            {{-- <a href="#contactLogs" class="nav-link" data-toggle="tab"><span>Call &amp; Message </span>Logs</a> --}}
          </nav>
          {{-- <a href="" id="contactOptions" class="text-secondary mg-l-auto d-xl-none"><i data-feather="more-horizontal"></i></a> --}}
        </div><!-- contact-content-header -->

        <div class="contact-content-body">
          <div class="tab-content">

            <div id="contactInformation" class="tab-pane show active pd-20 pd-xl-25">
              <div class="d-flex align-items-center justify-content-between mg-b-25">
                <h5 class="mg-b-0">Personal Details</h5>
                <div class="d-flex">
                  <a href="{{ route('technician.edit_profile') }}" class="btn btn-sm btn-white d-flex align-items-center mg-r-5"><i data-feather="edit-2"></i><span class="d-none d-sm-inline mg-l-5"> Edit</span></a>
                 
                </div>
              </div>

              <div class="row">
                <div class="col-6 col-sm">
                  <label class="tx-10 tx-medium tx-spacing-1 tx-color-03 tx-uppercase tx-sans mg-b-10">Firstname</label>
                  <p class="mg-b-0">{{ $firstName }}</p>
                </div><!-- col -->
                <div class="col-6 col-sm">
                  <label class="tx-10 tx-medium tx-spacing-1 tx-color-03 tx-uppercase tx-sans mg-b-10">Middlename</label>
                  <p class="mg-b-0">{{ $middleName }}</p>
                </div><!-- col -->
                <div class="col-sm mg-t-20 mg-sm-t-0">
                  <label class="tx-10 tx-medium tx-spacing-1 tx-color-03 tx-uppercase tx-sans mg-b-10">Lastname</label>
                  <p class="mg-b-0">{{ $lastName }}</p>
                </div><!-- col -->
              </div><!-- row -->

              <h5 class="mg-t-40 mg-b-20">Contact Details</h5>

              <div class="row row-sm">
                <div class="col-6 col-sm-4">
                  <label class="tx-10 tx-medium tx-spacing-1 tx-color-03 tx-uppercase tx-sans mg-b-10">Email Address</label>
                  <p class="tx-primary mg-b-0">{{$email}}</p>
                </div>
                <div class="col-6 col-sm-4">
                  <label class="tx-10 tx-medium tx-spacing-1 tx-color-03 tx-uppercase tx-sans mg-b-10">Mobile Phone</label>
                  <p class="tx-primary tx-rubik mg-b-0">{{$phoneNumber}}</p>
                </div>
                <div class="col-6 col-sm-4 mg-t-20 mg-sm-t-0">
                  <label class="tx-10 tx-medium tx-spacing-1 tx-color-03 tx-uppercase tx-sans mg-b-10">Work Phone</label>
                  <p class="tx-primary tx-rubik mg-b-0">{{$otherPhoneNumber}}</p>
                </div>
                <div class="col-sm-4 mg-t-20 mg-sm-t-30">
                  <label class="tx-10 tx-medium tx-spacing-1 tx-color-03 tx-uppercase tx-sans mg-b-10">Company</label>
                  <p class="mg-b-0">Ludwig Enterprise</p>
                </div>
                <div class="col-sm-4 mg-t-20 mg-sm-t-30">
                  <label class="tx-10 tx-medium tx-spacing-1 tx-color-03 tx-uppercase tx-sans mg-b-10">Job Position</label>
                  <p class="mg-b-0">Technician</p>
                </div>
                <div class="col-sm-6 mg-t-20 mg-sm-t-30">
                  <label class="tx-10 tx-medium tx-spacing-1 tx-color-03 tx-uppercase tx-sans mg-b-10">Home Address</label>
                  <p class="mg-b-0">{{$fullAddress}}</p>
                </div>
                <div class="col-sm-6 mg-t-20 mg-sm-t-30">
                  <label class="tx-10 tx-medium tx-spacing-1 tx-color-03 tx-uppercase tx-sans mg-b-10">Work Address</label>
                  <p class="mg-b-0">8284 Ajose Adeogun Street, Victoria Island, Lagos, Nigeria</p>
                </div>
                <div class="col-sm-6 mg-t-20 mg-sm-t-30">
                    <label class="tx-10 tx-medium tx-spacing-1 tx-color-03 tx-uppercase tx-sans mg-b-10">Rating</label>
                    <p class="mg-b-0">
                        <div class="pd-t-10 pd-b-15 d-flex align-items-baseline">
                            <h1 class="tx-normal tx-rubik mg-b-0 mg-r-5">4.2</h1>
                            <div class="tx-18">
                              <i class="icon ion-md-star lh-0 tx-orange"></i>
                              <i class="icon ion-md-star lh-0 tx-orange"></i>
                              <i class="icon ion-md-star lh-0 tx-orange"></i>
                              <i class="icon ion-md-star lh-0 tx-orange"></i>
                              <i class="icon ion-md-star lh-0 tx-gray-300"></i>
                            </div>
                      </div>
                    </p>
                </div>
                
              </div><!-- row -->
            </div>

            {{-- <div id="contactLogs" class="tab-pane pd-20 pd-xl-25">
            <div class="d-flex align-items-center justify-content-between mg-b-30">
                <h6 class="tx-15 mg-b-0">Call &amp; Message Logs</h6>
                <a href="#" class="btn btn-sm btn-white d-flex align-items-center"><i class="icon ion-md-time mg-r-5 tx-16 lh--9"></i> Clear History</a>
            </div>
            </div><!-- tab-pane --> --}}
          </div><!-- tab-content -->
        </div><!-- contact-content-body -->

      </div><!-- contact-content -->

    </div><!-- contact-wrapper -->
  </div>

@endsection