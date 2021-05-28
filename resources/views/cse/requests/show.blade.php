@extends('layouts.dashboard')
@section('title', 'Service Request Details')
    @include('layouts.partials._messages')
@section('content')
    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/css/dashforge.filemgr.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/css/bootstrap-multiselect.css') }}">
    <input type="hidden" id="route" class="d-none"
        value="{{ route('cse.sub_service_dynamic_fields', app()->getLocale()) }}">

    <div class="content-body">
        <div class="container pd-x-0">
            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                            <li class="breadcrumb-item"><a
                                    href="{{ route('cse.index', app()->getLocale()) }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('cse.requests.index', app()->getLocale()) }}">Requests</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Request Details</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row row-xs">

                <div class="col-lg-12 col-xl-12">
                    <div class="divider-text"> Service Request Modality</div>

                    <div class="media align-items-center">
                        <span class="tx-color-03 d-none d-sm-block">
                            <img src="{{ asset('assets/images/default-male-avatar.png') }}" class="avatar rounded-circle"
                                alt="Male Avatar">
                        </span>
                        <div class="media-body mg-sm-l-20">
                            <h4 class="tx-18 tx-sm-20 mg-b-2">
                                {{ ucfirst($service_request->client->account->first_name) }}
                                {{ ucfirst($service_request->client->account->last_name) }}
                                <a class="btn btn-sm btn-primary btn-icon" title="Call Client"
                                    href="tel:{{ $service_request->client->account->contact->phone_number }}"><i
                                        class="fas fa-phone"></i> </a>

                                <a href="#" data-service="{{ $service_request['uuid'] }}"
                                    class="notify-client-schedule-date btn btn-sm btn-success btn-icon"
                                    title="Notify Client to schedule date"><i class="fas fa-bell"></i> </a>
                            </h4>

                            <p class="tx-13 tx-color-03 mg-b-0">Scheduled Time:
                                {{ !empty($request['service_request']['preferred_time']) ? Carbon\Carbon::parse($request['service_request']['preferred_time'], 'UTC')->isoFormat('MMMM Do YYYY') : 'UNSCHEDULED' }}
                            </p>
                            <p class="tx-13 tx-color-03 mg-b-0">Job Ref.: {{ $service_request->unique_id }} </p>
                        </div>
                    </div><!-- media -->

                    <div class="contact-content-header mt-4">
                        <nav class="nav">
                            <a href="#serviceRequestActions" class="nav-link active" data-toggle="tab">Service Request
                                Actions</a>
                            <a href="#description" class="nav-link" data-toggle="tab"><span>Job Description</a>
                            <a href="#serviceRequestSummary" class="nav-link" data-toggle="tab"><span>Service Request
                                    Summary</a>
                        </nav>
                    </div><!-- contact-content-header -->

                    <div class="contact-content-body">
                        <div class="tab-content">

                            {{-- Service Request Actions --}}
                            <form class="form-data" enctype="multipart/form-data" method="POST"
                                action="{{ route('cse.service.request.action', ['locale' => app()->getLocale(), 'service_request' => $service_request->uuid]) }}">
                                @csrf
                                <div id="serviceRequestActions" class="tab-pane show active pd-20 pd-xl-25">
                                    <div class="mt-4">
                                        <div class="tx-13 mg-b-25">
                                            <div id="wizard3">
                                                @if(is_null($service_request['preferred_time']))
                                                @include('cse.requests.includes.schedule_date')
                                                @endif
                                                {{-- @include('cse.requests.includes.categorization') --}}
                                                @include('cse.requests.includes.invoice-building')
                                                @include('cse.requests.includes.reoccuring_actions')
                                            </div>
                                        </div>
                                    </div><!-- df-example -->

                                </div>

                                <button type="submit" class="btn btn-primary d-none" id="update-progress">Update
                                    Progress</button>

                            </form>
                            {{-- End of Service Request Actions --}}

                            {{-- Job Description --}}
                            {{-- @include('cse.requests.includes.job_description') --}}
                            {{-- End of Job Description --}}

                            {{-- Service Request Summary --}}
                            {{-- @include('cse.requests.includes.service_request_summary') --}}
                            {{-- End Service Request Summary --}}

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Modals --}}
    {{-- @include('cse.requests.includes.modals') --}}
    {{-- Modals End --}}
    @push('scripts')
        @include('cse.requests.includes.scripts')
    @endpush

@endsection
