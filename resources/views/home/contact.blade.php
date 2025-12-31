@extends('layouts.main', ['title' => 'Contact Us - Online Car Rental Management System'])

@section('content')
    <!-- Page Title -->
    <section class="page-title centred fixed-padding"
        style="background-image: url({{ asset('assets/images/background/inner-banner-bg.png') }}); padding-top: 200px !important;">
        <div class="container">
            <div class="content-box">
                <h1>Contact Us</h1>
                <ul class="bread-crumb clearfix">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li>Contact Us</li>
                </ul>
            </div>
        </div>
    </section>
    <!-- End Page Title -->

    <!-- Contact Info Section -->
    <section class="contact-info-section pt_120 pb_90">
        <div class="container">
            <div class="section-title centred mb_60">
                <span class="sub-title">Contact Info</span>
                <h2 class="title">Get in Touch with Us</h2>
                <p class="info-text">Have questions or need assistance? We're here to help! Reach out to us through any of
                    the following channels.</p>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="contact-info-block-one mb_30">
                        <div class="inner-box">
                            <div class="icon-box">
                                <i class="icon-23"></i>
                            </div>
                            <h4>Email Address</h4>
                            <p><a href="mailto:info@zerihuncarrent.com">info@zerihuncarrent.com</a></p>
                            <p><a href="mailto:support@zerihuncarrent.com">support@zerihuncarrent.com</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="contact-info-block-one mb_30">
                        <div class="inner-box">
                            <div class="icon-box">
                                <i class="icon-22"></i>
                            </div>
                            <h4>Phone Number</h4>
                            <p><a href="tel:09-23-43-39-67">09-23-43-39-67</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="contact-info-block-one mb_30">
                        <div class="inner-box">
                            <div class="icon-box">
                                <i class="icon-24"></i>
                            </div>
                            <h4>Office Address</h4>
                            <p>Medhanialem, Bole, Addis Ababa, Ethiopia</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Info Section End -->



    <!-- Map Section -->
    <section class="map-section">
        <div class="container-fluid p-0">
            <div class="google-map-area">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3940.74213543301!2d38.78298227487727!3d8.99585898950712!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x164b85a9ecb1407d%3A0x45804c012efea6de!2zRVRISU8gWkVSSUhVTiBDQVIgUkVOVEFMIEFERElTIEFCQUJBfEVUSElPUElBfOGLqOGImOGKquGKkyDhiqrhiKvhi618Y2FyIHJlbnR8cGhvbmUgbnVtYmVyfEx1eHVyeXxjYXI!5e0!3m2!1sen!2sit!4v1767100231093!5m2!1sen!2sit"
                    width="100%" height="500" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>
    <!-- Map Section End -->
@endsection