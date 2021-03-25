@extends('layouts.dashboard')
@section('title', 'Create New Discount /Promotion')
@include('layouts.partials._messages')
@section('content')

<link rel="stylesheet" href="{{ asset('assets/dashboard/assets/css/bootstrap-multiselect.css') }}">
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" /> --}}
<div class="content-body">
    <div class="container pd-x-0">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item"><a
                                href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add Loyalty Point</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Create New Loyalty Point</h4>
            </div>
            <div class="d-md-block">
                <a href="{{ route('admin.loyalty_list',app()->getLocale()) }}" class="btn btn-primary"><i
                        class="fas fa-arrow-left"></i> Loyalty List</a>
            </div>
        </div>


        <form  method="POST" action="{{ route('admin.loyalty_store', app()->getLocale()) }}"
            enctype="multipart/form-data">
            @csrf

            <div class="row row-xs">
                <div class="col-md-12">
                    <div class="form-row">

                    <div class="form-group col-md-4" >
                            <label class='add-page service'>Select Client</label>
                            <select class="selectpicker show-tick select-user" id="users" name="users"
                                title="select..." 
                                data-live-search="true">
                                <option value="">Select...</option>
                            </select>
                            @error('users')
                            <span class="invalid-feedback-err">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                    <div class="form-group col-md-4 parameter">
                    <label for="specified_request_amount_from">Select a Sum of Services Requests
                        Amount</label>
                    <input type="number" class="form-control custom-input-1" d=""
                        id="specified_request_amount" name="specified_request_amount"
                        value="{{ old('specified_request_amount') }}" autocomplete="off">
                        @error('specified_request_amount_from')
                        <span class="invalid-feedback-err">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        </div>

                    

                        <div class="form-group col-md-4">
                            <label for="rate">Points</label>
                            <div class="input-group">
                                <input type="number" min="0.1" step="any" id="points" class="form-control" name="points" value="{{ old('points') }}"
                                    aria-label="Dollar amount (with dot and two decimal places)">
                                <div class="input-group-append">
                                    <span id="percentage" class="input-group-text">0.00</span>
                                    <span class="input-group-text">%</span>
                                </div>
                                @error('points')
                                <span class="invalid-feedback-err">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                             
                        </div>
                        </div>

                        <div class="form-row">
                        <div class="form-group col-md-12">
                        <button type="submit" class="btn btn-primary float-right">Add Loyalty Points</button>
                        </div>

                    </div>
                </div>
            </div>
        </form>

    </div>
</div>
@push('scripts')

<script src="{{ asset('assets/dashboard/assets/js/bootstrap-multiselect.js') }}"></script>

<script>
$('.selectpicker').selectpicker();

$(document).ready(function() {
 var amount;
    $('#specified_request_amount').change(function() {
        amount = $(this).val();
        $.ajax({
            url: "{{ route('admin.loyalty_users',app()->getLocale()) }}",
            method: "POST",
            dataType: "JSON",
            data: {
                "_token": "{{ csrf_token() }}",
                "amount": amount
            },
            success: function(data) {
                if (data) {
                    $("#users").html(data.options).selectpicker('refresh');
                } else {
                    var message =
                        'Error occured while trying to get Enity Parameter List`s in ';
                    var type = 'error';
                    displayMessage(message, type);
                }
            },
        })
    });

    $.ajax({
            url: "{{ route('admin.loyalty_users',app()->getLocale()) }}",
            method: "POST",
            dataType: "JSON",
            data: {
                "_token": "{{ csrf_token() }}",
               
            },
            success: function(data) {
                if (data) {
                    $("#users").html(data.options).selectpicker('refresh');
                } else {
                    var message =
                        'Error occured while trying to get Enity Parameter List`s in ';
                    var type = 'error';
                    displayMessage(message, type);
                }
            },
        })


//get points percentage
        $('#points').keyup(function() {
        let point = $(this).val();
        let newpoint = parseFloat(point) / 100;
        if (point) {
        let newpoint = parseFloat(point) / 100;
        $('#percentage').text(newpoint);
    }else{
        $('#percentage').text('0'); 
    }
    });


    let point = $(this).val();
        let newpoint = parseFloat(point) / 100;
        if (point) {
        let newpoint = parseFloat(point) / 100;
        $('#percentage').text(newpoint);
    }else{
        $('#percentage').text('0'); 
    }

    });
</script>

@endpush
@endsection