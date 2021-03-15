@extends('layouts.dashboard')
@section('title', 'Invoices')
@section('content')
    @include('layouts.partials._messages')

    <div class="content-body">
        <div class="container pd-x-0">
            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Invoices</li>
                        </ol>
                    </nav>
                    <h4 class="mg-b-0 tx-spacing--1">Invoices</h4>
                </div>
                <div class="d-md-block">
                    <a href="" class="btn btn-primary"><i class="fas fa-plus"></i> Create New Invoice</a>
                    <a href="{{ route('admin.diagnostic', app()->getLocale()) }}" class="btn btn-primary"><i class="fas fa-plus"></i> Diagnostic Invoice</a>
                    <a href="{{ route('admin.rfq', app()->getLocale()) }}" class="btn btn-primary"><i class="fas fa-plus"></i> RFQ Issuance</a>
                    <a href="" class="btn btn-primary"><i class="fas fa-plus"></i> Supplier Return</a>
                    <a href="" class="btn btn-primary"><i class="fas fa-plus"></i> Service Completion</a>
                </div>
            </div>

            <div class="row row-xs">
                <div class="col-lg-12 col-xl-12 mg-t-10">
                    <div class="card mg-b-10">
                        <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                            <div>
                                <h6 class="mg-b-5">Invoices as of {{ date('M, d Y') }}</h6>
                                <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all FixMaster Invoices.</p>
                            </div>

                        </div><!-- card-header -->

                        <div class="table-responsive">

                            <table class="table table-hover mg-b-0" id="basicExample">
                                <thead class="thead-primary">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Invoice Number</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Amount Due</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="tx-color-03 tx-center">1</td>
                                        <td class="tx-medium">INV-2021-05</td>
                                        <td class="tx-medium">Francis Maja</td>
                                        <td class="tx-medium">12 Feb 2021</td>
                                        <td class="text-medium">#6000.00</td>
                                        <td class="text-medium">#6000.00</td>
                                        <td class="text-medium text-danger">Unpaid</td>
                                        <td class=" text-center">
                                            <div class="dropdown-file">
                                                <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="" class="dropdown-item details text-primary"><i class="far fa-user"></i> Summary</a>
                                                    <a href="" class="dropdown-item details text-info"><i class="far fa-edit"></i> Edit</a>
                                                    <a href="" class="dropdown-item details text-secondary"><i class="fa fa-percent"></i> Discount </a>
                                                    <a href="" class="dropdown-item details text-danger"><i class="fas fa-trash"></i> Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
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
