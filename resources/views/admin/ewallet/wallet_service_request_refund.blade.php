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
                            <li class="breadcrumb-item active" aria-current="page">E-Wallet Service Request Refund</li>
                        </ol>
                    </nav>
                    <h4 class="mg-b-0 tx-spacing--1">E-Wallet Service Request Refund</h4>
                </div>
                
            </div>
           
            <div class="row row-xs">
                <div class="col-lg-12 col-xl-12 mg-t-10">
                    <div class="card mg-b-10">
                        <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                            <div>
                                <h6 class="mg-b-5">E-Wallet Refund Request as of {{ date('M, d Y') }}</h6>
                                <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all FixMaster E-Wallet Refund Request.</p>
                            </div>

                        </div><!-- card-header -->

                        <div class="table-responsive">

                            <table class="table table-hover mg-b-0" id="basicExample">
                                <thead class="thead-primary">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Wallet ID</th>
                                    <th>Reference No</th>
                                    <th>Amount</th>
                                    <th>Opening Balance</th>
                                    <th>Closing Balance</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($userTransaction as $transaction)
                                <form action="{{ route('admin.approve_refund', ['transaction' => $transaction->id, 'locale' => app()->getLocale()]) }}" method="POST">
                @csrf
                                        <tr>
                                            <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
                                            <td class="tx-medium">{{ $transaction['wallet_id'] }}</td>
                                            <td class="text-medium">{{ $transaction['reference_no'] }}</td>
                                            <td class="text-medium">{{ $transaction['amount'] }}<input type="hidden" name="amount" value="8987" required></td>
                                            <td class="text-medium">{{ $transaction['opening_balance'] }}<input type="hidden" name="opening_balance" value="{{ $transaction->opening_balance }}" required></td>
                                            <td class="text-medium">{{ $transaction['closing_balance'] }}<input type="hidden" name="closing_balance" value="{{ $transaction->closing_balance }}" required></td>
                                            <td class="text-medium">{{ Carbon\Carbon::parse($transaction->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                                            <td class="text-medium text-warning"> @if($transaction->status === '3') Refund Requested @else Other @endif</td>
                                            <td class=" text-center">
                                          
                                                <div class="dropdown-file">
                                                    <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="{{ route('admin.wallet_refund_summary', [ 'transaction'=>$transaction['id'], 'locale'=>app()->getLocale() ]) }}" class="dropdown-item details text-primary"><i class="far fa-user"></i> Summary</a>
                                                    <a href="{{ route('admin.approve_refund', ['transaction'=>$transaction->id, 'locale'=>app()->getLocale()]) }}" class="dropdown-item details text-warning"><i class="fas fa-ban"></i> Approve Refund</a>
                                                        @if($transaction['status'] === '0')
                                                            <a href="{{ route('admin.approve_transaction', ['transaction'=>$transaction->id, 'locale'=>app()->getLocale()]) }}" class="dropdown-item details text-warning"><i class="fas fa-ban"></i> Approved</a>
                                                        @else
                                                            <a href="{{ route('admin.pending_transaction', ['transaction'=>$transaction->id, 'locale'=>app()->getLocale()]) }}" class="dropdown-item details text-success"><i class="fas fa-undo"></i> Processing</a>
                                                        @endif
                                                        <a href="{{ route('admin.delete_transaction', ['transaction'=>$transaction->id, 'locale'=>app()->getLocale()]) }}" class="dropdown-item details text-danger"><i class="fas fa-trash"></i> Delete</a>
                                                    </div>
                                                </div>
                                                
                                            </td>
                                        </tr>
                                        </form>
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
