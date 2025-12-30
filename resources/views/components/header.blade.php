<!-- preloader -->
<div class="loader-wrap" style="background: transparent !important;">
    <div class="preloader" style="background: transparent !important;">
        <div class="preloader-close" style="display: none;">x</div>
        <div id="handle-preloader" class="handle-preloader" style="background: transparent !important;">
            <div class="animation-preloader">
                <div class="spinner" style="border-color: #d4a853 !important; border-top-color: transparent !important;"></div>
            </div>
        </div>
    </div>
</div>
<style>
    .loader-wrap,
    .preloader,
    .handle-preloader {
        background: transparent !important;
    }
    .spinner {
        border: 4px solid #d4a853 !important;
        border-top-color: transparent !important;
    }

    /* Constrain logo height to prevent tall headers */
    .main_header_logo img,
    .sticky_header .main_header_logo img {
        height: 64px;      /* slightly larger for visibility */
        max-height: 64px;
        width: auto;
        object-fit: contain;
        display: block;
    }
</style>
<!-- preloader end -->

<!--Search Popup-->
<div id="search-popup" class="search-popup">
    <div class="popup-inner">
        <div class="container">
            <div class="upper-box">
                <figure class="logo-box"><a href="{{ route('home') }}"><img src="{{ asset('assets/images/logo.png') }}" alt=""></a></figure>
                <div class="close-search"><span class="fa-solid fa-xmark"></span></div>
            </div>
        </div>
    </div>
</div>
<!--End Search Popup-->

