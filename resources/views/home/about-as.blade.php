@extends('layouts.main')

@section('content')




<!-- About Section -->
<section class="about-section pt_120 pb_120">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="about-image-box">
                    <div class="image-inner">
                        <img src="{{ asset('assets/images/resource/about-image.png') }}" alt="About Image">
                    </div>
                    <div class="experience-box">
                        <div class="inner">
                            <h2>10</h2>
                            <h6>Years of Experience</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-content-box">
                    <div class="section-title mb_20">
                        <span class="sub-title">About Us</span>
                        <h2 class="title">Your Trusted Partner for Premium Car Rentals</h2>
                    </div>
                    <div class="text-box mb_40">
                        <p>Welcome to our premier car rental service, where luxury meets affordability. With over a decade of experience in the industry, we've built a reputation for providing exceptional vehicles and outstanding customer service.</p>
                        <p>Our mission is to make your journey comfortable, convenient, and memorable. Whether you're traveling for business or pleasure, our diverse fleet of well-maintained vehicles ensures you'll find the perfect car for your needs.</p>
                    </div>
                    <div class="counter-inner mb_35">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="counter-block-one">
                                    <div class="inner-box">
                                        <div class="count-outer count-box">
                                            <span class="count-text" data-speed="1500" data-stop="500">0</span><span>+</span>
                                        </div>
                                        <h6>Satisfied Clients</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="counter-block-one">
                                    <div class="inner-box">
                                        <div class="count-outer count-box">
                                            <span class="count-text" data-speed="1500" data-stop="100">0</span><span>+</span>
                                        </div>
                                        <h6>Premium Vehicles</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="btn-box">
                        <a href="{{ route('cars.index') }}" class="btn-style-one">Explore Our Fleet</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- About Section End -->

<!-- Why Choose Us Section -->
<section class="why-choose-us-section pb_120">
    <div class="container">
        <div class="section-title centred mb_60">
            <span class="sub-title">Why Choose Us</span>
            <h2 class="title">The Benefits of Choosing Our Service</h2>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="feature-block-one">
                    <div class="inner-box">
                        <div class="icon-box">
                            <i class="icon-1"></i>
                        </div>
                        <h4>Premium Fleet</h4>
                        <p>Access to a wide range of luxury and economy vehicles that are meticulously maintained.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="feature-block-one">
                    <div class="inner-box">
                        <div class="icon-box">
                            <i class="icon-2"></i>
                        </div>
                        <h4>Competitive Pricing</h4>
                        <p>Enjoy premium services at affordable rates with our transparent pricing policy.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="feature-block-one">
                    <div class="inner-box">
                        <div class="icon-box">
                            <i class="icon-3"></i>
                        </div>
                        <h4>24/7 Support</h4>
                        <p>Our customer service team is available round the clock to assist you with any queries.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Why Choose Us Section End -->

<!-- Team Section -->
<section class="team-section pb_120">
    <div class="container">
        <div class="section-title centred mb_60">
            <span class="sub-title">Our Team</span>
            <h2 class="title">Meet Our Expert Team</h2>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="team-block-one">
                    <div class="inner-box">
                        <figure class="image-box">
                            <img src="{{ asset('assets/images/team/team-image-1.png') }}" alt="Team Member">
                        </figure>
                        <div class="lower-content">
                            <h4>John Smith</h4>
                            <span class="designation">CEO & Founder</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="team-block-one">
                    <div class="inner-box">
                        <figure class="image-box">
                            <img src="{{ asset('assets/images/team/team-image-2.png') }}" alt="Team Member">
                        </figure>
                        <div class="lower-content">
                            <h4>Sarah Johnson</h4>
                            <span class="designation">Operations Manager</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="team-block-one">
                    <div class="inner-box">
                        <figure class="image-box">
                            <img src="{{ asset('assets/images/team/team-image-3.png') }}" alt="Team Member">
                        </figure>
                        <div class="lower-content">
                            <h4>Michael Brown</h4>
                            <span class="designation">Customer Relations</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Team Section End -->
@endsection