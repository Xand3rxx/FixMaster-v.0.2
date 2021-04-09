@extends('layouts.client')
@section('title', 'Payments')
@section('content')
    @include('layouts.partials._messages')


    <div class="col-lg-8 col-12">
        <div class="border-bottom pb-4 row">
            
            <div class="col-md-4 mt-4">
                <div class="media key-feature align-items-center p-3 rounded shadow mt-4">
                    <img src="{{ asset('assets/images/job/Circleci.svg') }}" class="avatar avatar-ex-sm" alt="">
                    <div class="media-body content ml-3">
                        <h4 class="title mb-0">Transactions</h4>
                        <p class="text-muted mb-0">3</p>
                    <!-- {{-- <p class="text-muted mb-0"><a href="javascript:void(0)" class="text-primary">CircleCi</a> @London, UK</p>     --}} -->
                    </div>
                </div>

            </div>

            <div class="col-md-4 mt-4">
                <div class="media key-feature align-items-center p-3 rounded shadow mt-4">
                    <img src="{{ asset('assets/images/job/Circleci.svg') }}" class="avatar avatar-ex-sm" alt="">
                    <div class="media-body content ml-3">
                        <h4 class="title mb-0">Amount Spent</h4>
                        <p class="text-muted mb-0">₦30,000.00</p> 
                    <!-- {{-- <p class="text-muted mb-0"><a href="javascript:void(0)" class="text-primary">CircleCi</a> @London, UK</p>     --}} -->
                    </div>
                </div>
            </div>

            <div class="col-md-4 mt-4">
                <div class="media key-feature align-items-center p-3 rounded shadow mt-4">
                    <img src="{{ asset('assets/images/job/Circleci.svg') }}" class="avatar avatar-ex-sm" alt="">
                    <div class="media-body content ml-3">
                        <h4 class="title mb-0">Amount Recieved</h4>
                        <p class="text-muted mb-0">₦84,560.00</p>
                    <!-- {{-- <p class="text-muted mb-0"><a href="javascript:void(0)" class="text-primary">CircleCi</a> @London, UK</p>     --}} -->
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-content mt-3" id="pills-tabContent">
            <!-- payment options ends here -->
            <div class="tab-pane fade show active" id="transactions" role="tabpanel" aria-labelledby="transactions-tab">
                <h5 class="mb-0">All Payments Transactions</h5>
                <div class="table-responsive mt-4 bg-white rounded shadow">
                    <div class="row mt-1 mb-1 ml-1 mr-1">
                        <div class="col-md-4">
                            <div class="form-group position-relative">
                                <label>Sort Table</label>
                                <select class="form-control custom-select" id="request-sorting">
                                    <option value="None">Select...</option>
                                    <option value="Date">Date</option>
                                    <option value="Month">Month</option>
                                    <option value="Date Range">Date Range</option>
                                </select>
                            </div>
                        </div><!--end col-->

                        <div class="col-md-4 specific-date d-none">
                            <div class="form-group position-relative">
                                <label>Specify Date <span class="text-danger">*</span></label>
                                <i data-feather="calendar" class="fea icon-sm icons"></i>
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
                                <i data-feather="calendar" class="fea icon-sm icons"></i>
                                <input name="name" id="name" type="date" class="form-control pl-5">
                            </div>
                        </div>

                        <div class="col-md-4 date-range d-none">
                            <div class="form-group position-relative">
                                <label>To <span class="text-danger">*</span></label>
                                <i data-feather="calendar" class="fea icon-sm icons"></i>
                                <input name="name" id="name" type="date" class="form-control pl-5">
                            </div>
                        </div>
                    </div>

                    <table class="table table-center table-padding mb-0" id="basicExample">
                        <thead>
                        <tr>
                            <th class="py-3">#</th>
                            <th class="py-3">Reference No</th>
                            <th class="py-3">Transaction ID</th>
                            <th class="py-3">Payment For</th>
                            <th class="py-3">Amount(₦)</th>
                            <th class="py-3">Status</th>
                            <th class="py-3">Transacation Date</th>
                            <th class="py-3">Action</th>

                            {{-- <th class="py-3">Balance</th> --}}
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($payments as $payment)
                            <tr>
                            <td>{{ $loop->iteration }}</td>
                                <td>{{$payment->reference_id}}</td>
                                <td>{{$payment->transaction_id == null ? 'UNAVAILABLE' : $payment->transaction_id  }}</td>
                                <td class="font-weight-bold">{{$payment->payment_for}}</td>
                                <td>{{$payment->amount}}</td>

                                @if($payment->status=='success')
                                    <td class="text-center text-success">Success</td>
                                @elseif($payment->status=='pending')
                                    <td class="text-center text-danger">Pending</td>
                                @elseif($payment->status=='failed')
                                    <td class="text-center text-warning">Failed</td>
                                @elseif($payment->status=='timeout')
                                    <td class="text-center text-info">Timeout</td>
                                @endif

                                <td>{{ Carbon\Carbon::parse($payment->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                                <td><a href="#" data-toggle="modal" data-target="#transactionDetails" class="btn btn-primary btn-sm ">Details</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>


                </div>
            </div>

        </div>


        <div class="modal fade" id="transactionDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
              <div class="modal-content tx-14">
                <div class="modal-header">
                  <h6 class="modal-title" id="exampleModalLabel2">E-Wallet Transaction Details</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body pd-x-25 pd-sm-x-30 pd-t-40 pd-sm-t-20 pd-b-15 pd-sm-b-20">
                    <div class="table-responsive mt-4">
                        <table class="table table-striped table-sm mg-b-0">
                        <tbody>
                            <tr>
                                <td class="tx-medium" width="25%">Unique ID</td>
                                <td class="tx-color-03" width="75%">WAL-23782382</td>
                            </tr>
                            <tr>
                                <td class="tx-medium" width="25%">Reference No.</td>
                                <td class="tx-color-03" width="75%">32e3lh2e23083h432b</td>
                            </tr>
                            <tr>
                                <td class="tx-medium" width="25%">Transaction ID.</td>
                                <td class="tx-color-03" width="75%">Transaction ID returned on success should be displayed here only if payment gateway was used or UNAVAILABLE</td>
                            </tr>
                            <tr>
                                <td class="tx-medium" width="25%">Transaction Type</td>
                                <td class="tx-color-03" width="75%">Credit</td>
                            </tr>
                            <tr>
                                <td class="tx-medium" width="25%">Payment Type</td>
                                <td class="tx-color-03" width="75%"3">Funding</td>
                            </tr>
                            <tr>
                                <td class="tx-medium" width="25%">Payment Channel</td>
                                <td class="tx-color-03" width="75%"3">Paystack or Flutterwave or Offline or Wallet</td>
                            </tr>
                            <tr>
                                <td class="tx-medium" width="25%">Payment For</td>
                                <td class="tx-color-03" width="75%"3">Wallet</td>
                            </tr>
                            <tr>
                                <td class="tx-medium" width="25%">Amount</td>
                                <td class="tx-color-03" width="75%">₦{{ number_format(10000) }}</td>
                            </tr>
                            <tr>
                                <td class="tx-medium" width="25%">Status</td>
                                <td class="text-warning" width="75%">Pending</td>
                            </tr>
                            <tr>
                                <td class="tx-medium" width="25%">Refund Reason</td>
                                <td class="tx-color-03" width="75%">This section should only be visible in a case of refund, the reason should be displayed here or UNAVAILABLE</td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                  </div><!-- modal-body -->
                <div class="modal-footer"></div>
              </div>
            </div>
        </div>



    </div><!--end col-->

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
