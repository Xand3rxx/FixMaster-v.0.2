@extends('layouts.dashboard')
@section('title', 'Admin Dashboard')
@include('layouts.partials._messages')
@section('content')

<div class="content-body">
  <div class="container pd-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
      <div>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-style1 mg-b-10">
          <li class="breadcrumb-item active">Dashboard</li>
            {{-- <li class="breadcrumb-item active" aria-current="page">Website Analytics</li> --}}
          </ol>
        </nav>
        <h4 class="mg-b-0 tx-spacing--1">Welcome to Fix<span style="color: #E97D1F;">Master</span> Admin Dashboard</h4>
      </div>
    </div>

    <div class="row row-xs">
      <div class="col-lg-12 col-xl-12">
         <div class="col-md-6 col-xl-4 mg-t-10 order-md-1 order-xl-0">
        <div class="card ht-lg-100p">
          <div class="card-header d-flex align-items-center justify-content-between">
            <h6 class="mg-b-0">Highest Requests by L.G.A</h6>
            <div class="tx-13 d-flex align-items-center">
              {{-- <span class="mg-r-5">Country:</span> <a href="" class="d-flex align-items-center link-03 lh-0">USA <i class="icon ion-ios-arrow-down mg-l-5"></i></a> --}}
            </div>
          </div><!-- card-header -->
          <div class="card-body pd-0">

            <div class="table-responsive">
              <table class="table table-borderless table-dashboard table-dashboard-one">
                <thead>
                  <tr>
                    <th class="wd-40">L.G.A</th>
                    <th class="wd-25 text-right">Requests</th>
                    <th class="wd-35 text-right">Total</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="tx-medium">Alimosho</td>
                    <td class="text-right">73</td>
                    <td class="text-right">₦150,200.80</td>
                  </tr>
                  <tr>
                    <td class="tx-medium">Kosofe</td>
                    <td class="text-right">64</td>
                    <td class="text-right">₦138,910.20</td>
                  </tr>
                  <tr>
                    <td class="tx-medium">Ibeju-Lekki</td>
                    <td class="text-right">58</td>
                    <td class="text-right">₦132,050.00</td>
                  </tr>
                  <tr>
                    <td class="tx-medium">Mushin</td>
                    <td class="text-right">31</td>
                    <td class="text-right">₦127,762.10</td>
                  </tr>
                  <tr>
                    <td class="tx-medium">Ojo</td>
                    <td class="text-right">17</td>
                    <td class="text-right">₦117,087.50</td>
                  </tr>
                </tbody>
              </table>
            </div><!-- table-responsive -->
          </div><!-- card-body -->
        </div><!-- card -->
      </div>
      </div>
   </div><!-- container -->
</div>


@section('scripts')
 <script src="{{ asset('assets/dashboard/lib/jquery/jquery.min.js') }}"></script>
 <script src="{{ asset('assets/dashboard/assets/datatables/dataTables.min.js') }}"></script>
<script src="{{ asset('assets/dashboard/assets/datatables/dataTables.bootstrap.min.js') }}"></script>
 <script>
      $(document).ready(function () {

        // Basic DataTable
        $('#basicExample, #demoRequests #paymentExample').DataTable({
          'iDisplayLength': 10,
          language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
              }
        });
    });
@endsection

@endsection
