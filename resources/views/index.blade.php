<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Carola - HTML 5 Template Preview</title>

    <!-- Stylesheets -->
    <link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/fontawesome-all.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/iconfont.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/owl.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/global.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/jquery.fancybox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/elements-css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/elements-css/footer.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/elements-css/booking-form.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/language-switcher/polyglot-language-switcher.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/daterangepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/jquery-ui.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">

    <!-- Fav Icon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    
    <!-- Custom styles for authentication dropdowns -->
    <style>
        .dropdown-menu {
            background: #fff;
            border: 1px solid rgba(0,0,0,.15);
            border-radius: 0.375rem;
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,.175);
            margin-top: 0.125rem;
            min-width: 10rem;
            padding: 0.5rem 0;
            z-index: 1000;
        }
        
        .dropdown-item {
            background: none;
            border: 0;
            clear: both;
            color: #212529;
            display: block;
            font-weight: 400;
            line-height: 1.5;
            padding: 0.375rem 1rem;
            text-align: inherit;
            text-decoration: none;
            white-space: nowrap;
            width: 100%;
        }
        
        .dropdown-item:hover {
            background-color: #f8f9fa;
            color: #16181b;
        }
        
        .dropdown-divider {
            border-top: 1px solid #dee2e6;
            height: 0;
            margin: 0.5rem 0;
            overflow: hidden;
        }
        
        .dropdown-toggle::after {
            border-top: 0.3em solid;
            border-right: 0.3em solid transparent;
            border-bottom: 0;
            border-left: 0.3em solid transparent;
            content: "";
            display: inline-block;
            margin-left: 0.255em;
            vertical-align: 0.255em;
        }
        
        .btn-style-one.dropdown-toggle {
            text-decoration: none;
        }
        
        .btn-style-one.dropdown-toggle:hover {
            text-decoration: none;
        }
    </style>
</head>


<!-- Page Wrapper -->
<body class="boxed_wrapper">

