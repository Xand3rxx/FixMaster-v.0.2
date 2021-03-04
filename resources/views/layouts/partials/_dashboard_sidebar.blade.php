<!-- START ADMIN SIDEBAR MENU -->
<aside class="aside aside-fixed" id="sidebarMenu">
  <div class="aside-header">
    <a href="{{ route('admin.index', app()->getLocale()) }}" class="aside-logo">
      {{-- dash<span>forge</span> --}}
      {{-- <img src="{{ asset('assets/images/home-fix-logo.png') }}" alt="FixMaster Logo" height="160" style="margin-top: -40px; margin-bottom: -38px;"> --}}
      {{-- <img src="{{ asset('assets/images/home-fix-logo-colored.png') }}" alt="FixMaster Logo" height="120"> --}}

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
          <h6 class="tx-semibold mg-b-0"> Charles Famoriyo</h6>
          <i data-feather="chevron-down"></i>
        </a>
        <p class="tx-color-03 tx-12 mg-b-0">Adminstrator</p>
      </div>
      <div class="collapse" id="loggedinMenu">
        <ul class="nav nav-aside mg-b-0">
          {{-- <li class="nav-item"><a href="" class="nav-link"><i data-feather="edit"></i> <span>Edit Profile</span></a></li> --}}
          {{-- <li class="nav-item {{ Route::currentRouteNamed('admin.view_profile') ? 'active' : '' }}"><a href="{{ route('admin.view_profile') }}" class="nav-link"><i data-feather="user"></i> <span>View Profile</span></a></li> --}}

          <li class="nav-item"><a href="#" class="nav-link"><i data-feather="settings"></i> <span>Account Settings</span></a></li>
        </ul>
      </div>
    </div><!-- aside-loggedin -->
    <ul class="nav nav-aside">
      <li class="nav-label">Components</li>
      <li class="nav-item {{ Route::currentRouteNamed('admin.index') ? 'active' : '' }}"><a href="{{ route('admin.index', app()->getLocale()) }}" class="nav-link"><i data-feather="airplay"></i> <span>Home</span></a></li>

      <li class="nav-item"><a href="" class="nav-link"><i data-feather="activity"></i> <span>Activity Log</span></a></li>

      <li class="nav-item with-sub">
        <a href="" class="nav-link"><i data-feather="percent"></i> <span>Discount/Promotion</span></a>
        <ul>
          <li class=""><a href="#">Add</a></li>
          <li class=""><a href="#">List</a></li>
        </ul>
      </li>

      <li class="nav-item with-sub {{ Route::currentRouteNamed('admin.add_estate', 'admin.list_estate') ? 'active show' : '' }}">
        <a href="" class="nav-link"><i data-feather="home"></i> <span>Estate Management</span></a>
        <ul>
          <li class="{{ Route::currentRouteNamed('admin.add_estate') ? 'active' : '' }}"><a href="{{ route('admin.add_estate', app()->getLocale()) }}">Add</a></li>
          <li class="{{ Route::currentRouteNamed('admin.list_estate') ? 'active' : '' }}"><a href="{{ route('admin.list_estate', app()->getLocale()) }}">List</a></li>
        </ul>
      </li>

      <li class="nav-item"><a href="" class="nav-link"><i data-feather="credit-card"></i> <span>Income/Commission</span></a></li>

      <li class="nav-item"><a href="" class="nav-link"><i data-feather="briefcase"></i> <span>Job Card</span></a></li>

      <li class="nav-item {{ Route::currentRouteNamed('admin.location_request') ? 'active' : '' }}"><a href="{{ route('admin.location_request', app()->getLocale()) }}" class="nav-link"><i data-feather="map-pin"></i> <span>Location Request</span></a></li>

      <li class="nav-item with-sub">
        <a href="" class="nav-link"><i data-feather="crop"></i> <span>Loyalty Management</span></a>
        <ul>
          <li class=""><a href="#">Add</a></li>
          <li class=""><a href="#">List</a></li>
        </ul>
      </li>

      <li class="nav-item with-sub">
        <a href="" class="nav-link"><i data-feather="message-circle"></i> <span>Messages</span></a>
        <ul>
          <li class=""><a href="#">Inbox</a></li>
          <li class=""><a href="#">Sent</a></li>
        </ul>
      </li>

      <li class="nav-item with-sub">
        <a href="" class="nav-link"><i data-feather="bell"></i> <span>Notification Management</span></a>
        <ul>
          <li class=""><a href="#">Email</a></li>
          <li class=""><a href="#">In-app</a></li>
          <li class=""><a href="#">SMS</a></li>
        </ul>
      </li>

      <li class="nav-item with-sub">
        <a href="" class="nav-link"><i data-feather="credit-card"></i> <span>Payments</span></a>
        <ul>
          <li class=""><a href="#">Disbursed</a></li>
          <li class=""><a href="#">Received</a></li>
        </ul>
      </li>

      <li class="nav-item with-sub ">
        <a href="#" class="nav-link"><i data-feather="credit-card"></i> <span>Payment Gateway</span></a>
        <ul>
          <li class=""><a href="#">List</a></li>
        </ul>
      </li>

      <li class="nav-item with-sub ">
        <a href="#" class="nav-link"><i data-feather="cpu"></i> <span>Price Management</span></a>
        <ul>
          <li class=""><a href="#">Add</a></li>
          <li class=""><a href="#">List</a></li>
        </ul>
      </li>

      <li class="nav-item with-sub">
        <a href="" class="nav-link"><i data-feather="star"></i> <span>Rating</span></a>
        <ul>
          <li class=""><a href="#">Category Rating</a></li>
          <li class=""><a href="#">Job Rating</a></li>
        </ul>
      </li>

      <li class="nav-item with-sub">
        <a href="" class="nav-link"><i data-feather="external-link"></i> <span>Referral</span></a>
        <ul>
          <li class=""><a href="#">Add</a></li>
          <li class=""><a href="#">List</a></li>
        </ul>
      </li>

      <li class="nav-item"><a href="" class="nav-link"><i data-feather="pie-chart"></i> <span>Reports</span></a></li>

      <li class="nav-item with-sub">
        <a href="" class="nav-link"><i data-feather="git-pull-request"></i> <span>Requests</span></a>
        <ul>
          <li class=""><a href="#">New</a></li>
          <li class=""><a href="#">Ongoing</a></li>
          <li class=""><a href="#">Completed</a></li>
          <li class=""><a href="#">Cancelled</a></li>
        </ul>
      </li>

      <li class="nav-item"><a href="#" class="nav-link"><i data-feather="file-text"></i> <span>RFQ's</span></a></li>

      <li class="nav-item with-sub {{ Route::currentRouteNamed('admin.categories.index') ? 'active show' : '' }}">
        <a href="" class="nav-link"><i data-feather="aperture"></i> <span>Service & Category</span></a>
        <ul>
          <li class=""><a href="{{ route('admin.categories.index', app()->getLocale()) }}">Category List</a></li>
          {{-- <hr> --}}
          <li class="{{ Route::currentRouteNamed('admin.categories.index') ? 'active' : '' }}"><a href="#">Add Category Service</a></li>
          <li class=""><a href="#">Category Services List</a></li>
          <li class=""><a href="#">Category Service Review</a></li>

        </ul>
      </li>

      <li class="nav-item with-sub">
        <a href="" class="nav-link"><i data-feather="git-pull-request"></i> <span>Special Project</span></a>
        <ul>
          <li class=""><a href="#">Inventory</a></li>
          <li class=""><a href="#">Requests</a></li>
        </ul>
      </li>

      <li class="nav-item with-sub">
        <a href="" class="nav-link"><i data-feather="percent"></i> <span>Tax Management</span></a>
        <ul>
          <li class=""><a href="#">Add</a></li>
          <li class=""><a href="#">List</a></li>
        </ul>
      </li>

      <li class="nav-item with-sub">
        <a href="" class="nav-link"><i data-feather="box"></i> <span>Tools</span></a>
        <ul>
          <li class=""><a href="#">Inventory</a></li>
          <li class=""><a href="#">Requests</a></li>
        </ul>
      </li>

      <li class="nav-item with-sub">
        <a href="" class="nav-link"><i data-feather="sliders"></i> <span>Utilities</span></a>
        <ul>
          <li class=""><a href="#">Project Status</a></li>
          <li class=""><a href="#">Reset Password</a></li>
          <li class=""><a href="#">Verify Payment</a></li>
        </ul>
      </li>

      <li class="nav-item"><a href="#" class="nav-link"><i data-feather="thumbs-up"></i> <span>Warranty Management</span></a></li>



      <li class="nav-label mg-t-25">Users</li>
      <li class="nav-item with-sub">
        <a href="" class="nav-link"><i data-feather="user-check"></i> <span>Adminstrators</span></a>
        <ul>
          <li class=""><a href="{{route('admin.users.administrator.create', app()->getLocale())}}">Add</a></li>
          <li class=""><a href="{{route('admin.users.administrator.index', app()->getLocale())}}">List</a></li>
        </ul>
      </li>

      <li class="nav-item"><a href="#" class="nav-link"><i data-feather="users"></i> <span>Clients</span></a></li>

      <li class="nav-item with-sub">
        <a href="" class="nav-link"><i data-feather="wind"></i> <span>CSE</span></a>
        <ul>
          <li class=""><a href="#">Add</a></li>
          <li class=""><a href="#">List</a></li>
        </ul>
      </li>

      <li class="nav-item with-sub">
        <a href="" class="nav-link"><i data-feather="wind"></i> <span>Franchise</span></a>
        <ul>
          <li class=""><a href="#">Add</a></li>
          <li class=""><a href="#">List</a></li>
        </ul>
      </li>

      <li class="nav-item with-sub">
        <a href="" class="nav-link"><i data-feather="zap"></i> <span>Technicians</span></a>
        <ul>
          <li class=""><a href="#">Add</a></li>
          <li class=""><a href="#">List</a></li>
        </ul>
      </li>
      <li class="nav-item with-sub">
        <a href="" class="nav-link"><i data-feather="zap"></i> <span>Quality Assurance</span></a>
        <ul>
          <li class=""><a href="#">Add</a></li>
          <li class=""><a href="#">List</a></li>
        </ul>
      </li>

      <li class="nav-label mg-t-25">Applicant Users</li>
      <li class="nav-item"><a href="#" class="nav-link"><i data-feather="users"></i> <span>CSE</span></a></li>
      <li class="nav-item"><a href="#" class="nav-link"><i data-feather="users"></i> <span>Supplier</span></a></li>
      <li class="nav-item"><a href="#" class="nav-link"><i data-feather="users"></i> <span>Technicians</span></a></li>


    </ul>
</aside>
<!-- END ADMIN SIDEBAR MENU -->
