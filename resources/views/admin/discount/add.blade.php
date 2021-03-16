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
                        <li class="breadcrumb-item active" aria-current="page">Add Discout/Promotion</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Create New Discount</h4>
            </div>
        </div>


        <form id="discountForm" method="POST" action="{{ route('admin.store_discount', app()->getLocale()) }}"
            enctype="multipart/form-data">
            @csrf
            <div class="row row-xs">
                <div class="col-md-12">
                    <div class="form-row">

                        <div class="form-group col-md-12">
                            <label for="entity">Select Entity</label>
                            <select id="entity_id" name="entity" class="custom-select cs-select" id>
                                <option selected value="">Select...</option>
                                @foreach($entities as $key => $value)
                                <option value="{{ strtolower($value->name) }}"
                                    {{ old('entity') ==  strtolower($value->name) ? 'selected' : ''}}>
                                    {{ $value->name }}</option>
                                @endforeach
                            </select>
                            @error('entity')
                            <span class="invalid-feedback-err">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <span class="invalid-feedback-err"></span>
                        </div>


                        <div class="form-group col-md-12 parameter" id="add-users">
                            <label class='add-page'>Add Users</label>
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



                        <div class="form-group col-md-6 show-estate">
                            <label>Select Estate</label>
                            <select class="custom-select cs-select" name="estate_name" id="estate_id">
                                <option selected value="">Select...</option>
                            </select>
                        </div>

                        <div class="form-group col-md-6 parameter show-estate" id="estate-users">
                            <label class='add-page not-users'>Add Estate Users</label>
                            <select class="selectpicker show-tick select-user" id="estate-user" name="users[]"
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


                        <div class="form-group col-md-6 show-service">
                            <label class='add-page'>Select Service Category</label>
                            <select class="selectpicker show-tick select-all-service" id="category_id" name="category[]"
                                title="select..." multiple="multiple" data-selected-text-format="count>3"
                                data-live-search="true">
                                <option value="">Select...</option>
                            </select>
                            @error('category')
                            <span class="invalid-feedback-err">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>


                        <div class="form-group col-md-6 show-service">
                            <label class='add-page'>Select Services</label>
                            <select class="selectpicker show-tick select-services" id="service_id" name="services[]"
                                title="select..." multiple="multiple" data-selected-text-format="count>3"
                                data-live-search="true">
                                <option value="">Select...</option>
                            </select>
                        </div>


                        <div class="form-group col-md-12">
                            <hr />
                        </div>

                        <fieldset class="form-fieldset col-md-12">
                            <legend>Filter By Additional Fields</legend>

                            <div class="form-row">
                                <br>
                                <div class="form-group col-md-3 parameter">
                                    <label for="specified_request_count_morethan">Total Count of Services Requests(more
                                        than)</label>
                                    <input type="number" min="1" class="form-control custom-input-1"
                                        id="specified_request_count_morethan" name="specified_request_count_morethan"
                                        value="{{ old('specified_request_count_morethan') }}" autocomplete="off">
                                        @error('specified_request_count_morethan')
                                        <span class="invalid-feedback-err">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                </div>
                                <div class="form-group col-md-3 parameter">
                                    <label for="specified_request_count_equalto">Total Count of Services Requests(equal
                                        to)</label>
                                    <input type="number" min="1" class="form-control custom-input-1"
                                        id="specified_request_count_equalto" name="specified_request_count_equalto"
                                        value="{{ old('specified_request_count_equalto') }}" autocomplete="off">
                                        @error('specified_request_count_equalto')
                                        <span class="invalid-feedback-err">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                </div>
                                <div class="form-group col-md-3 parameter">
                                    <label for="specified_request_amount_from">Total Sum of Services Requests
                                        Amount(from)</label>
                                    <input type="text" class="form-control custom-input-1"
                                        id="specified_request_amount_from" name="specified_request_amount_from"
                                        value="{{ old('specified_request_amount_from') }}" autocomplete="off">
                                        @error('specified_request_amount_from')
                                        <span class="invalid-feedback-err">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                </div>

                                <div class="form-group col-md-3 parameter">
                                    <label for="specified_request_amount_to">Total Sum of Services Requests
                                        Amount(To)</label>
                                    <input type="number" min="1" class="form-control custom-input-1"
                                        id="specified_request_amount_to" name="specified_request_amount_to"
                                        value="{{ old('specified_request_amount_to') }}" autocomplete="off">
                                        @error('specified_request_amount_to')
                                        <span class="invalid-feedback-err">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                </div>

                                <div class="form-group col-md-3 parameter">
                                    <label for="sspecified_request_start_date">Date Range(from)</label>
                                    <input type="date" class="form-control custom-input-1"
                                        id="specified_request_start_date" name="specified_request_start_date"
                                        value="{{ old('specified_request_start_date') }}" autocomplete="off">
                                </div>


                                <div class="form-group col-md-3 parameter">
                                    <label for="sspecified_request_end_date">Date Range(to)</label>
                                    <input type="date" class="form-control custom-input-1"
                                        id="specified_request_end_date" name="specified_request_end_date"
                                        value="{{ old('specified_request_end_date') }}" autocomplete="off">
                                </div>


                                <div class="form-group col-md-3 parameter">
                                    <label for="entity">States</label>
                                    <select id="state_id" name="state" class="custom-select cs-select">
                                        <option selected value="">Select...</option>
                                        @foreach($states as $state)
                                        <option value="{{ $state->id }}"
                                            {{ old('state') == $state->id ? 'selected' : ''}}>
                                            {{ $state->name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="form-group col-md-3 parameter">
                                    <label>LGAs</label>
                                    <select class="custom-select cs-select" name="parameter" id="lga_id">
                                        <option selected value="">Select...</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-12 parameter">
                                    <br />
                                    <button id="get_users" type="button" class="btn btn-primary btn-block">Get
                                        Users</button>
                                </div>

                            </div>
                        </fieldset>


                        <div class="form-group col-md-6">
                            <label for="discount_name">Name of discount</label>
                            <input type="text" class="form-control custom-input-1" id="discount_name"
                                name="discount_name" value="{{ old('discount_name') }}" autocomplete="off">
                            @error('discount_name')
                            <span class="invalid-feedback-err">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>


                        <div class="form-group col-md-6">
                            <label for="rate">Rate</label>
                            <div class="input-group">
                                <input type="number" min="0.1" step="any" id="rate" class="form-control" name="rate" value="{{ old('rate') }}"
                                    aria-label="Dollar amount (with dot and two decimal places)">
                                <div class="input-group-append">
                                    <span id="percentage" class="input-group-text">0.00</span>
                                    <span class="input-group-text">%</span>
                                </div>
                                @error('rate')
                                <span class="invalid-feedback-err">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="start_date">Duaration(Start)</label>
                            <input type="date" class="form-control custom-input-1" id="start_date"
                                min=<?= date('Y-m-d'); ?> name="start_date" value="{{ old('start_date') }}"
                                autocomplete="off">
                            @error('start_date')
                            <span class="invalid-feedback-err">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="end_date">Duration(End)</label>
                            <input type="date" class="form-control custom-input-1" id="end_date"
                                min=<?= date('Y-m-d');?> name="end_date" value="{{ old('end_date') }}"
                                autocomplete="off">
                            @error('end_date')
                            <span class="invalid-feedback-err">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-12">
                            <label for="description">Description</label>
                            <textarea rows="3" class="form-control" id="description-1" rows="5" maxlength="250"
                                name="description">{{ old('description') }}</textarea>
                        </div>
                    </div>





                    <div class="col-md-12">
                        <label> Notify Users</label>
                        <div class="flex-this">
                            <span class="f" style="display:flex">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio1" name="notify" class="custom-control-input"
                                        {{ old('notify') == 1 ? 'checked' : ''}} value="1">
                                    <label class="custom-control-label" for="customRadio1">Yes</label>
                                </div>

                                <div class="custom-control custom-radio" style="padding-left: 50px">
                                    <input type="radio" id="customRadio2" name="notify" class="custom-control-input"
                                        {{ old('notify') == 0 ? 'checked' : ''}} value="0">
                                    <label class="custom-control-label" for="customRadio2">No</label>
                                </div>
                            </span>

                            <button type="submit" class="btn btn-primary pull-right-1">Create</button>
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

$('.show-estate').hide();
$('.show-service').hide();
$('.parameter').hide();
$('#add-users').hide();
$('.add-page').hide();

$(document).ready(function() {
    $('.custom-select.cs-select').change(function() {
        $('.custom-select.cs-select').each(function(index, item) {
            if ($(this).children("option:selected").val()) {
                $(this).next('.invalid-feedback-err').hide();
            }

        });
    });

    $('.custom-input-1').on('blur', function() {
        $('.custom-input-1').each(function(index, item) {
            if ($(this).val() !== '') {
                $(this).next('.invalid-feedback-err').hide();
            }

        });
    });


    $('#rate').keyup(function() {
        let rate = $(this).val();
        let newrate = parseFloat(rate) / 100;
        if (rate) {
        let newrate = parseFloat(rate) / 100;
        $('#percentage').text(newrate);
    }else{
        $('#percentage').text('0'); 
    }
    });


    let rate = $('#rate').val();
    if (rate) {
        let newrate = parseFloat(rate) / 100;
        $('#percentage').text(newrate);
    }else{
        $('#percentage').text('0'); 
    }

});
</script>
<script>
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


    $('.selectpicker.select-all-service').on('change', function() {
        var selectPicker = $(this);
        var selectAllOption = selectPicker.find('option.select-all');
        var checkedAll = selectAllOption.prop('selected');
        var optionValues = selectPicker.find('option[value!="all"][data-divider!="true"]');

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



    $('.selectpicker.select-services').on('change', function() {
        var selectPicker = $(this);
        var selectAllOption = selectPicker.find('option.select-all');
        var checkedAll = selectAllOption.prop('selected');
        var optionValues = selectPicker.find('option[value!="all-services"][data-divider!="true"]');


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
});
</script>

<script>
$(document).ready(function() {
    var state, entity_user_type = '';
    $('#state_id').change(function() {
        state = $(this).children("option:selected").val();
        $.ajax({
            url: "{{ route('admin.getLGA',app()->getLocale()) }}",
            method: "POST",
            dataType: "JSON",
            data: {
                "_token": "{{ csrf_token() }}",
                "state_id": state
            },
            success: function(data) {
                if (data) {
                    $('#lga_id').html(data.lgas);
                } else {
                    var message =
                        'Error occured while trying to get Enity Parameter List`s in ';
                    var type = 'error';
                    displayMessage(message, type);
                }
            },
        })
    });
    $('#get_users').on("click", function() {
        var entity = $('#entity_id').children("option:selected").val();
        if (entity != 'estate') {
            $.ajax({
                url: "{{ route('admin.discount_users',app()->getLocale()) }}",
                method: "POST",
                dataType: "JSON",
                data: {
                    "_token": "{{ csrf_token() }}",
                    data: $('#discountForm').serialize()
                },
                success: function(data) {
                    if (data) {
                        $("#users").html(data.options).selectpicker('refresh');
                    } else {
                        var message =
                            'Error occured while trying to get Enity Parameter List`s in ';
                        var type = 'error';
                        displayMessage(message, type);
                        ory
                    }
                },
            })
        } else {
            $('#entity_id ~.invalid-feedback-err').html('Please select an Entity');
        }

    });



    $('#estate_id').on("change", function() {
        $.ajax({
            url: "{{ route('admin.discount_users',app()->getLocale()) }}",
            method: "POST",
            dataType: "JSON",
            data: {
                "_token": "{{ csrf_token() }}",
                data: $('#discountForm').serialize()
            },
            success: function(data) {
                if (data) {
                    $("#estate-user").html(data.options).selectpicker('refresh');
                } else {
                    var message =
                        'Error occured while trying to get Enity Parameter List`s in ';
                    var type = 'error';
                    displayMessage(message, type);
                    ory
                }
            },
        });

    });


    $('.selectpicker.select-all-service').on('changed.bs.select', function(e, clickedIndex, isSelected,
        previousValue) {
        var categoryid = $(this).val();
        $.ajax({
            url: "{{ route('admin.category_services',app()->getLocale()) }}",
            method: "POST",
            dataType: "JSON",
            data: {
                "_token": "{{ csrf_token() }}",
                data: categoryid.length > 0 ? categoryid : '1'
            },
            beforeSend: function() {
                $("#service_id").html();
            },
            success: function(data) {
                if (data) {
                    $("#service_id").html(data.service).selectpicker('refresh');
                } else {
                    var message =
                        'Error occured while trying to get Category List`s in ';
                    var type = 'error';
                    displayMessage(message, type);
                }
            },
        })


    });


});
</script>


<script>
//when pages loads
$(document).ready(function() {
    var entity = $('#entity_id').children("option:selected").val();
    if (entity === 'client') {
        $('.show-service').hide();
        $('.parameter').show();
        $('#add-users').show();
        $('.add-page').show();
    }
    if (entity === 'estate') {
        $('.show-estate').show();
        $('.show-service').hide();
        $('.parameter').show();
        $('#add-users').hide();
        $('.not-users').show();

        $.ajax({
            url: "{{ route('admin.all_estates',app()->getLocale()) }}",
            method: "POST",
            dataType: "JSON",
            data: {
                "_token": "{{ csrf_token() }}",
            },
            success: function(data) {
                if (data) {
                    $('#estate_id').html(data.estates);
                } else {
                    var message =
                        'Error occured while trying to get Enity Estate List`s in ';
                    var type = 'error';
                    displayMessage(message, type);
                }
            },
        });

    } else {
        $('.show-estate').hide();
    }



    if (entity === 'service') {
        $('.show-estate').hide();
        $('.show-service').show();
        $('.parameter').hide();
        $('.add-page').show();

        $.ajax({
            url: "{{ route('admin.categories',app()->getLocale()) }}",
            method: "POST",
            dataType: "JSON",
            data: {
                "_token": "{{ csrf_token() }}",
            },
            success: function(data) {
                if (data) {
                    $('#category_id').html(data.category).selectpicker('refresh');

                } else {
                    var message =
                        'Error occured while trying to get Enity Estate List`s in ';
                    var type = 'error';
                    displayMessage(message, type);
                }
            },
        })
    }



    if (entity) {
        $.ajax({
            url: "{{ route('admin.discount_users',app()->getLocale()) }}",
            method: "POST",
            dataType: "JSON",
            data: {
                "_token": "{{ csrf_token() }}",
                data: $('#discountForm').serialize()
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
    }

})
</script>


<script>
//when there is onchange event
$(document).ready(function() {
    $('#entity_id').on("change", function() {
        var entity = $(this).children("option:selected").val();
        if (entity === 'client') {
            $('.show-service').hide();
            $('.parameter').show();
            $('#add-users').show();
            $('.add-page').show();
        }
        if (entity === 'estate') {
            $('.show-estate').show();
            $('.show-service').hide();
            $('.parameter').show();
            $('#add-users').hide();
            $('.not-users').show();

            $.ajax({
                url: "{{ route('admin.all_estates',app()->getLocale()) }}",
                method: "POST",
                dataType: "JSON",
                data: {
                    "_token": "{{ csrf_token() }}",

                },
                success: function(data) {
                    if (data) {
                        $('#estate_id').html(data.estates);
                    } else {
                        var message =
                            'Error occured while trying to get Enity Estate List`s in ';
                        var type = 'error';
                        displayMessage(message, type);
                    }
                },
            })
        } else {
            $('.show-estate').hide();
        }

        if (entity === 'service') {
            $('.show-service').show();
            $('.show-estate').hide();
            $('.parameter').hide();
            $.ajax({
                url: "{{ route('admin.categories',app()->getLocale()) }}",
                method: "POST",
                dataType: "JSON",
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data) {
                    if (data) {
                        $('#category_id').html(data.category).selectpicker('refresh');

                    } else {
                        var message =
                            'Error occured while trying to get Enity Estate List`s in ';
                        var type = 'error';
                        displayMessage(message, type);
                    }
                },
            })

        } else {
            $('.show-services').hide();
        }


        if (entity) {
            $.ajax({
                url: "{{ route('admin.discount_users',app()->getLocale()) }}",
                method: "POST",
                dataType: "JSON",
                data: {
                    "_token": "{{ csrf_token() }}",
                    data: $('#discountForm').serialize()
                },
                success: function(data) {
                    if (data) {
                        $("#users").html(data.options).selectpicker('refresh');
                    } else {
                        var message =
                            'Error occured while trying to get Enity Users List`s in ';
                        var type = 'error';
                        displayMessage(message, type);
                    }
                }
            });
        }

    });

});
</script>


@endpush
@endsection