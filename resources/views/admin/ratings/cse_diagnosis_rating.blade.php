@extends('layouts.dashboard')
@section('title', 'CSE Diagnosis Rating')
@include('layouts.partials._messages')
@section('content')
<div class="content-body">
    <div class="container pd-x-0">
      <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item"><a href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
              <li class="breadcrumb-item" aria-current="page">Rating</li>
              <li class="breadcrumb-item active" aria-current="page">CSE Diagnosis Rating</li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1">CSE Diagnosis Rating</h4>
        </div>
      </div>

      <div class="row row-xs">

        <div class="col-lg-12 col-xl-12 mg-t-10">
            <div class="card mg-b-10">
              <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                <div>
                  <h6 class="mg-b-5">CSE Diagnosis Ratings as of {{ date('M, d Y') }}</h6>
                  <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all CSE Diagnosis Ratings authored by Clients.</p>
                </div>

              </div><!-- card-header -->

              <div class="table-responsive">

                <table class="table table-hover mg-b-0" id="basicExample">
                  <thead class="thead-primary">
                    <tr>
                      <th class="text-center">#</th>
                      <th>Client</th>
                      <th>CSE</th>
                      <th class="text-center">Job Reference</th>
                      <th class="text-center">Rating(5)</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="tx-color-03 tx-center">1</td>
                      <td class="tx-medium">Kelvin Adesanya</td>
                      <td class="tx-medium">Okoye Jackson</td>
                      <td class="tx-medium text-center">REF-79A722D6</td>
                      <td class="text-medium text-center">3.0</td>
                    </tr>
                    <tr>
                        <td class="tx-color-03 tx-center">2</td>
                        <td class="tx-medium">Wisdom Basil</td>
                        <td class="tx-medium">Olaoye Benedict</td>
                        <td class="tx-medium text-center">REF-27D2F0BE</td>
                        <td class="text-medium text-center">4.0</td>
                    </tr>
                    <tr>
                        <td class="tx-color-03 tx-center">3</td>
                        <td class="tx-medium">Adebola Julius</td>
                        <td class="tx-medium">Simpson Susan</td>
                        <td class="tx-medium text-center">REF-EEE7FD14</td>
                        <td class="text-medium text-center">4.0</td>
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
