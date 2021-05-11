@extends('layouts.dashboard')
@section('title', 'Customer Service Executive Reports')
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
            <li class="breadcrumb-item active" aria-current="page">Customer Service Executive</li>
          </ol>
        </nav>
        <h4 class="mg-b-0 tx-spacing--1">Customer Service Executive Reports</h4>
      </div>
    </div>

    <div class="contact-content-header mt-4">
      <nav class="nav">
        <a href="#job_assigned" class="nav-link active" data-toggle="tab">Job Assigned</a>
        <a href="#amount_earned" class="nav-link" data-toggle="tab"><span>Amount Earned</a>
        <a href="#cse_list" class="nav-link" data-toggle="tab"><span>List of CSE's</a>
        <a href="#rating_history" class="nav-link" data-toggle="tab"><span>CSE Rating History</a>
        <a href="#statement_balance" class="nav-link" data-toggle="tab"><span>Statement Balance</a>
        <a href="#prospect_conversion_list" class="nav-link" data-toggle="tab"><span>Prospect Conversion List</a>
        <a href="#customer_complaints" class="nav-link" data-toggle="tab"><span>List of Customer Complaints</a>
        <a href="#job_warranty_logs" class="nav-link" data-toggle="tab"><span>Job Warranty Log</a>
      </nav>
    </div><!-- contact-content-header -->

    <div class="contact-content-body">
      <div class="tab-content">
        <div id="job_assigned" class="tab-pane show active pd-20 pd-xl-25">
          <div class="row row-xs">
            <div class="col-lg-12 col-xl-12 mg-t-10">
              <div class="card mg-b-10">
                <div class="d-sm-flex mg-t-10"></div>

                <div class="row mt-1 mb-1 ml-1 mr-1">
                  <div class="col-md-4">
                    <input type="hidden" class="d-none" id="route" value="{{ route('admin.cse_report_first_sorting', app()->getLocale()) }}">
                    <div class="form-group">
                      <label>Sorting Parameters</label>
                      <select class="custom-select" id="sorting-parameters">
                        <option value="None">Select...</option>
                        <option value="SortType1">CSE List</option>
                        <option value="SortType2">Job Acceptance Date</option>
                        <option value="SortType3">Job Completion Date</option>
                        <option value="SortType4">Job Status</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4 cse-list d-none">
                    <div class="form-group position-relative">
                      <label>{{ !empty($cses->name) ? $cses->name : 'CSE' }} List <span class="text-danger">*</span></label>
                      <select class="form-control selectpicker" multiple id="cse-list">
                        <option value="" disabled>Select...</option>
                        @foreach ($cses['users'] as $cse)
                        <option value="{{ $cse['account']['user_id'] }}">{{ !empty($cse['account']['first_name']) ? Str::title($cse['account']['first_name'] ." ". $cse['account']['last_name']) : 'UNAVAILABLE' }}</option>
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

                <div class=" table-responsive">
                  <div id="job-assigned-sorting">
                    @include('admin.reports.cse.tables._job_assigned')
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
{{-- <script src="{{ asset('assets/dashboard/assets/js/admin/sortable_search.js') }}"></script> --}}
<script>
  $(document).ready(function() {
    //Initiate multiple dropdown select
    $('.selectpicker').selectpicker();


    $('#sorting-parameters').on('change', function() {
      let option = $("#sorting-parameters").find("option:selected").val();
      switch (option) {
        case 'SortType1':
          $('.cse-list').removeClass('d-none');
          $('.date-range, .job-status').addClass('d-none');
          $("#job-status").prop('selectedIndex', 0);
          $('#date-from, #date-to').val('');
          break
        case 'SortType2':
          $('.date-range').removeClass('d-none');
          $('.cse-list, .job-status').addClass('d-none');
          $("#cse-list, #job-status").prop('selectedIndex', 0);
          $('#date-from, #date-to').val('');
          break
        case 'SortType3':
          $('.date-range').removeClass('d-none');
          $('.cse-list, .job-status').addClass('d-none');
          $("#cse-list, #job-status").prop('selectedIndex', 0);
          $('#date-from, #date-to').val('');
          break
        case 'SortType4':
          $('.job-status').removeClass('d-none');
          $('.cse-list, .date-range').addClass('d-none');
          $("#cse-list").prop('selectedIndex', 0);
          $('#date-from, #date-to').val('');
          break
        default:
          $('.cse-list, .date-range, .job-status').addClass('d-none');
          break;
      }
    });

  });

  //SORT CSE REPORT BY CSE ID
  $('#cse-list').on('change', function() {
    //Get the User ID
    $cseIdList = [];
    $cseId = $(this).val();
    $cseIdList.push($cseId);
    // console.log($cseIdList);

    //Assign sorting level
    $sortLevel = 'SortType1';

    sortJobAssignedTable($sortLevel, $cseIdList);

  });

  //SORT ACTIVITY LOG BY DATE RANGE
  $('#date-to').change(function() {

    //Assign sorting level
    $sortLevel = $('#sorting-parameters').val();
    //Get date from to sort activity log
    $dateFrom = $('#date-from').val();
    //Get date to, to sort activity log
    $dateTo = $('#date-to').val();

    if ($.trim($dateFrom).length == 0) {
      var message = 'Kindly select a date to start From.';
      var type = 'error';
      displayMessage(message, type);

    } else {
      sortJobAssignedTable($sortLevel, $cseId = null, $jobStatus = null, $dateFrom, $dateTo);
      // sortTableData($userId, $sortLevel, $type, $date='', $year='', $month='', $dateFrom, $dateTo);
    }
  });

  function jQuerySort() {
    $('.basicExample').DataTable({
      'iDisplayLength': 10,
      language: {
        searchPlaceholder: 'Search...',
        sSearch: '',
        lengthMenu: '_MENU_ items/page',
      }
    })
  }

  function sortJobAssignedTable($sortLevel, $cseId = null, $jobStatus = null, $dateFrom = null, $dateTo = null) {
    //Get sorting route
    $route = $('#route').val();
    const $date = {
      "date_from": $dateFrom,
      "date_to": $dateTo
    }

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.ajax({
      url: $route,
      method: 'POST',
      data: {
        "sort_level": $sortLevel,
        "cse_id": $cseId,
        "job_status": $jobStatus,
        "date": $date,
      },
      beforeSend: function() {
        $("#job-assigned-sorting").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>');
      },
      success: function(data) {
        console.log(data);
        return false;
        if (data) {
          //Replace table with new sorted records
          $('#job-assigned-sorting').html('');
          // $('#job-assigned-sorting').html(data);

          //Add sorting class for jQuery datatable
          $('#basicExample').addClass('basicExample');

          //Attach JQuery datatable to current sorting
          if ($('#basicExample').hasClass('basicExample')) {
            jQuerySort();
          }
        } else {
          var message = 'Error occured while trying to sort this table.';
          var type = 'error';
          displayMessage(message, type);
        }
      },
      error: function() {
        alert('An error has occurred')
      }
    });
  }
</script>

@endpush

@endsection