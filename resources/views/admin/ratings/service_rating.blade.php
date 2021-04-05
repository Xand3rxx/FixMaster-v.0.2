@extends('layouts.dashboard')
@section('title', 'Service Rating')
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
              <li class="breadcrumb-item active" aria-current="page">Service Rating</li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1">Service Rating</h4>
        </div>
      </div>

      <div class="row row-xs">

        <div class="col-lg-12 col-xl-12 mg-t-10">
            <div class="card mg-b-10">
              <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                <div>
                  <h6 class="mg-b-5">Service Category Ratings as of {{ date('M, d Y') }}</h6>
                  <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all FixMaster Service Ratings made by Clients.</p>
                </div>

              </div><!-- card-header -->

              <div class="table-responsive">

                <table class="table table-hover mg-b-0" id="basicExample">
                  <thead class="thead-primary">
                    <tr>
                      <th class="text-center">#</th>
                      <th>Service</th>
                      <th class="text-center">Total Rating</th>
                      <th class="text-center">Overall Rating(5)</th>
                      <th class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php $sn = 1; @endphp
                @foreach($resviceRatings as $rating)
                    <tr>
                      <td class="tx-color-03 tx-center">{{$sn++}}</td>
                      <td class="tx-medium">{{$rating->service_request->service->name}}</td>
                      <td class="tx-medium text-center">{{$rating->star}}</td>
                      <td class="text-medium text-center">5.0</td>
                      <td class=" text-center">
                        <div class="dropdown-file">
                            <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
                            <div class="dropdown-menu dropdown-menu-right">
                            <a href="#serviceDetails" data-toggle="modal" class="dropdown-item details text-primary" title="View Computer & Laptops ratings"><i class="far fa-star"></i> Ratings</a>
                            </div>
                        </div>
                      </td>
                    </tr>
 @endforeach


                  </tbody>
                </table>
              </div><!-- table-responsive -->
            </div><!-- card -->

          </div><!-- col -->

      </div>
    </div>
</div>

<div class="modal fade" id="serviceDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">Computer & Laptops Ratings</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pd-x-25 pd-sm-x-30 pd-t-40 pd-sm-t-20 pd-b-15 pd-sm-b-20">
        <table class="table table-hover mg-b-0" id="basicExample">
          <thead class="thead-primary">
            <tr>
              <th class="text-center">#</th>
              <th>Job Reference</th>
              <th>Client</th>
              <th class="text-center">Rating(5)</th>
              <th class="text-center">Date</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="tx-color-03 tx-center">1</td>
              <td class="tx-medium">REF-EEE7FD14</td>
              <td>Kelvin Adesanya</td>
              <td class="text-medium text-center">3.0</td>
              <td>March 19th 2021, 9:06:56pm</td>
            </tr>

            <tr>
              <td class="tx-color-03 tx-center">2</td>
              <td class="tx-medium">REF-27D2F0BE</td>
              <td>Haruna Ahmadu</td>
              <td class="text-medium text-center">4.0</td>
              <td>March 19th 2021, 9:06:56pm</td>
            </tr>

            <tr>
              <td class="tx-color-03 tx-center">3</td>
              <td class="tx-medium">REF-79A722D6</td>
              <td>Oluyemi Ayotunde</td>
              <td class="text-medium text-center">5.0</td>
              <td>March 19th 2021, 9:06:56pm</td>
            </tr>
          </tbody>
        </table>
        </div><!-- modal-body -->
      <div class="modal-footer"></div>
    </div>
  </div>
</div>

@endsection
