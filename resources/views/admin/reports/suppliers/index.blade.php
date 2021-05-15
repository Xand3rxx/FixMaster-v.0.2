@extends('layouts.dashboard')
@section('title', 'Supplier Reports')
@include('layouts.partials._messages')
@section('content')
    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/css/bootstrap-multiselect.css') }}">

    <div class="content-body">
        <div class="container pd-x-0">
            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page">Reports</li>
                            <li class="breadcrumb-item active" aria-current="page">Supplier</li>
                        </ol>
                    </nav>
                    <h4 class="mg-b-0 tx-spacing--1">Supplier Reports</h4>
                </div>
            </div>

            <div class="contact-content-header mt-4">
                <nav class="nav">
                    <a href="#items_delivered" class="nav-link active" data-toggle="tab">Items Delivered</a>
                    <a href="#orders_completed" class="nav-link" data-toggle="tab"><span>Orders Completed</span></a>
                    <a href="#supplier_list" class="nav-link" data-toggle="tab"><span>Supplier List</span></a>
                    <a href="#rating_history" class="nav-link" data-toggle="tab"><span>Rating History</span></a>
                    <a href="#statement_balance" class="nav-link" data-toggle="tab"><span>Statement Balance</span></a>
                    <a href="#returned_items" class="nav-link" data-toggle="tab"><span>Returned Items</span></a>
                    <a href="#warranty_replacement" class="nav-link" data-toggle="tab"><span>Warranty Replacement</span></a>
                </nav>
            </div><!-- contact-content-header -->

            <div class="contact-content-body">
                <div class="tab-content">
                    <div id="items_delivered" class="tab-pane show active pd-20 pd-xl-25">
                        <div class="row row-xs">
                            <div class="col-lg-12 col-xl-12 mg-t-10">
                                <div class="card mg-b-10">
                                    <div class="d-sm-flex mg-t-10"></div>

                                <div class="table-responsive">
                                    <div class="row mt-1 mb-1 ml-1 mr-1 ">
                                        <div class="col-md-4">
                                            <input type="hidden" class="d-none" id="route" value="{{ route('admin.cse_report_first_sorting', app()->getLocale()) }}">
                                            <div class="form-group">
                                                <label>Sorting Parameters</label>
                                                <select class="custom-select" id="sorting-parameters">
                                                    <option value="None">Select...</option>
                                                    <option value="SortType1">Supplier List</option>
                                                    <option value="SortType2">Order Date</option>
                                                    <option value="SortType3">Delivery Date</option>
                                                    <option value="SortType4">Job Status</option>
                                                    <option value="SortType5">Summary</option>
                                                    <option value="SortType6">CSE/Customer List</option>
                                                </select>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-md-4 supplier-list d-none">
                                            <div class="form-group position-relative">
                                                <label>{{ !empty($suppliers->name) ? $suppliers->name : 'Supplier' }} List <span class="text-danger">*</span></label>
                                                <select class="form-control selectpicker" multiple id="supplier-list">
                                                    <option value="">Select...</option>
                                                    @foreach ($suppliers['users'] as $supplier)
                                                        <option value="{{ $supplier['account']['user_id'] }}">{{ !empty($supplier['account']['first_name']) ? Str::title($supplier['account']['first_name'] ." ". $supplier['account']['last_name']) : 'UNAVAILABLE' }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4 date-range d-none">
                                            <div class="form-group position-relative">
                                                <label>From <span class="text-danger">*</span></label>
                                                <input name=date_from" id="date-from" type="date" class="form-control pl-5">
                                            </div>
                                        </div>

                                        <div class="col-md-4 date-range d-none">
                                            <div class="form-group position-relative">
                                                <label>To <span class="text-danger">*</span></label>
                                                <input name="date_to" id="date-to" type="date" class="form-control pl-5" max="{{ Carbon\Carbon::now('UTC') }}">
                                            </div>
                                        </div>

                                        <div class="col-md-4 job-status d-none">
                                            <div class="form-group position-relative">
                                                <label>Job Status <span class="text-danger">*</span></label>
                                                <select class="form-control" name="job_status" id="job-status">
                                                    <option value="">Select...</option>
                                                    <option value="1">Pending</option>
                                                    <option value="2">Ongoing</option>
                                                    <option value="3">Cancelled</option>
                                                    <option value="4">Completed</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="items-delivered-sorting">
                                        @include('admin.reports.suppliers.tables._item_delivered')
                                    </div>
                                </div><!-- table-responsive -->
                            </div><!-- card -->

                        </div><!-- col -->
                    </div><!-- row -->
                </div>
                    <div id="orders_completed" class="tab-pane pd-20 pd-xl-25">
                        <div class="row row-xs">
                            <div class="col-lg-12 col-xl-12 mg-t-10">
                                <div class="card mg-b-10">
                                    <div class="d-sm-flex mg-t-10"></div>

                                    <div class="table-responsive">
                                        <div class="row mt-1 mb-1 ml-1 mr-1 ">
                                            <div class="col-md-4">
                                                <input type="hidden" class="d-none" id="route" value="{{ route('admin.cse_report_first_sorting', app()->getLocale()) }}">
                                                <div class="form-group">
                                                    <label>Sorting Parameters</label>
                                                    <select class="custom-select" id="sorting-parameters">
                                                        <option value="None">Select...</option>
                                                        <option value="SortType1">Supplier List</option>
                                                        <option value="SortType2">Order Date</option>
                                                        <option value="SortType3">Delivery Date</option>
                                                        <option value="SortType4">Job Status</option>
                                                        <option value="SortType5">Summary</option>
                                                        <option value="SortType6">CSE/Customer List</option>
                                                    </select>
                                                </div>
                                            </div><!--end col-->
                                            <div class="col-md-4 supplier-list d-none">
                                                <div class="form-group position-relative">
                                                    <label>{{ !empty($suppliers->name) ? $suppliers->name : 'Supplier' }} List <span class="text-danger">*</span></label>
                                                    <select class="form-control selectpicker" multiple id="supplier-list">
                                                        <option value="">Select...</option>
                                                        @foreach ($suppliers['users'] as $supplier)
                                                            <option value="{{ $supplier['account']['user_id'] }}">{{ !empty($supplier['account']['first_name']) ? Str::title($supplier['account']['first_name'] ." ". $supplier['account']['last_name']) : 'UNAVAILABLE' }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4 date-range d-none">
                                                <div class="form-group position-relative">
                                                    <label>From <span class="text-danger">*</span></label>
                                                    <input name=date_from" id="date-from" type="date" class="form-control pl-5">
                                                </div>
                                            </div>

                                            <div class="col-md-4 date-range d-none">
                                                <div class="form-group position-relative">
                                                    <label>To <span class="text-danger">*</span></label>
                                                    <input name="date_to" id="date-to" type="date" class="form-control pl-5" max="{{ Carbon\Carbon::now('UTC') }}">
                                                </div>
                                            </div>

                                            <div class="col-md-4 job-status d-none">
                                                <div class="form-group position-relative">
                                                    <label>Job Status <span class="text-danger">*</span></label>
                                                    <select class="form-control" name="job_status" id="job-status">
                                                        <option value="">Select...</option>
                                                        <option value="1">Pending</option>
                                                        <option value="2">Ongoing</option>
                                                        <option value="3">Cancelled</option>
                                                        <option value="4">Completed</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="items-delivered-sorting">
                                            @include('admin.reports.suppliers.tables._orders_completed')
                                        </div>
                                    </div><!-- table-responsive -->
                                </div><!-- card -->

                            </div><!-- col -->
                        </div><!-- row -->
                    </div>
            </div>
        </div>
    </div>
    </div>




    @push('scripts')
        <script src="{{ asset('assets/dashboard/assets/js/bootstrap-multiselect.js') }}"></script>

        <script>
            $(document).ready(function() {
                //Initiate multiple dropdown select
                $('.selectpicker').selectpicker();


                $('#sorting-parameters').on('change', function() {
                    let option = $("#sorting-parameters").find("option:selected").val();
                    switch (option) {
                        case 'SortType1':
                            $('.supplier-list').removeClass('d-none');
                            $('.date-range, .job-status').addClass('d-none');
                            $("#job-status").prop('selectedIndex', 0);
                            $('#date-from, #date-to').val('');
                            break
                        case 'SortType2':
                            $('.date-range').removeClass('d-none');
                            $('.cse-list, .job-status').addClass('d-none');
                            $("#supplier-list, #job-status").prop('selectedIndex', 0);
                            $('#date-from, #date-to').val('');
                            break
                        case 'SortType3':
                            $('.date-range').removeClass('d-none');
                            $('.supplier-list, .job-status').addClass('d-none');
                            $("#supplier-list, #job-status").prop('selectedIndex', 0);
                            $('#date-from, #date-to').val('');
                            break
                        case 'SortType4':
                            $('.job-status').removeClass('d-none');
                            $('.supplier-list, .date-range').addClass('d-none');
                            $("#supplier-list").prop('selectedIndex', 0);
                            $('#date-from, #date-to').val('');
                            break
                        default:
                            $('.supplier-list, .date-range, .job-status').addClass('d-none');
                            break;
                    }
                });

            });

            //SORT CSE REPORT BY CSE ID
            $('#cse-list').on('change', function (){
                //Get the User ID
                $cseId = $('#user_id').val();

                //Assign sorting level
                $sortLevel = 'SortType1';

                sortJobAssignedTable($sortLevel, $cseId);

            });

            function sortJobAssignedTable($sortLevel, $cseId = null, $jobStatus, $dateFrom = null, $dateTo = null){
                //Get sorting route
                $route = $('#route').val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: $route,
                    method: 'POST',
                    data: {"sort_level": $sortLevel, "cse_id": $cseId, "job_status": $jobStatus, "date_from": $dateFrom, "date_to": $dateTo},
                    beforeSend : function(){
                        $("#items-delivered-sorting").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>');
                    },
                    success: function (data){
                        if(data){
                            //Replace table with new sorted records
                            $('#items-delivered-sorting').html('');
                            $('#items-delivered-sorting').html(data);

                            //Add sorting class for jQuery datatable
                            $('#basicExample').addClass('basicExample');

                            //Attach JQuery datatable to current sorting
                            if($('#basicExample').hasClass('basicExample')){
                                jQuerySort();
                            }
                        }else {
                            var message = 'Error occured while trying to sort this table.';
                            var type = 'error';
                            displayMessage(message, type);
                        }
                    }
                });
            }

            function jQuerySort(){
                $('.basicExample').DataTable({
                    'iDisplayLength': 10,
                    language: {
                        searchPlaceholder: 'Search...',
                        sSearch: '',
                        lengthMenu: '_MENU_ items/page',
                    }
                })
            }
        </script>
    @endpush

@endsection
