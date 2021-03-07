@extends('layouts.dashboard')
@section('title', 'E-Wallet')
@section('content')
    @include('layouts.partials._messages')

    <div class="content-body">
        <div class="container pd-x-0">
            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">E-Wallet Transactions</li>
                        </ol>
                    </nav>
                    <h4 class="mg-b-0 tx-spacing--1">E-Wallet Transactions</h4>
                </div>
                
            </div>

            <div class="row row-xs">
                <div class="col-lg-12 col-xl-12 mg-t-10">
                    <div class="card mg-b-10">
                        <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                            <div>
                                <h6 class="mg-b-5">E-Wallet Transactions as of {{ date('M, d Y') }}</h6>
                                <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all your E-Wallet Transactions on FixMaster.</p>
                            </div>

                        </div><!-- card-header -->

                        <div class="table-responsive">

                            <table class="table table-hover mg-b-0" id="basicExample">
                                <thead class="thead-primary">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Wallet ID</th>
                                    <th>Receipt No</th>
                                    <th>Reference No</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($userTransaction as $transaction)
                                        <tr>
                                            <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
                                            <td class="tx-medium">{{ $transaction['wallet_id'] }}</td>
                                            <td class="tx-medium">{{ $transaction['reference'] .' '.$transaction['last_name'] }}</td>
                                            <td class="tx-medium">{{ $transaction['receipt_no'] }}</td>
                                            <td class="text-medium">{{ $transaction['amount'] }}</td>
                                            <td class="text-medium">{{ $transaction['status'] }}</td>
                                           
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
