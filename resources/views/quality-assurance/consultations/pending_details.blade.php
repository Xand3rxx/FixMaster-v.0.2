@extends('layouts.dashboard')
@section('title', 'Quality Assurance Payments')
@include('layouts.partials._messages')
@section('content')

<div class="content-body">
  <div class="container pd-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
      <div>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-style1 mg-b-10">
          <li class="breadcrumb-item"><a href="{{ route('quality-assurance.index',app()->getLocale()) }}">Dashboard</a></li>
          <li class="breadcrumb-item" aria-current="page">Consultation</li>
            <li class="breadcrumb-item" aria-current="page">Pending</li>
            <li class="breadcrumb-item active" aria-current="page">details</li>
          </ol>

        </nav>
        <h4 class="mg-b-0 tx-spacing--1">Pending Consultation</h4>
      </div>
    </div>

    <div class="row row-xs">
      <div class="col-lg-12 col-xl-12 mg-t-10">

        <div class="row">
            <div class="col-md-9">

            </div>

            <div class="col-md-3">
              {{-- <div class="text-center">
                  <h5 class="p-earn">Earnings: N50,000,000</h5>
                  </div> --}}
        <button class="btn btn-sm" style="background-color: #E97D1F; color:#fff">Accept</button> <button class="btn btn-sm" style="background-color: #E97D1F; color:#fff;">Go Back</button>
            </div>
        </div>
        <div class="divider-text">Service Request Description</div>
<br>
        <table class="table mg-b-0">
            <tbody>
              <tr>
                <td class="">Job Reference</td>
                <td class="">REF-234234723</td>
              </tr>
              <tr>
                <td class="">Service Required</td>
                <td class="">Eletronics (Computer & Laptops)</td>
              </tr>
              <tr>
                <td class="">Service Description</td>
                <td class="">{{ Carbon\Carbon::parse('2020-12-28 16:58:54', 'UTC')->isoFormat('MMMM Do YYYY, h:mm:a') }}</td>
              </tr>
            </tbody>
          </table>

          <br>
          <div class="divider-text">Service Request Media Files</div>

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

