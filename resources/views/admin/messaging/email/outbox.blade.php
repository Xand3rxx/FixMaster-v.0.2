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
                    <h4 class="mg-b-0 tx-spacing--1">Outbox</h4>
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
                                    <th>Date</th>
                                    <th>Title</th>
                                    <th>Sender</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody id="tbrows">
                                
                                       

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
            var trow="";
            var cnt = 0;
            $.get( url+"/api/messaging/outbox", function( data ) {
                $.each(data.data, function(key, val){
                    cnt++;
                    trow ='<tr><td class="tx-color-03 tx-center">'+cnt+'</td>';
                    trow +='<td class="tx-medium">'+val.created_at+'</td>';
                    trow +='<td class="tx-medium">'+val.title+'</td>';
                    trow +='<td class="tx-medium">'+val.sender+'</td>';
                    trow +='<td class=" text-center">';
                    trow +='<div class="dropdown-file">';
                    trow +='<a href="" class="dropdown-link" data-toggle="dropdown">';
                    trow +='<i data-feather="more-vertical"></i></a>';
                    trow +='<div class="dropdown-menu dropdown-menu-right">';
                    trow +='<a href="" class="dropdown-item details text-primary">';
                    trow +='<i class="far fa-user"></i> Summary</a>';
                    trow +='<a href="" class="dropdown-item details text-info">';
                    trow +='<i class="far fa-edit"></i> Edit</a>';
                    trow +='<a href="" class="dropdown-item details text-secondary">'
                    trow +='<i class="fa fa-percent"></i> Discount </a>';
                    trow +='<a href="" class="dropdown-item details text-success">';
                    trow +='<i class="fas fa-ban"></i> Approve</a>';
                    trow +='<a href="" class="dropdown-item details text-warning">'
                    trow +='<i class="fas fa-ban"></i> Decline</a>';
                    trow +='</div></div></td></tr>';
           
             $('#tbrows').append(trow);
        })
           
      });
        });

    </script>
@endsection

@endsection
