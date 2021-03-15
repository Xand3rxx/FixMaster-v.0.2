@extends('layouts.dashboard')
@section('title', 'Category Rating')
@include('layouts.partials._messages')
@section('content')
<div class="content-body">
    <div class="container pd-x-0">
      <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item"><a href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Category Rating</li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1">Category Rating</h4>
        </div>
      </div>

      <div class="row row-xs">

        <div class="col-lg-12 col-xl-12 mg-t-10">
            <div class="card mg-b-10">
              <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                <div>
                  <h6 class="mg-b-5">Service Category Ratings as of {{ date('M, d Y') }}</h6>
                  <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all FixMaster total Service Category Ratings made by Clients.</p>
                </div>

              </div><!-- card-header -->

              <div class="table-responsive">

                <table class="table table-hover mg-b-0" id="basicExample">
                  <thead class="thead-primary">
                    <tr>
                      <th class="text-center">#</th>
                      <th>Service</th>
                      <th>Category Name</th>
                      <th class="text-center">Total Votes</th>
                      <th class="text-center">Rating(5)</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="tx-color-03 tx-center">1</td>
                      <td class="tx-medium">Communication</td>
                      <td class="tx-medium">Mobile Phone</td>
                      <td class="tx-medium text-center">205</td>
                      <td class="text-medium text-center">3.8</td>
                    </tr>
                    <tr>
                        <td class="tx-color-03 tx-center">2</td>
                        <td class="tx-medium">Mechanical</td>
                        <td class="tx-medium">Pump</td>
                        <td class="tx-medium text-center">459</td>
                        <td class="text-medium text-center">4.0</td>
                    </tr>
                    <tr>
                        <td class="tx-color-03 tx-center">3</td>
                        <td class="tx-medium">Mechanical</td>
                        <td class="tx-medium">Generator</td>
                        <td class="tx-medium text-center">876</td>
                        <td class="text-medium text-center">4.4</td>
                    </tr>
                  </tbody>
                </table>
              </div><!-- table-responsive -->
            </div><!-- card -->

          </div><!-- col -->

      </div>

    </div>
</div>
@endsection
