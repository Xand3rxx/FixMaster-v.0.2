@extends('layouts.dashboard')
@section('title', 'Warranty List')
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
              <li class="breadcrumb-item active" aria-current="page">Warranty Transaction</li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1">Warranty Transaction</h4>
        </div>
      </div>

      
       
        <div class="col-lg-12 col-xl-12 mg-t-10">
            <div class="card mg-b-10">
              <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                <div>
                  <h6 class="mg-b-5">Warranty Transaction as of {{ date('M, d Y') }}</h6>
                  <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all FixMaster Warranty Transaction.</p>
                </div>
                
              </div><!-- card-header -->
             
              <table class="table table-hover mg-b-0" id="basicExample">
    <thead class="thead-primary">
      <tr>
        <th class="text-center">#</th>
        <th>Client Name</th>
        <th>Warranty Name</th>
        
        <th>Job Reference</th>  
        <th>Amount</th>  
        <th>Status</th>
        <th class="text-center">Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($warranties as $warranty)
        <tr>
          <td class="tx-color-03 tx-center">{{ $loop->iteration ?? ''}}</td>
          <td class="tx-medium">{{ $warranty->name->first_name. ' '.$warranty->name->last_name ?? '' }}</td>
          <td class="tx-medium">{{ $warranty->warranty_name->name ?? ''}}</td>
          <td class="tx-medium">{{ $warranty->payment->unique_id ?? ''}}</td>
         
          @if($warranty->amount == null )
                  
          <td>Not Avalaible</td>
          
          @else
            
            
            <td>{{ $warranty->amount}}</td>
          
        @endif
          <td>{{ $warranty->status ?? '' }}</td>
          <td class=" text-center">
            <div class="dropdown-file">
              <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
              <div class="dropdown-menu dropdown-menu-right">
              <a href="{{-- route('admin.warranty_summary', ['details'=>$warranty->uuid, 'locale'=>app()->getLocale()]) --}}" class="dropdown-item details text-primary"><i class="far fa-clipboard"></i> Details</a>
             
  


                
              </div>
            </div>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>






@push('scripts')
  <script src="{{ asset('assets/dashboard/assets/js/4823bfe5-4a86-49ee-8905-bb9a0d89e2e0.js') }}"></script>
@endpush

@endsection