<!-- preloader -->
<div class="loader-wrap">
    <div class="preloader">
        <div class="preloader-close">x</div>
        <div id="handle-preloader" class="handle-preloader">
            <div class="animation-preloader">
                <div class="spinner"></div>
                <div class="txt-loading">
                    <span data-text-preloader="C" class="letters-loading">
                        C
                    </span>
                    <span data-text-preloader="a" class="letters-loading">
                        a
                    </span>
                    <span data-text-preloader="r" class="letters-loading">
                        r
                    </span>
                    <span data-text-preloader="o" class="letters-loading">
                        o
                    </span>
                    <span data-text-preloader="l" class="letters-loading">
                        l
                    </span>
                    <span data-text-preloader="a" class="letters-loading">
                        a
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
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
        <div class="overlay-layer"></div>
        <div class="container">
            <div class="search-form">
                <form method="post" action="https://z.commonsupport.com/html/carola/index.html">
                    <div class="form-group">
                        <fieldset>
                            <input type="search" class="form-control" name="search-input" value="" placeholder="Type your keyword and hit" required >
                            <button type="submit"><i class="icon-50"></i></button>
                        </fieldset>
                    </div>
                </form>
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
                    <p>Open Hours: Mon - Fri 8.00 am - 6.00 pm</p>
                </div>
                <div class="header-top-contact-info">
                    <ul>
                        <li><i class="icon-22"></i><a href="#">+39-351-780-4756</a></li>
                        <li><i class="icon-23"></i><a href="#">info@carrental.com</a></li>
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
                                <li class="active"><a href="/">Home</a>
                                <li class="dropdown"><a href="index-2.html">Car Fleet</a>
                                    <ul>
                                        <li><a href="car-listing.html">Car Listing</a></li>
                                        <li><a href="car-listing-2.html">Car Listing 2</a></li>
                                        <li><a href="car-listing-3.html">Car Listing 3</a></li>
                                        <li><a href="car-listing-4.html">Car Listing 4</a></li>
                                        <li><a href="car-details.html">Car Details</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown"><a href="index-2.html">Pages</a>
                                    <ul>
                                        <li><a href="about-us.html">About Us</a></li>
                                        <li><a href="team.html">Our Team</a></li>
                                        <li><a href="faq.html">Faq</a></li>
                                        <li class="dropdown"><a href="index-2.html">Testimonials</a>
                                            <ul>
                                                <li><a href="testimonials.html">Testimonials</a></li>
                                                <li><a href="testimonials-2.html">Testimonials 2</a></li>
                                                <li><a href="testimonials-3.html">Testimonials 3</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="services-area.html">Service Areas</a></li>
                                        <li><a href="area-details.html">Area Details</a></li>
                                        <li><a href="gallery.html">Gallery</a></li>
                                        <li><a href="pricing.html">Pricing</a></li>
                                        <li><a href="checkout.html">Checkout</a></li>
                                        <li><a href="error.html">404</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown"><a href="index-2.html">News</a>
                                    <ul>
                                        <li><a href="blog-grid.html">Blog Grid</a></li>
                                        <li><a href="blog-standard.html">Blog Standard</a></li>
                                        <li><a href="blog-details.html">Blog Details</a></li>
                                    </ul>
                                </li>
                                <li><a href="contact.html">Contact</a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
                <div class="header_right_content">
                    <button class="search-toggler"><i class="fas fa-search"></i></button>
                    <div class="language-switcher">
                        <div id="polyglotLanguageSwitcher">
                            <form action="#">
                                <select id="polyglot-language-options">
                                    <option id="en" value="en" selected></option>
                                    <option id="fr" value="fr"></option>
                                    <option id="de" value="de"></option>
                                    <option id="it" value="it"></option>
                                    <option id="es" value="es"></option>
                                </select>
                            </form>
                        </div>
                    </div>
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
            <div class="menu-outer"><!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header--></div>
            <div class="contact-info">
                <h4>Contact Info</h4>
                <ul>
                    <li>Chicago 12, Melborne City, USA</li>
                    <li><a href="tel:+8801682648101">+88 01682648101</a></li>
                    <li><a href="mailto:info@example.com">info@example.com</a></li>
                </ul>
            </div>
            <ul class="social-links centred">
                <li><a href="index-2.html"><span class="fab fa-twitter"></span></a></li>
                <li><a href="index-2.html"><span class="fab fa-facebook-square"></span></a></li>
                <li><a href="index-2.html"><span class="fab fa-pinterest-p"></span></a></li>
                <li><a href="index-2.html"><span class="fab fa-instagram"></span></a></li>
            </ul>
        </nav>
    </div>
    <!-- End Mobile Menu -->

</header>
<!-- End Main Header -->

