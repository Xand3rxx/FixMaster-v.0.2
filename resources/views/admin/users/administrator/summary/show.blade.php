@extends('layouts.dashboard')
@section('title', Str::title($user['account']['last_name'] ." ". $user['account']['first_name'].'\'s Summary'))
@section('content')
@include('layouts.partials._messages')

<div class="content-body">
    <div class="container pd-x-0">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.users.administrator.index', app()->getLocale())}}">Administrators List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ Str::title($user['account']['last_name'] ." ". $user['account']['first_name']) }}</li>
                    </ol>
                </nav>
            </div>

            <div class="d-md-block">
                <a href="{{ route('admin.users.administrator.index', app()->getLocale()) }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Back</a>

            </div>
        </div>

        <div class="row row-xs">
            <div class="col-sm-12 col-lg-12">
                <div class="card mg-b-20 mg-lg-b-25">
                    <div class="card-header pd-y-15 pd-x-20 d-flex align-items-center justify-content-between">
                        <h6 class="tx-uppercase tx-semibold mg-b-0">{{ Str::title($user['account']['last_name'] ." ". $user['account']['first_name']) }} Summary</h6>
                    </div><!-- card-header -->
                </div>
            </div>
        </div>
    </div>

    @section('scripts')

    @endsection

    @endsection