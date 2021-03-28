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
                        <li class="breadcrumb-item active" aria-current="page">Customer Service Executive List</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Customer Service Executive List</h4>
            </div>
            
        </div>

        <div class="contact-content-header mt-4">
      <nav class="nav">
      <a href="#summary" class="nav-link active" data-toggle="tab">Job Assigned</a>
      <a href="#discount" class="nav-link" data-toggle="tab"><span>Amount Earned</a>
      <a href="#client" class="nav-link" data-toggle="tab"><span>List of CSE's</a>
      <a href="#client" class="nav-link" data-toggle="tab"><span>CSE Rating History</a>
      <a href="#activityLog" class="nav-link" data-toggle="tab"><span>Statement Balance</a> 
      <a href="#client" class="nav-link" data-toggle="tab"><span>Prospect Conversion List</a>
      <a href="#client" class="nav-link" data-toggle="tab"><span>List of Customer Complaints</a>
      <a href="#client" class="nav-link" data-toggle="tab"><span>Job Warranty Log</a>
      </nav>
      <a href="" id="contactOptions" class="text-secondary mg-l-auto d-xl-none"><i data-feather="more-horizontal"></i></a>
    </div><!-- contact-content-header -->

        <div class="row row-xs">
            <div class="col-lg-12 col-xl-12 mg-t-10">
                <div class="card mg-b-10">
                    <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                        <div>
                            <h6 class="mg-b-5">Customer Service Executive as of {{ date('M, d Y') }}</h6>
                            <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all FixMaster Customer Service Executive.</p>
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

                    <div class="table-responsive">

                        <table class="table table-hover mg-b-0" id="basicExample">
                            <thead class="thead-primary">
                                <tr>
                                  <th class="text-center">#</th>
                                  <th>Job Reference</th>
                                  <th>CSE ID</th>
                                  <th>Full Name</th>
                                  <th>Job Acceptance Date</th>
                                  <th>Job Completion Date</th>
                                  <th>Status</th>
                                  <th>Action</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($serviceRequests as $serviceRequest)
                                <tr>
                                    <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
                                    <td class="tx-medium">{{ $serviceRequest->service_request->unique_id ?? ''}}</td>
                                   
                  <td class="tx-medium"> @foreach($serviceRequest->service_request->users as $data)
                  @foreach($data->roles as $res)
                  @if($res->url == "cse")
                     {{$data->cse->unique_id ?? ''}}
                  @endif
                  @endforeach
                  @endforeach</td>
                  <td class="tx-medium"> @foreach($serviceRequest->service_request->users as $data)
                  @foreach($data->roles as $res)
                  @if($res->url == "cse")
                     {{$data->account->first_name}} {{$data->account->last_name}}
                  @endif
                  @endforeach
                  @endforeach</td>
                                    
                                
                  <td class="text-medium">{{ Carbon\Carbon::parse($serviceRequest->service_request->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                  <td class="text-medium">{{ Carbon\Carbon::parse($serviceRequest->service_request->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td> 
                  
                  @if($serviceRequest->service_request->status_id == 1)
                    <td class="text-medium text-warning">Pending</td>
                  @elseif($serviceRequest->service_request->status_id == 2)
                  <td class="text-medium text-info">Ongoing</td>
                  @elseif($serviceRequest->service_request->status_id == 3)
                    <td class="text-medium text-danger">Cancelled</td>
                  @elseif($serviceRequest->service_request->status_id == 4)
                    <td class="text-medium text-success">Completed</td>
                  @else
                 <td class="text-medium text-warning">{{$serviceRequest->service_request->status}}</td>
                  @endif
                  
                              
                  <td class=" text-center">
                    <div class="dropdown-file">
                      <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
                      <div class="dropdown-menu dropdown-menu-right">
                     <a href="{{ route('admin.cse_report_details', ['details'=>$serviceRequest->service_request->uuid, 'locale'=>app()->getLocale()]) }}" class="dropdown-item details"><i class="far fa-clipboard"></i> Details</a>
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