<!-- Slider Three -->
<section class="slider style_three">
    <div class="owl-carousel owl-nav-none owl_dots_none theme_carousel owl-theme"
       data-options='{"loop": true, "margin": 0, "autoheight":true, "lazyload":true, "nav": true, "dots": true, "autoplay": true, "autoplayTimeout": 7000, "smartSpeed": 1800, "responsive":{ "0" :{ "items": "1" }, "768" :{ "items" : "1" } , "1000":{ "items" : "1" }}}'>
       <div class="slide-item-content">
          <div class="slide-item content_left">
             <div class="image-layer" style="background-image:url(assets/images/sliders/slider-3.jpg)">
             </div>
             <div class="container">
                <div class="slider_content">
                    <h6 class="animate_up d-inline-block">Car Rental</h6>
                    <h1 class="animate_left">Luxury Dream <br><span>Cars for Rental</span></h1>
                    <p class="description animate_right">Embark on a stylish journey without the high cost.<br>Explore our affordable dream car rentals</p>
                    <div class="button_all animate_down">
                    <a href="#" target="_blank" rel="nofollow" class="btn-style-four animated">Get in Touch</a>
                    </div>
                </div>
             </div>
          </div>
       </div>
       <div class="slide-item-content">
          <div class="slide-item content_left">
             <div class="image-layer" style="background-image:url(assets/images/sliders/slider-3.jpg)">
             </div>
             <div class="container">
                <div class="slider_content">
                    <h6 class="animate_up d-inline-block">Car Rental</h6>
                    <h1 class="animate_left">Luxury Dream <br><span>Cars for Rental</span></h1>
                    <p class="description animate_right">Embark on a stylish journey without the high cost<br>Explore our affordable dream car rentals</p>
                    <div class="button_all animate_down">
                    <a href="#" target="_blank" rel="nofollow" class="btn-style-four animated">Get in Touch</a>
                    </div>
                </div>
             </div>
          </div>
       </div>
       <div class="slide-item-content">
          <div class="slide-item content_left">
             <div class="image-layer" style="background-image:url(assets/images/sliders/slider-3.jpg)">
             </div>
             <div class="container">
                <div class="slider_content">
                    <h6 class="animate_up d-inline-block">Car Rental</h6>
                    <h1 class="animate_left">Luxury Dream <br><span>Cars for Rental</span></h1>
                    <p class="description animate_right">Embark on a stylish journey without the high cost<br>Explore our affordable dream car rentals</p>
                    <div class="button_all animate_down">
                    <a href="#" target="_blank" rel="nofollow" class="btn-style-four animated">Get in Touch</a>
                    </div>
                </div>
             </div>
          </div>
       </div>
    </div>
</section>
<!-- Slider Three End -->



<!-- Car Type Section -->
<section class="car-type-section pt_120 pb_90 home-three">
    <div class="container">
        <div class="section-title centred mb_60">
            <span class="sub-title">Car Makes</span>
            <h2 class="title">Explore Our Car Collection</h2>
        </div>
        <div class="car-type-outer-box">
            @foreach($carMakes as $carMake)
            <div class="car-type-item">
                <div class="car-image">
                    @php
                        $makeImages = [
                            'Toyota' => 'car-1.png',
                            'Honda' => 'car-2.png', 
                            'BMW' => 'car-3.png',
                            'Tesla' => 'car-4.png',
                            'Ford' => 'car-5.png',
                            'Mercedes-Benz' => 'car-6.png',
                            'Audi' => 'sedan.png',
                            'Hyundai' => 'hatchback.png',
                            'Porsche' => 'sports-car.png',
                            'Volkswagen' => 'suv.png'
                        ];
                        $imageFile = $makeImages[$carMake->make] ?? 'car-1.png';
                    @endphp
                    <img src="{{ asset('assets/images/car-type/' . $imageFile) }}" alt="{{ $carMake->make }}">
                    <div class="shape"><img src="{{ asset('assets/images/shape/shape-2.png') }}" alt=""></div>
                    <div class="car-count">
                        <span class="count-badge">{{ $carMake->total_count }}</span>
                    </div>
                </div>
                <div class="car-name">
                    <h6><a href="{{ route('cars.index', ['make' => $carMake->make]) }}">{{ $carMake->make }}</a></h6>
                    <p class="car-count-text">{{ $carMake->total_count }} {{ Str::plural('car', $carMake->total_count) }} available</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Car Type Section End -->

<!-- Divider Section -->
<section class="divider">
    <div class="container">
        <div class="border-divider"></div>
    </div>
</section>
<!-- Divider Section End -->


