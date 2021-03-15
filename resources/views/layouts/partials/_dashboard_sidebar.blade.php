<!-- Sidebar options are displayed based on the Authenticated User Role -->

<!-- START ADMIN SIDEBAR MENU -->
{{-- {{ dd(Auth::user()->type->role) }} --}}
@if((Auth::user()->type->role->name === 'Super Admin') || (Auth::user()->type->role->name === 'Administrator'))
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
          {{-- <h6 class="tx-semibold mg-b-0"> {{ $profile->first_name.' '.$profile->last_name ?? 'Charles Famoriyo' }}</h6> --}}
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

        <li class="nav-item {{ Route::currentRouteNamed('admin.activity-log.index') ? 'active' : '' }}"><a href="{{ route('admin.activity-log.index', app()->getLocale()) }}" class="nav-link"><i data-feather="activity"></i> <span>Activity Log</span></a></li>

        <li class="nav-item with-sub {{ Route::currentRouteNamed('admin.categories.index', 'admin.services.index') ? 'active show' : '' }}">
          <a href="" class="nav-link"><i data-feather="aperture"></i> <span>Category & Service</span></a>
          <ul>
            <li class="{{ Route::currentRouteNamed('admin.categories.index') ? 'active' : '' }}"><a href="{{ route('admin.categories.index', app()->getLocale()) }}">Category List</a></li>
            <li class="{{ Route::currentRouteNamed('admin.services.index') ? 'active' : '' }}"><a href="{{ route('admin.services.index', app()->getLocale()) }}">Services List</a></li>
          </ul>
        </li>

        <li class="nav-item with-sub {{ Route::currentRouteNamed('admin.add_discount', 'admin.discount_list') ? 'active show' : '' }}">
          <a href="" class="nav-link"><i data-feather="percent"></i> <span>Discount/Promotion</span></a>
          <ul>
          <li class="{{ Route::currentRouteNamed('admin.add_discount') ? 'active' : '' }}"><a href="{{ route('admin.add_discount',  app()->getLocale()) }}">Add</a></li>
            <li class="{{ Route::currentRouteNamed('admin.discount_list') ? 'active' : '' }}"><a href="{{ route('admin.discount_list',  app()->getLocale()) }}">List</a></li>
          </ul>
        </li>

        <li class="nav-item with-sub {{ Route::currentRouteNamed('admin.add_estate', 'admin.list_estate') ? 'active show' : '' }}">
          <a href="" class="nav-link"><i data-feather="home"></i> <span>Estate Management</span></a>
          <ul>
            <li class="{{ Route::currentRouteNamed('admin.add_estate') ? 'active' : '' }}"><a href="{{ route('admin.add_estate', app()->getLocale()) }}">Add</a></li>
            <li class="{{ Route::currentRouteNamed('admin.list_estate') ? 'active' : '' }}"><a href="{{ route('admin.list_estate', app()->getLocale()) }}">List</a></li>
          </ul>
        </li>

        <li class="nav-item with-sub">
          <a href="" class="nav-link"><i data-feather="credit-card"></i> <span>E-Wallet Management</span></a>
          <ul>
            <li class=""><a href="#">Funding List </a></li>
            <li class=""><a href="#">Service Requests List</a></li>
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

        <li class="nav-item with-sub {{ Route::currentRouteNamed('list_payment_gateway') ? 'active show' : '' }}">
            <a href="" class="nav-link"><i data-feather="credit-card"></i> <span>Payment Gateway</span></a>
            <ul>
              <li class="{{ Route::currentRouteNamed('list_payment_gateway') ? 'active' : '' }}"><a href="{{ route('admin.list_payment_gateway', app()->getLocale()) }}">List</a></li>
            </ul>
          </li>

        <li class="nav-item with-sub ">
          <a href="#" class="nav-link"><i data-feather="cpu"></i> <span>Price Management</span></a>
          <ul>
            <li class=""><a href="#">Add</a></li>
            <li class=""><a href="#">List</a></li>
          </ul>
        </li>

        <li class="nav-item with-sub {{ Route::currentRouteNamed('admin.category', 'admin.job', 'admin.category_reviews') ? 'active show' : '' }}">
          <a href="" class="nav-link"><i data-feather="star"></i> <span>Rating</span></a>
          <ul>
            <li class="{{ Route::currentRouteNamed('admin.category') ? 'active' : '' }}"><a href="{{ route('admin.category',  app()->getLocale()) }}">Category Rating</a></li>
            <li class="{{ Route::currentRouteNamed('admin.job') ? 'active' : '' }}"><a href="{{ route('admin.job',  app()->getLocale()) }}">Job Rating</a></li>
            <li class="{{ Route::currentRouteNamed('admin.category_reviews') ? 'active' : '' }}"><a href="{{ route('admin.category_reviews',  app()->getLocale()) }}">Category Reviews</a></li>
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

        <li class="nav-item with-sub">
          <a href="" class="nav-link"><i data-feather="git-pull-request"></i> <span>Special Project</span></a>
          <ul>
            <li class=""><a href="#">Inventory</a></li>
            <li class=""><a href="#">Requests</a></li>
          </ul>
        </li>

        <li class="nav-item {{ Route::currentRouteNamed('admin.taxes.index') ? 'active' : '' }}"><a href="{{ route('admin.taxes.index', app()->getLocale()) }}" class="nav-link"><i data-feather="percent"></i> <span>Tax Management</span></a></li>

        <li class="nav-item with-sub {{ Route::currentRouteNamed('admin.tools.index') ? 'active show' : '' }}">
          <a href="" class="nav-link"><i data-feather="box"></i> <span>Tools</span></a>
          <ul>
          <li class="{{ Route::currentRouteNamed('admin.tools.index') ? 'active' : '' }}"><a href="{{ route('admin.tools.index', app()->getLocale()) }}">Inventory</a></li>
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

        <li class="nav-item"><a href="{{route('admin.users.clients.index', app()->getLocale())}}" class="nav-link"><i data-feather="users"></i> <span>Clients</span></a></li>

        <li class="nav-item with-sub">
          <a href="" class="nav-link"><i data-feather="wind"></i> <span>CSE</span></a>
          <ul>
            <li class=""><a href="{{route('admin.users.cse.create', app()->getLocale())}}">Add</a></li>
            <li class=""><a href="{{route('admin.users.cse.index', app()->getLocale())}}">List</a></li>
          </ul>
        </li>

        <li class="nav-item with-sub">
          <a href="" class="nav-link"><i data-feather="home"></i> <span>Franchisee</span></a>
          <ul>
            <li class=""><a href="{{route('admin.users.franchisee.create', app()->getLocale())}}">Add</a></li>
            <li class=""><a href="{{route('admin.users.franchisee.index', app()->getLocale())}}">List</a></li>
          </ul>
        </li>

        <li class="nav-item with-sub">
          <a href="" class="nav-link"><i data-feather="hard-drive"></i> <span>Suppliers</span></a>
          <ul>
            <li class=""><a href="#">Add</a></li>
            <li class=""><a href="#">List</a></li>
          </ul>
        </li>

        <li class="nav-item with-sub">
          <a href="" class="nav-link"><i data-feather="zap"></i> <span>Technicians & Artisan</span></a>
          <ul>
            <li class=""><a href="{{route('admin.users.technician-artisan.create', app()->getLocale())}}">Add</a></li>
            <li class=""><a href="{{route('admin.users.technician-artisan.index', app()->getLocale())}}">List</a></li>
          </ul>
        </li>
        <li class="nav-item with-sub">
          <a href="" class="nav-link"><i data-feather="check-square"></i> <span>Quality Assurance</span></a>
          <ul>
            <li class=""><a href="{{route('admin.users.quality-assurance.create', app()->getLocale())}}">Add</a></li>
            <li class=""><a href="{{route('admin.users.quality-assurance.index', app()->getLocale())}}">List</a></li>
          </ul>
        </li>

        <li class="nav-label mg-t-25">Prospective FixMaster Users</li>
        <li class="nav-item"><a href="#" class="nav-link"><i data-feather="wind"></i> <span>CSE</span></a></li>
        <li class="nav-item"><a href="#" class="nav-link"><i data-feather="hard-drive"></i> <span>Supplier</span></a></li>
        <li class="nav-item"><a href="#" class="nav-link"><i data-feather="zap"></i> <span>Technicians</span></a></li>


      </ul>
  </aside>
