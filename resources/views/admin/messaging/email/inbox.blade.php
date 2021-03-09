@extends('layouts.dashboard')
@section('title', 'Inbox')
@section('content')
    @include('layouts.partials._messages')

    <div class="content-body">
        <div class="container pd-x-0">
            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Emails</li>
                        </ol>
                    </nav>
                    <h4 class="mg-b-0 tx-spacing--1">Inbox</h4>
                </div>
                <div class="d-md-block">
                    <a href="{{ route('admin.new_email', app()->getLocale()) }}" class="btn btn-primary"><i class="fas fa-plus"></i> New Message</a>
                </div>
            </div>

            <div class="row row-xs">
                <div class="col-lg-12 col-xl-12 mg-t-10">
                    <div class="card mg-b-10">
                        <div class="table-responsive">

                            <table class="table table-hover mg-b-0" id="basicExample">
                                <thead class="thead-primary">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Title</th>
                                    <th>Sender</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                
                                       

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
    var url = window.location.origin
        $(document).ready(function() {

            $.get( url+"/api/inbox", function( data ) {
            console.log(data)
           
      });
        });

    </script>
@endsection

@endsection