<!-- Brand Section 2 -->
<section class="brand-section-2 home-three">
    <div class="container-fulid">
        <div class="brand-outer-box-2">
            <div class="single-brand-item-2">
                <div class="brand-image">
                    <img src="assets/images/brands/brand-1.png" alt="">
                </div>
            </div>
            <div class="single-brand-item-2">
                <div class="brand-image">
                    <img src="assets/images/brands/brand-2.png" alt="">
                </div>
            </div>
            <div class="single-brand-item-2">
                <div class="brand-image">
                    <img src="assets/images/brands/brand-3.png" alt="">
                </div>
            </div>
            <div class="single-brand-item-2">
                <div class="brand-image">
                    <img src="assets/images/brands/brand-4.png" alt="">
                </div>
            </div>
            <div class="single-brand-item-2">
                <div class="brand-image">
                    <img src="assets/images/brands/brand-5.png" alt="">
                </div>
            </div>
            <div class="single-brand-item-2">
                <div class="brand-image">
                    <img src="assets/images/brands/brand-6.png" alt="">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Brand Section 2 End -->

<!-- Featured Cars Section -->
<section class="featured-cars-section">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="section-title text-center">
          <h2>Available Cars</h2>
          <p>Choose from our selection of quality vehicles</p>
        </div>
      </div>
    </div>
    
    @if($cars->count() > 0)
    <div class="row">
      @foreach($cars as $car)
      <div class="col-lg-4 col-md-6 mb-4">
        <div class="featured-car-item">
          <div class="car-image">
            @if($car->image)
              <img src="{{ Storage::url($car->image) }}" alt="{{ $car->full_name }}" class="img-fluid">
            @else
              <div class="no-image-placeholder">
                <i class="fas fa-car fa-3x"></i>
              </div>
            @endif
            <div class="car-price">
              <span>${{ number_format($car->daily_rate, 2) }}</span>
              <small>/day</small>
            </div>
          </div>
          <div class="car-details">
            <h4>{{ $car->full_name }}</h4>
            <p class="car-info">
              <span><i class="fas fa-palette"></i> {{ $car->color }}</span>
              <span><i class="fas fa-users"></i> {{ $car->seats }} seats</span>
              <span><i class="fas fa-gas-pump"></i> {{ ucfirst($car->fuel_type) }}</span>
              <span><i class="fas fa-cog"></i> {{ ucfirst($car->transmission) }}</span>
            </p>
            <p class="car-description">{{ Str::limit($car->description, 100) }}</p>
            <div class="car-actions">
              <button type="button" class="btn btn-outline-primary btn-sm" onclick="showCarDetails({{ $car->id }}, '{{ $car->full_name }}', '{{ $car->color }}', {{ $car->seats }}, '{{ ucfirst($car->fuel_type) }}', '{{ ucfirst($car->transmission) }}', '{{ $car->description }}', {{ $car->daily_rate }}, '{{ $car->image ? Storage::url($car->image) : '' }}')">
                <i class="fas fa-eye"></i> View Details
              </button>
              @auth
                <a href="{{ route('reservations.create', ['car_id' => $car->id]) }}" class="btn btn-success btn-sm">
                  <i class="fas fa-calendar-plus"></i> Reserve Now
                </a>
              @else
                <a href="{{ route('login') }}" class="btn btn-warning btn-sm">
                  <i class="fas fa-sign-in-alt"></i> Login to Reserve
                </a>
              @endauth
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
    
    <div class="row mt-4">
      <div class="col-lg-12 text-center">
        <a href="{{ route('cars.index') }}" class="btn btn-primary btn-lg">
          <i class="fas fa-list"></i> View All Cars
        </a>
      </div>
    </div>
    @else
    <div class="row">
      <div class="col-lg-12">
        <div class="alert alert-info text-center">
          <i class="fas fa-info-circle"></i> No cars available at the moment. Please check back later.
        </div>
      </div>
    </div>
    @endif
  </div>
</section>
<!-- Featured Cars Section End -->

