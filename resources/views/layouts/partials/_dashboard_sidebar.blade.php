<!-- Sidebar options are displayed based on the Authenticated User Role -->

<!-- START ADMIN SIDEBAR MENU -->
{{-- {{ dd(Auth::user()->type->role) }} --}}
@if((Auth::user()->type->role->name === 'Super Admin') || (Auth::user()->type->role->name === 'Administrator'))
  @include('layouts.partials._admin_sidebar')
@endif
<!-- END ADMIN SIDEBAR MENU -->

<!-- START CLIENT SERVICE EXECUTIVE SIDEBAR MENU -->
@if(Auth::user()->type->role->name === 'Customer Service Executive')
  @include('layouts.partials._cse_sidebar')
@endif
<!-- END CLIENT SERVICE EXECUTIVE SIDEBAR MENU -->

<!-- START QUALITY ASSURANCE SIDEBAR MENU -->
@if(Auth::user()->type->role->name === 'Quality Assurance Manager')
  @include('layouts.partials._qa_sidebar')
@endif
<!-- END QUALITY ASSURANCE SIDEBAR MENU -->

<!-- START TECHNICIAN & ARTISAN SIDEBAR MENU -->
@if(Auth::user()->type->role->name === 'Technicians & Artisans')
  @include('layouts.partials._technician_sidebar')
@endif
<!-- END TECHNICIAN & ARTISAN SIDEBAR MENU -->
