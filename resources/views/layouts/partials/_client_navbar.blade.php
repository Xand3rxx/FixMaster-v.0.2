
<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title') | FixMaster.ng - We Fix, You Relax!</title>
    <meta name="Author" content="Anthony Joboy (Lagos, Nigeria)" />
    <meta name="Telephone" content="Tel: +234 903 554 7107" />
    <meta name="description" content="FixMaster is your best trusted one-call solution for a wide range of home maintenance, servicing and repair needs. Our well-trained & certified uniformed technicians are fully insured professionals with robust experience to provide home services to fully meet your needs with singular objective to make you totally relax while your repair requests are professionally handled." />
    <meta name="keywords" content="Home-fix, Home-improvement, Home-repairs, Cleaning-services, Modern" />
    <meta name="email" content="info@fixmaster.com.ng" />
    <meta name="website" content="https://www.fixmaster.com.ng" />
    <meta name="Version" content="v0.0.1" />
    
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/png" sizes="16x16">

    <!-- Bootstrap -->
    <link href="{{ asset('assets/client/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons -->
    <link href="{{ asset('assets/client/css/materialdesignicons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Main Css -->
    <link href="{{ asset('assets/client/css/style.css') }}" rel="stylesheet" type="text/css" id="theme-opt" />
    <link href="{{ asset('assets/client/css/colors/default.css') }}" rel="stylesheet" id="color-opt">

</head>

<body>
    <!-- Loader -->
    <!-- <div id="preloader">
        <div id="status">
            <div class="spinner">
                <div class="double-bounce1"></div>
                <div class="double-bounce2"></div>
            </div>
        </div>
    </div> -->
    <!-- Loader -->
    
    <!-- Navbar STart -->
<!-- Navbar STart -->
<style>
    #topnav .navigation-menu.nav-light > li > a{
        /* color: #ffffff !important; */
        color: #3c4858 !important;
    }
    #topnav .navigation-menu.nav-light > li > a:hover{
        color: #fff !important;
    }
    #topnav.nav-sticky .navigation-menu.nav-light > li > a {
        color: #3c4858 !important;
    }
    #topnav .navigation-menu.nav-light > li > a:focus{
        color: #ffff !important;
    }

    #topnav .navigation-menu.nav-light > li > a:active{
        color: #ffff !important;
    }
    /* #topnav.nav-sticky .navigation-menu > li > a {
        color: #3c4858 !important;
    } */
    /* #topnav .navigation-menu .has-submenu .menu-arrow {
        border: solid #ffffff;
    } */
    @media (max-width: 991px){
        #topnav .navigation-menu.nav-light > li > a {
            color: #3c4858 !important;
            padding: 10px 20px;
        }
    }

    .event-width{
        width: 320px !important;
    }

    @media (max-width: 992px){
        .event-width{
            margin-left: -20px !important;
        }
    }

    .avatar.avatar-large {
        border: 1px solid;
        border-color: #e97d1f;
    }
</style>
<!-- Navbar STart -->
<header id="topnav" class="defaultscroll sticky navbar-dark">
    <div class="container">
        <!-- Logo container-->
        <div>
        <a class="logo" href="{{ route('client.home') }}">
            <img src="{{ asset('assets/images/home-fix-logo-colored.png') }}" style="margin-top: -40px !important; margin-bottom: -38px !important; margin-left: 50px !important" height="70" alt="FixMaster Logo">
        </a>
        </div>                 
        
        <!-- End Logo container-->
        <div class="menu-extras">
            <div class="menu-item">
                <!-- Mobile menu toggle-->
                <a class="navbar-toggle">
                    <div class="lines">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </a>
                <!-- End mobile menu toggle-->
            </div>
        </div>

        <div id="navigation">
            <!-- Navigation Menu-->   
            <ul class="navigation-menu nav-light">
                <li ><a href="{{ route('page.home') }}">FixMaster Home</a></li>

                <li><a class="{{ Route::currentRouteNamed('page.about') ? 'selected' : '' }}" href="{{ route('page.about') }}">About us</a></li>
                
                <li class="has-submenu {{ Route::currentRouteNamed('page.how_it_works', 'page.faq') ? 'selected' : '' }}">
                    <a href="javascript:void(0)">How it works</a><span class="menu-arrow"></span>
                    <ul class="submenu">
                        <li><a class="{{ Route::currentRouteNamed('page.how_it_works') ? 'selected' : '' }}" href="{{ route('page.how_it_works') }}">How It Works</a></li>
                        <li><a class="{{ Route::currentRouteNamed('page.faq') ? 'selected' : '' }}" href="{{ route('page.faq') }}">FAQ</a></li>
                    </ul>
                </li>
                
                <li><a class="{{ Route::currentRouteNamed('page.contact') ? 'selected' : '' }}" href="{{ route('page.contact') }}">Contact</a></li>

                <li class="has-submenu {{ Route::currentRouteNamed('client.home', 'client.messages', 'client.services', 'client.service_quote', 'client.service_custom', 'client.services_details', 'client.requests', 'client.request_details', 'client.request_invoice', 'client.messages', 'client.payments', 'client.settings', 'client.wallet', 'client.technician_profile') ? 'active' : '' }}">
                    <a href="javascript:void(0)" class="l-dark l-light">Profile</a><span class="menu-arrow"></span>
                    <ul class="submenu">
                        <li class="{{ Route::currentRouteNamed('client.home') ? 'active' : '' }}"><a href="{{ route('client.home') }}">Dashboard</a></li>

                        <li class="{{ Route::currentRouteNamed('client.services', 'client.service_quote', 'client.service_custom', 'client.services_details') ? 'active' : '' }}"><a href="{{ route('client.services') }}">Book a Service</a></li>

                        <li class="{{ Route::currentRouteNamed('client.wallet') ? 'active' : '' }}"><a href="{{ route('client.wallet') }}">E-Wallet</a></li>

                        <li class="{{ Route::currentRouteNamed('client.requests', 'client.request_details', 'client.request_invoice', 'client.technician_profile') ? 'active' : '' }}"><a href="{{ route('client.requests') }}">Requests</a></li>

                        <li class="{{ Route::currentRouteNamed('client.payments') ? 'active' : '' }}"><a href="{{ route('client.payments') }}">Payments</a></li>

                        <li class="{{ Route::currentRouteNamed('client.messages') ? 'active' : '' }}"><a href="{{ route('client.messages') }}">Messages</a></li>

                        <li class="{{ Route::currentRouteNamed('client.settings') ? 'active' : '' }}"><a href="{{ route('client.settings') }}">Settings</a></li>

                        {{-- <li><a href="{{ route('login') }}">Logout</a></li> --}}
                    </ul>
                </li>

                <li title="Logout"><a href="{{ route('logout') }}" ><i class="uil uil-sign-out-alt" style="font-size: 20px" ></i></a></li>

            </ul><!--end navigation menu-->
        </div><!--end navigation-->
    </div><!--end container-->
</header><!--end header-->
<!-- Navbar End -->
<!-- Navbar End -->
