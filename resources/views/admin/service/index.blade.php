@extends('layouts.dashboard')
@section('title', 'Category Services List')
@include('layouts.partials._messages')
@section('content')
<input class="d-none" id="locale" type="hidden" value="{{ app()->getLocale() }}">

<div class="content-body">
    <div class="container pd-x-0">
      <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item"><a href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Category Services List</li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1">Category Services List</h4>
        </div>
      </div>

      <div class="row row-xs">
        <div class="col-12 justify-content-center text-center align-items-center">
          <a href="#addService" class="btn btn-primary float-right" data-toggle="modal"><i class="fas fa-plus"></i> Add New</a>
        </div>

        <div class="col-lg-12 col-xl-12 mg-t-10">
            <div class="card mg-b-10">
              <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                <div>
                  <h6 class="mg-b-5">Category Services as of {{ date('M, d Y') }}</h6>
                  <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all FixMaster core Services.</p>
                </div>
                
              </div><!-- card-header -->
             
              <div class="table-responsive">
                <div id="sort_table">
                  @include('admin.service._table')
                </div>
              </div><!-- table-responsive -->
            </div><!-- card -->
    
          </div><!-- col -->

      </div>

    </div>
</div>

<div class="modal fade" id="serviceCategoryDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content tx-14">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel2">Category Service Details</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="modal-body" id="modal-body">
          <!-- Modal displays here -->
          <div id="spinner-icon"></div>
      </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editService" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
    <div class="modal-content tx-14">
      <div class="modal-body pd-x-25 pd-sm-x-30 pd-t-40 pd-sm-t-20 pd-b-15 pd-sm-b-20">
        <a href="" role="button" class="close pos-absolute t-15 r-15" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </a>
        <div class="modal-body" id="modal-edit-body">
          <!-- Modal displays here -->
          <div id="spinner-icon-3"></div>
        </div>
      </div><!-- modal-body -->
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->


@push('scripts')
<script>
  $(document).ready(function() {

    $(document).on('click', '#category-details', function(event) {
      event.preventDefault();
      let route = $(this).attr('data-url');
      let categoryeName = $(this).attr('data-category-name');
      
      $.ajax({
          url: route,
          beforeSend: function() {
            $("#spinner-icon").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>');
          },
          // return the result
          success: function(result) {
              $('#modal-body').html('');
              $('#modal-body').modal("show");
              $('#modal-body').html(result).show();
          },
          complete: function() {
              $("#spinner-icon").hide();
          },
          error: function(jqXHR, testStatus, error) {
              var message = error+ ' An error occured while trying to retireve '+ categoryeName +' service details.';
              var type = 'error';
              displayMessage(message, type);
              $("#spinner-icon").hide();
          },
          timeout: 8000
      })
    });

    $(document).on('click', '#service-edit', function(event) {
        event.preventDefault();

        let route = $(this).attr('data-url');
        let id = $(this).attr('data-id');
        let serviceName = $(this).attr('data-service-name');

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $.ajax({
        url: route,
        method: 'GET',
        data: {"id": id, "serviceName": serviceName },
        beforeSend : function(){
            $("#spinner-icon-3").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>'); 
        },
        success: function (result){
            $('#modal-edit-body').modal("show");
            $('#modal-edit-body').html('');
            $('#modal-edit-body').html(result).show();
        },
        complete: function() {
              $("#spinner-icon-3").hide();
        },
        error: function(jqXHR, testStatus, error) {
            var message = error+ ' An error occured while trying to edit '+ serviceName+' category';
            var type = 'error';
            displayMessage(message, type);
            $("#spinner-icon-3").hide();
        },
        timeout: 8000
        });

    });

    // $('.close').click(function (){
    //   $(".modal-backdrop").remove();
    // });

  });
 
</script>
@endpush

@endsection