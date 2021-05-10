@extends('layouts.dashboard')
@section('title', 'CSE Warranty Claims')
@include('layouts.partials._messages')
@section('content')
<input class="d-none" id="locale" type="hidden" value="{{ app()->getLocale() }}">

<div class="content-body">
    <div class="container pd-x-0">
      <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                <li class="breadcrumb-item"><a href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('cse.requests.index', app()->getLocale()) }}">Requests</a></li>
                <li class="breadcrumb-item active" aria-current="page">Warranty Claims</li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1">Warranty Claims</h4>
        </div>
      </div>

      
       
        <div class="col-lg-12 col-xl-12 mg-t-10">
            <div class="card mg-b-10">
              <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                <div>
                  <h6 class="mg-b-5">Warranty Claims as of {{ date('M, d Y') }}</h6>
                  <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all FixMaster Warranties issued by clients on the job you supervised.</p>
                </div>
                
              </div><!-- card-header -->
             
              <table class="table table-hover mg-b-0" id="basicExample">
    <thead class="thead-primary">
      <tr>
        <th class="text-center">#</th>
        <th>Client Name</th>
        <th>Warranty</th>
        <th>Job Reference</th>  
        <th>Start Date</th>  
        <th>End Date</th>  
        <th>Status</th>
        <th class="text-center">Action</th>
      </tr>
    </thead>
    <tbody>
      {{-- @foreach ($issuedWarranties as $warranty)
        <tr>
          <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
          <td class="tx-medium">{{ $warranty['user']['account']['first_name'].' '.$warranty['user']['account']['last_name'] }}</td>
          <td class="tx-medium">{{ $warranty['warranty']['name'] }}</td>
          <td class="tx-medium">{{ $warranty['service_request']['unique_id'] }}</td>
          <td class="tx-medium">{{ Carbon\Carbon::parse($warranty->start_date ?? '2020-12-28 16:58:54', 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
          <td class="tx-medium">{{ Carbon\Carbon::parse($warranty->expiration_date ?? '2020-12-28 16:58:54', 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
          @if($warranty->status == 'used')
            <td class="text-success">Used</td>
          @else
            <td class="text-danger">Unused</td>
          @endif
          <td class=" text-center">
            <div class="dropdown-file">
              <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
              <div class="dropdown-menu dropdown-menu-right">
              <a href="{{ route('admin.issued_warranty_details', ['warranty'=>$warranty->uuid, 'locale'=>app()->getLocale()]) }}" class="dropdown-item details text-primary"><i class="far fa-clipboard"></i> Details</a>
              <a href="{{ route('admin.mark_warranty_resolved', ['warranty'=>$warranty->uuid, 'locale'=>app()->getLocale()]) }}" class="dropdown-item details text-success"><i class="fas fa-check"></i> Mark as Resolved</a>
              <a href="{{ route('admin.mark_warranty_resolved', ['warranty'=>$warranty->uuid, 'locale'=>app()->getLocale()]) }}" class="dropdown-item details text-info"><i class="fas fa-clipboard"></i> Resolved Details</a>
                
              </div>
            </div>
          </td>
        </tr>
      @endforeach --}}

        <tr>
            <td class="tx-color-03 tx-center">1</td>
            <td class="tx-medium">Kelvin Adesanya</td>
            <td class="tx-medium">Free Warranty</td>
            <td class="tx-medium">REF-234234723</td>
            <td class="tx-medium">{{ Carbon\Carbon::now('UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
            <td class="tx-medium">{{ Carbon\Carbon::now('UTC')->addDays(7)->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
            <td class="text-success">Used</td>
            <td class=" text-center">
              <div class="dropdown-file">
                <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="{{ route('cse.warranty_claim_details', app()->getLocale()) }}" class="dropdown-item details text-primary"><i class="far fa-clipboard"></i> Details</a>
                    <a href="#" class="dropdown-item details text-success"><i class="fas fa-check"></i> Mark as Resolved</a>
                    <a href="#" class="dropdown-item details text-info"><i class="fas fa-clipboard"></i> Resolved Details</a>
                  
                </div>
              </div>
            </td>
          </tr>
    </tbody>
  </table>


@endsection