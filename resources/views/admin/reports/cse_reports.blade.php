@extends('layouts.dashboard')
@section('title', 'Customer Service Executive List')
@include('layouts.partials._messages')

@section('content')

<div class="content-body">
    <div class="container pd-x-0">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page">Reports</li>
                        <li class="breadcrumb-item active" aria-current="page">Customer Service Executive</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Customer Service Executive Reports</h4>
            </div>
        </div>

        <div class="contact-content-header mt-4">
            <nav class="nav">
              <a href="#job_assigned" class="nav-link active" data-toggle="tab">Job Assigned</a>
              <a href="#amount_earned" class="nav-link" data-toggle="tab"><span>Amount Earned</a>
              <a href="#cse_list" class="nav-link" data-toggle="tab"><span>List of CSE's</a>
              <a href="#rating_history" class="nav-link" data-toggle="tab"><span>CSE Rating History</a>
              <a href="#statement_balance" class="nav-link" data-toggle="tab"><span>Statement Balance</a> 
              <a href="#prospect_conversion_list" class="nav-link" data-toggle="tab"><span>Prospect Conversion List</a>
              <a href="#customer_complaints" class="nav-link" data-toggle="tab"><span>List of Customer Complaints</a>
              <a href="#job_warranty_logs" class="nav-link" data-toggle="tab"><span>Job Warranty Log</a>
            </nav>
        </div><!-- contact-content-header -->

        <div class="contact-content-body">
          <div class="tab-content">
            <div id="job_assigned" class="tab-pane show active pd-20 pd-xl-25">
              <div class="row row-xs">
                <div class="col-lg-12 col-xl-12 mg-t-10">
                  <div class="card mg-b-10">
                    <div class="d-sm-flex mg-t-10""></div>

                    <div class="table-responsive">
                      <div class="row mt-1 mb-1 ml-1 mr-1 ">
                        <div class="col-md-4">
                          <div class="form-group">
                              <label>Sorting Parameters</label>
                              <select class="custom-select" id="sorting-type">
                                  <option value="None">Select...</option>
                                  <option value="SortType1">CSE List</option>
                                  <option value="SortType2">Date</option>
                                  <option value="SortType3">Job Acceptance Date</option>
                                  <option value="SortType4">Job Status</option>
                              </select>
                          </div>
                        </div><!--end col-->
                        {{-- <div class="d-non date-section"> --}}
                          <div class="col-md-4">
                              <div class="form-group">
                                  <label>Sort by Date</label>
                                  <select class="custom-select" id="request-sorting">
                                      <option value="None">Select...</option>
                                      <option value="Date Range">Date Range</option>
                                      <option value="Month">Month</option>
                                      <option value="Date">Specific Date</option>
                                  </select>
                              </div>
                          </div><!--end col-->
              
                          <div class="col-md-4 specific-date d-none">
                              <div class="form-group position-relative">
                                  <label>Specify Date <span class="text-danger">*</span></label>
                                  <input name="name" id="name" type="date" class="form-control pl-5">
                              </div>
                          </div>
              
                          <div class="col-md-4 sort-by-year d-none">
                              <div class="form-group position-relative">
                                  <label>Specify Year <span class="text-danger">*</span></label>
                                  <select class="form-control custom-select" id="Sortbylist-Shop">
                                      <option>Select...</option>
                                      <option>2018</option>
                                      <option>2019</option>
                                      <option>2020</option>
                                  </select>
                              </div>
                          </div>
              
                          <div class="col-md-4 sort-by-year d-none">
                              <div class="form-group position-relative">
                                  <label>Specify Month <span class="text-danger">*</span></label>
                                  <select class="form-control custom-select" id="Sortbylist-Shop">
                                      <option>Select...</option>
                                      <option>January</option>
                                      <option>February</option>
                                      <option>March</option>
                                      <option>April</option>
                                      <option>May</option>
                                      <option>June</option>
                                      <option>July</option>
                                      <option>August</option>
                                      <option>September</option>
                                      <option>October</option>
                                      <option>November</option>
                                      <option>December</option>
                                  </select>
                              </div>
                          </div>
              
                          <div class="col-md-4 date-range d-none">
                              <div class="form-group position-relative">
                                  <label>From <span class="text-danger">*</span></label>
                                  <input name="name" id="name" type="date" class="form-control pl-5">
                              </div>
                          </div>
              
                          <div class="col-md-4 date-range d-none">
                              <div class="form-group position-relative">
                                  <label>To <span class="text-danger">*</span></label>
                                  <input name="name" id="name" type="date" class="form-control pl-5">
                              </div>
                          </div>
                        {{-- </div> --}}
                      </div>

                      <table class="table table-hover mg-b-0" id="basicExample">
                        <thead class="thead-primary">
                          <tr>
                            <th class="text-center">#</th>
                            <th>Name</th>
                            <th>Job Ref.</th>
                            <th>Job Location</th>
                            <th>Booking Date</th>
                            <th>Acceptance Date</th>
                            <th>Diagnostic Date</th>
                            <th>Completion Date</th>
                            <th>Status</th>
                            <th>Days Btw. Booking & Acceptance</th>
                            <th>Days Btw. Acceptance & Completion</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td class="tx-color-03 tx-center">1</td>
                            <td class="tx-medium">Benedict Olaoye </td>
                            <td class="tx-medium">REF-39432798</td>
                            <td class="tx-medium">Victoria Island</td>
                            {{-- <td class="text-medium text-center">₦{{number_format(7000) }}</td> --}}
                            <td class="text-medium">{{ Carbon\Carbon::parse('2021-02-14 13:39:55', 'UTC')->isoFormat('MMMM Do YYYY hh:mm:ssa') }}</td>
                            <td class="text-medium">{{ Carbon\Carbon::parse('2021-02-15 08:12:39', 'UTC')->isoFormat('MMMM Do YYYY hh:mm:ssa') }}</td>
                            <td class="text-medium">{{ Carbon\Carbon::parse('2021-02-15 10:47:32', 'UTC')->isoFormat('MMMM Do YYYY hh:mm:ssa') }}</td>
                            <td class="text-medium">UNAVAILABLE</td>
                            <td class="text-medium text-info">Ongoing</td>
                            <td class="text-medium text-center">0days</td>
                            <td class="text-medium text-center">UNAVAILABLE</td>
                          </tr>

                          <tr>
                            <td class="tx-color-03 tx-center">2</td>
                            <td class="tx-medium">Susan Ngozi </td>
                            <td class="tx-medium">REF-66EB5A26</td>
                            <td class="tx-medium">Ogba</td>
                            <td class="text-medium">{{ Carbon\Carbon::parse('2021-01-23 17:09:23', 'UTC')->isoFormat('MMMM Do YYYY hh:mm:ssa') }}</td>
                            <td class="text-medium">{{ Carbon\Carbon::parse('2021-01-24 06:54:11', 'UTC')->isoFormat('MMMM Do YYYY hh:mm:ssa') }}</td>
                            <td class="text-medium">{{ Carbon\Carbon::parse('2021-01-15 09:12:06', 'UTC')->isoFormat('MMMM Do YYYY hh:mm:ssa') }}</td>
                            <td class="text-medium">{{ Carbon\Carbon::parse('2021-01-15 14:39:43', 'UTC')->isoFormat('MMMM Do YYYY hh:mm:ssa') }}</td>
                            <td class="text-medium text-success">Completed</td>
                            <td class="text-medium text-center">{{ Carbon\Carbon::parse('2021-01-23 17:09:23', 'UTC')->diffInDays(Carbon\Carbon::parse('2021-01-24 06:54:11', 'UTC')) }}days</td>
                            <td class="text-medium text-center">{{ Carbon\Carbon::parse('2021-01-24 06:54:11', 'UTC')->diffInDays(Carbon\Carbon::parse('2021-01-15 14:39:43', 'UTC')) }}days</td>
                          </tr>
          
                        </tbody>
                      </table>
                    </div><!-- table-responsive -->
                  </div><!-- card -->
          
                </div><!-- col -->
              </div><!-- row -->
          </div>  
          </div>  
        </div>  
  </div>  
</div>  
        
               


@section('scripts')
<script>
    $(document).ready(function() {

        $('#request-sorting').on('change', function() {
            let option = $("#request-sorting").find("option:selected").val();
            switch (option) {
                case 'Date':
                    $('.specific-date').removeClass('d-none');
                    $('.sort-by-year, .date-range').addClass('d-none');
                    break;

                case 'Month':
                    $('.sort-by-year').removeClass('d-none');
                    $('.specific-date, .date-range').addClass('d-none');
                    break;

                case 'Date Range':
                    $('.date-range').removeClass('d-none');
                    $('.specific-date, .sort-by-year').addClass('d-none');
                    break;

                default:
                    $('.specific-date, .sort-by-year, .date-range').addClass('d-none');
                    break;
            }

        });
    });
</script>
@endsection

@endsection