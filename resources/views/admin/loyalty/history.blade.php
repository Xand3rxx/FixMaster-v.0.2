@extends('layouts.dashboard')
@section('title', 'Loyalty History')
@include('layouts.partials._messages')
@section('content')
<div class="content-body">
    <div class="container pd-x-0">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item"><a
                                href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Loyalty History</li>
                    </ol>
                </nav>
            </div>
            <div class="d-md-block">
                <a href="{{ route('admin.add_loyalty', app()->getLocale()) }}" class="btn btn-primary"><i
                        class="fas fa-plus"></i> Add New Loyalty</a>
            </div>
        </div>

        <div class="row row-xs">

            <div class="col-lg-12 col-xl-12 mg-t-10">
                <div class="card mg-b-10">
                    <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                        <div>
                            <h6 class="mg-b-5">Loyalty Histories as of {{ date('M, d Y') }}</h6>
                            <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all FixMaster
                            Histories.</p>
                        </div>

                    </div><!-- card-header -->

                    <div class="table-responsive">

                        <table class="table table-hover mg-b-0" id="basicExample">
                            <thead class="thead-primary">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Name</th>
                                    <th>Points</th>
                                    <th>Amount</th>
                                    <th>loyalty in Naira</th>
                                    <th>Date Created</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($loyalty as $row)
                                <tr>
                                    <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
                                    <td class="tx-medium">{{ucfirst($row->first_name) }} {{ucfirst($row->last_name) }}</td>
                                    <td class="tx-medium">{{ $row->points}}</td>
                             
                                    <td class="tx-medium">{{ $row->amount}}</td>
                                    <td class="tx-medium">{{ $row->points/100 * $row->amount }} &#8358;</td>
                                    <td class="text-medium">
                                        {{ Carbon\Carbon::parse($row->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}
                                    </td>
                     
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div><!-- table-responsive -->
                </div><!-- card -->

            </div><!-- col -->

        </div>

    </div>
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