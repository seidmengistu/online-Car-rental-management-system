@extends('layouts.main', ['title' => 'Contact Us - Online Car Rental Management System'])

@section('content')
<!-- Page Title -->
<section class="page-title centred fixed-padding" style="background-image: url({{ asset('assets/images/background/inner-banner-bg.png') }});">
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
            <p class="info-text">Have questions or need assistance? We're here to help! Reach out to us through any of the following channels.</p>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="contact-info-block-one mb_30">
                    <div class="inner-box">
                        <div class="icon-box">
                            <i class="icon-23"></i>
                        </div>
                        <h4>Email Address</h4>
                        <p><a href="mailto:info@carrental.com">info@carrental.com</a></p>
                        <p><a href="mailto:support@carrental.com">support@carrental.com</a></p>
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
                        <p><a href="tel:+251-911-123-456">+251-911-123-456</a></p>
                        <p><a href="tel:+251-911-123-456">+251-911-123-456</a></p>
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
                        <p>57 Heold Insaf Station Road,<br>Cardiff, United Kingdom</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Contact Info Section End -->

<!-- Contact Form Section -->
<section class="contact-form-section pb_120">
    <div class="container">
        <div class="section-title mb_50">
            <span class="sub-title">Send Message</span>
            <h2 class="title">Have Questions? Send Us a Message</h2>
        </div>
        <div class="form-inner">
            <form method="post" action="#" id="contact-form" class="default-form">
                @csrf
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group">
                            <input type="text" name="name" placeholder="Your Name" required>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group">
                            <input type="email" name="email" placeholder="Email Address" required>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group">
                            <input type="text" name="phone" placeholder="Phone Number" required>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group">
                            <input type="text" name="subject" placeholder="Subject" required>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group">
                            <textarea name="message" placeholder="Write Message"></textarea>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group message-btn">
                            <button type="submit" class="btn-style-one">Send Message</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<!-- Contact Form Section End -->

<!-- Map Section -->
<section class="map-section">
    <div class="container-fluid p-0">
        <div class="google-map-area">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2484.6701389278105!2d-3.1812908!3d51.4813325!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x486e1cb8742c46f5%3A0xc620b871e5d19ede!2sCardiff%20Central%20Station!5e0!3m2!1sen!2suk!4v1656276812345!5m2!1sen!2suk" width="100%" height="500" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</section>
<!-- Map Section End -->
@endsection