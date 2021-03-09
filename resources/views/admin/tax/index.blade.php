@extends('layouts.dashboard')
@section('title', 'Tax List')
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
              <li class="breadcrumb-item active" aria-current="page">Tax List</li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1">Tax List</h4>
        </div>
      </div>

      <div class="row row-xs">
        <div class="col-12 justify-content-center text-center align-items-center">
          <a href="#addTax" class="btn btn-primary float-right" data-toggle="modal"><i class="fas fa-plus"></i> Add New</a>
        </div>

        <div class="col-lg-12 col-xl-12 mg-t-10">
            <div class="card mg-b-10">
              <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                <div>
                  <h6 class="mg-b-5">Taxes as of {{ date('M, d Y') }}</h6>
                  <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all FixMaster core Services.</p>
                </div>
                
              </div><!-- card-header -->
             
              <div class="table-responsive">
                <div id="sort_table">
                  @include('admin.tax._table')
                </div>
              </div><!-- table-responsive -->
            </div><!-- card -->
    
          </div><!-- col -->

      </div>

    </div>
</div>

<div class="modal fade" id="addTax" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-body pd-x-25 pd-sm-x-30 pd-t-40 pd-sm-t-20 pd-b-15 pd-sm-b-20">
        <a href="" role="button" class="close pos-absolute t-15 r-15" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </a>
        <form method="POST" action="{{ route('admin.taxes.store', app()->getLocale()) }}">
          @csrf
          <h5 class="mg-b-2"><strong>Create New Tax</strong></h5>
          <div class="form-row mt-4">
            <div class="form-group col-md-12">
              <div class="form-row mt-4">
                <div class="form-group col-md-4">
                    <label for="name">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Name" value="{{ old('name') }}"  autocomplete="off">
                    @error('name')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                    <label for="percentage">Percentage(%)</label>
                    <input type="text" class="form-control @error('percentage') is-invalid @enderror" name="percentage" min="1" max="100" maxlength="5" id="percentage" placeholder="Percentage" value="{{ old('percentage') }}" autocomplete="off">
                    @error('percentage')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                  <label>Apply</label>
                  <select class="custom-select @error('applicable') is-invalid @enderror" name="applicable">
                    <option selected value="">Select...</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                  </select>
                  <small class="text-danger">If "Apply" is set to yes, other taxes will be set to no</small>
                  @error('applicable')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
            </div>
            
            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="inputEmail4">Description(Optional)</label>
                <textarea rows="3" class="form-control @error('description') is-invalid @enderror" name="description" id="description">{{ old('description') }}</textarea>
                @error('description')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>
            </div>
            <button type="submit" class="btn btn-primary">Create Tax</button>
          </div>
        </form>
      </div><!-- modal-body -->
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->

<div class="modal fade" id="taxDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content tx-14">
        <div class="modal-header">
          <h6 class="modal-title" id="exampleModalLabel2">Tax Percentage History</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pd-x-25 pd-sm-x-30 pd-t-40 pd-sm-t-20 pd-b-15 pd-sm-b-20" id="modal-body">
            <!-- Modal displays here -->
            <div id="spinner-icon"></div>
        </div>
        <div class="modal-footer"></div>
      </div>
    </div>
</div>


<div class="modal fade" id="editTax" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
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
  <script src="{{ asset('assets/dashboard/assets/js/253d5420-ccbe-4671-89f8-956cd70c42bc.js') }}"></script>

  <script>
    $(document).ready(function (){

      $(document).on('click', '#tax-details', function(event) {
    // $('body').delegate( '#service-details', 'click', function(event) {
      event.preventDefault();
      let route = $(this).attr('data-url');
      let serviceName = $(this).attr('data-tax-name');
      
      $.ajax({
          url: route,
          beforeSend: function() {
            $("#modal-body").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>');
          },
          // return the result
          success: function(result) {
              $('#modal-body').modal("show");
              $('#modal-body').html('');
              $('#modal-body').html(result).show();
          },
          complete: function() {
              $("#spinner-icon").hide();
          },
          error: function(jqXHR, testStatus, error) {
              var message = error+ ' An error occured while trying to retireve '+ serviceName +' tax details.';
              var type = 'error';
              displayMessage(message, type);
              $("#spinner-icon").hide();
          },
          timeout: 8000
      })
    });


    $(document).on('click', '#tax-edit', function(event) {
        event.preventDefault();

        let route = $(this).attr('data-url');
        let id = $(this).attr('data-id');
        let taxName = $(this).attr('data-tax-name');

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $.ajax({
        url: route,
        method: 'GET',
        data: {"id": id, "taxName": taxName },
        beforeSend : function(){
            $("#modal-edit-body").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>'); 
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
            var message = error+ ' An error occured while trying to edit '+ taxName+' tax';
            var type = 'error';
            displayMessage(message, type);
            $("#spinner-icon-3").hide();
        },
        timeout: 8000
        });

    });


    });
  </script>
@endpush


@endsection