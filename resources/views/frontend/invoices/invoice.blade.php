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
    <link href="{{ asset('assets/client/css/magnific-popup.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/client/css/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
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
<section class="bg-invoice mb-5">
    <div class="container">
        <div class="row mt-5 pt-4 pt-sm-0 justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow rounded border-0">
                    <div class="card-body">
                        <div class="invoice-top pb-4 border-bottom">
                            <div class="row">
                                <div class="col-md-8">
                                    <img src="{{ asset('assets/images/home-fix-logo-colored.png') }}" class="l-dark" style="margin-top: 10px !important;" height="80" alt="FixMaster Logo">
                                    <div class="logo-invoice mb-2">
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
                            @if($invoice['status'] === '2' && $invoice['phase'] == '2')
                            <div class="d-flex justify-content-start">
                                <h3 style="border: 2px solid red; padding: 5px; color: red;">PAID</h3>
                            </div>
                            @endif
                            <div class="d-flex justify-content-center">
                                <h2 style="border: 2px solid grey; padding: 5px">{{$invoice['invoice_type']}}</h2>
                            </div>
                        </div>

                        <div class="invoice-middle py-4">
                            <div class="row mb-0">
                                <div class="col-md-6 order-md-1">
                                    <dl class="row mb-0">
                                        <dt class="col-md-4 col-5 font-weight-normal">Report To. :</dt>
                                        <dd class="col-md-8 col-7 text-muted">{{ $invoice['client']->account->first_name }} {{ $invoice['client']->account->last_name }}</dd>

                                        <dt class="col-md-4 col-5 font-weight-normal">Customer No. :</dt>
                                        <dd class="col-md-8 col-7 text-muted">{{ $invoice['client']['contact']['phone_number'] }}</dd>

                                        <dt class="col-md-4 col-5 font-weight-normal">Customer Email :</dt>
                                        <dd class="col-md-8 col-7 text-muted">{{ $invoice['client']['email'] }}</dd>

                                        <dt class="col-md-4 col-5 font-weight-normal">Service Location :</dt>
                                        <dd class="col-md-8 col-7 text-muted">{{ $invoice['client']['contact']['address'] }}</dd>
                                    </dl>
                                </div>

                                <div class="col-md-6 order-md-2 mt-2">
                                    <dl class="row mb-0">
                                        <dt class="col-md-6 col-5 font-weight-normal">Order No. :</dt>
                                        <dd class="col-md-6 col-7 text-muted">{{ $invoice['unique_id'] }}</dd>
                                    </dl>
                                    <dl class="row mb-0">
                                        <dt class="col-md-6 col-5 font-weight-normal">Order Date. :</dt>
                                        <dd class="col-md-6 col-7 text-muted">{{ Carbon\Carbon::parse($invoice['serviceRequest']['created_at'], 'UTC')->isoFormat('MMMM Do, YYYY') }}</dd>
                                    </dl>
                                    <dl class="row mb-0">
                                        <dt class="col-md-6 col-5 font-weight-normal">Assigned CSE. :</dt>
                                        <dd class="col-md-6 col-7 text-muted">{{ $invoice['serviceRequest']['service_request_assignee']['user']['account']['first_name'].' '. $invoice['serviceRequest']['service_request_assignee']['user']['account']['last_name'] }}</dd>
                                    </dl>
                                    <dl class="row mb-0">
                                        <dt class="col-md-6 col-5 font-weight-normal">Visit Date. :</dt>
                                        <dd class="col-md-6 col-7 text-muted">Friday 10th May, 2021</dd>
                                    </dl>
                                    <dl class="row mb-0">
                                        <dt class="col-md-6 col-5 font-weight-normal">Report Issuance Date :</dt>
                                        <dd class="col-md-6 col-7 text-muted">Monday 10th May, 2021</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>

                        <div class="py-3">
                            <span class="font-weight-bold text-uppercase">Invoice Details :</span>

                            <div class="mt-5">
                            <h5 class="font-weight-bold text-uppercase">Electricity: </h5>
                            <div class="card shadow rounded">
                                <div class="card-body">
                                    <h5 class="card-title">Root Cause: </h5>
                                    <p class="card-text">Sit tempora ut magnam quisquam sed eius magnam. Aliquam sed quiquia quaerat ipsum tempora. Ipsum dolore quaerat ut. Dolorem non numquam ut tempora modi non porro. Aliquam ut quaerat neque quiquia non sed. Quaerat est magnam magnam quisquam sit ut dolorem. Amet porro quiquia neque est quiquia porro. Sit porro adipisci quaerat sit. Amet aliquam porro dolorem labore dolorem. Dolor amet ut quiquia dolor quiquia. Tempora velit aliquam tempora dolore etincidunt magnam dolorem. Tempora sed quaerat quisquam dolore est. Dolorem dolor numquam dolor voluptatem. Dolorem sit neque labore. Dolorem neque adipisci magnam dolor. Tempora adipisci amet voluptatem porro labore consectetur. Quiquia est non dolore dolorem adipisci amet non. Numquam neque ut sed. Voluptatem non amet etincidunt adipisci aliquam sit velit. Neque quisquam amet eius tempora. Ut dolorem neque adipisci consectetur. Etincidunt numquam tempora dolor dolor. Etincidunt consectetur aliquam est. Adipisci sed modi neque ut dolor sed.</p>
                                </div>
                            </div>
                            </div>
                            <div class="my-3">
                            <h5 class="font-weight-bold text-uppercase">Plumbing: </h5>
                            <div class="card shadow rounded">
                                <div class="card-body">
                                    <h5 class="card-title">Root Cause: </h5>
                                    <p class="card-text">Sit tempora ut magnam quisquam sed eius magnam. Aliquam sed quiquia quaerat ipsum tempora. Ipsum dolore quaerat ut. Dolorem non numquam ut tempora modi non porro. Aliquam ut quaerat neque quiquia non sed. Quaerat est magnam magnam quisquam sit ut dolorem. Amet porro quiquia neque est quiquia porro. Sit porro adipisci quaerat sit. Amet aliquam porro dolorem labore dolorem. Dolor amet ut quiquia dolor quiquia. Tempora velit aliquam tempora dolore etincidunt magnam dolorem. Tempora sed quaerat quisquam dolore est. Dolorem dolor numquam dolor voluptatem. Dolorem sit neque labore. Dolorem neque adipisci magnam dolor. Tempora adipisci amet voluptatem porro labore consectetur. Quiquia est non dolore dolorem adipisci amet non. Numquam neque ut sed. Voluptatem non amet etincidunt adipisci aliquam sit velit. Neque quisquam amet eius tempora. Ut dolorem neque adipisci consectetur. Etincidunt numquam tempora dolor dolor. Etincidunt consectetur aliquam est. Adipisci sed modi neque ut dolor sed.</p>
                                </div>
                            </div>
                            </div>

                        </div>

                        <div class="py-3">
                            <span class="font-weight-bold text-uppercase">Quotation  Schedule:</span>
                        </div>
                        @if($invoice['invoice_type'] === 'Final Invoice')
                            <div class="table-responsive bg-white shadow rounded">
                                <table class="table mb-0 table-center invoice-tb">
                                    <thead class="bg-light">
                                    <tr>
                                        <th scope="col" class="text-left">S/N</th>
                                        <th scope="col" class="text-left">Materials</th>
                                        <th scope="col" class="text-left">Quantity</th>
                                        <th scope="col" class="text-left">Unit of Measurement</th>
                                        <th scope="col" class="text-left">Unit Price</th>
                                        <th scope="col" class="text-left">Total Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($invoice['rfqs']['rfqBatches'] as $item)
                                        <tr>
                                            <td class="text-left">{{ $loop->iteration }}</td>
                                            <td class="text-left">{{ $item->component_name }}</td>
                                            <td class="text-left">{{ $item->quantity }}</td>
                                            <td class="text-left">{{ $item->unit_of_measurement }}</td>
                                            <td class="text-left">{{ $item->amount }}</td>
                                            <td class="text-left">{{ $item->quantity* $item->amount }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>


                                <div class="table-responsive bg-white shadow rounded mt-4">
                                    <table class="table mb-0 table-center invoice-tb">
                                        <thead class="bg-light">
                                        <tr>
                                            <th scope="col" class="text-left">S/N</th>
                                            <th scope="col" class="text-left">Labour</th>
                                            <th scope="col" class="text-left">Total Price</th>
                                            <th scope="col" class="text-left">Sub Totals</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td class="text-left">1</td>
                                            <td class="text-left">Activity 1</td>
                                            <td class="text-left">₦ 2000</td>
                                            <td class="text-left"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-left">2</td>
                                            <td class="text-left">Activity 2</td>
                                            <td class="text-left">₦ 2000</td>
                                            <td class="text-left">₦ 4000</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                        @elseif($invoice['invoice_type'] === 'Diagnosis Invoice')
                            <div class="table-responsive bg-white shadow rounded mt-4">
                                <table class="table mb-0 table-center invoice-tb">
                                    <thead class="bg-light">
                                    <tr>
                                        <th scope="col" class="text-left">S/N</th>
                                        <th scope="col" class="text-left">Name</th>
                                        <th scope="col" class="text-left">Total Price</th>
                                        <th scope="col" class="text-left">Sub Totals</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="text-left">1</td>
                                        <td class="text-left">Service Charge</td>
                                        <td class="text-left">₦ {{ number_format($invoice['serviceRequest']['service']['service_charge']) }}</td>
                                        <td class="text-left">₦ {{ number_format($invoice['serviceRequest']['service']['service_charge']) }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        @endif

                            <div class="row my-4">
                                <div class="col-lg-6 col-md-6 ml-auto">
                                    <ul class="list-unstyled h5 font-weight-normal mt-4 mb-0">
                                        {!!
    $invoice['invoice_type'] == 'Final Invoice'
    ?
    "
    <li class='test-muted d-flex justify-content-between'>Subtotal :<span>₦". number_format($invoice['rfqs']['total_amount']+4000, 2) ."</span></li>
    <li class='test-muted d-flex justify-content-between'>Logistics :<span>₦".  number_format($logistics, 2) ."</span></li>
    <li class='text-muted d-flex justify-content-between'>FixMaster Royalty :<span>₦". number_format($fixmasterRoyalty, 2)."</span></li>
    <li class='text-muted d-flex justify-content-between mt-2'>Discounts :</li>
    <li class='d-flex justify-content-between text-danger mb-2'>First Booking Discount :<span> - ₦ 1,500.00</span></li>
    <li class='text-muted d-flex justify-content-between'>Total Job Quotation :<span> ₦ ".number_format(($invoice['rfqs']['total_amount']+4000) + $logistics + $fixmasterRoyalty - 1500, 2)." </span></li>
    <li class='d-flex justify-content-between text-danger'>Less Booking Fee :<span> - ₦ 1,500.00</span></li>
    <li class='d-flex justify-content-between mt-2'>Total Amount Due :<span>₦ ".number_format(($invoice['rfqs']['total_amount']+4000) + $logistics + $fixmasterRoyalty - 1500 - 1500, 2)."</span></li>
    "
    :
    "
    <li class='test-muted d-flex justify-content-between'>Subtotal :<span>₦ ". number_format($subTotal, 2) ."</span></li>
    <li class='test-muted d-flex justify-content-between'>Logistics :<span>₦ ". number_format($logistics, 2) ."</span></li>
    <li class='text-muted d-flex justify-content-between'>FixMaster Royalty :<span>₦ ". number_format($fixmasterRoyalty, 2)."</span></li>
    <li class='text-muted d-flex justify-content-between'>Taxes :<span> ₦ ". number_format($tax, 2)."</span></li>
    <li class='d-flex justify-content-between text-danger'>Less Booking Fee :<span> - ₦ 1,500.00</span></li>
    <li class='d-flex justify-content-between'>Total Amount Due :<span>₦ ". number_format($subTotal + $logistics + $fixmasterRoyalty + $tax - 1500, 2)."</span></li>
    "
    !!}

                                    </ul>
                                </div><!--end col-->
                            </div>
                    </div>

                    <div class="d-flex justify-content-center py-3">
                        @if($invoice->status == '1' && $invoice['phase'] == '1')
                        <div id="client-decision">
                            <input id="decision-route" type="hidden" name="route" value="{{ route('client.decline', app()->getLocale()) }}">
                            <input id="client-accept" type="hidden" name="route" value="{{ route('client.accept', app()->getLocale()) }}">
                            <input id="invoice_uuid" type="hidden" name="invoiceUUID" value="{{ $invoice['uuid'] }}">
                            <button class="btn btn-outline-primary" id="client_accept" name="client_choice">Client Accept</button>
                            <button class="btn btn-outline-primary" id="client_decline" name="client_choice">Client Decline</button>
                            <div id="msg"></div>
                        </div>
                        @elseif($invoice->status == '1' && $invoice['phase'] == '2')
                            @if($invoice['invoice_type'] === 'Diagnosis Invoice')
                                <input id="invoice_uuid" type="hidden" name="invoiceUUID" value="{{ $invoice['uuid'] }}">
                                <input id="client-return" type="hidden" name="route" value="{{ route('client.return', app()->getLocale()) }}">
                                <button id="return-btn" href="{{route('client.service.all', app()->getLocale())}}" class="btn btn-outline-primary mr-2">Go Back</button>
                            @endif
                            <form method="POST" action="{{ route('client.invoice.payment', app()->getLocale()) }}">
                                @csrf
                                {{-- REQUIREMENTS FOR PAYMENT GATWAYS  --}}
                                <input type="hidden" class="d-none" value={{ $total_cost }} name="booking_fee">

                                <input type="hidden" class="d-none" value="paystack" id="payment_channel" name="payment_channel">

                                <input type="hidden" class="d-none" value="{{ $invoice['unique_id'] }}" id="unique_id" name="unique_id">

                                <input type="hidden" class="d-none" value="{{ $invoice['invoice_type'] }}" id="invoice_type" name="invoice_type">

                                <input type="hidden" class="d-none" value="{{ $invoice['uuid'] }}" id="uuid" name="uuid">

                                <button type="submit" id="paystack_option"  class="btn btn-outline-success">Pay with paystack</button>
                            </form>
                                <form method="POST" action="{{ route('flutterwave-submit', app()->getLocale()) }}">
                                    @csrf
                                    {{-- REQUIREMENTS FOR PAYMENT GATWAYS  --}}
                                    <input type="hidden" class="d-none" value="{{ $total_cost }}" name="booking_fee">

                                    <input type="hidden" class="d-none" value="flutterwave" id="payment_channel" name="payment_channel">

                                    <input type="hidden" class="d-none" value="service-request" id="payment_for" name="payment_for">

                                    <input type="hidden" class="d-none" value="{{ $invoice['unique_id'] }}" id="unique_id" name="unique_id">

                                    <input type="hidden" class="d-none" value="{{ $invoice['invoice_type'] }}" id="invoice_type" name="invoice_type">

                                    <input type="hidden" class="d-none" value="{{ $invoice['uuid'] }}" id="uuid" name="uuid">

                                    <button type="submit" id="flutterwave_option"  class="btn btn-outline-success">Pay with flutterwave</button>
                                </form>
                            @elseif($invoice['status'] === '2' && $invoice['phase'] == '2')
                            <a href="{{route('client.service.all', app()->getLocale())}}" class="btn btn-outline-primary">Go Back</a>
                        @endif
                    </div>

                    <div class="invoice-footer border-top py-3 px-3">
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

<script src="{{ asset('assets/dashboard/lib/jquery/jquery.min.js') }}"></script>
<script src="{{asset('assets/frontend/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/jquery.easing.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/scrollspy.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/owl.carousel.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/owl.init.js')}}"></script>
<!-- Icons -->
<script src="{{asset('assets/frontend/js/feather.min.js')}}"></script>
<!-- Switcher -->
<script src="{{asset('assets/frontend/js/switcher.js')}}"></script>
<!-- Main Js -->
<script src="{{asset('assets/frontend/js/app.js')}}"></script>
<!-- scroll -->
<script src="{{ asset('assets/frontend/js/scroll.js')}}"></script>
<script src="{{ asset('assets/frontend/js/typed/lib/typed.js')}}"></script>
<script src="{{ asset('assets/client/datatables/dataTables.min.js') }}"></script>
<script src="{{ asset('assets/client/datatables/dataTables.bootstrap.min.js') }}"></script>
<!-- Datepicker -->
<script src="{{ asset('assets/client/js/jquery.datetimepicker.full.min.js') }}"></script>
<script src="{{ asset('assets/client/js/moment.js') }}"></script>
<script src="{{ asset('assets/client/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('assets/client/js/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/client/js/polyfill.js') }}"></script>
<script src="https://unicons.iconscout.com/release/v2.1.9/script/monochrome/bundle.js"></script>
<script src="{{ asset('assets/client/js/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/dashboard/assets/js/jquery.tinymce.min.js') }}"></script>
</body>

    <script src="{{asset('assets/frontend/js/invoice/client_decision.js')}}"></script>

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
            $('.close').click(function (){
                $(".modal-backdrop").remove();
            });
        });

    </script>