<!-- Brand Section -->
<section class="brand-section pt_120 pb_120">
    <div class="container">
        <div class="section-title-box">
            <div class="section-title">
                <span class="sub-title">Brands</span>
                <h2 class="title">Explore Premium Car Brands</h2>
            </div>
            <div class="show-all-btn">
                <a href="#" class="btn-style-three">Show all Brands</a>
            </div>
        </div>
        <div class="brand-outer-box">
            <div class="single-brand-item">
                <div class="brand-image">
                    <img src="assets/images/brands/audi.png" alt="">
                </div>
                <div class="brand-title">
                    <h6>Audi</h6>
                </div>
            </div>
            <div class="single-brand-item">
                <div class="brand-image">
                    <img src="assets/images/brands/bmw.png" alt="">
                </div>
                <div class="brand-title">
                    <h6>BMW</h6>
                </div>
            </div>
            <div class="single-brand-item">
                <div class="brand-image">
                    <img src="assets/images/brands/mercedes-benz.png" alt="">
                </div>
                <div class="brand-title">
                    <h6>Mercedes Benz</h6>
                </div>
            </div>
            <div class="single-brand-item">
                <div class="brand-image">
                    <img src="assets/images/brands/tesla-motors.png" alt="">
                </div>
                <div class="brand-title">
                    <h6>Tesla Motors</h6>
                </div>
            </div>
            <div class="single-brand-item">
                <div class="brand-image">
                    <img src="assets/images/brands/volkswagen.png" alt="">
                </div>
                <div class="brand-title">
                    <h6>Volkswagen</h6>
                </div>
            </div>
            <div class="single-brand-item">
                <div class="brand-image">
                    <img src="assets/images/brands/porsche.png" alt="">
                </div>
                <div class="brand-title">
                    <h6>Porsche</h6>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Brand Section End -->

<!-- Services Section -->
<section class="services-section pt_120 pb_90">
    <div class="container">
        <div class="section-title centred mb_60">
            <span class="sub-title">Service Area</span>
            <h2 class="title">Top Places We Serve</h2>
        </div>
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                <div class="services-block-one">
                    <h6 class="service-title"><a href="#">Paris, France</a></h6>
                    <div class="services-iamge">
                        <img src="assets/images/service/service-image-1.jpg" alt="">
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                <div class="services-block-one">
                    <h6 class="service-title"><a href="#">Rome, Italy</a></h6>
                    <div class="services-iamge">
                        <img src="assets/images/service/service-image-2.jpg" alt="">
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                <div class="services-block-one">
                    <h6 class="service-title"><a href="#">Berlin, Germany</a></h6>
                    <div class="services-iamge">
                        <img src="assets/images/service/service-image-3.jpg" alt="">
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                <div class="services-block-one">
                    <h6 class="service-title"><a href="#">Beijing, China</a></h6>
                    <div class="services-iamge">
                        <img src="assets/images/service/service-image-4.jpg" alt="">
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                <div class="services-block-one">
                    <h6 class="service-title"><a href="#">Abu Dhabi, UAE</a></h6>
                    <div class="services-iamge">
                        <img src="assets/images/service/service-image-5.jpg" alt="">
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                <div class="services-block-one">
                    <h6 class="service-title"><a href="#">Dhaka, Bangladesh</a></h6>
                    <div class="services-iamge">
                        <img src="assets/images/service/service-image-6.jpg" alt="">
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                <div class="services-block-one">
                    <h6 class="service-title"><a href="#">Singapore</a></h6>
                    <div class="services-iamge">
                        <img src="assets/images/service/service-image-7.jpg" alt="">
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                <div class="services-block-one">
                    <h6 class="service-title"><a href="#">London, UK</a></h6>
                    <div class="services-iamge">
                        <img src="assets/images/service/service-image-8.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Services Section End -->

