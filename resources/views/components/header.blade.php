<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Animal | Template </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.ico') }}">

    <!-- CSS here -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slicknav.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <!-- ✅ Important: Alpine.js for dropdown -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

</head>

<body>

<header>
    <div class="header-area header-transparent">
        <div class="main-header header-sticky">
            <div class="container-fluid">
                <div class="row align-items-center">

                    <!-- Logo -->
                    <div class="col-xl-2 col-lg-2 col-md-1">
                        <div class="logo">
                            <a href="{{ url('/') }}"><img src="{{ asset('assets/img/logo/logo.png') }}" alt=""></a>
                        </div>
                    </div>

                    <div class="col-xl-10 col-lg-10 col-md-10">
                        <div class="menu-main d-flex align-items-center justify-content-end">

                            <!-- Main Menu -->
                            <div class="main-menu f-right d-none d-lg-block">
                                <nav> 
                                    <ul id="navigation">
                                        <li><a href="{{ url('/') }}">Home</a></li>
                                        <li><a href="{{ url('/about') }}">About</a></li>
                                        <li><a href="{{ url('/services') }}">Services</a></li>
                                        <li><a href="{{ url('/blog') }}">Blog</a></li>
                                        <li><a href="{{ url('/contact') }}">Contact</a></li>
                                    </ul>
                                </nav>
                            </div>

                            <!-- Right Buttons -->
                            <div class="header-right-btn f-right d-none d-lg-block ml-30">
                                @if (Route::has('login'))
                                    @auth
                                        <!-- ✅ Authenticated User Dropdown -->
                                        <div x-data="{ open: false }" class="relative">
                                            <button @click="open = !open" class="inline-flex items-center px-3 py-2 text-sm font-medium text-black bg-transparent border-0">
                                                <div>{{ Auth::user()->name }}</div>
                                                <i class="fas fa-chevron-down ms-2"></i>
                                            </button>

                                            <div x-show="open" @click.outside="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded shadow-lg py-2 z-50" style="display:none;">
                                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-gray-100 text-black">Dashboard</a>
                                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-gray-100 text-black">Profile</a>

                                                <form method="POST" action="{{ route('logout') }}">
                                                    @csrf
                                                    <button type="submit" class="w-full text-left px-4 py-2 text-black hover:bg-gray-100">Log Out</button>
                                                </form>
                                            </div>
                                        </div>
                                    @else
                                        <!-- ✅ Guest User -->
                                        <a href="{{ route('login') }}" class="btns btn btn-sm" style="color:black!important;">Login</a>
                                        @if (Route::has('register'))
                                            <a href="{{ route('register') }}" class="btns1 btn btn-sm ml-2" >Register</a>
                                        @endif
                                    @endauth
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Mobile Menu -->
                    <div class="col-12">
                        <div class="mobile_menu d-block d-lg-none"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</header>
<style>a.btns.btn.btn-sm {
    border: 2px solid black!important;
    background: none!Important;
}
a.btns1.btn.btn-sm {
    border: 0px solid black!important;
    background: #f32c2e!Important;
    color:white!important;
}

</style>