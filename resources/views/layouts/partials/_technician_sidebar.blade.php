<aside class="aside aside-fixed" id="sidebarMenu">
  <div class="aside-header">
    <a href="#" class="aside-logo"></a>
    <a href="" class="aside-menu-link">
      <i data-feather="menu"></i>
      <i data-feather="x"></i>
    </a>
    <a href="" id="chatContentClose" class="burger-menu d-none"><i data-feather="arrow-left"></i></a>
  </div>
  <div class="aside-body">
    <div class="aside-loggedin">
      <div class="d-flex align-items-center justify-content-start">
       
        <a href="" class="avatar">
          @if(!empty($profile->avatar) && file_exists(public_path().'/assets/user-avatars/'.$profile->avatar))
            <img src="{{ asset('assets/user-avatars/'.$profile->avatar) }}" class="rounded-circle" alt="Technician avatar" />
        @else
            @if($profile->gender == 'male')
                <img src="{{ asset('assets/images/default-male-avatar.png') }}" alt="Default male profile avatar" class="rounded-circle" />
            @else
                <img src="{{ asset('assets/images/default-female-avatar.png') }}" alt="Default female profile avatar" class="rounded-circle" />
            @endif
        @endif
        </a>

        <div class="aside-alert-link">
          <a href="#" class="new" data-toggle="tooltip" title="You have 0 unread messages"><i data-feather="message-square"></i></a>
          {{-- <a href="" class="new" data-toggle="tooltip" title="You have 4 new notifications"><i data-feather="bell"></i></a> --}}
          <a href="#" data-toggle="tooltip" onclick="event.preventDefault();
          document.getElementById('logout-form').submit();" href="{{ route('logout', app()->getLocale()) }}" title="Sign out"><i data-feather="log-out"></i></a>



          <form id="logout-form" action="{{ route('logout', app()->getLocale()) }}" method="POST" style="display: none;">
              @csrf
          </form>

        </div>
      </div>
      <div class="aside-loggedin-user">
        <a href="#loggedinMenu" class="d-flex align-items-center justify-content-between mg-b-2" data-toggle="collapse">
        <h6 class="tx-semibold mg-b-0"> {{ !empty($profile->first_name || $profile->last_name) ? $profile->first_name.' '.$profile->last_name : 'UNAVAILABLE' }}</h6>
          <i data-feather="chevron-down"></i>
        </a>
        <p class="tx-color-03 tx-12 mg-b-0">{{ Auth::user()->type->role->name ?? 'Technicians & Artisans' }}</p>
      </div>
      <div class="collapse {{ Route::currentRouteNamed('technician.view_profile', 'technician.edit_profile') ? 'show' : '' }}" id="loggedinMenu">
        <ul class="nav nav-aside mg-b-0">
          <li class="nav-item {{ Route::currentRouteNamed('technician.view_profile') ? 'active' : '' }}"><a href="{{ route('technician.view_profile', app()->getLocale()) }}" class="nav-link"><i data-feather="user"></i> <span>View Profile</span></a></li>

          <li class="nav-item {{ Route::currentRouteNamed('technician.edit_profile') ? 'active' : '' }}"><a href="{{ route('technician.edit_profile',app()->getLocale()) }}" class="nav-link"><i data-feather="settings"></i> <span>Account Settings</span></a></li>
        </ul>
      </div>
    </div><!-- aside-loggedin -->
    <ul class="nav nav-aside">
      <li class="nav-label">Components</li>
      <li class="nav-item {{ Route::currentRouteNamed('technician.index') ? 'active' : '' }}"><a href="{{ route('technician.index', app()->getLocale()) }}" class="nav-link"><i data-feather="airplay"></i> <span>Home</span></a></li>

      <li class="nav-item {{ Route::currentRouteNamed('technician.location_request') ? 'active' : '' }}"><a href="{{ route('technician.location_request', app()->getLocale()) }}" class="nav-link"><i data-feather="map-pin"></i> <span>Location Request</span></a></li>

      <li class="nav-item with-sub {{ Route::currentRouteNamed('technician.messages.inbox', 'technician.messages.outbox') ? 'active show' : '' }}">
        <a href="" class="nav-link"><i data-feather="message-circle"></i> <span>Messages</span></a>
        <ul>
          <li class="{{ Route::currentRouteNamed('technician.messages.inbox') ? 'active' : '' }}"><a href="{{ route('technician.messages.inbox', app()->getLocale()) }}">Inbox</a></li>
          <li class="{{ Route::currentRouteNamed('technician.messages.outbox') ? 'active' : '' }}"><a href="{{ route('technician.messages.outbox', app()->getLocale()) }}">Sent</a></li>
          {{-- <li><a href="#cseMessageComposer" data-toggle="modal">Compose</a></li> --}}
        </ul>
      </li>

      <li class="nav-item {{ Route::currentRouteNamed('technician.payments') ? 'active' : '' }}"><a href="{{ route('technician.payments', app()->getLocale()) }}" class="nav-link"><i data-feather="credit-card"></i> <span>Payments</span></a></li>

      <li class="nav-item {{ Route::currentRouteNamed('technician.requests', 'technician.request_details') ? 'active' : '' }}"><a href="{{ route('technician.requests', app()->getLocale()) }}" class="nav-link"><i data-feather="git-pull-request"></i> <span>Requests</span></a></li>

    </ul>
</aside>