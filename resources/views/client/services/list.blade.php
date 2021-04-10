@extends('layouts.client')
@section('title', 'My Service Requests')
@section('content')
@include('layouts.partials._messages')

<div class="col-lg-8 col-12" style="margin-top: 3rem;">

<div class="content-body">
        <div class="container pd-x-0">
            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
                <div>

                    <h4 class="mg-b-0 tx-spacing--1">My Service Request List</h4>
                </div>

            </div>

            <div class="row row-xs">
                <div class="col-lg-12 col-xl-12 mg-t-10">
                    <div class="card mg-b-10">
                        <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                            <div>
                                <h6 class="mg-b-5">My Service Request as of {{ date('M, d Y') }}</h6>
                                <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all My Service Request.</p>
                            </div>

                        </div><!-- card-header -->

                        <div class="table-responsive">

                            <table class="table table-hover mg-b-0" id="basicExample">
                                <thead class="thead-primary">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Service Name</th>
                                    <th class="text-center">Service Charge(₦)</th>
                                    <th>Status</th>
                                    <th>Issued Created </th>
                                    <th>Scheduled Date</th>
                                    <th class="text-center">Action</th> 
                                </tr>
                                </thead>
                                <tbody>

                                @foreach ($myServiceRequests['service_requests'] as $myServiceRequest)

                                <tr>

                                <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
                                <td>{{ $myServiceRequest['service']['name'] }}</td>
                                <td class="text-center font-weight-bold">{{ $myServiceRequest->bookingFee->amount }}</td>
                                <td class="tx-medium">
                                @if($myServiceRequest->status_id == 1)
                                    <span class="badge badge-warning rounded">Pending</span>
                                @elseif($myServiceRequest->status_id == 2)
                                    <span class="badge badge-info rounded">Ongoing</span>
                                @elseif($myServiceRequest->status_id == 3)
                                    <span class="badge badge-danger rounded">Cancelled</span>
                                @elseif($myServiceRequest->status_id == 4)
                                    <span class="badge badge-success rounded">Completed</span>
                                @endif
                                </td>
                                <td class="tx-medium">{{ Carbon\Carbon::parse($myServiceRequest['created_at'], 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                                <td class="tx-medium font-weight-bold">{{ !empty($myServiceRequest['preferred_time']) ? Carbon\Carbon::parse($myServiceRequest['preferred_time'], 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') : 'Not Scheduled yet'}} </td>
                                <td class=" text-center">

                                    <div class="btn-group dropdown-primary mr-2 mt-2">
                                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action
                                        </button>
                                        <div class="dropdown-menu">
                                             <a href="{{ route('client.request_details', [ 'request'=>$myServiceRequest->uuid, 'locale'=>app()->getLocale() ]) }}" class="dropdown-item text-primary"><i data-feather="clipboard" class="fea icon-sm"></i> Details</a>

                                             @if($myServiceRequest->status_id == 2)
                                                <a href="#" class="dropdown-item details text-success"><i data-feather="check" class="fea icon-sm"></i> Mark as Completed</a>
                                             @endif

                                             @if($myServiceRequest->status_id == 1)
                                                <a href="#" class="dropdown-item details text-warning"><i data-feather="edit" class="fea icon-sm"></i> Edit</a>
                                             @endif

                                             @if($myServiceRequest->status_id == 1)
                                                <div class="dropdown-divider"></div>
                                                <a href="#cancelRequest" id="cancel-request" data-toggle="modal" data-url="#" data-job-reference="{{ $myServiceRequest->unique_id }}" class="dropdown-item text-danger cancel_reques"><i data-feather="x" class="fea icon-sm"></i> Cancel Request</a>

                                            @endif
                                            @if($myServiceRequest->status_id == 3)
                                                <div class="dropdown-divider"></div>
                                                <a href="javascript:void(0)" class="dropdown-item text-success"><i data-feather="corner-up-left" class="fea icon-sm"></i> Reinstate Request</a>
                                            @endif

                                            @if(\App\Models\Invoice::where('service_request_id', $myServiceRequest->service->id)->where('phase', '1')->count() > 0 || \App\Models\Invoice::where('service_request_id', $myServiceRequest->service->id)->where('phase', '2')->count() > 0)
                                                <div class="dropdown-divider"></div>
                                                @foreach(\App\Models\Invoice::where('service_request_id', $myServiceRequest->service->id)->where('phase', '1')->orWhere('phase', '2')->where('invoice_type', 'Diagnosis Invoice')->orWhere('invoice_type', 'Completion Invoice')->get() as $invoice)
                                                    <a href="{{ route('invoice', ['locale' => app()->getLocale(), 'invoice' => $invoice['uuid']]) }}" class="dropdown-item details text-info"><i data-feather="file-text" class="fea icon-sm"></i> {{ $invoice['invoice_type'] }} Invoice</a>
                                                @endforeach
                                            @endif
                                            {{-- {{ dd($myServiceRequest['warranty']) }} --}}

                                            @if($myServiceRequest->status_id == 4 && !empty($myServiceRequest['warranty']))
                                                <div class="dropdown-divider"></div>
                                                <a href="#" class="dropdown-item text-success"><i data-feather="award" class="fea icon-sm"></i> Initiate Warranty</a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                </tr>

                                <!-- <div class="modal fade" id="LoginForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"> -->
                {{-- <div class="modal fade" id="view{{$myServiceRequest->service->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Service Request Details </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="form-row mt-4">
                            <div class="form-group col-md-12">
                            <div class="form-group col-md-12">
                                    <label for="percentage">Description </label>
                                    <!-- <input type="text" class="form-control" value="{{$myServiceRequest->service->description }}" autocomplete="off"> -->
                                    <textarea rows="3" class="form-control" >{{$myServiceRequest->service->description }}</textarea>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="percentage">Service Request Address</label>
                                    <input type="text" class="form-control" value="{{$myServiceRequest->service->client_security_code }}" autocomplete="off">

                                </div>

                                <div class="form-group col-md-12">
                                    <label for="percentage">Assigned To</label>
                                    <input type="text" class="form-control" value="{{$myServiceRequest->service->client_security_code }}" autocomplete="off">

                                </div>


                            </div>
                            <!-- <button type="submit" class="btn btn-primary">Create Tax</button> -->
                        </div>

                    </div><!-- modal-body -->

                    <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div><!-- modal-footer -->

    </div><!-- modal-content --> --}}
  </div><!-- modal-dialog -->
</div><!-- modal -->


                                @endforeach
                                </tbody>
                            </table>
                        </div><!-- table-responsive -->
                    </div><!-- card -->

                </div><!-- col -->
            </div><!-- row -->

        </div><!-- container -->
    </div>


<!-- @section('scripts')
    <script>


    </script>
@endsection -->

</div>

@endsection
