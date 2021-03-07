@extends('layouts.dashboard')
@section('title', $transaction->wallet_id.'\'s Summary')
@include('layouts.partials._messages')
@section('content')
    <div class="content-body">
        <div class="container pd-x-0">
            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.list_estate', app()->getLocale()) }}">E-Wallet Service Request</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $transaction->wallet_id }}</li>
                        </ol>
                    </nav>
                    {{-- <h4 class="mg-b-0 tx-spacing--1">E-wallet Service Request Summary</h4> --}}
                </div>

               <div class="d-md-block">
                    <a href="{{ route('admin.wallet_transaction', app()->getLocale()) }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Back</a>
                     
                </div>
            </div>

            <div class="row row-xs">
                <div class="col-sm-12 col-lg-12">
                    <div class="card mg-b-20 mg-lg-b-25">
                        <div class="card-header pd-y-15 pd-x-20 d-flex align-items-center justify-content-between">
                            <h6 class="tx-uppercase tx-semibold mg-b-0">{{ $transaction->wallet_id }} Summary</h6>
                            <nav class="nav nav-with-icon tx-13">
                                <!-- <a href="" class="nav-link"><i data-feather="plus"></i> Add New</a> -->
                            </nav>
                        </div><!-- card-header -->
                        <div class="card-body pd-25">
                            <div class="media">
{{--                                <div class="pos-relative d-inline-block mg-b-20">--}}
{{--                                    <div class="avatar avatar-xxl"><span class="avatar-initial rounded-circle bg-gray-700 tx-normal"><i class="icon ion-md-person"></i></span></div>--}}
{{--                                    --}}{{-- <a href="" class="contact-edit-photo"><i data-feather="edit-2"></i></a> --}}
{{--                                </div>--}}
                                <div class="media-body pd-l-25">
                                   
                                    <div class="table-responsive">
                                        <table class="table table-striped table-sm mg-b-0">
                                            <tbody>
                                            <tr>
                                                <td class="tx-medium">Client Name</td>
                                                <td class="tx-color-03">{{ $transaction->wallet_id }}</td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Card Name</td>
                                                <td class="tx-color-03"> {{ $transaction->wallet_id .' '. $transaction->wallet_id}} </td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Phone Number</td>
                                                <td class="tx-color-03"> {{ $transaction->wallet_id}} </td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Email</td>
                                                <td class="tx-color-03"> {{ $transaction->wallet_id }} </td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Status</td>
                                                <td class="tx-color-03"> @if($transaction['status'] === '1') Approved @else Pending @endif </td>
                                            </tr>
                                           
                                            <tr>
                                                <td class="tx-medium">Merchant</td>
                                                <td class="tx-color-03"> {{ $transaction->transaction_type_id }} </td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Wallet ID</td>
                                                <td class="tx-color-03"> {{ $transaction->wallet_id }} </td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Reciept No</td>
                                                <td class="tx-color-03"> {{ $transaction->receipt_no }} </td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Reference No</td>
                                                <td class="tx-color-03"> {{ $transaction->reference }} </td>
                                            </tr>
                                             <tr>
                                              <td class="tx-medium">Amount</td>
                                              <td class="tx-color-03"> {{ $transaction->amount }} </td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Service Requested</td>
                                                <td class="tx-color-03"> {{ $transaction->wallet_id }} </td>
                                            </tr>
                                            
                                            <tr>
                                                <td class="tx-medium">Date Created</td>
                                                <td class="tx-color-03"> {{ Carbon\Carbon::parse($transaction->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }} </td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Last Edited</td>
                                                <td class="tx-color-03"> @if(!empty($transaction->updated_at)) {{ Carbon\Carbon::parse($transaction->updated_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }} @else Never @endif </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- card -->
                </div><!-- col -->

            </div><!-- row -->

        </div>
    </div>

@endsection
