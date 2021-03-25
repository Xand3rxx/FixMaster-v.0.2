@extends('layouts.dashboard')
@section('title', $loyalty->first_name.'\'s Summary')
@include('layouts.partials._messages')
@section('content')
<div class="content-body">
  <div class="container pd-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
      <div>
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
          <li class="breadcrumb-item"><a  href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.loyalty_list',app()->getLocale()) }}"> List</a></li>
          <li class="breadcrumb-item active" aria-current="page">{{'Summary' }}</li>
          </ol>
        </nav>
      </div>

      <div class="d-md-block">
      <a href="{{ route('admin.loyalty_list',app()->getLocale()) }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Back</a>
      <a href="{{ route('admin.edit_loyalty', [ 'loyalty'=>$loyalty->uuid, 'locale'=>app()->getLocale() ]) }}" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
                       
        <a href="#"  data-url="{{ route('admin.delete_loyalty', [ 'loyalty'=>$loyalty->uuid, 'locale'=>app()->getLocale() ]) }}" id="delete" class="btn btn-danger"><i class="fas fa-trash"></i> Delete</a>
      </div>
    </div>


          
    <h5 class="mg-t-40 mg-b-20 capitalize"> {{ucfirst($loyalty->first_name) }} {{ucfirst($loyalty->last_name) }} Details</h5>
          <div class="table-responsive">
            <table class="table table-striped table-sm mg-b-0">
              <tbody>
                <tr>
                  <td class="tx-medium">Name</td>
                  <td class="tx-color-03 capitalize">{{ucfirst($loyalty->first_name) }} {{ucfirst($loyalty->last_name) }}</td>
                </tr>
                <tr>
                  <td class="tx-medium">Points</td>
                  <td class="tx-color-03 capitalize">{{$loyalty->points}}</td>
                </tr>
              

                <tr>
                  <td class="tx-medium">Created Date</td>
                  <td class="tx-color-03">{{ Carbon\Carbon::parse($loyalty->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                </tr>

                
              </tbody>
            </table>
          </div>
        </div>



      </div><!-- tab-content -->
    </div><!-- contact-content-body -->
</div>

@section('scripts')
@push('scripts')
<script>
$(document).ready(function() {

    $(document).on('click', '#delete', function(event) {
        event.preventDefault();
        let route = $(this).attr('data-url');
        let url = "<a href='" + route + "'  class='confirm-link'>Yes Delete</a>";
        displayAlert(url, 'Would you like to detele this loyalty?')
    });

    $(document).on('click', '#deactivate', function(event) {
        event.preventDefault();
        let route = $(this).attr('data-url');
        let url = "<a href='" + route + "'  class='confirm-link'>Yes Deactivate</a>";
        displayAlert(url, 'Would you like to deactivate this loyalty?')
    })

    $(document).on('click', '#activate', function(event) {
        event.preventDefault();
        let route = $(this).attr('data-url');
        let url = "<a href='" + route + "'  class='confirm-link'>Yes Reinstate</a>"
        displayAlert(url, 'Would you like to reinstate this loyalty?')
    });


    function displayAlert(url, message) {
        Swal.fire({
            title: 'Are you sure?',
            text: message,
            showCancelButton: true,
            confirmButtonColor: '#E97D1F',
            cancelButtonColor: '#8392a5',
            confirmButtonText: url
        })

    }

});
</script>
@endpush

@endsection

@endsection