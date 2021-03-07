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
                    <a href="{{ route('admin.wallet_refund', app()->getLocale()) }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Back</a>
                     
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
                                                <td class="tx-medium">Wallet ID</td>
                                                <td class="tx-color-03">{{ $transaction->wallet_id }}<input type="text" name="wallet_id" value="{{ $transaction->wallet_id }}" required> </td></td>
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
                                                <td class="tx-medium">Card Name</td>
                                                <td class="tx-color-03"> {{ $transaction->firstname .' '. $transaction->lastname}} </td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Phone Number</td>
                                                <td class="tx-color-03"> {{ $transaction->phone}} </td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Email</td>
                                                <td class="tx-color-03"> {{ $transaction->email }} </td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Amount</td>
                                                <td class="tx-color-03"> {{ $transaction->amount }} <input type="hidden" name="amount" value="{{ $transaction->amount }}" required></td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Opening Balance</td>
                                                <td class="tx-color-03"> {{ $transaction->opening_balance }} <input type="hidden" name="opening_balance" value="{{ $transaction->opening_balance }} " required></td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Closing Balance</td>
                                                <td class="tx-color-03"> {{ $transaction->closing_balance }}<input type="hidden" name="closing_balance" value="{{ $transaction->closing_balance }}" required> </td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Status</td>
                                                <td class="tx-color-03">  @if($transaction['status'] === '1') Approved @elseif($transaction['status'] === '0') Pending @elseif($transaction['3'] === '3') Cancel @endif  </td>
                                            </tr>
                                           
                                            <tr>
                                                <td class="tx-medium">Merchant</td>
                                                <td class="tx-color-03"> @if($transaction->payment_gateway== '1') Paystack @else Other @endif </td>
                                            </tr>
                                           
                                            
                                            <tr>
                                                <td class="tx-medium">Date Created</td>
                                                <td class="tx-color-03"> {{ Carbon\Carbon::parse($transaction->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }} ({{ $transaction->created_at->diffForHumans() }}) </td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Last Edited</td>
                                                <td class="tx-color-03"> @if(!empty($transaction->updated_at)) {{ Carbon\Carbon::parse($transaction->updated_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }} @else Never @endif </td>
                                            </tr>
                                            <tr>
                                            <div class="d-md-block">
                                            
                                            <td class="tx-medium">
                                            <a href="{{ route('admin.approve_refund', ['transaction'=>$transaction->id, 'locale'=>app()->getLocale()]) }}" class="btn btn-primary"><i class="fas fa-arrow-right"></i> Approve Refund</a>
                    
                <td></div>
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
