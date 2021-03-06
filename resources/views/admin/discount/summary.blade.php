@extends('layouts.dashboard')
@section('title', $discount->name.'\'s Summary')
@include('layouts.partials._messages')
@section('content')
<div class="content-body">
  <div class="container pd-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
      <div>
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
          <li class="breadcrumb-item"><a  href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.discount_list',app()->getLocale()) }}"> List</a></li>
          <li class="breadcrumb-item active" aria-current="page">{{'Summary' }}</li>
          </ol>
        </nav>
      </div>

      <div class="d-md-block">
      <a href="{{ route('admin.discount_list',app()->getLocale()) }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Back</a>
        <a href="#" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
        @if($discount->status == 'activate') 
        <a href="#"  id="deactivate" data-toggle="modal" data-url="{{ route('admin.deactivate_discount', [ 'discount'=>$discount->uuid, 'locale'=>app()->getLocale() ]) }}"   class="btn btn-warning" title="Deactivate "><i class="fas fa-ban"></i> Deactivate</a>
        @else 
        <a href="#" id="activate" data-toggle="modal" data-url="{{ route('admin.activate_discount', [ 'discount'=>$discount->uuid, 'locale'=>app()->getLocale() ]) }}"  class="btn btn-success" title="Reinstate"><i class="fas fa-undo"></i> Reinstate</a>
        @endif                 
        <a href="#" id="delete" class="btn btn-danger"><i class="fas fa-trash"></i> Delete</a>
      </div>
    </div>


          
    <h5 class="mg-t-40 mg-b-20 capitalize"> {{ ucfirst($discount->name)}} Details</h5>
          <div class="table-responsive">
            <table class="table table-striped table-sm mg-b-0">
              <tbody>
                <tr>
                  <td class="tx-medium">Name</td>
                  <td class="tx-color-03 capitalize">{{$discount->name}}</td>
                </tr>
                <tr>
                  <td class="tx-medium">Enity</td>
                  <td class="tx-color-03 capitalize">{{$discount->entity}}</td>
                </tr>
                <tr>
                  <td class="tx-medium">Rate</td>
                  <td class="tx-color-03">{{$discount->rate}} %</td>
                </tr>
                <tr>
                  <td class="tx-medium">Created By</td>
                  <td class="tx-color-03">{{ucfirst('super admin')}}</td>
                </tr>
                <tr>
                  <td class="tx-medium">Duration</td>
 
                        <td class="tx-color-03">{{CustomHelpers::displayTime($discount->duration_start, $discount->duration_end) }}</td>   
                </tr>
                <tr>
                  <td class="tx-medium">Notification</td>
                  <td class="tx-color-03">{{$discount->notify == 0 ? ' Sent': 'Not Sent'}}</td>
                </tr>

                <tr>
                  <td class="tx-medium">Status</td>
                  @if($discount->status == 'activate') 
                        <td class="tx-color-03">Active</td>
                      @else 
                        <td class="tx-color-03">Deactivated</td>
                      @endif
                 
                </tr>

                <tr>
                  <td class="tx-medium">Created Date</td>
                  <td class="tx-color-03">{{ Carbon\Carbon::parse($discount->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
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
        displayAlert(url, 'Would you like to detele this Discount?')
    });

    $(document).on('click', '#deactivate', function(event) {
        event.preventDefault();
        let route = $(this).attr('data-url');
        let url = "<a href='" + route + "'  class='confirm-link'>Yes Deactivate</a>";
        displayAlert(url, 'Would you like to deactivate this Discount?')
    })

    $(document).on('click', '#activate', function(event) {
        event.preventDefault();
        let route = $(this).attr('data-url');
        let url = "<a href='" + route + "'  class='confirm-link'>Yes Reinstate</a>"
        displayAlert(url, 'Would you like to reinstate this Discount?')
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