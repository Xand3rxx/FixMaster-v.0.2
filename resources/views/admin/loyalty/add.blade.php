@extends('layouts.dashboard')
@section('title', 'Create New Loyalty')
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
                        <li class="breadcrumb-item active" aria-current="page">Add Loyalty </li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Create New Loyalty</h4>
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

                    <div class="form-group col-md-6 parameter">
                    <label for="specified_request_amount_from">Select a Sum of Services Requests
                        Amount</label>
                    <input type="number" class="form-control custom-input-1" id="sum"
                        id="specified_request_amount" name="specified_request_amount"
                        value="{{ old('specified_request_amount') }}" autocomplete="off">
                        @error('specified_request_amount')
                        <span class="invalid-feedback-err">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        </div>

                    

                        <div class="form-group col-md-6">
                            <label for="rate">Points</label>
                            <div class="input-group">
                                <input type="number" min="0.1" step="any" id="points" class="form-control" name="points" value="{{ old('points') }}"
                                    aria-label="Dollar amount (with dot and two decimal places)">
                                <div class="input-group-append">
                                <span class="input-group-text">%</span>
                                    <span id="percentage" class="input-group-text">0.00</span>
                                    <span class="input-group-text">&#8358;</span>
                                </div>
                                @error('points')
                                <span class="invalid-feedback-err">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                             
                        </div>
                      
                        <div class="form-group col-md-6" >
                            <label class='add-page service'>Select Client</label>
                            <select class="selectpicker show-tick select-user" id="users" name="users[]"
                                title="select..." multiple="multiple" data-selected-text-format="count>3"
                                data-live-search="true">
                                <option value="">Select...</option>
                            </select>
                            @error('users')
                            <span class="invalid-feedback-err">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-2" >
                            <label class='add-page not-users'>Users' Count</label>
                            <input type="number" disabled class="form-control user-count" />
                        
                        </div>
                        </div>

                        <div class="form-row">
                        <div class="form-group col-md-12">
                        <button type="submit" class="btn btn-primary">Add Loyalty Points</button>
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

    $('.selectpicker.select-user').on('change', function() {
        var selectPicker = $(this);
        var selectAllOption = selectPicker.find('option.select-all');
        var checkedAll = selectAllOption.prop('selected');
        var optionValues = selectPicker.find('option[value!="[all]"][data-divider!="true"]');

        if (checkedAll) {
            // Process 'all/none' checking
            var allChecked = selectAllOption.data("all") || false;

            if (!allChecked) {
                optionValues.prop('selected', true).parent().selectpicker('refresh');
                selectAllOption.data("all", true);
            } else {
                optionValues.prop('selected', false).parent().selectpicker('refresh');
                selectAllOption.data("all", false);
            }

            selectAllOption.prop('selected', false).parent().selectpicker('refresh');
        } else {
            // Clicked another item, determine if all selected
            var allSelected = optionValues.filter(":selected").length == optionValues.length;
            selectAllOption.data("all", allSelected);
        }
    }).trigger('change');


 var amount;
    $('#sum').change(function() {
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
                    $('.user-count').val(data.count).selectpicker('refresh');
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
                    $('.user-count').val(data.count).selectpicker('refresh');
                } else {
                    var message =
                        'Error occured while trying to get Enity Parameter List`s in ';
                    var type = 'error';
                    displayMessage(message, type);
                }
            },
        })


//get points percentage
let sum, point;
   if(!sum){
        $('#points').attr('disabled', 'true')  
    }

        $('#sum').keyup(function() {
        sum = $(this).val();
        if(!sum)
         $('#points').attr('disabled', 'true');

        if(sum)
        $('#points').removeAttr('disabled')   
        
        if (point && sum) {
        let newpoint = parseFloat(point) / 100 * parseInt(sum);
        $('#percentage').text(Math.round(newpoint));
        }else{
        $('#percentage').text('0.00'); 
        }
    });

 
    $('#points').keyup(function() {
         point = $(this).val();
        if (point && sum) {
        let newpoint = parseFloat(point) / 100 * parseInt(sum);
        $('#percentage').text(Math.round(newpoint));
        }else{
            $('#percentage').text('0.00'); 
        }
    });


        point = $('#points').val();
        sum = $('#sum').val();
        if(sum){
            $('#points').removeAttr('disabled')  
        }
            
    
        if (point != '' && sum != '') {
        let newpoint = parseFloat(point) / 100 * parseInt(sum);
        $('#percentage').text(Math.round(newpoint));
        }else{
        $('#percentage').text('0.00'); 
        }

  
    });
</script>

@endpush
@endsection