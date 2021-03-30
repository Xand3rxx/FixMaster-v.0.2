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
                        <li class="breadcrumb-item active" aria-current="page">Customer Service Executive</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Customer Service Executive Job Assigned Report</h4>
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
      <a href="" id="contactOptions" class="text-secondary mg-l-auto d-xl-none"><i data-feather="more-horizontal"></i></a>
    </div><!-- contact-content-header -->
    <div class="contact-content-body">
      <div class="tab-content">
        <div id="job_assigned" class="tab-pane show active pd-20 pd-xl-25">

        <div class="row row-xs">
            <div class="col-lg-12 col-xl-12 mg-t-10">
                <div class="card mg-b-10">
                    <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                        <div>
                            <h6 class="mg-b-5">Customer Service Executive Job Assigned as of {{ date('M, d Y') }}</h6>
                            <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all FixMaster Customer Service Executive Job Assigned.</p>
                        </div>

                    </div><!-- card-header -->

            <div class="card-body pd-y-30">
            <div class="d-sm-flex">
              <div class="media">
                <div class="wd-40 wd-md-50 ht-40 ht-md-50 bg-teal tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-6">
                  <i data-feather="bar-chart-2"></i>
                </div>
                <div class="media-body">
                  <h6 class="tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold tx-nowrap mg-b-5 mg-md-b-8">Total CSE's</h6>
                <h4 class="tx-20 tx-sm-18 tx-md-20 tx-normal tx-rubik mg-b-0">{{count($serviceRequests)}}</h4>
                </div>
              </div>
              
            </div>
          </div><!-- card-body -->
         
          <div class="contact-content-body">
                        <div class="tab-content">
                          <table class="table table-hover mg-b-0" id="basicExample">
                            <thead class="thead-primary">
                                <tr>
                                  <th class="text-center">#</th>
                                  <th>CSE ID</th>
                                  <th>Job ID</th>
                                  <th>Full Name</th>
                                  <th>Job Location</th>
                                  <th>Job Booking Date</th>
                                  <th>Job Acceptance Date</th>
                                  <th>Job Completion Date</th>
                                  <th>Job Status</th>
                                  <th>Days Between Booking / Acceptance</th>
                                  <th>Days Between Booking / Acceptance</th>
                                                                  
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($serviceRequests as $serviceRequest)
                                <tr>
                                    <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
                                    <td class="tx-medium"> @foreach($serviceRequest->users as $data)
                  @foreach($data->roles as $res)
                  @if($res->url == "cse")
                     {{$data->cse->unique_id ?? ''}}
                  @endif
                  @endforeach
                  @endforeach</td>
                   
                  <td class="tx-medium">{{ $serviceRequest->unique_id ?? ''}}</td>
                                   
                 
                  <td class="tx-medium"> @foreach($serviceRequest->users as $data)
                  @foreach($data->roles as $res)
                  @if($res->url == "cse")
                     {{$data->account->first_name}} {{$data->account->last_name}}
                  @endif
                  @endforeach
                  @endforeach</td>
                  <td class="tx-color-03"> {{$serviceRequest->address->address}} </td>
                  <td class="text-medium">{{ Carbon\Carbon::parse($serviceRequest->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                  <td class="text-medium">{{ Carbon\Carbon::parse($serviceRequest->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                  <td class="text-medium">{{ Carbon\Carbon::parse($serviceRequest->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td> 
                  @if($serviceRequest->status_id == 1)
                    <td class="text-medium text-warning">Pending</td>
                  @elseif($serviceRequest->status_id == 2)
                  <td class="text-medium text-info">Ongoing</td>
                  @elseif($serviceRequest->status_id == 3)
                    <td class="text-medium text-danger">Cancelled</td>
                  @elseif($serviceRequest->status_id == 4)
                    <td class="text-medium text-success">Completed</td>
                  @else
                 <td class="text-medium text-warning">{{$serviceRequest->status}}</td>
                  @endif
                                    
                                
                  <td class="text-medium">{{ Carbon\Carbon::parse($serviceRequest->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                  <td class="text-medium">{{ Carbon\Carbon::parse($serviceRequest->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td> 
                  
                  </tr>
                  
                    @endforeach
                  </tbody>
                  </table>
                  </div><!-- table-responsive -->
                </div><!-- card -->
                </div>
                </div>
                </div>
                </div>
                <div class="tab-pane pd-20 pd-xl-25" id="amount_earned">
                            <div class="col-lg-12 col-xl-12">
                                <div class="card">
                                <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                                    <div>
                                        <h6 class="mg-b-5"> CSE Earning as of {{ date('M, d Y') }}</h6>
                                        <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all Fixmaster CSE Earning .</p>
                                    </div>

                                </div>
                                  <div class="table-responsive">

                                      <table class="table table-hover mg-b-0" id="basicExample">
                                          <thead class="thead-primary">
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>CSE ID</th>
                                                <th>Job ID</th>
                                                <th>Job Acceptance Date</th>
                                                <th>Diagnostic Date</th>
                                                <th>Day Betwn Accept & Diagnostic</th>
                                                <th>Job Completion Date</th>
                                                <th>Diagnostic Earning</th>
                                                <th>Completion Earning</th>
                                                <th>Total Earned</th>
                                                <th>Diagnostic Paid (Y/N)</th>
                                                <th>Completion Paid (Y/N)</th>
                                                <th>Total Paid</th>
                                                
                                            </tr>
                                          </thead>
                                          <tbody>
                                          @foreach($users as $cse)
                                            <tr>
                                              <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
                                              <td class="tx-medium"> {{ $cse['unique_id']}}</td>
                                              <td class="tx-medium"> {{ $cse['unique_id']}}</td>
                                              <td class="text-medium">{{ Carbon\Carbon::parse($serviceRequest->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                                              <td class="text-medium">{{ Carbon\Carbon::parse($serviceRequest->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                                              <td class="text-medium">{{ Carbon\Carbon::parse($serviceRequest->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                
                                              <td class="text-medium">{{ Carbon\Carbon::parse($serviceRequest->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                
                                              <td class="tx-medium">2000</td>
                                              <td class="tx-medium">3000</td>
                                              <td class="tx-medium">5000</td>
                                              <td class="tx-medium">Y</td>
                                              <td class="tx-medium">N</td>
                                              <td class="tx-medium">2000</td>
                                            </tr>
                                            @endforeach
                                          </tbody>
                                      </table>
                                  </div>
                              </div>

                          </div>
                          </div><!-- end amount earned -->
                
 <div class="tab-pane pd-20 pd-xl-25" id="cse_list">
                            <div class="col-lg-12 col-xl-12">
                                <div class="card">
                                <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                                    <div>
                                        <h6 class="mg-b-5"> CSE Earning as of {{ date('M, d Y') }}</h6>
                                        <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all Fixmaster CSE Earning .</p>
                                    </div>

                                </div>
                                  <div class="table-responsive">

                                      <table class="table table-hover mg-b-0" id="basicExample">
                                          <thead class="thead-primary">
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>CSE ID</th>
                                                <th>Territory</th>
                                                <th>Franchisee</th>
                                                <th>On Boarding Date</th>
                                                <th>CSE Status</th>
                                                <th>CSE Rating</th>
                                                <th>Job Completion Date</th>
                                                <th>Last Activity Date</th>
                                                <th>Number of Jobs In the Last X Month</th>
                                               
                                            </tr>
                                          </thead>
                                          <tbody>
                                          @foreach($users as $cse)
                                            <tr>
                                              <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
                                              <td class="tx-medium"> {{ $cse['unique_id']}}</td>
                                              <td class="tx-medium"> Lagos</td>
                            
                                              <td class="tx-medium">Service discount</td>
                                              <td class="text-medium">{{ Carbon\Carbon::parse($serviceRequest->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                
                                              <td class="tx-medium">Service discount</td>
                                              <td class="tx-medium">Service discount</td>
                                              <td class="text-medium">{{ Carbon\Carbon::parse($serviceRequest->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                
                                              <td class="text-medium">{{ Carbon\Carbon::parse($serviceRequest->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                
                                              <td class="tx-medium">6 Months</td>
                                             
                                            </tr>
                                            @endforeach
                                          </tbody>
                                      </table>
                                  </div>
                              </div>

                          </div>
                          </div><!-- end cse list -->


                          <div class="tab-pane pd-20 pd-xl-25" id="rating_history">
                            <div class="col-lg-12 col-xl-12">
                                <div class="card">
                                <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                                    <div>
                                        <h6 class="mg-b-5"> CSE Earning as of {{ date('M, d Y') }}</h6>
                                        <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all Fixmaster CSE Earning .</p>
                                    </div>

                                </div>
                                  <div class="table-responsive">

                                      <table class="table table-hover mg-b-0" id="basicExample">
                                          <thead class="thead-primary">
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>CSE ID</th>
                                                <th>Territory</th>
                                                <th>Current Rating</th>
                                                <th>Rating Last Month</th>
                                                <th>CSE Status</th>
                                                <th>CSE Rating</th>
                                                <th>Rating Last Quater</th>
                                                <th>Notable Feedback</th>
                                                <th>Job ID</th>
                                                <th>Job Rating</th>
                                               
                                            </tr>
                                          </thead>
                                          <tbody>
                                          @foreach($users as $cse)
                                            <tr>
                                              <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
                                              <td class="tx-medium"> {{ $cse['unique_id']}}</td>
                                              <td class="tx-medium"> Lagos</td>
                            
                                              <td class="tx-medium">Service discount</td>
                                              <td class="text-medium">{{ Carbon\Carbon::parse($serviceRequest->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                
                                              <td class="tx-medium">Service discount</td>
                                              <td class="tx-medium">Service discount</td>
                                              <td class="text-medium">{{ Carbon\Carbon::parse($serviceRequest->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                
                                              <td class="text-medium">{{ Carbon\Carbon::parse($serviceRequest->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                
                                              <td class="tx-medium">6 Months</td>
                                              <td class="tx-medium">6 Months</td>
                                            </tr>
                                            @endforeach
                                          </tbody>
                                      </table>
                                  </div>
                              </div>

                          </div>
                          </div><!-- end rating history -->


                          <div class="tab-pane pd-20 pd-xl-25" id="statement_balance">
                            <div class="col-lg-12 col-xl-12">
                                <div class="card">
                                <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                                    <div>
                                        <h6 class="mg-b-5"> CSE Earning as of {{ date('M, d Y') }}</h6>
                                        <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all Fixmaster CSE Earning .</p>
                                    </div>

                                </div>
                                  <div class="table-responsive">

                                      <table class="table table-hover mg-b-0" id="basicExample">
                                          <thead class="thead-primary">
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>Diagnostic Date</th>
                                                <th>Diagnostic Earning</th>
                                                <th>Diagnostic Paid (Y/N)</th>
                                                <th>Diagnostic Pay Date</th>
                                                <th>Completion Date</th>
                                                <th>Completion Earning</th>
                                                <th>Completion Paid (Y/N)</th>
                                                <th>Completion Pay Date</th>
                                                <th>Total Earned</th>
                                                <th>Total Paid</th>
                                               
                                            </tr>
                                          </thead>
                                          <tbody>
                                          @foreach($users as $cse)
                                            <tr>
                                              <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
                                              <td class="tx-medium"> {{ $cse['unique_id']}}</td>
                                              <td class="tx-medium"> Lagos</td>
                            
                                              <td class="tx-medium">Service discount</td>
                                              <td class="text-medium">{{ Carbon\Carbon::parse($serviceRequest->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                
                                              <td class="tx-medium">Service discount</td>
                                              <td class="tx-medium">Service discount</td>
                                              <td class="text-medium">{{ Carbon\Carbon::parse($serviceRequest->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                
                                              <td class="text-medium">{{ Carbon\Carbon::parse($serviceRequest->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                
                                              <td class="tx-medium">6 Months</td>
                                              <td class="tx-medium">6 Months</td>
                                            </tr>
                                            @endforeach
                                          </tbody>
                                      </table>
                                  </div>
                              </div>

                          </div>
                          </div><!-- end statement balance -->

                          <div class="tab-pane pd-20 pd-xl-25" id="prospect_conversion_list">
                            <div class="col-lg-12 col-xl-12">
                                <div class="card">
                                <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                                    <div>
                                        <h6 class="mg-b-5"> CSE Earning as of {{ date('M, d Y') }}</h6>
                                        <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all Fixmaster CSE Earning .</p>
                                    </div>

                                </div>
                                  <div class="table-responsive">

                                      <table class="table table-hover mg-b-0" id="basicExample">
                                          <thead class="thead-primary">
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>CSE ID</th>
                                                <th>CSE Unique Code</th>
                                                <th>Territory</th>
                                                <th>Franchisee</th>
                                                <th>Customer Code</th>
                                                <th>Reg. Date</th>
                                                <th>Customer Status</th>
                                                <th>Customer Rating</th>
                                                
                                               
                                            </tr>
                                          </thead>
                                          <tbody>
                                          @foreach($users as $cse)
                                            <tr>
                                              <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
                                              <td class="tx-medium"> {{ $cse['unique_id']}}</td>
                                              <td class="tx-medium"> Lagos</td>
                            
                                              <td class="tx-medium">Service discount</td>
                                              <td class="text-medium">{{ Carbon\Carbon::parse($serviceRequest->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                
                                              <td class="text-medium">{{ Carbon\Carbon::parse($serviceRequest->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                
                                              <td class="text-medium">{{ Carbon\Carbon::parse($serviceRequest->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                
                                              <td class="tx-medium">6 Months</td>
                                              <td class="tx-medium">6 Months</td>
                                            </tr>
                                            @endforeach
                                          </tbody>
                                      </table>
                                  </div>
                              </div>

                          </div>
                          </div><!-- end prospect conversion list -->

                          <div class="tab-pane pd-20 pd-xl-25" id="customer_complaints">
                            <div class="col-lg-12 col-xl-12">
                                <div class="card">
                                <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                                    <div>
                                        <h6 class="mg-b-5"> CSE Earning as of {{ date('M, d Y') }}</h6>
                                        <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all Fixmaster CSE Earning .</p>
                                    </div>

                                </div>
                                  <div class="table-responsive">

                                      <table class="table table-hover mg-b-0" id="basicExample">
                                          <thead class="thead-primary">
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>CSE ID</th>
                                                <th>Territory</th>
                                                <th>Job Category</th>
                                                <th>Job ID</th>
                                                <th>Job Type</th>
                                                <th>Job Status</th>
                                                <th>Job Rating</th>
                                                <th>Complaints</th>
                                                
                                               
                                            </tr>
                                          </thead>
                                          <tbody>
                                          @foreach($users as $cse)
                                            <tr>
                                              <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
                                              <td class="tx-medium"> {{ $cse['unique_id']}}</td>
                                              <td class="tx-medium"> Lagos</td>
                            
                                              <td class="tx-medium">Service discount</td>
                                              <td class="text-medium">{{ Carbon\Carbon::parse($serviceRequest->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                
                                              <td class="tx-medium">Repairs</td>
                                              <td class="tx-medium">Ongoing</td>
                                              <td class="text-medium">2</td>
                
                                              <td class="text-medium">Very terrible</td>
                
                                             
                                            </tr>
                                            @endforeach
                                          </tbody>
                                      </table>
                                  </div>
                              </div>

                          </div>
                          </div><!-- end customer complaints list -->


                          <div class="tab-pane pd-20 pd-xl-25" id="job_warranty_logs">
                            <div class="col-lg-12 col-xl-12">
                                <div class="card">
                                <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                                    <div>
                                        <h6 class="mg-b-5"> CSE Earning as of {{ date('M, d Y') }}</h6>
                                        <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all Fixmaster CSE Earning .</p>
                                    </div>

                                </div>
                                  <div class="table-responsive">

                                      <table class="table table-hover mg-b-0" id="basicExample">
                                          <thead class="thead-primary">
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>CSE ID</th>
                                              
                                                <th>Job Category</th>
                                                <th>Job ID</th>
                                                <th>Job Description</th>
                                                <th>Job Rating</th>
                                                <th>Warranty Status</th>
                                                <th>Warranty Type</th>
                                                <th>Warranty Resolution Status</th>
                                                <th>Job Rating</th>
                                                <th>Complaints</th>
                                                
                                               
                                            </tr>
                                          </thead>
                                          <tbody>
                                          @foreach($users as $cse)
                                            <tr>
                                              <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
                                              <td class="tx-medium"> {{ $cse['unique_id']}}</td>
                                              <td class="tx-medium"> Lagos</td>
                            
                                              <td class="tx-medium">Service discount</td>
                                              <td class="tx-medium">Repairs</td>
                                              <td class="tx-medium">Repairs</td>
                                              <td class="tx-medium">Ongoing</td>
                                              <td class="text-medium">2</td>
                
                                              <td class="text-medium">Very terrible</td>
                                              <td class="text-medium">2</td>
                
                                              <td class="text-medium">Very terrible</td>
                                             
                                            </tr>
                                            @endforeach
                                          </tbody>
                                      </table>
                                  </div>
                              </div>

                          </div>
                          </div><!-- end Job Warranty Log -->


            </div><!-- col -->
        </div><!-- row -->

    </div><!-- container -->
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