@endif
<!-- END ADMIN SIDEBAR MENU -->

<!-- START CLIENT SERVICE EXECUTIVE SIDEBAR MENU -->
@if(Auth::user()->type->role->name === 'Customer Service Executive')
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
          <h6 class="tx-semibold mg-b-0"> David Akinsola</h6>
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
@endif
<!-- END CLIENT SERVICE EXECUTIVE SIDEBAR MENU -->

<!-- START QUALITY ASSURANCE SIDEBAR MENU -->
@if(Auth::user()->type->role->name === 'Quality Assurance Manager')

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
          <a href="" class="avatar"><img src="{{!empty(Auth::user()->account->avatar) ? asset('assets/qa_avatars/'.Auth::user()->account->avatar) : asset('assets/images/no-image-available.png')}}" class="rounded-circle" alt="Male Avatar"></a>
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

        <li class="nav-item {{ Route::currentRouteNamed('qa.requests', 'qa.request_details') ? 'active show' : '' }}"><a href="{{ route('qa.requests', app()->getLocale()) }}" class="nav-link"><i data-feather="git-pull-request"></i> <span>Requests</span></a></li>
        <li class="nav-item {{ Route::currentRouteNamed('qa.payments') ? 'active show' : '' }}"><a href="{{ route('qa.payments', app()->getLocale()) }}" class="nav-link"><i data-feather="credit-card"></i> <span>Payments</span></a></li>

      </ul>
    </div>
  </aside>
@endif
<!-- END QUALITY ASSURANCE SIDEBAR MENU -->

<!-- START TECHNICIAN & ARTISAN SIDEBAR MENU -->
@if(Auth::user()->type->role->name === 'Technicians & Artisans')
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
          <h6 class="tx-semibold mg-b-0"> David Akinsola</h6>
            <i data-feather="chevron-down"></i>
          </a>
          <p class="tx-color-03 tx-12 mg-b-0">Technician</p>
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

        <li class="nav-item"><a href="#" class="nav-link"><i data-feather="git-pull-request"></i> <span>Requests</span></a></li>

      </ul>
  </aside>
@endif
<!-- END TECHNICIAN & ARTISAN SIDEBAR MENU -->
