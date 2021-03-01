<!-- START CSE SIDEBAR MENU -->

<!-- END CSE SIDEBAR MENU -->

<!-- START TECHINICIAN SIDEBAR MENU -->
{{-- @if($user->designation === '[TECHNICIAN_ROLE]') --}}

<aside class="aside aside-fixed" id="sidebarMenu">
  <div class="aside-header">
      <a href="{{ route('qa.index',app()->getLocale())}}" class="aside-logo">
      
    </a>
    <a href="" class="aside-menu-link">
      <i data-feather="menu"></i>
      <i data-feather="x"></i>
    </a>
    <a href="" id="mailSidebar" class="burger-menu d-md-none"><i data-feather="arrow-left"></i></a>

  </div>
  <div class="aside-body">
    <div class="aside-loggedin">
      <div class="d-flex align-items-center justify-content-start">
        <a href="" class="avatar"><img src="{{ asset('assets/images/default-male-avatar.png') }}" class="rounded-circle" alt="Male Avatar"></a>
        <div class="aside-alert-link">
          <a onclick="event.preventDefault();
          document.getElementById('logout-form').submit();" href="{{ route('logout', app()->getLocale()) }}" data-toggle="tooltip" title="Sign out"><i data-feather="log-out"></i></a>
          <form id="logout-form" action="{{ route('logout', app()->getLocale()) }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
      </div>
      <div class="aside-loggedin-user">
        <a href="#loggedinMenu" class="d-flex align-items-center justify-content-between mg-b-2" data-toggle="collapse">
          <h6 class="tx-semibold mg-b-0">{{ Auth::user()->account->first_name.' '.Auth::user()->account->last_name }}</h6>
          <i data-feather="chevron-down"></i>
        </a>
        {{-- <p class="tx-color-03 tx-12 mg-b-0">Ludwig Enterprise (TECHNICIAN)</p> --}}
        <p class="tx-color-03 tx-12 mg-b-0">Quality Assurance Manager</p>
      </div>
      <div class="collapse" id="loggedinMenu">
        <ul class="nav nav-aside mg-b-0">
          {{-- <li class="nav-item"><a href="" class="nav-link"><i data-feather="edit"></i> <span>Edit Profile</span></a></li> --}}
          <li class="nav-item {{ Route::currentRouteNamed('qa.view_profile') ? 'active' : '' }}"><a href="{{ route('qa.view_profile', app()->getLocale()) }}" class="nav-link"><i data-feather="user"></i> <span>View Profile</span></a></li>

          <li class="nav-item {{ Route::currentRouteNamed('qa.edit_profile') ? 'active' : '' }}"><a href="{{ route('qa.edit_profile',app()->getLocale()) }}" class="nav-link"><i data-feather="settings"></i> <span>Account Settings</span></a></li>
        </ul>
      </div>
    </div><!-- aside-loggedin -->
    <ul class="nav nav-aside">
      <li class="nav-label">Components</li>
      <li class="nav-item {{ Route::currentRouteNamed('qa.index') ? 'active' : '' }}"><a href="{{ route('qa.index', app()->getLocale()) }}" class="nav-link"><i data-feather="airplay"></i> <span>Home</span></a></li>


      <li class="nav-label mg-t-25">Adminstration</li>

      <li class="nav-item with-sub {{ Route::currentRouteNamed('inbox_messages', 'outbox_messages') ? 'active show' : '' }}">
        <a href="" class="nav-link"><i data-feather="message-circle"></i> <span>Messages</span></a>
        <ul>
          <li class="{{ Route::currentRouteNamed('qa.messages.inbox') ? 'active' : '' }}"><a href="{{ route('qa.messages.inbox', app()->getLocale()) }}">Inbox</a></li>
          <li class="{{ Route::currentRouteNamed('qa.messages.sent') ? 'active' : '' }}"><a href="{{ route('qa.messages.sent', app()->getLocale()) }}">Sent</a></li>
          {{-- <li><a href="#cseMessageComposer" data-toggle="modal">Compose</a></li> --}}
        </ul>
      </li>
      {{-- <li class="nav-item {{ Route::currentRouteNamed('technician.location_request') ? 'active show' : '' }}""><a href="{{ url('technician.location_request') }}" class="nav-link"><i data-feather="map-pin"></i> <span>Location Request</span></a></li> --}}


      <li class="nav-item {{ Route::currentRouteNamed('qa.requests', 'qa.request_details') ? 'active show' : '' }}"><a href="{{ route('qa.requests', app()->getLocale()) }}" class="nav-link"><i data-feather="git-pull-request"></i> <span>Requests</span></a></li>


      <li class="nav-item {{ Route::currentRouteNamed('qa.payments') ? 'active show' : '' }}"><a href="{{ route('qa.payments', app()->getLocale()) }}" class="nav-link"><i data-feather="credit-card"></i> <span>Payments</span></a></li>

    </ul>
  </div>
</aside>

