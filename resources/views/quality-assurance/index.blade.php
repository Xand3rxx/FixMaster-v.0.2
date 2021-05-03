@extends('layouts.dashboard')
@section('title', Auth::user()->type->role->name.' Dashboard' ?? 'Technicians & Artisans Dashboard')
@include('layouts.partials._messages')
@section('content')

<div class="content-body">
  <div class="container pd-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
      <div>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-style1 mg-b-10">
          <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </nav>
        <h4 class="mg-b-0 tx-spacing--1">Welcome to Fix<span style="color: #E97D1F;">Master</span> {{ Auth::user()->type->role->name ?? 'Quality Assurance' }} Dashboard</h4>
      </div>
    </div>

    <div class="row row-xs">
      <div class="col-lg-12 col-xl-12">
        <div class="card">
          <div class="card-body pd-lg-25">
                 <div class="row">

                  <div class="col-md-4 mt-4">
                    <div class="shadow mt-4 qa-style">
                        <div class="media-body content ml-3 text-center">
                            <h5 class="title mb-0 qa">Completed Jobs</h5>
                            <h2 class="qa">10</h2>
                        </div>
                    </div>

                </div>

                <div class="col-md-4 mt-4">
                    <div class="shadow mt-4 qa-style">
                        <div class="media-body content ml-3 text-center">
                            <h5 class="title mb-0 qa">Ongoing Jobs</h5>
                        <h2 class="qa">7</h2>

                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-4">
                    <div class="qa-style shadow mt-4">
                        <div class="media-body content ml-3 text-center">
                            <h5 class="title mb-0 qa">Pending Consultations</h4>
                        <h2 class="qa">20</h2>

                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-4">
                    <div class="qa-style shadow mt-4">
                        <div class="media-body content ml-3 text-center">
                            <h5 class="title mb-0 qa">Completed Consultations</h4>
                        <h2 class="qa">20</h2>

                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-4">
                    <div class="qa-style shadow mt-4">
                        <div class="media-body content ml-3 text-center">
                            <h5 class="title mb-0 qa">Ongoing Consultations</h4>
                        <h2 class="qa">20</h2>

                        </div>
                    </div>
                </div>
                 </div>
          </div>
        </div><!-- card -->
      </div><br><br>

      {{-- <div class="qa-style"  style="margin-left: 860px;">
        <p>Earnings: N500</p>
    </div> --}}

      <div class="col-md-12 col-xl-12 mg-t-10">

        <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
            <div>
                <h6 class="mg-b-5">Pending Consultations</h6>
                <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all <strong>Jobs
                    </strong> assigned to you by FixMaster Administrator or Customer Service
                    Executive for consultation.</p>
            </div>

        </div><!-- card-header -->

        <div class="table-responsive">
            <table class="table table-hover mg-b-0" id="basicExample">
                <thead class="thead-primary">
                    <tr>
                        <th class="text-center">#</th>
                        <th>Job ID</th>
                        <th>Service Category</th>
                        <th class="text-center">Date</th>
                        <th class=" text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                        <tr>
                            <td class="tx-color-03 tx-center">1</td>
                            <td class="tx-medium">REF-79A722D6</td>
                            <td class="tx-medium">Unavailable</td>
                            <td class="tx-medium">2021-04-26</td>
                            <td class="tx-medium"><button class="btn" style="background-color: #E97D1F; color:#fff">Details</button></td>
                        </tr>

                        <tr>
                            <td class="tx-color-03 tx-center">2</td>
                            <td class="tx-medium">REF-79A722S5</td>
                            <td class="tx-medium">Unavailable</td>
                            <td class="tx-medium">2021-04-26</td>
                            <td class="tx-medium"><button class="btn" style="background-color: #E97D1F; color:#fff">Details</button></td>
                        </tr>
                </tbody>
            </table>
        </div><!-- table-responsive -->

      </div>


    </div><!-- row -->
  </div><!-- container -->
</div>


@section('scripts')
<script>
    $(document).ready(function() {

        $('#request-sorting').on('change', function (){
                let option = $("#request-sorting").find("option:selected").val();

                if(option === 'None'){
                    $('.specific-date, .sort-by-year, .date-range').addClass('d-none');
                }

                if(option === 'Date'){
                    $('.specific-date').removeClass('d-none');
                    $('.sort-by-year, .date-range').addClass('d-none');
                }

                if(option === 'Month'){
                    $('.sort-by-year').removeClass('d-none');
                    $('.specific-date, .date-range').addClass('d-none');
                }

                if(option === 'Date Range'){
                    $('.date-range').removeClass('d-none');
                    $('.specific-date, .sort-by-year').addClass('d-none');
                }
        });
    });

</script>
@endsection

@endsection
