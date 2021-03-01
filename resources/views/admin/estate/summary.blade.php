@extends('layouts.dashboard')
@section('title', $estate->estate_name.'\'s Summary')
@include('layouts.partials._messages')
@section('content')
    <div class="content-body">
        <div class="container pd-x-0">
            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.list_estate', app()->getLocale()) }}">Estates</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $estate->estate_name }}</li>
                        </ol>
                    </nav>
                    {{-- <h4 class="mg-b-0 tx-spacing--1">Administrators List</h4> --}}
                </div>

                <div class="d-md-block">
                    <a href="{{ route('admin.list_estate', app()->getLocale()) }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Back</a>
                    <a href="{{ route('admin.edit_estate', [ 'estate'=>$estate->uuid, 'locale'=>app()->getLocale() ]) }}" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
                    @if($estate->is_active == 0)
                        <a href="{{ route('admin.reinstate_estate', ['estate'=>$estate->uuid, 'locale'=>app()->getLocale()]) }}" class="btn btn-success"><i class="fas fa-undo"></i>Reinstate</a>
                    @else
                    <a href="{{ route('admin.deactivate_estate', ['estate'=>$estate->uuid, 'locale'=>app()->getLocale()]) }}" class="btn btn-warning"><i class="fas fa-ban"></i> Deactivate</a>
                    @endif
                    <a href="{{ route('admin.delete_estate', ['estate'=>$estate->uuid, 'locale'=>app()->getLocale()]) }}" class="btn btn-danger"><i class="fas fa-trash"></i> Delete</a>
                </div>
            </div>

            <div class="row row-xs">
                <div class="col-sm-12 col-lg-12">
                    <div class="card mg-b-20 mg-lg-b-25">
                        <div class="card-header pd-y-15 pd-x-20 d-flex align-items-center justify-content-between">
                            <h6 class="tx-uppercase tx-semibold mg-b-0">{{ $estate->estate_name }} Summary</h6>
                            <nav class="nav nav-with-icon tx-13">
                                <!-- <a href="" class="nav-link"><i data-feather="plus"></i> Add New</a> -->
                            </nav>
                        </div><!-- card-header -->
                        <div class="card-body pd-25">
                            <div class="media">
{{--                                <div class="pos-relative d-inline-block mg-b-20">--}}
{{--                                    <div class="avatar avatar-xxl"><span class="avatar-initial rounded-circle bg-gray-700 tx-normal"><i class="icon ion-md-person"></i></span></div>--}}
{{--                                    --}}{{-- <a href="" class="contact-edit-photo"><i data-feather="edit-2"></i></a> --}}
{{--                                </div>--}}
                                <div class="media-body pd-l-25">
                                    {{-- <h5 class="mg-b-5 mb-2">Business Type: Marine Cargo</h5> --}}
                                    <div class="table-responsive">
                                        <table class="table table-striped table-sm mg-b-0">
                                            <tbody>
                                            <tr>
                                                <td class="tx-medium">Estate Name</td>
                                                <td class="tx-color-03">{{ $estate->estate_name }}</td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Author</td>
                                                <td class="tx-color-03"> {{ $estate->first_name .' '. $estate->last_name }} </td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Phone Number</td>
                                                <td class="tx-color-03"> {{ $estate->phone_number }} </td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Email</td>
                                                <td class="tx-color-03"> {{ $estate->email }} </td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Status</td>
                                                <td class="tx-color-03"> @if($estate->is_active == '1') Active @else Inactive @endif </td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Date of Birth</td>
                                                <td class="tx-color-03"> {{ Carbon\Carbon::parse($estate->date_of_birth, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }} </td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Identification Type</td>
                                                <td class="tx-color-03"> {{ $estate->identification_type }} </td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Identification Number</td>
                                                <td class="tx-color-03"> {{ $estate->identification_number }} </td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Expiry Date</td>
                                                <td class="tx-color-03"> {{ $estate->expiry_date }} </td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Full Address</td>
                                                <td class="tx-color-03"> {{ $estate->full_address }} </td>
                                            </tr>
                                             <tr>
                                              <td class="tx-medium">State</td>
                                              <td class="tx-color-03"> {{ $estate->state->name }} </td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">L.G.A</td>
                                                <td class="tx-color-03"> {{ $estate->lga->name }} </td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Town</td>
                                                <td class="tx-color-03"> {{ $estate->town }} </td>
                                            </tr>
                                            <tr>
                                              <td class="tx-medium">Landmark</td>
                                              <td class="tx-color-03"> {{ $estate->landmark }} </td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Date Created</td>
                                                <td class="tx-color-03"> {{ Carbon\Carbon::parse($estate->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }} ({{ $estate->created_at->diffForHumans() }}) </td>
                                            </tr>
                                            <tr>
                                                <td class="tx-medium">Last Edited</td>
                                                <td class="tx-color-03"> @if(!empty($estate->updated_at)) {{ Carbon\Carbon::parse($estate->updated_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }} @else Never @endif </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- card -->
                </div><!-- col -->

            </div><!-- row -->

        </div>
    </div>

@endsection
