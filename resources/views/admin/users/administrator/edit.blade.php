@extends('layouts.dashboard')
@section('title', 'Edit '. Str::title($user['account']['last_name'] .' '. $user['account']['first_name'].'\'s Account'))
@section('content')
<div class="content-body">
    <div class="container pd-x-0">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.users.administrator.index', app()->getLocale())}}">Administrators List</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> Edit Administrator</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Edit {{ Str::title($user['account']['last_name'] ." ". $user['account']['first_name']) }}'s Account</h4>
            </div>

            <div class="d-md-block">
                <a href="{{ route('admin.users.administrator.index', app()->getLocale()) }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Back</a>
            </div>
        </div>
        <div class="row row-xs">
            <div class="col-lg-12 col-xl-12">
                <form method="POST" action="{{ route('admin.users.administrator.update',[app()->getLocale(), $user['uuid']]) }}">
                    @csrf @method('PUT')
                    <input type="hidden" name="uuid" value="{{$user['uuid']}}">
                    <div class="col-md-12">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="first_name">First Name</label>
                                <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name') ?? $user['account']->first_name }}" placeholder="First Name" autocomplete="off">
                                @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="middle_name">Middle Name</label>
                                <input type="text" class="form-control" id="middle_name" name="middle_name" value="{{ old('middle_name') ?? $user['account']->middle_name }}" autocomplete="off" placeholder="Middle Name">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="last_name">Last Name</label>
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name') ?? $user['account']->last_name }}" autocomplete="off" placeholder="Last Name">
                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="inputEmail4">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') ?? $user->email }}" autocomplete="off" placeholder="Email">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="phone_number">Phone Number</label>
                                <input type="tel" maxlength="11" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" value="{{ old('phone_number')?? $user['phones'][0]['number'] }}" placeholder="Phone Number" autocomplete="off">
                                @error('phone_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="role_id">Designation</label>
                                <select class="custom-select @error('role_id') is-invalid @enderror" id="designation" name="role_id">
                                    <option selected disabled value="0">Select...</option>
                                    @foreach ($roles as $role)
                                    <option value="{{$role->id}}" {{old('role_id') == $role->id ? 'selected' : ''}} @if($user['roles'][0]['id']==$role->id) selected @endif> {{Str::title($role->name)}}</option>
                                    @endforeach
                                </select>
                                @error('role_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <div class="col-md-12 d-none permission">
                        <legend>Access & Permissions</legend>
                        <p>Check areas to allow Admin Access.</p>
                        <div class="form-row">
                            @foreach($permissions as $id => $name)
                            <div class="form-group col-md-2">
                                <div class="custom-control custom-checkbox ">
                                    <input type="checkbox" id="{{$id}}" name="permission[{{$id}}]" class="custom-control-input">
                                    <label class="custom-control-label" for="{{$id}}">{{$name}}</label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>


                    <div class="col-md-12 mt-4">
                        <button type="submit" class="btn btn-primary"> Update Profile</button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    "use strict";
    $(document).ready(function() {
        $('#designation').val() == '1' ? $('.permission').addClass('d-none') : $('.permission').removeClass('d-none');
        $('#designation').change(function() {
            if ($(this).val() == '1') {
                $('.permission').addClass('d-none');
            } else {
                $('.permission').removeClass('d-none');
            }
        });
    });
</script>
@endsection