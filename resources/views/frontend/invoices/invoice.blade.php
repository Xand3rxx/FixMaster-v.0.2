<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>@yield('title') | FixMaster.ng - We Fix, You Relax!</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <meta name="Author" content="Anthony Joboy (Lagos, Nigeria)" />
    <meta name="Telephone" content="Tel: +234 903 554 7107" /> --}}
    <meta name="description"
          content="FixMaster is your best trusted one-call solution for a wide range of home maintenance, servicing and repair needs. Our well-trained & certified uniformed technicians are fully insured professionals with robust experience to provide home services to fully meet your needs with singular objective to make you totally relax while your repair requests are professionally handled." />
    <meta name="keywords" content="Home-fix, Home-improvement, Home-repairs, Cleaning-services, Modern" />
    <meta name="email" content="info@homefix.ng" />
    <meta name="website" content="https://www.fixmaster.com.ng" />
    <meta name="Version" content="v0.0.1" />

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/png" sizes="16x16">

    <!-- vendor css -->
    <link href="{{ asset('assets/dashboard/lib/fontawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/dashboard/lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">

    <!-- DashForge CSS -->
    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/css/dashforge.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/css/dashforge.demo.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/css/dashforge.dashboard.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/datatables/dataTables.bs4.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/datatables/dataTables.bs4-custom.css') }}" />
    <link href="{{ asset('assets/dashboard/lib/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/dashboard/lib/prismjs/themes/prism-vs.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/client/css/jquery.datetimepicker.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    @yield('css')

    <style>
        div.dt-buttons {
            margin-top: 1em;
            margin-left: 1.5em;
        }

        button.dt-button,
        div.dt-button,
        a.dt-button,
        input.dt-button {
            font-size: inherit !important;
            color: #fff !important;
            background-color: #E97D1F !important;
            background: linear-gradient(to bottom, rgb(233 125 31) 0%, rgb(233 125 31) 100%);
            border-color: #E97D1F !important;
            display: inline-block !important;
            font-weight: 400 !important;
            text-align: center !important;
            vertical-align: middle !important;
            user-select: none !important;
            background-color: transparent !important;
            border: 1px solid transparent !important;
            padding: 0.46875rem 0.9375rem !important;
            font-size: 0.875rem !important;
            line-height: 1.5 !important;
            border-radius: 0.25rem !important;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out !important;
            line-height: 1.5 i !important;
            text-decoration: none;
            outline: none;
            text-overflow: ellipsis;
        }

        button.dt-button:hover,
        div.dt-button:hover,
        a.dt-button:hover,
        input.dt-button:hover {
            color: #fff !important;
            background-color: #E97D1F !important;
            background: linear-gradient(to bottom, rgb(233 125 31) 0%, rgb(233 125 31) 100%);
            border-color: #E97D1F !important;
        }

    </style>


</head>

<body>
<div class="d-flex justify-content-center mt-5 border-bottom">
    <p style="font-size: 12px; text-align: center;">
        If you click <strong>decline</strong> , your service request will end here and you'll be required<br />to pay for diagnosis alone but you will not enjoy the discount bonus.<br>

        If you click <strong>accept</strong> , your service request continues till the end of the fix and your<br /> discount bonus will be applied.
    </p>
</div>

