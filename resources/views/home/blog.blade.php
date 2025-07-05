@extends('layouts.main', ['title' => 'Blog - Online Car Rental Management System'])

@section('content')

<!-- Blog Grid Section -->
<section class="blog-grid-section pt_120 pb_90">
    <div class="container">
        <div class="section-title centred mb_60">
            <span class="sub-title">Latest News</span>
            <h2 class="title">Car Rental News & Tips</h2>
            <p class="info-text">Stay updated with the latest trends, tips, and news from the car rental industry.</p>
        </div>
        
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12 news-block mb_30">
                <div class="news-block-one">
                    <div class="inner-box">
                        <div class="image-box">
                            <figure class="image">
                                <a href="#"><img src="{{ asset('assets/images/blog/blog-image-01.jpg') }}" alt="Blog Image"></a>
                            </figure>
                            <div class="post-date">
                                <h4>25<span>Jun</span></h4>
                            </div>
                        </div>
                        <div class="lower-content">
                            <ul class="post-info clearfix">
                                <li><i class="icon-18"></i><a href="#">Admin</a></li>
                                <li><i class="icon-19"></i>3 Comments</li>
                            </ul>
                            <h3><a href="#">Top 10 Road Trip Routes in Europe for Your Next Adventure</a></h3>
                            <p>Discover the most scenic and exciting road trip routes across Europe, perfect for your next car rental adventure.</p>
                            <div class="link-btn">
                                <a href="#" class="btn-style-one">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 col-sm-12 news-block mb_30">
                <div class="news-block-one">
                    <div class="inner-box">
                        <div class="image-box">
                            <figure class="image">
                                <a href="#"><img src="{{ asset('assets/images/blog/blog-image-02.jpg') }}" alt="Blog Image"></a>
                            </figure>
                            <div class="post-date">
                                <h4>18<span>Jun</span></h4>
                            </div>
                        </div>
                        <div class="lower-content">
                            <ul class="post-info clearfix">
                                <li><i class="icon-18"></i><a href="#">Admin</a></li>
                                <li><i class="icon-19"></i>5 Comments</li>
                            </ul>
                            <h3><a href="#">How to Choose the Perfect Rental Car for Your Family Vacation</a></h3>
                            <p>Learn how to select the ideal rental car that meets all your family's needs for a comfortable and enjoyable vacation.</p>
                            <div class="link-btn">
                                <a href="#" class="btn-style-one">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 col-sm-12 news-block mb_30">
                <div class="news-block-one">
                    <div class="inner-box">
                        <div class="image-box">
                            <figure class="image">
                                <a href="#"><img src="{{ asset('assets/images/blog/blog-image-03.jpg') }}" alt="Blog Image"></a>
                            </figure>
                            <div class="post-date">
                                <h4>12<span>Jun</span></h4>
                            </div>
                        </div>
                        <div class="lower-content">
                            <ul class="post-info clearfix">
                                <li><i class="icon-18"></i><a href="#">Admin</a></li>
                                <li><i class="icon-19"></i>2 Comments</li>
                            </ul>
                            <h3><a href="#">5 Essential Tips for Saving Money on Your Next Car Rental</a></h3>
                            <p>Discover practical strategies to reduce costs and get the best deals on your next car rental without compromising quality.</p>
                            <div class="link-btn">
                                <a href="#" class="btn-style-one">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 col-sm-12 news-block mb_30">
                <div class="news-block-one">
                    <div class="inner-box">
                        <div class="image-box">
                            <figure class="image">
                                <a href="#"><img src="{{ asset('assets/images/blog/blog-image-04.jpg') }}" alt="Blog Image"></a>
                            </figure>
                            <div class="post-date">
                                <h4>05<span>Jun</span></h4>
                            </div>
                        </div>
                        <div class="lower-content">
                            <ul class="post-info clearfix">
                                <li><i class="icon-18"></i><a href="#">Admin</a></li>
                                <li><i class="icon-19"></i>4 Comments</li>
                            </ul>
                            <h3><a href="#">The Rise of Electric Vehicles in the Car Rental Industry</a></h3>
                            <p>Explore how electric vehicles are transforming the car rental landscape and what this means for environmentally conscious travelers.</p>
                            <div class="link-btn">
                                <a href="#" class="btn-style-one">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 col-sm-12 news-block mb_30">
                <div class="news-block-one">
                    <div class="inner-box">
                        <div class="image-box">
                            <figure class="image">
                                <a href="#"><img src="{{ asset('assets/images/blog/blog-image-05.jpg') }}" alt="Blog Image"></a>
                            </figure>
                            <div class="post-date">
                                <h4>29<span>May</span></h4>
                            </div>
                        </div>
                        <div class="lower-content">
                            <ul class="post-info clearfix">
                                <li><i class="icon-18"></i><a href="#">Admin</a></li>
                                <li><i class="icon-19"></i>1 Comment</li>
                            </ul>
                            <h3><a href="#">Understanding Car Rental Insurance: What You Really Need</a></h3>
                            <p>Demystify the complex world of car rental insurance options and learn which coverages are essential for your protection.</p>
                            <div class="link-btn">
                                <a href="#" class="btn-style-one">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 col-sm-12 news-block mb_30">
                <div class="news-block-one">
                    <div class="inner-box">
                        <div class="image-box">
                            <figure class="image">
                                <a href="#"><img src="{{ asset('assets/images/blog/blog-image-06.jpg') }}" alt="Blog Image"></a>
                            </figure>
                            <div class="post-date">
                                <h4>22<span>May</span></h4>
                            </div>
                        </div>
                        <div class="lower-content">
                            <ul class="post-info clearfix">
                                <li><i class="icon-18"></i><a href="#">Admin</a></li>
                                <li><i class="icon-19"></i>6 Comments</li>
                            </ul>
                            <h3><a href="#">Luxury Car Rentals: Is the Premium Experience Worth the Cost?</a></h3>
                            <p>Evaluate whether splurging on a luxury rental car provides value for your money and enhances your travel experience.</p>
                            <div class="link-btn">
                                <a href="#" class="btn-style-one">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="pagination-wrapper text-center mt_30">
            <ul class="pagination clearfix">
                <li><a href="#" class="active">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#"><i class="fas fa-angle-right"></i></a></li>
            </ul>
        </div>
    </div>
</section>
<!-- Blog Grid Section End -->
@endsection