<!-- Blog Section -->
<section class="blog-section pt_120 pb_90">
    <div class="container">
        <div class="section-title centred mb_60">
            <span class="sub-title">Latest News</span>
            <h2 class="title">Latest Press Update</h2>
        </div>
        <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                <div class="blog-post-one">
                    <div class="blog-post-outer">
                        <div class="blog-post-image">
                            <img src="assets/images/blog/blog-image-01.jpg" alt="">
                        </div>
                        <div class="blog-post-content">
                            <ul class="post-info">
                                <li class="post-tag"><a href="blog-details.html">Travel Blog</a></li>
                                <li class="post-date"><i class="icon-31"></i>20 Mar, 2024</li>
                            </ul>
                            <h3 class="post-title"><a href="#">10 European ski destinations you should visit this winter</a></h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                <div class="blog-post-one">
                    <div class="blog-post-outer">
                        <div class="blog-post-image">
                            <img src="assets/images/blog/blog-image-02.jpg" alt="">
                        </div>
                        <div class="blog-post-content">
                            <ul class="post-info">
                                <li class="post-tag"><a href="blog-details.html">Covid Travel</a></li>
                                <li class="post-date"><i class="icon-31"></i>20 Mar, 2024</li>
                            </ul>
                            <h3 class="post-title"><a href="#">Booking travel during Corona: Find who are giving service</a></h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                <div class="blog-post-one">
                    <div class="blog-post-outer">
                        <div class="blog-post-image">
                            <img src="assets/images/blog/blog-image-03.jpg" alt="">
                        </div>
                        <div class="blog-post-content">
                            <ul class="post-info">
                                <li class="post-tag"><a href="blog-details.html">Europe</a></li>
                                <li class="post-date"><i class="icon-31"></i>20 Mar, 2024</li>
                            </ul>
                            <h3 class="post-title"><a href="#">Change your place and get the fresh air from the nature</a></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Blog Section End -->


<!-- Main Footer -->
<footer class="main_footer home-three">
    <div class="container">
        <div class="footer-top-outer">
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                    <div class="footer_widget footer_about_widget">
                        <figure class="footer_widget_logo">
                            <a href="{{ route('home') }}"><img src="{{ asset('assets/images/footer-logo.png') }}" alt=""></a>
                        </figure>
                        <h6><strong>Follow Us On:</strong></h6>
                        <ul class="social-links">
                            <li><a href="#"><i class="fab fa-square-facebook"></i></a></li>
                            <li><a href="#"><i class="fab fa-square-twitter"></i></a></li>
                            <li><a href="#"><i class="fab fa-linkedin"></i></a></li>
                            <li><a href="#"><i class="fab fa-dribbble"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                    <div class="footer_widget footer_resources_widget">
                        <h4 class="footer_widget_title">Resources</h4>
                        <ul class="resources_page_list">
                            <li><a href="#">About Team</a></li>
                            <li><a href="#">Policies</a></li>
                            <li><a href="#">Careers</a></li>
                            <li><a href="#">Press</a></li>
                            <li><a href="#">Open Road</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12">
                    <div class="footer_widget footer_community_widget">
                        <h4 class="footer_widget_title">Community</h4>
                        <ul class="community_page_list">
                            <li><a href="#">Newsletter</a></li>
                            <li><a href="#">Reviews</a></li>
                            <li><a href="#">Testimonials</a></li>
                            <li><a href="#">Social Group</a></li>
                            <li><a href="#">Helpdesk</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                    <div class="footer_widget footer_contact_widget">
                        <h4 class="footer_widget_title">Contact</h4>
                        <p>57 heold insaf Station Road, Cardiff, United Kingdom</p>
                        <ul class="footer-info-list">
                            <li><a href="#">info@example.com</a></li>
                            <li><a href="#">029 2021 4012</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom-outer">
            <div class="copyright">Copyright &copy; 2025 &nbsp;<a href="index-2.html">Carola</a> , Inc. All Rights Reserved</div>
        </div>
    </div>
</footer>
<!-- Main Footer End -->

<!-- Scroll to Top -->
<button class="scroll-top scroll-to-target" data-target="html">
    <i class="icon-13"></i>
