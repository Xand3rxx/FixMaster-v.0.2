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
          <a href="" class="avatar"><img src="{{ asset('assets/images/home-fix-logo-coloredd.png') }}" class="rounded-circle" alt="Male Avatar"></a>
          <div class="aside-alert-link">
            <a href="#" class="new" data-toggle="tooltip" title="You have 0 unread messages"><i data-feather="message-square"></i></a>
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
          <h6 class="tx-semibold mg-b-0"> {{ !empty($profile->first_name || $profile->last_name) ? $profile->first_name.' '.$profile->last_name : 'UNAVAILABLE' }}</h6>
            <i data-feather="chevron-down"></i>
          </a>
          <p class="tx-color-03 tx-12 mg-b-0">{{ Auth::user()->type->role->name ?? 'Administrator' }}</p>
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

        <li class="nav-item with-sub {{ Route::currentRouteNamed('admin.categories.index', 'admin.services.index', 'admin.booking-fees.index', 'admin.statuses.index', 'admin.serviceCriteria.index') ? 'active show' : '' }}">
          <a href="" class="nav-link"><i data-feather="aperture"></i> <span>Category & Service</span></a>
          <ul>
          <li class="{{ Route::currentRouteNamed('admin.booking-fees.index') ? 'active' : '' }}"><a href="{{ route('admin.booking-fees.index', app()->getLocale()) }}">Booking Fee</a></li>
            <li class="{{ Route::currentRouteNamed('admin.categories.index') ? 'active' : '' }}"><a href="{{ route('admin.categories.index', app()->getLocale()) }}">Categories</a></li>
            <li class="{{ Route::currentRouteNamed('admin.services.index') ? 'active' : '' }}"><a href="{{ route('admin.services.index', app()->getLocale()) }}">Services</a></li>
            {{-- <li class="{{ Route::currentRouteNamed('admin.services.index') ? 'active' : '' }}"><a href="{{ route('admin.services.index', app()->getLocale()) }}">Sub-Services</a></li> --}}
            <li class="{{ Route::currentRouteNamed('admin.statuses.index') ? 'active' : '' }}"><a href="{{ route('admin.statuses.index', app()->getLocale()) }}">Service Request Status</a></li>
          {{-- <li class="{{ Route::currentRouteNamed('admin.serviceCriteria.index') ? 'active' : '' }}"><a href="{{ route('admin.serviceCriteria.index', app()->getLocale()) }}">Settings</a></li> --}}
          </ul>
        </li>

        <li class="nav-item with-sub {{ Route::currentRouteNamed('admin.add_discount', 'admin.discount_list', 'admin.edit_discount', 'admin.discount_history') ? 'active show' : '' }}">
          <a href="" class="nav-link"><i data-feather="percent"></i> <span>Discount/Promotion</span></a>
          <ul>
          <li class="{{ Route::currentRouteNamed('admin.add_discount') ? 'active' : '' }}"><a href="{{ route('admin.add_discount',  app()->getLocale()) }}">Add</a></li>
            <li class="{{ Route::currentRouteNamed('admin.discount_list') ? 'active' : '' }}"><a href="{{ route('admin.discount_list',  app()->getLocale()) }}">List</a></li>
            <li class="{{ Route::currentRouteNamed('admin.discount_history') ? 'active' : '' }}"><a href="{{ route('admin.discount_history',  app()->getLocale()) }}">History</a></li>
          </ul>
        </li>

        <li class="nav-item with-sub {{ Route::currentRouteNamed('admin.add_estate', 'admin.list_estate') ? 'active show' : '' }}">
          <a href="" class="nav-link"><i data-feather="home"></i> <span>Estate Management</span></a>
          <ul>
            <li class="{{ Route::currentRouteNamed('admin.add_estate') ? 'active' : '' }}"><a href="{{ route('admin.add_estate', app()->getLocale()) }}">Add</a></li>
            <li class="{{ Route::currentRouteNamed('admin.list_estate') ? 'active' : '' }}"><a href="{{ route('admin.list_estate', app()->getLocale()) }}">List</a></li>
          </ul>
        </li>

        <li class="nav-item with-sub {{ Route::currentRouteNamed('admin.ewallet.clients', 'admin.ewallet.transactions', 'admin.ewallet.client_history') ? 'active show' : '' }}">
          <a href="" class="nav-link"><i data-feather="credit-card"></i> <span>E-Wallet Management</span></a>
          <ul>
            <li class="{{ Route::currentRouteNamed('admin.ewallet.clients', 'admin.ewallet.client_history') ? 'active' : '' }}"><a href="{{ route('admin.ewallet.clients', app()->getLocale()) }}">Clients</a></li>
            <li class="{{ Route::currentRouteNamed('admin.ewallet.transactions') ? 'active' : '' }}"><a href="{{ route('admin.ewallet.transactions', app()->getLocale()) }}">Transactions</a></li>
          </ul>
        </li>

          <li class="nav-item with-sub {{ Route::currentRouteNamed('admin.earnings', 'admin.income', 'admin.income_history') ? 'active show' : '' }}">
              <a href="" class="nav-link"><i data-feather="home"></i> <span>Income/Commission</span></a>
              <ul>
                  <li class="{{ Route::currentRouteNamed('admin.earnings') ? 'active' : '' }}"><a href="{{ route('admin.earnings', app()->getLocale()) }}">Earnings</a></li>
                  <li class="{{ Route::currentRouteNamed('admin.income') ? 'active' : '' }}"><a href="{{ route('admin.income', app()->getLocale()) }}">Income</a></li>
                  <li class="{{ Route::currentRouteNamed('admin.income_history') ? 'active' : '' }}"><a href="{{ route('admin.income_history', app()->getLocale()) }}">Histories</a></li>
              </ul>
          </li>

        <li class="nav-item {{ Route::currentRouteNamed('admin.invoices') ? 'active show' : '' }}">
            <a href="{{ route('admin.invoices', app()->getLocale()) }}" class="nav-link"><i data-feather="file-text"></i> <span>Invoice Management</span></a>
        </li>

        

        <li class="nav-item {{ Route::currentRouteNamed('admin.location_request') ? 'active' : '' }}"><a href="{{ route('admin.location_request', app()->getLocale()) }}" class="nav-link"><i data-feather="map-pin"></i> <span>Location Request</span></a></li>

        <li class="nav-item with-sub {{ Route::currentRouteNamed('admin.add_loyalty', 'admin.loyalty_list', 'admin.loyalty_history') ? 'active show' : '' }}">
          <a href="" class="nav-link"><i data-feather="crop"></i> <span>Loyalty Management</span></a>
          <ul>
          <li class="{{ Route::currentRouteNamed('admin.add_loyalty') ? 'active' : '' }}"><a href="{{ route('admin.add_loyalty',  app()->getLocale()) }}">Add</a></li>
          <li class="{{ Route::currentRouteNamed('admin.loyalty_list') ? 'active' : '' }}"><a href="{{ route('admin.loyalty_list',  app()->getLocale()) }}">List</a></li>
          <li class="{{ Route::currentRouteNamed('admin.loyalty_history') ? 'active' : '' }}"><a href="{{ route('admin.loyalty_history',  app()->getLocale()) }}">History</a></li>

          </ul>
        </li>

        <li class="nav-item with-sub {{ Route::currentRouteNamed('admin.inbox', 'admin.outbox') ? 'active show' : '' }}">
          <a href="" class="nav-link"><i data-feather="message-circle"></i> <span>Messages</span></a>
          <ul>
            <li class="{{ Route::currentRouteNamed('admin.inbox') ? 'active' : '' }}"><a href="{{ route('admin.inbox', app()->getLocale()) }}">Inbox</a></li>
            <li class="{{ Route::currentRouteNamed('admin.outbox') ? 'active' : '' }}"><a href="{{ route('admin.outbox', app()->getLocale()) }}">Sent</a></li>
          </ul>
        </li>

        <li class="nav-item {{ Route::currentRouteNamed('admin.template') ? 'active' : '' }}"><a href="{{ route('admin.template', app()->getLocale()) }}" class="nav-link"><i data-feather="bell"></i> <span>Notification Management</span></a></li>

        {{-- <li class="nav-item with-sub {{ Route::currentRouteNamed('admin.template') ? 'active show' : '' }}">
          <a href="" class="nav-link"><i data-feather="bell"></i> <span>Notification Management</span></a>
          <ul>
            <li class="{{ Route::currentRouteNamed('admin.template') ? 'active' : '' }}"><a href="{{ route('admin.template', app()->getLocale()) }}">Email & SMS</a></li>
            <li class=""><a href="#">In-app</a></li>
            <li class=""><a href="#">SMS</a></li>
          </ul>
        </li> --}}

        <li class="nav-item with-sub {{ Route::currentRouteNamed('admin.disbursed_payments', 'admin.received_payments') ? 'active show' : '' }}">
          <a href="" class="nav-link"><i data-feather="credit-card"></i> <span>Payments</span></a>
          <ul>
            <li class="{{ Route::currentRouteNamed('') ? 'active' : '' }}"><a href="#">Disbursed</a></li>
            <li class="{{ Route::currentRouteNamed('') ? 'active' : '' }}"><a href="#">Received</a></li>
            <li class="{{ Route::currentRouteNamed('') ? 'active' : '' }}"><a href="#">Verify</a></li>
          </ul>
        </li>

        <li class="nav-item with-sub {{ Route::currentRouteNamed('list_payment_gateway') ? 'active show' : '' }}">
            <a href="" class="nav-link"><i data-feather="credit-card"></i> <span>Payment Gateway</span></a>
            <ul>
              <li class="{{ Route::currentRouteNamed('list_payment_gateway') ? 'active' : '' }}"><a href="{{ route('admin.list_payment_gateway', app()->getLocale()) }}">List</a></li>
            </ul>
          </li>

        <li class="nav-item with-sub {{ Route::currentRouteNamed('admin.category', 'admin.job', 'admin.category_reviews') ? 'active show' : '' }}">
          <a href="" class="nav-link"><i data-feather="star"></i> <span>Rating</span></a>
          <ul>
            <li class="{{ Route::currentRouteNamed('admin.category') ? 'active' : '' }}"><a href="{{ route('admin.category',  app()->getLocale()) }}">CSE Diagnosis Rating</a></li>
            <li class="{{ Route::currentRouteNamed('admin.job') ? 'active' : '' }}"><a href="{{ route('admin.job',  app()->getLocale()) }}">Service Rating</a></li>
            <li class="{{ Route::currentRouteNamed('admin.category_reviews') ? 'active' : '' }}"><a href="{{ route('admin.category_reviews',  app()->getLocale()) }}">Service Reviews</a></li>
          </ul>
        </li>

        <li class="nav-item with-sub {{ Route::currentRouteNamed('admin.add_referral', 'admin.referral_list') ? 'active show' : '' }}">
          <a href="" class="nav-link"><i data-feather="external-link"></i> <span>Referral</span></a>
          <ul>
            <li class="{{ Route::currentRouteNamed('admin.add_referral') ? 'active' : '' }}"><a href="{{ route('admin.add_referral',  app()->getLocale()) }}">Add</a></li>
            <li class="{{ Route::currentRouteNamed('admin.referral_list') ? 'active' : '' }}"><a href="{{ route('admin.referral_list',  app()->getLocale()) }}">List</a></li>
          </ul>
        </li>

        <li class="nav-item with-sub {{ Route::currentRouteNamed('admin.cse_reports') ? 'active show' : '' }}">
          <a href="" class="nav-link"><i data-feather="bar-chart-2"></i> <span>Reports</span></a>
          <ul>
            
          <li class="nav-item {{ Route::currentRouteNamed('admin.cse_reports') ? 'active' : '' }}"><a href="{{ route('admin.cse_reports', app()->getLocale()) }}">CSE</a></li>
            <li class=""><a href="#">Customer</a></li>
            <li class=""><a href="#">Job Management</a></li>
            <li class=""><a href="#">Marketing</a></li>
            <li class=""><a href="#">Supplier</a></li>
            <li class=""><a href="#">Technician</a></li>
          </ul>
        </li>
        
      <li class="nav-item {{ Route::currentRouteNamed('admin.requests') ? 'active show' : '' }}"><a href="{{ route('admin.requests', app()->getLocale()) }}" class="nav-link"><i data-feather="git-pull-request"></i> <span>Requests <sup class="font-weight-bold text-danger">{{ $pendingRequests }}</sup></span></a></li>

        <li class="nav-item with-sub {{ Route::currentRouteNamed('admin.rfq', 'admin.supplier_invoices') ? 'active show' : '' }}">
          <a href="" class="nav-link"><i data-feather="file-text"></i> <span>RFQ's</span></a>
          <ul>
            <li class="{{ Route::currentRouteNamed('admin.rfq') ? 'active' : '' }}"><a href="{{ route('admin.rfq', app()->getLocale()) }}">Requests</a></li>
          <li class="{{ Route::currentRouteNamed('admin.supplier_invoices') ? 'active' : '' }}"><a href="{{ route('admin.supplier_invoices', app()->getLocale()) }}">Supplier's invoices</a></li>
          </ul>
        </li>

        <li class="nav-item with-sub">
          <a href="" class="nav-link"><i data-feather="git-pull-request"></i> <span>Special Project</span></a>
          <ul>
            <li class=""><a href="#">Inventory</a></li>
            <li class=""><a href="#">Requests</a></li>
          </ul>
        </li>

        <li class="nav-item {{ Route::currentRouteNamed('admin.taxes.index') ? 'active' : '' }}"><a href="{{ route('admin.taxes.index', app()->getLocale()) }}" class="nav-link"><i data-feather="percent"></i> <span>Tax Management</span></a></li>

        <li class="nav-item with-sub {{ Route::currentRouteNamed('admin.tools.index', 'admin.tools_request') ? 'active show' : '' }}">
          <a href="" class="nav-link"><i data-feather="box"></i> <span>Tools</span></a>
          <ul>
          <li class="{{ Route::currentRouteNamed('admin.tools.index') ? 'active' : '' }}"><a href="{{ route('admin.tools.index', app()->getLocale()) }}">Inventory</a></li>
          <li class="{{ Route::currentRouteNamed('admin.tools_request') ? 'active' : '' }}"><a href="{{ route('admin.tools_request', app()->getLocale()) }}">Requests</a></li>
          </ul>
        </li>

        {{-- <li class="nav-item with-sub">
          <a href="" class="nav-link"><i data-feather="sliders"></i> <span>Utilities</span></a>
          <ul>
            <li class=""><a href="#">Reset Password</a></li>
            <li class=""><a href="#">Verify Payment</a></li>
          </ul>
        </li> --}}

        <li class="nav-item with-sub {{ Route::currentRouteNamed('admin.warranty_list', 'admin.issued_warranty', 'admin.warranty_summary', 'admin.edit_warranty') ? 'active show' : '' }}">
          <a href="" class="nav-link"><i data-feather="award"></i> <span>Warranty Management <sup class="font-weight-bold text-danger">{{ $unresolvedWarranties }}</sup></span> </a>
          <ul>
            <li class="{{ Route::currentRouteNamed('admin.warranty_list') ? 'active' : '' }}"><a href="{{route('admin.warranty_list', app()->getLocale())}}">Add</a></li>
            <li class="{{ Route::currentRouteNamed('admin.warranty_list', 'admin.warranty_summary', 'admin.edit_warranty') ? 'active' : '' }}"><a href="{{route('admin.warranty_list', app()->getLocale())}}">List</a></li>
            <li class="{{ Route::currentRouteNamed('admin.issued_warranty') ? 'active' : '' }}"><a href="{{route('admin.issued_warranty', app()->getLocale())}}">Issued</a></li>
          </ul>
        </li>

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
            <li class=""><a href="{{route('admin.users.supplier.create', app()->getLocale())}}">Add</a></li>
            <li class=""><a href="{{route('admin.users.supplier.index', app()->getLocale())}}">List</a></li>
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
