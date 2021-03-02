@extends('layouts.client')
@section('title', 'Payments')
@section('content')
@include('layouts.partials._messages')

<div class="col-lg-8 col-12">
    <h5 class="mb-0 mt-4">Payment History</h5>
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
                    <th class="py-3">Job Reference</th>
                    <th class="py-3">Reference No.</th>
                    <th class="py-3">Payment Method</th>
                    <th class="py-3">Amount</th>
                    <th class="py-3">Payment Date</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($payments as $payment)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $payment->serviceRequest->job_reference }}</td>
                    <td>{{ $payment->payment_reference }}</td>
                    <td> {{ $payment->payment_method }}</td>
                    <td class="font-weight-bold">₦{{ number_format($payment->amount) }}</td>
                    <td>{{ Carbon\Carbon::parse($payment->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
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