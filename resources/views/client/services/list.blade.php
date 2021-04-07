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
                                    <th>Service Cost</th>
                                    <!-- <th>Phone Number</th>
                                    <th>Clients</th> -->
                                    <th>Status</th>
                                    <th>Created </th>
                                    <th>Updated </th>
                                    <th class="text-center">Action</th> 
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($myServiceRequests as $k=> $myServiceRequest)
                                <tr>

                                <!-- <li class="badge badge-danger badge-pill">Remote</li> -->

                                <td class="tx-color-03 tx-center">{{ ++$k }}</td>
                                <td class="tx-medium">{{ $myServiceRequest->service->name }}</td>
                                <td class="tx-medium">{{ $myServiceRequest->total_amount }}</td>
                                <td class="tx-medium">
                                @if($myServiceRequest->service->status==1)
                                <span class="badge badge-primary rounded">Pending</span>
                                @elseif($myServiceRequest->service->status==2)
                                <span class="badge badge-success rounded">Ongoing</span>
                                @elseif($myServiceRequest->service->status==3)
                                <span class="badge badge-warning rounded">Cancelled</span>
                                @elseif($myServiceRequest->service->status==4)
                                <span class="badge badge-danger rounded">Completed</span>
                                @endif
                                </td>
                                <td class="tx-medium">{{date("Y/m/d h:i:A", strtotime($myServiceRequest->created_at))}} </td>
                                <td class="tx-medium">{{date("Y/m/d h:i:A", strtotime($myServiceRequest->updated_at))}} </td>
                                <td class=" text-center">
                                    <div class="dropdown-file">
                                    <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                       <a href="javascript:void(0)" data-target="#view{{$myServiceRequest->service->id }}" data-toggle="modal" class="dropdown-item details text-primary" title="View {{ $myServiceRequest->service->name}} details"><i class="far fa-clipboard"></i> Details</a>
                                        <hr>
                                        @foreach(\App\Models\Invoice::where('service_request_id', $myServiceRequest->service->id)->where('is_accepted', 'accepted')->get() as $invoice)
                                            <a href="{{ route('invoice', ['locale' => app()->getLocale(), 'invoice' => $invoice['uuid']]) }}" class="dropdown-item details text-info"><i data-feather="file-text" class="fea icon-sm"></i> View {{ $invoice['invoice_type'] }}</a>
                                        @endforeach
                                        <hr>
                                        <a href="javascript:void(0)" data-target="#view{{$myServiceRequest->service->id }}" data-toggle="modal" class="dropdown-item details text-primary" title="View {{ $myServiceRequest->service->name}} details"><i class="far fa-clipboard"></i> Initiate Warranty</a>
                                         </div>
                                    </div>
                                </td>
                                </tr>

                                <!-- <div class="modal fade" id="LoginForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"> -->
                <div class="modal fade" id="view{{$myServiceRequest->service->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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

    </div><!-- modal-content -->
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