</button>
<!--End Scroll to Top -->
<!-- Scripts -->
<script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery-ui.js') }}"></script>
<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/daterangepicker.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.fancybox.js') }}"></script>
<script src="{{ asset('assets/js/appear.js') }}"></script>
<script src="{{ asset('assets/js/wow.js') }}"></script>
<script src="{{ asset('assets/js/owl.js') }}"></script>
<script src="{{ asset('assets/js/validation.js') }}"></script>
<script src="{{ asset('assets/language-switcher/jquery.polyglot.language.switcher.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
<script src="{{ asset('assets/js/booking-form.js') }}"></script>

<!-- AdminLTE JS -->
<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

<!-- Car Details Modal -->
<div class="modal fade" id="carDetailsModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Car Details</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="car-image-container text-center mb-3">
              <img id="modalCarImage" src="" alt="Car Image" class="img-fluid rounded" style="max-height: 300px; width: auto;">
              <div id="modalNoImage" class="no-image-placeholder d-none">
                <i class="fas fa-car fa-5x text-muted"></i>
                <p class="text-muted mt-2">No image available</p>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <h5 id="modalCarName" class="text-primary mb-3"></h5>
            <div class="car-specs">
              <div class="row mb-2">
                <div class="col-6"><strong>Color:</strong></div>
                <div class="col-6" id="modalCarColor"></div>
              </div>
              <div class="row mb-2">
                <div class="col-6"><strong>Seats:</strong></div>
                <div class="col-6" id="modalCarSeats"></div>
              </div>
              <div class="row mb-2">
                <div class="col-6"><strong>Fuel Type:</strong></div>
                <div class="col-6" id="modalCarFuelType"></div>
              </div>
              <div class="row mb-2">
                <div class="col-6"><strong>Transmission:</strong></div>
                <div class="col-6" id="modalCarTransmission"></div>
              </div>
              <div class="row mb-3">
                <div class="col-6"><strong>Daily Rate:</strong></div>
                <div class="col-6">
                  <span class="badge badge-success" id="modalCarPrice"></span>
                </div>
              </div>
            </div>
            <div class="car-description">
              <h6>Description:</h6>
              <p id="modalCarDescription" class="text-muted"></p>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <div>
          @auth
            <a href="#" id="modalReserveBtn" class="btn btn-success">
              <i class="fas fa-calendar-plus"></i> Reserve Now
            </a>
          @else
            <a href="{{ route('login') }}" class="btn btn-warning">
              <i class="fas fa-sign-in-alt"></i> Login to Reserve
            </a>
          @endauth
        </div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script>
function showCarDetails(carId, carName, color, seats, fuelType, transmission, description, dailyRate, imageUrl) {
  // Populate modal with car data
  document.getElementById('modalCarName').textContent = carName;
  document.getElementById('modalCarColor').textContent = color;
  document.getElementById('modalCarSeats').textContent = seats + ' seats';
  document.getElementById('modalCarFuelType').textContent = fuelType;
  document.getElementById('modalCarTransmission').textContent = transmission;
  document.getElementById('modalCarPrice').textContent = '$' + parseFloat(dailyRate).toFixed(2) + ' /day';
  document.getElementById('modalCarDescription').textContent = description;
  
  // Handle car image
  const carImage = document.getElementById('modalCarImage');
  const noImage = document.getElementById('modalNoImage');
  
  if (imageUrl && imageUrl.trim() !== '') {
    carImage.src = imageUrl;
    carImage.classList.remove('d-none');
    noImage.classList.add('d-none');
  } else {
    carImage.classList.add('d-none');
    noImage.classList.remove('d-none');
  }
  
  // Update reserve button href
  const reserveBtn = document.getElementById('modalReserveBtn');
  if (reserveBtn) {
    reserveBtn.href = "{{ route('reservations.create') }}?car_id=" + carId;
  }
  
  // Show the modal
  $('#carDetailsModal').modal('show');
}
</script>
</body>

</html>
