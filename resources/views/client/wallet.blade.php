@extends('layouts.client')
@section('title', 'E-Wallet')
@section('content')
@include('layouts.partials._messages')

<style>
    [type=radio] { 
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    /* IMAGE STYLES */
    [type=radio] + img {
        cursor: pointer;
    }

    /* CHECKED STYLES */
    [type=radio]:checked + img {
        outline: 2px solid #E97D1F;
        outline-style: dashed;
    }
</style>
<div class="col-lg-8 col-12">
    <div class="border-bottom pb-4 row">
        {{-- <h5>Femi Joseph</h5>
        <p class="text-muted mb-0">I have started my career as a trainee and prove my self and achieve all the milestone with good guidance and reach up to the project manager. In this journey, I understand all the procedure which make me a good developer, team leader, and a project manager.</p>--}}
        <div class="col-md-4 mt-4">
            <div class="media key-feature align-items-center p-3 rounded shadow mt-4">
                <img src="{{ asset('assets/images/job/Circleci.svg') }}" class="avatar avatar-ex-sm" alt="">
                <div class="media-body content ml-3">
                    <h4 class="title mb-0">Transactions</h4>
                <p class="text-muted mb-0">{{ $walletTransactions->count() }}</p>
                    {{-- <p class="text-muted mb-0"><a href="javascript:void(0)" class="text-primary">CircleCi</a> @London, UK</p>     --}}
                </div>
            </div>

        </div>

        <div class="col-md-4 mt-4">
            <div class="media key-feature align-items-center p-3 rounded shadow mt-4">
                <img src="{{ asset('assets/images/job/Circleci.svg') }}" class="avatar avatar-ex-sm" alt="">
                <div class="media-body content ml-3">
                    <h4 class="title mb-0">Amount Spent</h4>
                    <p class="text-muted mb-0">₦30,000.00</p>
                    {{-- <p class="text-muted mb-0"><a href="javascript:void(0)" class="text-primary">CircleCi</a> @London, UK</p>     --}}
                </div>
            </div>
        </div>

        <div class="col-md-4 mt-4">
            <div class="media key-feature align-items-center p-3 rounded shadow mt-4">
                <img src="{{ asset('assets/images/job/Circleci.svg') }}" class="avatar avatar-ex-sm" alt="">
                <div class="media-body content ml-3">
                    <h4 class="title mb-0">Amount Recieved</h4>
                    <p class="text-muted mb-0">₦84,560.00</p>
                    {{-- <p class="text-muted mb-0"><a href="javascript:void(0)" class="text-primary">CircleCi</a> @London, UK</p>     --}}
                </div>
            </div>
        </div>
    </div> 

    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-12 mt-4 pt-2 text-center">
            <ul class="nav nav-pills nav-justified flex-column flex-sm-row rounded" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link rounded active" id="fund-account-tab" data-toggle="pill" href="#fund-account" role="tab" aria-controls="fund-account" aria-selected="false">
                        <div class="text-center pt-1 pb-1">
                            <h4 class="title font-weight-normal mb-0">Fund Account</h4>
                        </div>
                    </a><!--end nav link-->
                </li><!--end nav item-->
                
                <li class="nav-item">
                    <a class="nav-link rounded" id="transactions-tab" data-toggle="pill" href="#transactions" role="tab" aria-controls="transactions" aria-selected="false">
                        <div class="text-center pt-1 pb-1">
                            <h4 class="title font-weight-normal mb-0">Transactions</h4>
                        </div>
                    </a><!--end nav link-->
                </li><!--end nav item-->
            </ul><!--end nav pills-->
        </div>
    </div>

    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="fund-account" role="tabpanel" aria-labelledby="fund-account-tab">
            <div class="col-md-12 mt-4 pt-2">
                <h5>Fund Account :</h5>
        
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Amount : </label>
                                <input name="name" id="number" type="tel" class="form-control font-weight-bold" required placeholder="Amount : ">
                            </div>
                        </div><!--end col-->
        
                        <div class="col-md-6">
                            <label>Payment Gateway : </label>
                                <br>
                            <label>
                                <input type="radio" name="profile_avatar" value="">
                                <img src="{{ asset('assets/images/paystack.png') }}" alt="" class="img-fluid avatar avatar-small mx-2 mt-4 rounded-circl shadow">
                            </label>
        
                            <label>
                                <input type="radio" name="profile_avatar" value="">
                                <img src="{{ asset('assets/images/flutterwave.jpg') }}" alt="" class="img-fluid avatar avatar-small mx-2 mt-4 rounded-circl shadow">
                            </label>
        
                        </div><!--end col-->
                        <div class="col-md-12 form-group">
                            <div class="col-md-6 custom-control custom-checkbox form-group position-relative">
                                <input type="radio" id="customRadio33" name="customRadio" class="custom-control-input">
                                <label class="custom-control-label" for="customRadio33">Use my saved card</label>
                            </div>
                        
                            <div class="col-md-6 custom-control custom-checkbox form-group position-relative">
                                <input type="radio" id="customRadio34" name="customRadio" class="custom-control-input">
                                <label class="custom-control-label" for="customRadio34">No, I have another card</label>
                            </div>
                        </div>
                    </div>
                
                    <div class="row d-none add-card mt-b col-md-6">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Name of card holder : </label>
                                <input name="name" id="name" type="text" class="form-control font-weight-bold" required placeholder="Name">
                            </div>
                        </div><!--end col-->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Card Number :</label>
                                <input type="tel" min="0" autocomplete="off" id="cardnumber" maxlength="16" class="form-control font-weight-bold" required placeholder="0000 0000 0000 0000">
                            </div>                                                                               
                        </div><!--end col-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Expires End :</label>
                                <input type="tel" min="0" autocomplete="off" id="exdate" class="form-control font-weight-bold" required placeholder="MM/YY" maxlength="2">
                            </div>
                        </div><!--end col-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>CVV :</label>
                                <input type="tel" min="0" autocomplete="off" id="cvv" class="form-control font-weight-bold" required placeholder="CVV" maxlength="3">
                            </div>
                        </div><!--end col-->
                    </div><!--end row-->
                    {{-- <div class="row mb-4"> --}}
                        <div class="col-md-12">
                            <input type="submit" id="submit" name="send" class="submitBnt btn btn-primary" value="Make Payment">
                        </div><!--end col-->
                    {{-- </div><!--end row--> --}}
                </form><!--end form-->
            </div><!--end col-->
        </div>

        <div class="tab-pane fade show" id="transactions" role="tabpanel" aria-labelledby="transactions-tab">
            <h5 class="mb-0">Transactions</h5>
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
                            <th class="py-3">Payment Type</th>
                            <th class="py-3">Timestamp</th>
                            <th class="py-3">Amount</th>
                            {{-- <th class="py-3">Balance</th> --}}
                        </tr>
                    </thead>
        
                    <tbody>
                        @foreach ($walletTransactions as $walletTransaction)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $walletTransaction->serviceRequest->job_reference }}</td>
                            <td> 
                                @if($walletTransaction->payment_type == "Payment")
                                    Service Request Payment
                                @elseif($walletTransaction->payment_type == 'Refund')
                                    Service Request Refund
                                @else
                                    E-Wallet Funding
                                @endif
                            </td>
                            <td>{{ Carbon\Carbon::parse($walletTransaction->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                            <td class="font-weight-bold">₦{{ number_format($walletTransaction->amount) }}</td>
                            {{-- <td class="font-weight-bold">
                                @if($walletTransaction->payment_type == "Payment")
                                    ₦{{ number_format($walletTransaction->wallet->balance - $walletTransaction->amount) }}
                                @elseif($walletTransaction->payment_type == 'Refund')
                                    ₦{{ number_format($walletTransaction->wallet->balance + $walletTransaction->amount) }}
                                @else
                                    ₦{{ number_format($walletTransaction->wallet->balance + $walletTransaction->amount) }}
                                @endif
                            </td> --}}
                        </tr>
                        @endforeach
                      
                       
                    </tbody>
                </table>
        
                
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