@extends('layouts.dashboard')
@section('title', 'My Services List')
@section('content')
    @include('layouts.partials._messages')

    <div class="content-body">
        <div class="container pd-x-0">
            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Estates</li>
                        </ol>
                    </nav>
                    <h4 class="mg-b-0 tx-spacing--1">Estates List</h4>
                </div>
                <div class="d-md-block">
                    <a href="{{ route('admin.add_estate', app()->getLocale()) }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add New</a>
                </div>
            </div>

            <div class="row row-xs">
                <div class="col-lg-12 col-xl-12 mg-t-10">
                    <div class="card mg-b-10">
                        <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                            <div>
                                <h6 class="mg-b-5">Estates as of {{ date('M, d Y') }}</h6>
                                <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all FixMaster Estates.</p>
                            </div>

                        </div><!-- card-header -->

                        <div class="table-responsive">

                            <table class="table table-hover mg-b-0" id="basicExample">
                                <thead class="thead-primary">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Estate Name</th>
                                    <th>Author</th>
                                    <th>Phone Number</th>
                                    <th>Clients</th>
                                    <th>Status</th>
                                    <th>Created By</th>
                                    <th>Approved / Declined By</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($myServiceRequests as $k=> $myServiceRequest)
                                <tr>
                                <td class="tx-color-03 tx-center">{{ ++$k }}</td>
                                <td class="tx-medium">{{ $myServiceRequest['unique_id'] }}</td>
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


@section('scripts')
    <script>
      

    </script>
@endsection

@endsection
