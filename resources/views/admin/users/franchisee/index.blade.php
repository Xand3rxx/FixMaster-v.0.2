@extends('layouts.dashboard')
@section('title', 'Franchisee List')
@include('layouts.partials._messages')

@section('content')

<div class="content-body">
    <div class="container pd-x-0">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Franchisee List</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Franchisee List</h4>
            </div>
            <div class="d-md-block">
                <a href="{{ route('admin.users.franchisee.create', app()->getLocale()) }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add New</a>
            </div>
        </div>

        <div class="row row-xs">
            <div class="col-lg-12 col-xl-12 mg-t-10">
                <div class="card mg-b-10">
                    <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                        <div>
                            <h6 class="mg-b-5">Franchisee as of {{ date('M, d Y') }}</h6>
                            <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all FixMaster Franchisee.</p>
                        </div>

                    </div><!-- card-header -->

                    <div class="table-responsive">

                        <table class="table table-hover mg-b-0" id="basicExample">
                            <thead class="thead-primary">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Franchisee ID</th>
                                    <th>Full Name</th>
                                    <th>E-Mail</th>
                                    <th>Phone Number</th>
                                    <th>CAC Number</th>
                                    <!-- <th>Requests</th> -->
                                    <th>Status</th>
                                    <th>Date Created</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $franchisee)
                                <tr>
                                    <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
                                    <td class="tx-medium">{{ $franchisee['unique_id']}}</td>
                                    <td class="tx-medium">{{ Str::title($franchisee['user']['account']['last_name'] ." ". $franchisee['user']['account']['first_name']) }}</td>
                                    <td class="tx-medium">{{ $franchisee['user']['email'] }}</td>
                                    <td class="tx-medium">{{ $franchisee['user']['contact']['phone_number'] ?? 'UNAVAILABLE' }}</td>

                                    <td class="tx-medium text-uppercase">{{$franchisee['cac_number']}}</td>

                                    <!-- <td class="tx-medium text-info">{{ $franchisee['user']['requests'] ?? '0'  }}</td> -->
                                    <td class="text-medium text-success">{{is_null($franchisee['user']['deleted_at']) ? 'Active' : InActive}}</td>
                                    <td class="text-medium">{{ Carbon\Carbon::parse($franchisee->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                                    <td class=" text-center">
                                        <div class="dropdown-file">
                                            <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="#" class="dropdown-item details text-warning"><i class="fas fa-ban"></i> Deactivate</a>
                                                <a href="#" class="dropdown-item details text-danger"><i class="fas fa-trash"></i> Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div><!-- table-responsive -->
                </div><!-- card -->

            </div><!-- col -->
        </div><!-- row -->

    </div><!-- container -->
</div>

@endsection