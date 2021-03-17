<aside class="aside aside-fixed" id="sidebarMenu">
    <div class="aside-header">
      <a href="{{ route('admin.index', app()->getLocale()) }}" class="aside-logo"></a>
      <a href="" class="aside-menu-link">
        <i data-feather="menu"></i>
        <i data-feather="x"></i>
      </a>
      <a href="" id="mailSidebar" class="burger-menu d-md-none"><i data-feather="arrow-left"></i></a>
    </div>
    <div class="aside-body">
      <div class="aside-loggedin">
        <div class="d-flex align-items-center justify-content-start">
          <a href="" class="avatar"><img src="{{ asset('assets/images/home-fix-logo-coloredd.png') }}" class="rounded-circle" alt="Male Avatar"></a>
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
          <p class="tx-color-03 tx-12 mg-b-0">Client Service Executive</p>
        </div>
        <div class="collapse" id="loggedinMenu">
          <ul class="nav nav-aside mg-b-0">
            <li class="nav-item"><a href="#" class="nav-link"><i data-feather="settings"></i> <span>Account Settings</span></a></li>
          </ul>
        </div>
      </div><!-- aside-loggedin -->
      <ul class="nav nav-aside">
        <li class="nav-label">Components</li>
        <li class="nav-item"><a href="#" class="nav-link"><i data-feather="airplay"></i> <span>Home</span></a></li>

        <li class="nav-item"><a href="#" class="nav-link"><i data-feather="map-pin"></i> <span>Location Request</span></a></li>

        <li class="nav-item with-sub">
          <a href="" class="nav-link"><i data-feather="message-circle"></i> <span>Messages</span></a>
          <ul>
            <li class=""><a href="#">Inbox</a></li>
            <li class=""><a href="#">Sent</a></li>
          </ul>
        </li>

        <li class="nav-item"><a href="#" class="nav-link"><i data-feather="credit-card"></i> <span>Payments</span></a></li>

        <li class="nav-item with-sub">
          <a href="" class="nav-link"><i data-feather="git-pull-request"></i> <span>Requests</span></a>
          <ul>
            <li class=""><a href="#">New</a></li>
            <li class=""><a href="#">Ongoing</a></li>
            <li class=""><a href="#">Completed</a></li>
            <li class=""><a href="#">Cancelled</a></li>
          </ul>
        </li>

      </ul>
  </aside>