<!-- Main Header -->
<header class="header home-three">
    <!-- Header Top -->
    <div class="header-top-one">
        <div class="container">
            <div class="header-top-outer">
                <div class="header-top-info">
                    <i class="far fa-clock"></i>
                    <p>Open Hours: Mon - Sun 02.00 - 12.00</p>
                </div>
                <div class="header-top-contact-info">
                    <ul>
                        <li><i class="icon-22"></i><a href="#">09-23-43-39-67</a></li>
                        <li><i class="icon-23"></i><a href="#">info@zerihuncarrent.com</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Header Top -->

    <!-- Main Header -->
    <div class="main_header">
        <div class="container">
            <div class="main_header_inner">
                <div class="main_header_logo">
                    <figure>
                        <a href="{{ route('home') }}"><img src="{{ asset('assets/images/logo-light.png') }}" alt="Company Logo"></a>
                    </figure>
                </div>
                <div class="main_header_menu menu_area">
                    <!--Mobile Navigation Toggler-->
                    <div class="mobile-nav-toggler">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </div>
                    <nav class="main-menu">
                        <div class="collapse navbar-collapse show" id="navbarSupportedContent">
                            <ul class="navigation">
                                <li class="{{ Request::routeIs('home') ? 'active' : '' }}"><a href="{{ route('home') }}">Home</a>
                                <li class="dropdown">Cars
                                    <ul>
                                        <li><a href="{{ Request::routeIs('home') ? '#car-collection' : route('home') }}">Car Collection</a></li>
                                        <li><a href="{{ Request::routeIs('home') ? '#available-cars' : route('home') }}">Available Cars</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown"><a href="#">Pages</a>
                                    <ul>
                                        <li><a href="{{ route('about') }}">About Us</a></li>
                                        <li><a href="{{ route('faq') }}">Faq</a></li>
                                        <li><a href="{{ route('gallery') }}">Gallery</a></li>
                                        <li><a href="{{ route('blog') }}">Blog</a></li>
                                    </ul>
                                </li>                               
                                <li class="{{ Request::routeIs('contact') ? 'active' : '' }}"><a href="{{ route('contact') }}">Contact</a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
                <div class="header_right_content">
                    <!-- Custom Language Switcher -->
                    <div class="custom-language-switcher">
                        <button class="lang-toggle" id="langToggle">
                            <i class="fas fa-globe"></i>
                            <span class="current-lang">English</span>
                            <i class="fas fa-chevron-down arrow"></i>
                        </button>
                        <div class="lang-dropdown" id="langDropdown">
                            <div class="lang-option" data-lang="en">
                                <span class="lang-name">English</span>
                                <i class="fas fa-check check-icon"></i>
                            </div>
                            <div class="lang-option" data-lang="am">
                                <span class="lang-name">አማርኛ (Amharic)</span>
                                <i class="fas fa-check check-icon"></i>
                            </div>
                            <div class="lang-option" data-lang="om">
                                <span class="lang-name">Oromoo (Oromo)</span>
                                <i class="fas fa-check check-icon"></i>
                            </div>
                            <div class="lang-option" data-lang="so">
                                <span class="lang-name">Soomaali (Somali)</span>
                                <i class="fas fa-check check-icon"></i>
                            </div>
                        </div>
                    </div>
                    <!-- Hidden Google Translate (for functionality) -->
                    <div id="google_translate_landing" style="display: none;"></div>
                    <div class="link-btn">
                        @auth
                            <!-- Logged in user dropdown -->
                            <div class="dropdown">
                                <a href="#" class="btn-style-one dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user me-1"></i>{{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}">
                                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('profile') }}">
                                        <i class="fas fa-user-edit me-2"></i>Profile
                                    </a></li>
                                    @if(Auth::user()->isStaff() || Auth::user()->isManager())
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-cog me-2"></i>Admin Panel
                                    </a></li>
                                    @endif
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <!-- Guest user dropdown -->
                            <div class="dropdown">
                                <a href="#" class="btn-style-one dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user me-1"></i>Account
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('login') }}">
                                        <i class="fas fa-sign-in-alt me-2"></i>Login
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('register') }}">
                                        <i class="fas fa-user-plus me-2"></i>Register
                                    </a></li>
                                </ul>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Main Header -->

    <!-- Sticky Header-->
    <div class="sticky_header">
        <div class="container">
            <div class="main_header_inner">
                <div class="main_header_logo">
                    <figure>
                        <a href="{{ route('home') }}"><img src="{{ asset('assets/images/logo-light.png') }}" alt="Company Logo"></a>
                    </figure>
                </div>
                <div class="main_header_menu menu_area">
                    <nav class="main-menu">
                        <!--Keep This Empty / Menu will come through Javascript-->
                    </nav>
                </div>
                <div class="header_right_content">
                    <button class="search-toggler"><i class="fas fa-search"></i></button>
                    <div class="link-btn">
                        @auth
                            <!-- Logged in user dropdown -->
                            <div class="dropdown">
                                <a href="#" class="btn-style-one dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user me-1"></i>{{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}">
                                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('profile') }}">
                                        <i class="fas fa-user-edit me-2"></i>Profile
                                    </a></li>
                                    @if(Auth::user()->isStaff() || Auth::user()->isManager())
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-cog me-2"></i>Admin Panel
                                    </a></li>
                                    @endif
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <!-- Guest user dropdown -->
                            <div class="dropdown">
                                <a href="#" class="btn-style-one dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user me-1"></i>Account
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('login') }}">
                                        <i class="fas fa-sign-in-alt me-2"></i>Login
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('register') }}">
                                        <i class="fas fa-user-plus me-2"></i>Register
                                    </a></li>
                                </ul>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Sticky Header-->

    <!-- Mobile Menu  -->
    <div class="mobile-menu">
        <div class="menu-backdrop"></div>
        <div class="close-btn">X</div>
        <nav class="menu-box">
            <div class="nav-logo"><a href="{{ route('home') }}"><img src="{{ asset('assets/images/mobile-logo.png') }}" alt="" title=""></a></div>
            <div class="menu-outer">
                <!-- Mobile Navigation Menu -->
                <ul class="navigation clearfix">
                    <li class="{{ Request::routeIs('home') ? 'active' : '' }}"><a href="{{ route('home') }}">Home</a></li>
                    <li class="dropdown"><a href="#">Cars</a>
                        <ul>
                            <li><a href="{{ Request::routeIs('home') ? '#car-collection' : route('cars.index') }}">Car Collection</a></li>
                            <li><a href="{{ Request::routeIs('home') ? '#available-cars' : route('cars.index', ['available' => 'true']) }}">Available Cars</a></li>
                        </ul>
                    </li>
                    <li class="dropdown"><a href="#">Pages</a>
                        <ul>
                            <li><a href="{{ route('about') }}">About Us</a></li>
                            <li><a href="{{ route('faq') }}">Faq</a></li>
                            <li><a href="{{ route('gallery') }}">Gallery</a></li>
                            <li><a href="{{ route('blog') }}">Blog</a></li>
                        </ul>
                    </li>
                    <li class="{{ Request::routeIs('contact') ? 'active' : '' }}"><a href="{{ route('contact') }}">Contact</a></li>
                </ul>
            </div>
            <div class="contact-info">
                <h4>Contact Info</h4>
                <ul>
                    <li>Chicago 12, Melborne City, USA</li>
                    <li><a href="tel:+8801682648101">+88 01682648101</a></li>
                    <li><a href="mailto:info@example.com">info@example.com</a></li>
                </ul>
            </div>
            <ul class="social-links centred">
                <li><a href="#"><span class="fab fa-twitter"></span></a></li>
                <li><a href="#"><span class="fab fa-facebook-square"></span></a></li>
                <li><a href="#"><span class="fab fa-pinterest-p"></span></a></li>
                <li><a href="#"><span class="fab fa-instagram"></span></a></li>
            </ul>
        </nav>
    </div>
    <!-- End Mobile Menu -->

</header>
<!-- End Main Header --> 