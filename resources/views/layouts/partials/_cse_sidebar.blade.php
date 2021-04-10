<aside class="aside aside-fixed" id="sidebarMenu">
  <div class="aside-header">
    <a href="{{ route('cse.index', app()->getLocale()) }}" class="aside-logo"></a>
    <a href="" class="aside-menu-link">
      <i data-feather="menu"></i>
      <i data-feather="x"></i>
    </a>
    <a href="" id="chatContentClose" class="burger-menu d-none"><i data-feather="arrow-left"></i></a>
  </div>
  <div class="aside-body">
    <div class="aside-loggedin">
      <div class="d-flex align-items-center justify-content-start">
        <a href="" class="avatar"><img src="{{!empty(Auth::user()->account->avatar) ? asset('assets/user-avatars/'.Auth::user()->account->avatar) : asset('assets/user-avatars/default-male-avatar.png')}}" class="rounded-circle" alt="Male Avatar"></a>
        <div class="aside-alert-link">
        <a href="#" class="new" data-toggle="tooltip" title="You have 0 unread messages"><i data-feather="message-square"></i></a>
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
        <p class="tx-color-03 tx-12 mg-b-0">Customer Service Executive(CSE)</p>
        <p class="tx-15 mg-b-0 mt-4 font-weight-bold text-center">Job availability</p><br>
        <div class="custom-control custom-switch" style="margin-left: 4rem !important; margin-top: -12px !important;">
          <input type="checkbox" checked class="custom-control-input" id="cse-availability">
          <label class="custom-control-label font-weight-bold" for="cse-availability"></label>
        </div>
        <p class="text-center tx-14 text-success tx-12 mt-1 mg-b-0">Available</p><br>

      </div>
      <div class="collapse {{ Route::currentRouteNamed('cse.view_profile', 'cse.edit_profile') ? 'show' : '' }}" id="loggedinMenu">
        <ul class="nav nav-aside mg-b-0">
          <li class="nav-item {{ Route::currentRouteNamed('cse.view_profile') ? 'active' : '' }}"><a href="{{ route('cse.view_profile', [app()->getLocale(), auth()->user()->uuid]) }}" class="nav-link"><i data-feather="user"></i> <span>View Profile</span></a></li>

          <li class="nav-item {{ Route::currentRouteNamed('cse.edit_profile') ? 'active' : '' }}"><a href="{{ route('cse.edit_profile',[app()->getLocale(), auth()->user()->uuid]) }}" class="nav-link"><i data-feather="settings"></i> <span>Account Settings</span></a></li>
        </ul>
      </div>
    </div><!-- aside-loggedin -->
    <ul class="nav nav-aside">
      <li class="nav-label">Components</li>
      <li class="nav-item {{ Route::currentRouteNamed('cse.index') ? 'active' : '' }}"><a href="{{ route('cse.index', app()->getLocale()) }}" class="nav-link"><i data-feather="airplay"></i> <span>Home</span></a></li>

      <li class="nav-item {{ Route::currentRouteNamed('cse.location_request') ? 'active' : '' }}"><a href="{{ route('cse.location_request', app()->getLocale()) }}" class="nav-link"><i data-feather="map-pin"></i> <span>Location Request</span></a></li>

      <li class="nav-item with-sub {{ Route::currentRouteNamed('inbox_messages', 'outbox_messages') ? 'active show' : '' }}">
        <a href="" class="nav-link"><i data-feather="message-circle"></i> <span>Messages</span></a>
        <ul>
          <li class="{{ Route::currentRouteNamed('cse.messages.inbox') ? 'active' : '' }}"><a href="{{ route('cse.messages.inbox', app()->getLocale()) }}">Inbox</a></li>
          <li class="{{ Route::currentRouteNamed('cse.messages.sent') ? 'active' : '' }}"><a href="{{ route('cse.messages.sent', app()->getLocale()) }}">Sent</a></li>
        </ul>
      </li>

      <li class="nav-item {{ Route::currentRouteNamed('cse.payments') ? 'active show' : '' }}"><a href="{{ route('cse.payments', app()->getLocale()) }}" class="nav-link"><i data-feather="credit-card"></i> <span>Payments</span></a></li>

      <li class="nav-item {{ Route::currentRouteNamed('cse.requests.index', 'cse.request_details', 'cse.requests.show') ? 'active show' : '' }}"><a href="{{ route('cse.requests.index', app()->getLocale()) }}" class="nav-link"><i data-feather="git-pull-request"></i> <span>Requests</span></a></li>

    </ul>
  </div>
</aside>

