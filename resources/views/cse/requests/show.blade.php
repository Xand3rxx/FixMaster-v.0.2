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
                                @php
                                    if($service_request['client']['account']['gender'] == 'male' || $service_request['client']['account']['gender'] == 'others'){
                                        $genderAvatar = 'default-male-avatar.png';
                                    }else{
                                        $genderAvatar = 'default-female-avatar.png';
                                    }
                                @endphp

                                @if(empty($service_request['client']['account']['avatar']))
                                    <img src="{{ asset('assets/images/'.$genderAvatar) }}" class="avatar rounded-circle" alt="Default avatar">
                                @elseif(!file_exists(public_path('assets/user-avatars/'.$service_request['client']['account']['avatar'])))
                                    <img src="{{ asset('assets/images/'.$genderAvatar) }}" class="avatar rounded-circle" alt="Profile avatar">
                                @else
                                    <img src="{{ asset('assets/user-avatars/'.$service_request['client']['account']['avatar']) }}" class="avatar rounded-circle" alt="Profile avatar">
                                @endif

                        </span>
                        <div class="media-body mg-sm-l-20">
                            <h4 class="tx-18 tx-sm-20 mg-b-2">
                                {{ ucfirst($service_request['client']['account']['first_name']) }}
                                {{ ucfirst($service_request['client']['account']['last_name']) }}
                                <a class="btn btn-sm btn-primary btn-icon" title="Call Client"
                                    href="tel:{{ $service_request['client']['account']['contact']['phone_number'] }}"><i
                                        class="fas fa-phone"></i> </a>

                                @if (empty($service_request['preferred_time']))
                                    <a href="#" data-service="{{ $service_request['uuid'] }}"
                                        class="notify-client-schedule-date btn btn-sm btn-success btn-icon"
                                        title="Notify Client to schedule date"><i class="fas fa-bell"></i> </a>
                                @endif
                            </h4>

                            <p class="tx-13 tx-color-03 mg-b-0">Scheduled Date:
                                {{ !empty($service_request['preferred_time']) ? Carbon\Carbon::parse($service_request['preferred_time'], 'UTC')->isoFormat('MMMM Do YYYY') : 'UNSCHEDULED' }}
                            </p>
                            <p class="tx-13 tx-color-03 mg-b-0">Job Ref.: {{ $service_request['unique_id'] }} </p>
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
                            <div id="serviceRequestActions" class="tab-pane show active pd-20 pd-xl-25">
                            {{-- Service Request Actions --}}
                            <form id="service_request_form" class="form-data" enctype="multipart/form-data" method="POST"
                                action="{{ route('cse.service.request.action', ['locale' => app()->getLocale(), 'service_request' => $service_request->uuid]) }}">
                                @csrf
                                <div id="serviceRequestActions" class="tab-pane show active pd-20 pd-xl-25">
                                    <div class="mt-4">
                                        <div class="tx-13 mg-b-25">
                                            <div id="wizard3">
                                                @if ($stage == \App\Models\ServiceRequest::CSE_ACTIVITY_STEP['schedule_categorization'])
                                                    {{-- Stage 1 --}}
                                                    {{-- @if (is_null($service_request['preferred_time'])) --}}
                                                    @include('cse.requests.includes.schedule_date')
                                                    {{-- @endif --}}
                                                    @include('cse.requests.includes.categorization')
                                                    {{-- End of Stage 1 --}}
                                                @else
                                                    {{-- Stage 2 --}}
                                                    {{-- @include('cse.requests.includes.initial-technician') --}}
                                                    {{-- End of Stage 2 --}}
                                                    {{-- Stage 3 --}}
                                                    {{-- @include('cse.requests.includes.invoice-building') --}}

                                                    {{-- End of Stage 3 --}}
                                                    @include('cse.requests.includes.reoccuring-actions')
                                                    @include('cse.requests.includes.materials-acceptance')
                                                    @include('cse.requests.includes.project-progresses')

                                                @endif

                                            </div>
                                        </div>
                                    </div><!-- df-example -->

                                </div>

                                <button type="submit" class="btn btn-primary d-none" id="update-progress">Update
                                    Progress</button>

                            </form>
                            </div>
                            {{-- End of Service Request Actions --}}

                            {{-- Job Description --}}
                            @if(!empty($materials_accepted))
                                @include('cse.requests.includes.job_description')
                            @endif

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
        <script>
            $('#wizard3').steps({
                headerTag: 'h3',
                bodyTag: 'section',
                autoFocus: true,
                titleTemplate: '<span class="number">#index#</span> <span class="title">#title#</span>',
                loadingTemplate: '<span class="spinner"></span> #text#',
                labels: {
                    // current: "current step:",
                    // pagination: "Pagination",
                    finish: "Update Job Progress",
                    // next: "Next",
                    // previous: "Previous",
                    loading: "Loading ..."
                },
                stepsOrientation: 1,
                // transitionEffect: "fade",
                // transitionEffectSpeed: 200,
                showFinishButtonAlways: false,
                onStepChanging: function(event, currentIndex, newIndex) {
                    if (currentIndex < newIndex) {
                        @if ($stage == \App\Models\ServiceRequest::CSE_ACTIVITY_STEP['schedule_categorization'])
                            // Step 1 Schedule Date
                            if (currentIndex === 0) {
                            return ($("#service-date-time").val().length !== 0) ? true : false;
                            }
                            // Step 2 Re-categorization
                            if (currentIndex === 1) {
                            return ($("#sub_service_uuid").val().length !== 0) ? true : false;
                            }
                        @else
                            return true;
                        @endif
                    } else {
                        // Always allow step back to the previous step even if the current step is not valid.
                        return true;
                    }
                },
                onFinished: function(event, currentIndex) {
                    $('#update-progress').trigger('click');
                },
            });

        </script>
        @include('cse.requests.includes.scripts')
    @endpush

@endsection
