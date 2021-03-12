@extends('layouts.dashboard')
@section('title', 'Inbox')
@section('content')
@include('layouts.partials._messages')
<link rel="stylesheet" href="{{ asset('assets/dashboard/assets/css/dashforge.mail.css') }}">

<div class="mail-wrapper ml-2">
  <div class="mail-sidebar">
    <div class="mail-sidebar-body">
    </div>
  </div>

  <div class="mail-group">
    <div class="mail-group-header">

      <div class="pd-10">
        <a href="{{ route('admin.new_email', app()->getLocale()) }}" data-toggle="modal" class="btn btn-primary btn-block tx-uppercase tx-10 tx-medium tx-sans tx-spacing-4">Compose</a>
      </div>

      
    </div><!-- mail-group-header -->
    <div class="mail-group-body">
        <div class="pd-y-15 pd-x-20 d-flex justify-content-between align-items-center">
          <h6 class="tx-uppercase tx-semibold mg-b-0">Outbox</h6>
          <div class="dropdown tx-13">
            <span class="tx-color-03">Sort:</span> <a href="" class="dropdown-link link-02">Date</a>
          </div><!-- dropdown -->
        </div>
        <label class="mail-group-label">Today</label>
        <ul class="list-unstyled media-list mg-b-0">
          <li class="media unread">
            <div class="avatar"><span class="avatar-initial rounded-circle bg-indigo">d</span></div>
            <div class="media-body mg-l-15">
              <div class="tx-color-03 d-flex align-items-center justify-content-between mg-b-2">
                <span class="tx-12">Dyanne Aceron</span>
                <span class="tx-11">1:20pm</span>
              </div>
              <h6 class="tx-13">Just asking questions</h6>
              <p class="tx-12 tx-color-03 mg-b-0">Aenean commodo ligula eget dolor. Ae nean massa. Cum sociis natoque </p>
            </div><!-- media-body -->
          </li>
          <li class="media">
            <div class="avatar"><img src="../https://via.placeholder.com/350" class="rounded-circle" alt=""></div>
            <div class="media-body mg-l-15">
              <div class="tx-color-03 d-flex align-items-center justify-content-between mg-b-2">
                <span class="tx-12">Reynante Labares</span>
                <span class="tx-11">11:40am</span>
              </div>
              <h6 class="tx-13">30 Seconds Survey to Your Next Job</h6>
              <p class="tx-12 tx-color-03 mg-b-0">Aenean commodo ligula eget dolor. Ae nean massa. Cum sociis natoque </p>
            </div><!-- media-body -->
          </li>
          <li class="media">
            <div class="avatar"><span class="avatar-initial rounded-circle bg-gray-800">r</span></div>
            <div class="media-body mg-l-15">
              <div class="tx-color-03 d-flex align-items-center justify-content-between mg-b-2">
                <span class="tx-12">Rolando Paloso</span>
                <span class="tx-11">10:54am</span>
              </div>
              <h6 class="tx-13">Watch, Listen and Play Longer</h6>
              <p class="tx-12 tx-color-03 mg-b-0">Aenean commodo ligula eget dolor. Ae nean massa. Cum sociis natoque </p>
            </div><!-- media-body -->
          </li>
          <li class="media">
            <div class="avatar"><span class="avatar-initial rounded-circle bg-pink">s</span></div>
            <div class="media-body mg-l-15">
              <div class="tx-color-03 d-flex align-items-center justify-content-between mg-b-2">
                <span class="tx-12">Socrates Itumay</span>
                <span class="tx-11">09:50am</span>
              </div>
              <h6 class="tx-13">Pre-Order Sale: Mastering CSS</h6>
              <p class="tx-12 tx-color-03 mg-b-0">Aenean commodo ligula eget dolor. Ae nean massa. Cum sociis natoque </p>
            </div><!-- media-body -->
          </li>
        </ul>
        <label class="mail-group-label">Yesterday</label>
        <ul class="list-unstyled media-list mg-b-0">
          <li class="media">
            <div class="avatar"><img src="../https://via.placeholder.com/500" class="rounded-circle" alt=""></div>
            <div class="media-body mg-l-15">
              <div class="tx-color-03 d-flex align-items-center justify-content-between mg-b-2">
                <span class="tx-12">Yassi Pressman</span>
                <span class="tx-11">8:20pm</span>
              </div>
              <h6 class="tx-13">Envato Contributor Payment</h6>
              <p class="tx-12 tx-color-03 mg-b-0">Commodo ligula eget dolor. Aenean massa cum sociis natoqu</p>
            </div><!-- media-body -->
          </li>
          <li class="media unread">
            <div class="avatar"><span class="avatar-initial rounded-circle bg-teal">i</span></div>
            <div class="media-body mg-l-15">
              <div class="tx-color-03 d-flex align-items-center justify-content-between mg-b-2">
                <span class="tx-12">Isidore Dilao</span>
                <span class="tx-11">06:42pm</span>
              </div>
              <h6 class="tx-13">America's Best Dance Cruise</h6>
              <p class="tx-12 tx-color-03 mg-b-0">Aenean commodo ligula eget dolor. Ae nean massa. Cum sociis natoque </p>
            </div><!-- media-body -->
          </li>
        </ul>
        <label class="mail-group-label">January 20</label>
        <ul class="list-unstyled media-list mg-b-0">
          <li class="media">
            <div class="avatar"><img src="../https://via.placeholder.com/500" class="rounded-circle" alt=""></div>
            <div class="media-body mg-l-15">
              <div class="tx-color-03 d-flex align-items-center justify-content-between mg-b-2">
                <span class="tx-12">Dexter Dela Cruz</span>
                <span class="tx-11">4:18pm</span>
              </div>
              <h6 class="tx-13">A Flaming Pile of Garbage</h6>
              <p class="tx-12 tx-color-03 mg-b-0">Commodo ligula eget dolor. Aenean massa cum sociis natoqu</p>
            </div><!-- media-body -->
          </li>
          <li class="media">
            <div class="avatar"><span class="avatar-initial rounded-circle bg-primary">a</span></div>
            <div class="media-body mg-l-15">
              <div class="tx-color-03 d-flex align-items-center justify-content-between mg-b-2">
                <span class="tx-12">Adrian Monino</span>
                <span class="tx-11">06:42pm</span>
              </div>
              <h6 class="tx-13">America's Best Dance Cruise</h6>
              <p class="tx-12 tx-color-03 mg-b-0">Aenean commodo ligula eget dolor. Ae nean massa. Cum sociis natoque </p>
            </div><!-- media-body -->
          </li>
        </ul>
        <label class="mail-group-label">January 18</label>
        <ul class="list-unstyled media-list mg-b-0">
          <li class="media">
            <div class="avatar"><img src="../https://via.placeholder.com/500" class="rounded-circle" alt=""></div>
            <div class="media-body mg-l-15">
              <div class="tx-color-03 d-flex align-items-center justify-content-between mg-b-2">
                <span class="tx-12">Annie Christensen</span>
                <span class="tx-11">7:26pm</span>
              </div>
              <h6 class="tx-13">Just asking questions</h6>
              <p class="tx-12 tx-color-03 mg-b-0">Commodo ligula eget dolor. Aenean massa cum sociis natoqu</p>
            </div><!-- media-body -->
          </li>
          <li class="media">
            <div class="avatar"><span class="avatar-initial rounded-circle bg-primary">a</span></div>
            <div class="media-body mg-l-15">
              <div class="tx-color-03 d-flex align-items-center justify-content-between mg-b-2">
                <span class="tx-12">Adrian Monino</span>
                <span class="tx-11">06:42pm</span>
              </div>
              <h6 class="tx-13">Watch, Listen and Play Longer</h6>
              <p class="tx-12 tx-color-03 mg-b-0">Aenean commodo ligula eget dolor. Ae nean massa. Cum sociis natoque </p>
            </div><!-- media-body -->
          </li>
          <li class="media">
            <div class="avatar"><img src="../https://via.placeholder.com/600" class="rounded-circle" alt=""></div>
            <div class="media-body mg-l-15">
              <div class="tx-color-03 d-flex align-items-center justify-content-between mg-b-2">
                <span class="tx-12">Robert Restificar</span>
                <span class="tx-11">12:01pm</span>
              </div>
              <h6 class="tx-13">Envato Contributor Payment</h6>
              <p class="tx-12 tx-color-03 mg-b-0">Commodo ligula eget dolor. Aenean massa cum sociis natoqu</p>
            </div><!-- media-body -->
          </li>
          <li class="media">
            <div class="avatar"><span class="avatar-initial rounded-circle bg-purple">r</span></div>
            <div class="media-body mg-l-15">
              <div class="tx-color-03 d-flex align-items-center justify-content-between mg-b-2">
                <span class="tx-12">Raymart Serencio</span>
                <span class="tx-11">10:13am</span>
              </div>
              <h6 class="tx-13">Sale: Javascript Beginners</h6>
              <p class="tx-12 tx-color-03 mg-b-0">Aenean commodo ligula eget dolor. Ae nean massa. Cum sociis natoque </p>
            </div><!-- media-body -->
          </li>
        </ul>
        {{-- <div class="pd-t-1 pd-b-5 pd-x-5">
          <a href="" class="btn btn-xs btn-block btn-light bd-0 tx-uppercase tx-10 tx-spacing-1 tx-medium mn-ht-0">Load more</a>
        </div> --}}
      </div><!-- mail-group-body -->
  </div><!-- mail-group -->

  <div class="mail-content">
    <div class="mail-content-header d-none">
        {{-- <a href="" id="mailContentClose" class="link-02 d-none d-lg-block d-xl-none mg-r-20"><i data-feather="arrow-left"></i></a> --}}
        <div class="media">
        <div class="avatar avatar-sm"><img src="../https://via.placeholder.com/600" class="rounded-circle" alt=""></div>
        <div class="media-body mg-l-10">
            <h6 class="mg-b-2 tx-13">Reynante Labares</h6>
            <span class="d-block tx-11 tx-color-03">Today, 11:40am</span>
        </div><!-- media-body -->
        </div><!-- media -->
        <nav class="nav nav-icon-only mg-l-auto">
        {{-- <a href="" data-toggle="tooltip" title="Archive" class="nav-link d-none d-sm-block"><i data-feather="archive"></i></a>
        <a href="" data-toggle="tooltip" title="Report Spam" class="nav-link d-none d-sm-block"><i data-feather="slash"></i></a>
        <a href="" data-toggle="tooltip" title="Mark Unread" class="nav-link d-none d-sm-block"><i data-feather="mail"></i></a>
        <a href="" data-toggle="tooltip" title="Add Label" class="nav-link d-none d-sm-block"><i data-feather="folder"></i></a>
        <a href="" data-toggle="tooltip" title="Add Tag" class="nav-link d-none d-sm-block"><i data-feather="tag"></i></a>
        <span class="nav-divider d-none d-sm-block"></span>
        <a href="" data-toggle="tooltip" title="Mark Important" class="nav-link d-none d-sm-block"><i data-feather="star"></i></a>
        <a href="" data-toggle="tooltip" title="Trash" class="nav-link d-none d-sm-block"><i data-feather="trash"></i></a>
        <a href="" data-toggle="tooltip" title="Print" class="nav-link d-none d-sm-block"><i data-feather="printer"></i></a>
        <a href="" data-toggle="tooltip" title="Options" class="nav-link d-sm-none"><i data-feather="more-vertical"></i></a> --}}
        </nav>
    </div><!-- mail-content-header -->
    <div class="mail-content-body d-none" id="mail-content">
        
        <div class="pd-20 pd-lg-25 pd-xl-30">
        <h5 class="mg-b-30">30 Seconds Survey to Your Next Job</h5>

        <h6 class="tx-semibold mg-b-0">Ms. Katherine Lumaad</h6>
        <span class="tx-color-03">ThemePixels, Inc.</span>
        <p class="tx-color-03">San Francisco, CA, United States</p>

        <p>Greetings!</p>
        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. </p>
        <p>Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. </p>
        <p>Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem.</p>
        <p>
            <span>Sincerely yours,</span><br>
            <strong>Envato Design Team</strong>
        </p>
        </div>
        <div class="pd-20 pd-lg-25 pd-xl-30 pd-t-0-f">
        <div id="editor-container" class="tx-13 tx-lg-14 ht-100">
        </div>
        <div class="d-flex align-items-center justify-content-between mg-t-10">
            
            <button class="btn btn-primary">Reply</button>
        </div>
        </div>
    </div><!-- mail-content-body -->
