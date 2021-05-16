@extends('layouts.dashboard')
@section('title', 'Quality Assurance Payments')
@include('layouts.partials._messages')
@section('content')
<link rel="stylesheet" href="{{ asset('assets/dashboard/assets/css/dashforge.filemgr.css') }}">
<div class="content-body">
  <div class="container pd-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
      <div>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-style1 mg-b-10">
          <li class="breadcrumb-item"><a href="{{ route('quality-assurance.index',app()->getLocale()) }}">Dashboard</a></li>
          <li class="breadcrumb-item" aria-current="page">Request</li>
            <li class="breadcrumb-item" aria-current="page">Active</li>
            <li class="breadcrumb-item active" aria-current="page">details</li>
          </ol>

        </nav>
        <h4 class="mg-b-0 tx-spacing--1">Active Requests</h4>
      </div>
    </div>

    <div class="row row-xs">
      <div class="col-lg-12 col-xl-12 mg-t-10">

        <div class="row">
            <div class="col-md-9">

            </div>

            <div class="col-md-3">

                <a href="tel:08173682832" class="btn btn-primary btn-icon"><i class="fas fa-phone"></i> Call CSE</a> <button class="btn btn-sm" style="background-color: #E97D1F; color:#fff;">Go Back</button>
            </div>
        </div>
        <div class="divider-text">Service Request Description</div>
<br>
        <table class="table table-striped table-sm mg-b-0">
            <tbody>
              <tr>
                <td class="">Job Reference</td>
                <td class="">{{$activeDetails->service_request->unique_id}}</td>
              </tr>
              <tr>
                <td class="">Service Required</td>
                <td class="">{{$activeDetails->service_request->service->category->name}} ({{$activeDetails->service_request->service->name}})</td>
              </tr>
              <tr>
                <td class="tx-medium">Scheduled Date & Time</td>
                <td class="tx-color-03">{{ Carbon\Carbon::parse($activeDetails->service_request->preferred_time, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:a') }}</td>
            </tr>
            <tr>
                <td class="tx-medium">Request Address</td>
                <td class="tx-color-03">{{$activeDetails->service_request->address->address}}</td>
            </tr>
            <tr>
                <td class="tx-medium">Town/City</td>
                <td class="tx-color-03">{{$activeDetails->service_request->address->town->name}}</td>
            </tr>
            <tr>
                <td class="tx-medium">L.G.A</td>
                <td class="tx-color-03">{{$activeDetails->service_request->address->lga->name}}</td>
            </tr>
              <tr>
                <td class="">Service Description</td>
                <td class="">{{$activeDetails->service_request->service->description}}</td>
              </tr>
            </tbody>
          </table>

          <br>
          <div class="divider-text">Service Request Media Files</div>

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

      </div>
    </div>

  </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('assets/dashboard/assets/js/qa-payments-sortings.js') }}"></script>
 <script>
    $(document).ready(function() {


    });

</script>
@endsection