<section class="bg-invoice">
    <div class="container">
        <div class="row mt-5 pt-4 pt-sm-0 justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow rounded border-0">
                    <div class="card-body" style="border: 0.5px solid grey">
                        <div class="invoice-top pb-4 border-bottom">
                            <div class="row">
                                <div class="col-md-8">
                                    <img src="{{ asset('assets/images/home-fix-logo-colored.png') }}" class="l-dark" style="margin-top: 10px !important;" height="80" alt="FixMaster Logo">

                                    <div class="logo-invoice mb-2">
                                        @if($invoice->status == 1 && $invoice['phase'] == '2' && $invoice['invoice_type'] == 'Diagnosis Invoice')
                                            <form method="POST" action="{{ route('client.invoice.payment', app()->getLocale()) }}">
                                                @csrf
                                                {{-- REQUIREMENTS FOR PAYMENT GATWAYS  --}}
                                                <input type="hidden" class="d-none" value={{ $total_cost }} name="booking_fee">

                                                <input type="hidden" class="d-none" value="paystack" id="payment_channel" name="payment_channel">

                                                <input type="hidden" class="d-none" value="{{ $invoice['unique_id'] }}" id="unique_id" name="unique_id">

                                                <input type="hidden" class="d-none" value="{{ $invoice['uuid'] }}" id="uuid" name="uuid">

                                                <button type="submit" id="paystack_option"  class="btn btn-success">PAY </button>
                                            </form>
                                            <span class="text-primary"> Pending Payment</span><br>
                                        @elseif($invoice->status == 2 && $invoice['invoice_type'] == 'Diagnosis Invoice')
                                            <span class="text-success">Paid</span><br>
                                        @endif
                                    </div>

                                    <a href="" class="text-primary h6"><i data-feather="link" class="fea icon-sm text-muted mr-2"></i>www.fixmaster.com.ng</a>


                                </div><!--end col-->

                                <div class="col-md-4 mt-4 mt-sm-0">
                                    <h5>Address :</h5>
                                    <dl class="row mb-0">
                                        <dt class="col-2 text-muted"><i data-feather="map-pin" class="fea icon-sm"></i></dt>
                                        <dd class="col-10 text-muted">
                                            <a href="#" class="video-play-icon text-muted">
                                                <p class="mb-0">284 Ajose Adeogun Street, Victoria Island,</p>
                                                <p class="mb-0">Lagos, Nigeria</p>
                                            </a>
                                        </dd>

                                        <dt class="col-2 text-muted"><i data-feather="mail" class="fea icon-sm"></i></dt>
                                        <dd class="col-10 text-muted">
                                            <a href="mailto:info@fixmaster.com.ng" class="text-muted">info@fixmaster.com.ng</a>
                                        </dd>

                                        <dt class="col-2 text-muted"><i data-feather="phone" class="fea icon-sm"></i></dt>
                                        <dd class="col-10 text-muted">
                                            <a href="tel:+152534-468-854" class="text-muted">(+234) 0813-286-3878</a>
                                        </dd>
                                    </dl>
                                </div><!--end col-->
                            </div><!--end row-->
                            <div class="d-flex justify-content-center">
                                <h2 style="border: 2px solid grey; padding: 5px">{{$invoice['invoice_type']}}</h2>
                            </div>
                        </div>

                        <div class="invoice-middle py-4">
                            <h5>Invoice Details :</h5>
                            <div class="row mb-0">
                                <div class="col-md-8 order-2 order-md-1">
                                    <dl class="row">
                                        <dt class="col-md-3 col-5 font-weight-normal">Invoice No. :</dt>
                                        <dd class="col-md-9 col-7 text-muted">{{ $invoice['unique_id'] }}</dd>

                                        <dt class="col-md-3 col-5 font-weight-normal">Name :</dt>
                                        <dd class="col-md-9 col-7 text-muted">{{ $invoice['client']->account->first_name }} {{ $invoice['client']->account->last_name }}</dd>

                                        <dt class="col-md-3 col-5 font-weight-normal">Address :</dt>
                                        <dd class="col-md-9 col-7 text-muted">
                                            <p class="mb-0">{{ $invoice['client']['contact']['address'] }}</p>
                                        </dd>

                                        <dt class="col-md-3 col-5 font-weight-normal">Phone :</dt>
                                        <dd class="col-md-9 col-7 text-muted">{{ $invoice['client']['contact']['phone_number'] }}</dd>
                                    </dl>
                                </div>

                                <div class="col-md-4 order-md-2 order-1 mt-2 mt-sm-0">
                                    <dl class="row mb-0">
                                        <dt class="col-md-4 col-5 font-weight-normal">Date :</dt>
                                        <dd class="col-md-8 col-7 text-muted">{{ Carbon\Carbon::parse($invoice['created_at'], 'UTC')->isoFormat('MMMM Do, YYYY') }}</dd>
                                    </dl>
                                    <dl class="row mb-0">
                                        <dt class="col-md-4 col-5 font-weight-normal">Type :</dt>
                                        <dd class="col-md-8 col-7 text-muted">{{ $invoice->invoice_type }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>

                        <div class="invoice-table pb-4">
                            @if($invoice->invoice_type === 'Diagnosis Invoice')
                                <div class="table-responsive bg-white shadow rounded">
                                    <table class="table mb-0 table-center invoice-tb">
                                        <thead class="bg-light">
                                        <tr>
                                            <th scope="col" class="text-left">#</th>
                                            <th scope="col" class="text-left">Name</th>
                                            <th scope="col" class="text-left">Model Number</th>
                                            <th scope="col" class="text-left">Quantity</th>
                                            <th scope="col" class="text-left">Unit Price</th>
                                            <th scope="col">Total Amount</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <tr>
                                            <td class="text-left">0</td>
                                            <td class="text-left">Service Charge</td>
                                            <td class="text-left"></td>
                                            <td class="text-left">1</td>
                                            <td class="text-left">₦ {{ number_format($invoice['serviceRequest']['service']['service_charge']) }}</td>
                                            <td class="text-left">₦ {{ number_format($invoice['serviceRequest']['service']['service_charge']) }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row pb-4">
                                    <div class="col-lg-4 col-md-5 ml-auto">
                                        <ul class="list-unstyled h5 font-weight-normal mt-4 mb-0">
                                            <li class="text-muted d-flex justify-content-between">Subtotal :<span>₦ {{ number_format($subTotal ,2) }}</span></li>
                                            <li class="text-muted d-flex justify-content-between">FixMaster Royalty :<span> ₦ {{ number_format( $fixmasterRoyalty ,2) }}</span></li>
                                            <li class="text-muted d-flex justify-content-between">Logistics :<span> ₦ {{ number_format( $logistics ,2 ) }}</span></li>
                                            <li class="text-muted d-flex justify-content-between">Taxes :<span> ₦ {{ number_format($tax , 2) }}</span></li>
                                            <li class="d-flex justify-content-between text-danger">Booking :<span> - ₦ {{ number_format($bookingCost, 2) }}</span></li>
                                            <li class="d-flex justify-content-between">Total :<span>₦ {{ number_format($total_cost
    ,2) }}</span></li>
                                        </ul>
                                    </div><!--end col-->
                                </div>
                            @elseif($invoice->invoice_type === 'RFQ Invoice')
                                <div class="table-responsive bg-white shadow rounded">
                                    <table class="table mb-0 table-center invoice-tb">
                                        <thead class="bg-light">
                                        <tr>
                                            <th scope="col" class="text-left">#</th>
                                            <th scope="col" class="text-left">Component Name</th>
                                            <th scope="col" class="text-left">Model Number</th>
                                            <th scope="col" class="text-left">Quantity</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($invoice->rfqs->rfqBatches as $item)
                                            <tr>
                                                <td class="text-left">{{ $loop->iteration }}</td>
                                                <td class="text-left">{{ $item->component_name }}</td>
                                                <td class="text-left">{{ $item->model_number }}</td>
                                                <td class="text-left">{{ $item->quantity }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @elseif ($invoice->invoice_type === 'Supplier Invoice')
                                <div class="table-responsive bg-white shadow rounded">
                                    <table class="table mb-0 table-center invoice-tb">
                                        <thead class="bg-light">
                                        <tr>
                                            <th scope="col" class="text-left">Supplier Name</th>
                                            <th scope="col" class="text-left">Delivery Fee</th>
                                            <th scope="col" class="text-left">Delivery Time</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td class="text-left">{{ $invoice->rfqs->rfqSupplier->name }}</td>
                                            <td class="text-left">₦ {{ number_format($invoice->rfqs->rfqSupplier->devlivery_fee) }}</td>
                                            <td class="text-left">{{ Carbon\Carbon::parse($invoice->rfqs->rfqSupplier->delivery_time, 'UTC')->isoFormat('MMMM Do YYYY') }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="table-responsive bg-white shadow rounded mt-3">
                                    <table class="table mb-0 table-center invoice-tb">
                                        <thead class="bg-light">
                                        <tr>
                                            <th scope="col" class="text-left">#</th>
                                            <th scope="col" class="text-left">Component Name</th>
                                            <th scope="col" class="text-left">Model Number</th>
                                            <th scope="col" class="text-left">Quantity</th>
                                            <th scope="col" class="text-left">Amount</th>
                                            <th scope="col" class="text-left">Total</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($invoice->rfqs->rfqBatches as $item)
                                            <tr>
                                                <td class="text-left">{{ $loop->iteration }}</td>
                                                <td class="text-left">{{ $item->component_name }}</td>
                                                <td class="text-left">{{ $item->model_number }}</td>
                                                <td class="text-left">{{ $item->quantity }}</td>
                                                <td class="text-left">₦ {{ number_format($item->amount) }}</td>
                                                <td class="text-left">₦ {{ number_format($item->quantity * $item->amount) }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-md-5 ml-auto">
                                        <ul class="list-unstyled h5 font-weight-normal mt-4 mb-0">
                                            <li class="d-flex justify-content-between">Total :<span>₦ {{ number_format($invoice->rfqs->total_amount + $invoice->rfqs->rfqSupplier->devlivery_fee) }}</span></li>
                                            {{--                                                                    <li class="text-muted d-flex justify-content-between">Labour Cost :<span> ₦ {{ number_format(3500) }}</span></li>--}}
                                            {{--                                                                    <li class="text-muted d-flex justify-content-between">FixMaster Royalty :<span> ₦ {{ number_format(5000) }}</span></li>--}}
                                            {{--                                                                    <li class="text-muted d-flex justify-content-between">Taxes :<span> ₦ {{ number_format(253) }}</span></li>--}}
                                            {{--                                                                    <li class="text-muted d-flex justify-content-between">Warranty Cost :<span> ₦ {{ number_format(1500) }}</span></li>--}}
                                            {{--                                                                    <li class="d-flex justify-content-between">Total :<span>₦ {{ number_format($invoice->rfqs->total_amount + 3500 + 5000 + 253 + 1500) }}</span></li>--}}
                                        </ul>
                                    </div><!--end col-->
                                </div>
                            @elseif ($invoice->invoice_type === 'Completion Invoice')
                                @if($invoice->rfq_id != null)
                                    <div class="table-responsive bg-white shadow rounded">
                                        <table class="table mb-0 table-center invoice-tb">
                                            <thead class="bg-light">
                                            <tr>
                                                <th scope="col" class="text-left">#</th>
                                                <th scope="col" class="text-left">Component Name</th>
                                                <th scope="col" class="text-left">Model Number</th>
                                                <th scope="col" class="text-left">Quantity</th>
                                                <th scope="col" class="text-left">Amount</th>
                                                <th scope="col" class="text-left">Total</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($invoice->rfqs->rfqBatches as $item)
                                                <tr>
                                                    <td class="text-left">{{ $loop->iteration }}</td>
                                                    <td class="text-left">{{ $item->component_name }}</td>
                                                    <td class="text-left">{{ $item->model_number }}</td>
                                                    <td class="text-left">{{ $item->quantity }}</td>
                                                    <td class="text-left">₦ {{ number_format($item->amount) }}</td>
                                                    <td class="text-left">₦ {{ number_format($item->quantity * $item->amount) }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif

                                <div class="table-responsive bg-white shadow rounded mt-3">
                                    <table class="table mb-0 table-center invoice-tb">
                                        <thead class="bg-light">
                                        <tr>
                                            <th scope="col" class="text-left" colspan="2">Labour Cost</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td class="text-left">Hours worked</td>
                                            <td class="text-left">{{$invoice['hours_spent']}} {{ $invoice['hours_spent']>1 ? 'hrs' : 'hr' }} </td>
                                        </tr>
                                        <tr>
                                            <td class="text-left">Labor</td>
                                            <td class="text-left">
                                                ₦ {{ number_format($invoice['labour_cost']) }}
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>


                                <div class="row">
                                    <div class="col-lg-4 col-md-5 ml-auto">
                                        <ul class="list-unstyled h5 font-weight-normal mt-4 mb-0">
                                            <li class="test-muted d-flex justify-content-between">Subtotal :<span>₦ {{ number_format($invoice['materials_cost'] + $invoice['labour_cost']) }}</span></li>
                                            <li class="text-muted d-flex justify-content-between">
                                                FixMaster Royalty :
                                                @if($get_fixMaster_royalty['amount'] == null)
                                                    <span> ₦ {{ number_format( $fixmaster_royalty ) }}</span>
                                                @endif
                                            </li>
                                            <li class="text-muted d-flex justify-content-between">Warranty Cost :<span> ₦ {{ number_format($warranty) }}</span></li>
                                            <li class="text-muted d-flex justify-content-between">Logistics :<span> ₦ {{ number_format($logistics) }}</span></li>
                                            <li class="d-flex justify-content-between text-danger">Booking :<span> - ₦ {{ number_format($invoice->serviceRequest->price->amount) }}</span></li>
                                            <li class="d-flex justify-content-between text-danger">Discount :<span> - ₦ {{ number_format( 0.5 * $logistics ) }}</span></li>
                                            <li class="text-muted d-flex justify-content-between">Taxes :<span> ₦ {{ number_format($taxes) }}</span></li>
                                            <li class="d-flex justify-content-between">Total :<span>₦ {{ number_format( $total_cost ) }}</span></li>
                                        </ul>
                                    </div><!--end col-->
                                </div>
                            @endif

                        </div>

                        <div class="invoice-footer border-top pt-4">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="text-sm-left text-muted text-center">
                                        <h6 class="mb-0">Customer Service : <a href="tel:08132863878" class="text-warning">(+234) 0813-286-3878</a></h6>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="text-sm-right text-muted text-center">
                                        <h6 class="mb-0">&copy {{ date('Y') }} FixMaster. All Rights Reserved. </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--end col-->
        </div><!--end row-->
    </div><!--end container-->
</section>

@if($invoice['invoice_type'] === 'Completion Invoice' && $invoice['phase'] === '1')
    <section class="bg-invoice">
        <div class="container">
            <div class="row mt-5 pt-4 pt-sm-0 justify-content-center">
                <div class="col-lg-10">
                    <div class="card shadow rounded border-0">
                        <div class="card-body">
                            <div class="invoice-top pb-4 border-bottom">
                                <div class="row">
                                    <div class="col-md-8">
                                        <img src="{{ asset('assets/images/home-fix-logo-colored.png') }}" class="l-dark" style="margin-top: -38px !important;" height="140" alt="FixMaster Logo">
                                        <a href="" class="text-primary h6"><i data-feather="link" class="fea icon-sm text-muted mr-2"></i>www.fixmaster.com.ng</a>


                                    </div><!--end col-->

                                    <div class="col-md-4 mt-4 mt-sm-0">
                                        <h5>Address :</h5>
                                        <dl class="row mb-0">
                                            <dt class="col-2 text-muted"><i data-feather="map-pin" class="fea icon-sm"></i></dt>
                                            <dd class="col-10 text-muted">
                                                <a href="#" class="video-play-icon text-muted">
                                                    <p class="mb-0">284 Ajose Adeogun Street, Victoria Island,</p>
                                                    <p class="mb-0">Lagos, Nigeria</p>
                                                </a>
                                            </dd>

                                            <dt class="col-2 text-muted"><i data-feather="mail" class="fea icon-sm"></i></dt>
                                            <dd class="col-10 text-muted">
                                                <a href="mailto:info@fixmaster.com.ng" class="text-muted">info@fixmaster.com.ng</a>
                                            </dd>

                                            <dt class="col-2 text-muted"><i data-feather="phone" class="fea icon-sm"></i></dt>
                                            <dd class="col-10 text-muted">
                                                <a href="tel:+152534-468-854" class="text-muted">(+234) 0813-286-3878</a>
                                            </dd>
                                        </dl>
                                    </div><!--end col-->
                                </div><!--end row-->
                            </div>

                            <div class="invoice-middle py-4">
                                <h5>Invoice Details :</h5>
                                <div class="row mb-0">
                                    <div class="col-md-8 order-2 order-md-1">
                                        <dl class="row">
                                            <dt class="col-md-3 col-5 font-weight-normal">Invoice No. :</dt>
                                            <dd class="col-md-9 col-7 text-muted">{{ $invoice['unique_id'] }}</dd>

                                            <dt class="col-md-3 col-5 font-weight-normal">Name :</dt>
                                            <dd class="col-md-9 col-7 text-muted">{{ $invoice['client']->account->first_name }} {{ $invoice['client']->account->last_name }}</dd>

                                            <dt class="col-md-3 col-5 font-weight-normal">Address :</dt>
                                            <dd class="col-md-9 col-7 text-muted">
                                                <p class="mb-0">{{ $invoice['client']['contact']['address'] }}</p>
                                            </dd>

                                            <dt class="col-md-3 col-5 font-weight-normal">Phone :</dt>
                                            <dd class="col-md-9 col-7 text-muted">{{ $invoice['client']['contact']['phone_number'] }}</dd>
                                        </dl>
                                    </div>

                                    <div class="col-md-4 order-md-2 order-1 mt-2 mt-sm-0">
                                        <dl class="row mb-0">
                                            <dt class="col-md-4 col-5 font-weight-normal">Date :</dt>
                                            <dd class="col-md-8 col-7 text-muted">{{ Carbon\Carbon::parse($invoice['created_at'], 'UTC')->isoFormat('MMMM Do, YYYY') }}</dd>
                                        </dl>
                                        <dl class="row mb-0">
                                            <dt class="col-md-4 col-5 font-weight-normal">Type :</dt>
                                            <dd class="col-md-8 col-7 text-muted">{{ $invoice->invoice_type }}</dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>

                            <div class="invoice-table pb-4">
                                @if($invoice->invoice_type === 'Completion Invoice')
                                    @if($invoice->rfq_id != null)
                                        <div class="table-responsive bg-white shadow rounded">
                                            <table class="table mb-0 table-center invoice-tb">
                                                <thead class="bg-light">
                                                <tr>
                                                    <th scope="col" class="text-left">#</th>
                                                    <th scope="col" class="text-left">Component Name</th>
                                                    <th scope="col" class="text-left">Model Number</th>
                                                    <th scope="col" class="text-left">Quantity</th>
                                                    <th scope="col" class="text-left">Amount</th>
                                                    <th scope="col" class="text-left">Total</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($invoice->rfqs->rfqBatches as $item)
                                                    <tr>
                                                        <td class="text-left">{{ $loop->iteration }}</td>
                                                        <td class="text-left">{{ $item->component_name }}</td>
                                                        <td class="text-left">{{ $item->model_number }}</td>
                                                        <td class="text-left">{{ $item->quantity }}</td>
                                                        <td class="text-left">₦ {{ number_format($item->amount) }}</td>
                                                        <td class="text-left">₦ {{ number_format($item->quantity * $item->amount) }}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif

                                    <div class="table-responsive bg-white shadow rounded mt-3">
                                        <table class="table mb-0 table-center invoice-tb">
                                            <thead class="bg-light">
                                            <tr>
                                                <th scope="col" class="text-left" colspan="2">Labour Cost</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td class="text-left">Hours worked</td>
                                                <td class="text-left">{{$invoice['hours_spent']}} {{ $invoice['hours_spent']>1 ? 'hrs' : 'hr' }} </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Labor</td>
                                                <td class="text-left">
                                                    ₦ {{ number_format($invoice['labour_cost']) }}
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>


                                    <div class="row">
                                        <div class="col-lg-4 col-md-5 ml-auto">
                                            <ul class="list-unstyled h5 font-weight-normal mt-4 mb-0">
                                                <li class="test-muted d-flex justify-content-between">Subtotal :<span>₦ {{ number_format($invoice['materials_cost'] + $invoice['labour_cost']) }}</span></li>
                                                <li class="text-muted d-flex justify-content-between">
                                                    FixMaster Royalty :
                                                    @if($get_fixMaster_royalty['amount'] == null)
                                                        <span> ₦ {{ number_format( $fixmaster_royalty ) }}</span>
                                                    @endif
                                                </li>
                                                <li class="text-muted d-flex justify-content-between">Warranty Cost :<span> ₦ {{ number_format($warranty) }}</span></li>
                                                <li class="text-muted d-flex justify-content-between">Logistics :<span> ₦ {{ number_format($logistics) }}</span></li>
                                                <li class="d-flex justify-content-between text-danger">Booking :<span> - ₦ {{ number_format($invoice->serviceRequest->price->amount) }}</span></li>
                                                <li class="d-flex justify-content-between text-danger">Discount :<span> - ₦ {{ number_format( 0.5 * $logistics ) }}</span></li>
                                                <li class="text-muted d-flex justify-content-between">Taxes :<span> ₦ {{ number_format($taxes) }}</span></li>
                                                <li class="d-flex justify-content-between">Total :<span>₦ {{ number_format( $total_cost ) }}</span></li>
                                            </ul>
                                        </div><!--end col-->
                                    </div>
                                @endif

                            </div>

                            <form method="POST" action="">
                                @csrf
                                {{-- REQUIREMENTS FOR PAYMENT GATWAYS  --}}
                                <input type="hidden" class="d-none" value="" id="email" name="email">
                                <input type="hidden" class="d-none" value="" id="client_discount" name="client_discount">
                                <input type="hidden" class="d-none" value="" id="client_phone_number" name="client_phone_number">

                                {{-- Values are to be provided by the payment gateway using jQuery or Vanilla JS --}}
                                <input type="hidden" class="d-none" value="" id="payment_response_message" name="payment_response_message">
                                <input type="hidden" class="d-none" value="" id="payment_reference" name="payment_reference">

                                <input type="hidden" class="d-none" value="" id="serviceFee" name="service_fee">


                                <input type="hidden" class="d-none" value="" id="service_request_id" name="service_request_id">

                                <input type="hidden" class="d-none" value="" id="rfq_id" name="rfq_id">

                                <input type="hidden" class="d-none" value="" id="invoice" name="invoice">

                                <button type="submit" class="submitBnt btn btn-primary d-none">Submit</button>


                            </form>

                            <div class="invoice-footer border-top pt-4">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="text-sm-left text-muted text-center">
                                            <h6 class="mb-0">Customer Service : <a href="tel:08132863878" class="text-warning">(+234) 0813-286-3878</a></h6>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="text-sm-right text-muted text-center">
                                            <h6 class="mb-0">&copy {{ date('Y') }} FixMaster. All Rights Reserved. </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--end col-->
            </div><!--end row-->
        </div><!--end container-->
    </section>
@endif

@if($invoice->invoice_type === 'Diagnosis Invoice' && $invoice['phase'] == '1')
<section class="bg-invoice">
    <div class="container">
        <div class="row mt-5 pt-4 pt-sm-0 justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow rounded border-0">
                    <div class="card-body" style="border: 0.5px solid grey">
                        <div class="invoice-top pb-4 border-bottom">
                            <div class="row">
                                <div class="col-md-8">
                                    <img src="{{ asset('assets/images/home-fix-logo-colored.png') }}" class="l-dark" style="margin-top: 10px !important;" height="80" alt="FixMaster Logo">

                                    <div class="logo-invoice mb-2">
                                        @if($invoice->status == 1 && $invoice['invoice_type'] == 'Completion Invoice')
                                            <span class="text-primary"> Pending Payment</span><br>
                                            <button type="button" onclick="payWithPaystack()" id="paystack_option"  class="btn btn-success">PAY </button>
                                        @elseif($invoice->status == 2 && $invoice['invoice_type'] == 'Completion Invoice')
                                            <span class="text-success">Paid</span><br>
                                        @endif
                                    </div>

                                    <a href="" class="text-primary h6"><i data-feather="link" class="fea icon-sm text-muted mr-2"></i>www.fixmaster.com.ng</a>


                                </div><!--end col-->

                                <div class="col-md-4 mt-4 mt-sm-0">
                                    <h5>Address :</h5>
                                    <dl class="row mb-0">
                                        <dt class="col-2 text-muted"><i data-feather="map-pin" class="fea icon-sm"></i></dt>
                                        <dd class="col-10 text-muted">
                                            <a href="#" class="video-play-icon text-muted">
                                                <p class="mb-0">284 Ajose Adeogun Street, Victoria Island,</p>
                                                <p class="mb-0">Lagos, Nigeria</p>
                                            </a>
                                        </dd>

                                        <dt class="col-2 text-muted"><i data-feather="mail" class="fea icon-sm"></i></dt>
                                        <dd class="col-10 text-muted">
                                            <a href="mailto:info@fixmaster.com.ng" class="text-muted">info@fixmaster.com.ng</a>
                                        </dd>

                                        <dt class="col-2 text-muted"><i data-feather="phone" class="fea icon-sm"></i></dt>
                                        <dd class="col-10 text-muted">
                                            <a href="tel:+152534-468-854" class="text-muted">(+234) 0813-286-3878</a>
                                        </dd>
                                    </dl>
                                </div><!--end col-->
                            </div><!--end row-->
                            <div class="d-flex justify-content-center">
                                <h2 style="border: 2px solid grey; padding: 5px">Estimated Final Invoice</h2>
                            </div>
                        </div>

                        <div class="invoice-middle py-4">
                            <h5>Invoice Details :</h5>
                            <div class="row mb-0">
                                <div class="col-md-8 order-2 order-md-1">
                                    <dl class="row">
                                        <dt class="col-md-3 col-5 font-weight-normal">Invoice No. :</dt>
                                        <dd class="col-md-9 col-7 text-muted">{{ $invoice['unique_id'] }}</dd>

                                        <dt class="col-md-3 col-5 font-weight-normal">Name :</dt>
                                        <dd class="col-md-9 col-7 text-muted">{{ $invoice['client']->account->first_name }} {{ $invoice['client']->account->last_name }}</dd>

                                        <dt class="col-md-3 col-5 font-weight-normal">Address :</dt>
                                        <dd class="col-md-9 col-7 text-muted">
                                            <p class="mb-0">{{ $invoice['client']['contact']['address'] }}</p>
                                        </dd>

                                        <dt class="col-md-3 col-5 font-weight-normal">Phone :</dt>
                                        <dd class="col-md-9 col-7 text-muted">{{ $invoice['client']['contact']['phone_number'] }}</dd>
                                    </dl>
                                </div>

                                <div class="col-md-4 order-md-2 order-1 mt-2 mt-sm-0">
                                    <dl class="row mb-0">
                                        <dt class="col-md-4 col-5 font-weight-normal">Date :</dt>
                                        <dd class="col-md-8 col-7 text-muted">{{ Carbon\Carbon::parse($invoice['created_at'], 'UTC')->isoFormat('MMMM Do, YYYY') }}</dd>
                                    </dl>
                                    <dl class="row mb-0">
                                        <dt class="col-md-4 col-5 font-weight-normal">Type :</dt>
                                        <dd class="col-md-8 col-7 text-muted">Estimated Final Invoice</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>

                        <div class="invoice-table pb-4">
                                @if($rfqExists)
                                <div class="table-responsive bg-white shadow rounded">
                                    <table class="table mb-0 table-center invoice-tb">
                                        <thead class="bg-light">
                                        <tr>
                                            <th scope="col" class="text-left">#</th>
                                            <th scope="col" class="text-left">Name</th>
                                            <th scope="col" class="text-left">Model Number</th>
                                            <th scope="col" class="text-left">Quantity</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                            @foreach($invoice->rfqs->rfqBatches as $item)
                                                <tr>
                                                    <td class="text-left">{{ $loop->iteration }}</td>
                                                    <td class="text-left">{{ $item->component_name }}</td>
                                                    <td class="text-left">{{ $item->model_number }}</td>
                                                    <td class="text-left">{{ $item->quantity }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @endif
                                <div class="table-responsive bg-white shadow rounded mt-3">
                                    <table class="table mb-0 table-center invoice-tb">
                                        <thead class="bg-light">
                                        <tr>
                                            <th scope="col" class="text-left" colspan="2">Labour Cost</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td class="text-left">Hours worked</td>
                                            <td class="text-left">{{$invoice['hours_spent']}} {{ $invoice['hours_spent']>1 ? 'hrs' : 'hr' }} </td>
                                        </tr>
                                        <tr>
                                            <td class="text-left">Labor</td>
                                            <td class="text-left">
                                                ₦ {{ number_format($invoice['labour_cost']) }}
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row pb-4">
                                    <div class="col-lg-4 col-md-5 ml-auto">
                                        <ul class="list-unstyled h5 font-weight-normal mt-4 mb-0">
                                            <li class="test-muted d-flex justify-content-between">Subtotal :<span>₦ {{ number_format($invoice['materials_cost'] + $invoice['labour_cost'] ,2) }}</span></li>
                                            <li class="text-muted d-flex justify-content-between">
                                                FixMaster Royalty :
                                                @if($get_fixMaster_royalty['amount'] == null)
                                                    <span> ₦ {{ number_format( $fixmaster_royalty_value * (($invoice['materials_cost'] + $invoice['labour_cost'])) ,2) }}</span>
                                                @endif
                                            </li>
                                            <li class="text-muted d-flex justify-content-between">Warranty Cost :<span> ₦ {{ number_format($warranty * ($invoice['materials_cost'] + $invoice['labour_cost']) ,2) }}</span></li>
                                            <li class="text-muted d-flex justify-content-between">Logistics :<span> ₦ {{ number_format($logistics ,2) }}</span></li>
                                            <li class="text-muted d-flex justify-content-between">Taxes :<span> ₦ {{ number_format($tax ,2) }}</span></li>
                                            <li class="d-flex justify-content-between text-danger">Booking :<span> - ₦ {{ number_format($invoice->serviceRequest->price->amount,2) }}</span></li>
                                            <li class="d-flex justify-content-between text-danger">Discount :<span> - ₦ {{ number_format( 0.5 * $logistics ,2) }}</span></li>
                                            <li class="d-flex justify-content-between">Total :<span>₦ {{ number_format(
    ($invoice['materials_cost'] + $invoice['labour_cost']) + ( $fixmaster_royalty_value * (($invoice['materials_cost'] + $invoice['labour_cost'])) ) +
    ($warranty) + ($logistics) - ($invoice->serviceRequest->price->amount) - ( 0.5 * $logistics ) +
    ($tax)
 ,2) }}</span></li>
                                        </ul>
                                    </div><!--end col-->
                                </div>
                        </div>

                        <form method="POST" action="">
                            @csrf
                            {{-- REQUIREMENTS FOR PAYMENT GATWAYS  --}}
                            <input type="hidden" class="d-none" value="" id="email" name="email">
                            <input type="hidden" class="d-none" value="" id="client_discount" name="client_discount">
                            <input type="hidden" class="d-none" value="" id="client_phone_number" name="client_phone_number">

                            {{-- Values are to be provided by the payment gateway using jQuery or Vanilla JS --}}
                            <input type="hidden" class="d-none" value="" id="payment_response_message" name="payment_response_message">
                            <input type="hidden" class="d-none" value="" id="payment_reference" name="payment_reference">

                            <input type="hidden" class="d-none" value="" id="serviceFee" name="service_fee">


                            <input type="hidden" class="d-none" value="" id="service_request_id" name="service_request_id">

                            <input type="hidden" class="d-none" value="" id="rfq_id" name="rfq_id">

                            <input type="hidden" class="d-none" value="" id="invoice" name="invoice">

                            <button type="submit" class="submitBnt btn btn-primary d-none">Submit</button>


                        </form>

                        <div class="invoice-footer border-top pt-4">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="text-sm-left text-muted text-center">
                                        <h6 class="mb-0">Customer Service : <a href="tel:08132863878" class="text-warning">(+234) 0813-286-3878</a></h6>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="text-sm-right text-muted text-center">
                                        <h6 class="mb-0">&copy {{ date('Y') }} FixMaster. All Rights Reserved. </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--end col-->
        </div><!--end row-->
    </div><!--end container-->
</section>
@if(auth()->user()->type->role->url == 'client')
<div class="row justify-content-center border-top mt-4" style="margin-bottom: 50px; padding-top: 0">
    <div class="col-lg-8 col-md-12 mt-4 mb-4 pt-2 text-center">
        <div><h3>Proceed with Service</h3></div>
        <div>
            <form method="POST" action="{{ route('client.decision', app()->getLocale()) }}">
                @csrf
                <input type="hidden" name="request_id" value="{{ $serviceRequestID }}">
                <input type="hidden" name="invoice_id" value="{{ $invoice['id'] }}">
                <input type="hidden" name="request_uuid" value="{{ $serviceRequestUUID }}">
                <button class="btn btn-outline-primary" name="client_choice" value="accepted">Client Accept</button>
                <button class="btn btn-outline-primary" name="client_choice" value="declined">Client Decline</button>
            </form>
        </div>
    </div>
</div>
@else
    <div class="row justify-content-center border-top">
        <div class="col-lg-8 col-md-12 mt-4 mb-4 pt-2 text-center">
            <div>
                <a href="{{ route('cse.requests.show', [app()->getLocale(), $serviceRequestUUID]) }}" class="btn btn-outline-primary">Go Back</a>
            </div>
        </div>
    </div>
@endif
@endif
</body>


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