</div><!-- mail-wrapper -->


@push('scripts')
  <script src="{{ asset('assets/dashboard/assets/js/dashforge.mail.js') }}"></script>

  <script>
    // $(document).ready(function (){
    //   //Onclick to view message
    //   $(document).on('click', '.mail-group-body .media', function(){
    //     alert('Mr Dayo please continue from here. Thanks');
        
    //     let route = $(this).attr('data-url');

    //     $.ajax({
    //         url: route,
    //         beforeSend: function() {
    //           $("#mail-content").html('<div class="d-flex justify-content-center mt-4 mb-4" style="margin-top: 200px !important"><span class="loadingspinner"></span></div>');
    //         },
    //         // return the result
    //         success: function(result) {
    //             $('#mail-content').html('');
    //             $('#mail-content').html(result);
    //             $('.mail-content-header, .mail-content-body').removeClass('d-none');

    //             if(window.matchMedia('(max-width: 1199px)').matches) {
    //               $('body').addClass('mail-content-show');
    //             }

    //             if(window.matchMedia('(min-width: 768px)').matches) {
    //               $('#mailSidebar').removeClass('d-md-none');
    //               $('#mainMenuOpen').removeClass('d-md-flex');
    //             }
    //         },
    //         complete: function() {
    //             $("#mail-content").hide();
    //         },
    //         error: function(jqXHR, testStatus, error) {
    //             var message = error+ ' occured while trying to retireve message details.';
    //             var type = 'error';
    //             displayMessage(message, type);
    //             $("#mail-content").hide();
    //         },
    //         timeout: 8000
    //     });

    //   });


    // });
  </script>
@endpush

    {{-- <div class="content-body">
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
    </div> --}}


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
