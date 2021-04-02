@extends('layouts.dashboard')
@section('title', 'Warranty Details')
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
            <li class="breadcrumb-item"><a href="{{ route('admin.warranty_list', app()->getLocale()) }}">Warranty</a></li>
              <li class="breadcrumb-item active" aria-current="page">Warranty Details</li>
            </ol>
          </nav>
         
          <h4 class="mg-b-0 tx-spacing--1">Warranty ID: {{$warranty->unique_id ?? ''}}</h4><hr>
          
        </div>
      </div>
     
     

     
  
        <table class="table table-striped table-sm mg-b-0">
          <tbody>
            <tr>
              <td class="tx-medium">Warranty Name</td>
              <td class="tx-color-03">{{$warranty->name ?? ''}}</td>
            </tr>
            <tr>
              <td class="tx-medium">Warranty Type</td>
              <td class="tx-color-03">{{$warranty->warranty_type ?? ''}}</td>
            </tr>
            <tr>
              <td class="tx-medium">Warranty Percentage</td>
              <td class="tx-color-03">{{$warranty->amount ?? ''}}</td>
            </tr>
            <tr>
              <td class="tx-medium">User Count</td>
              <td class="tx-color-03">{{$warranty->amount ?? ''}}</td>
            </tr>
            <tr>
              <td class="tx-medium">Description</td>
              <td class="tx-color-03">{{$warranty->description ?? ''}}</td>
            </tr>
            <tr>
              <td class="tx-medium">Date Created</td>
              <td class="tx-color-03">{{ Carbon\Carbon::parse($warranty->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
            </tr>
            <tr>
              <td class="tx-medium">Date Updated</td>
              <td class="tx-color-03">{{ Carbon\Carbon::parse($warranty->updated_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
            </tr>
          
          

            
          </tbody>
        </table>
      </div>
    </div>
  </div>
      </div>
    </div>
</div>






@endsection