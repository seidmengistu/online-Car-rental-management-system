@extends('layouts.main', ['title' => 'Gallery - Online Car Rental Management System'])

@section('content')

<!-- Gallery Section -->
<section class="gallery-section pt_120 pb_90">
    <div class="container">
        <div class="section-title centred mb_60">
            <span class="sub-title">Our Gallery</span>
            <h2 class="title">Explore Our Car Collection</h2>
            <p class="info-text">Browse through our extensive collection of premium rental vehicles.</p>
        </div>
        
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12 gallery-block mb_30">
                <div class="gallery-block-one">
                    <div class="inner-box">
                        <figure class="image-box">
                            <img src="{{ asset('assets/images/gallery/image-1.jpg') }}" alt="Gallery Image">
                        </figure>
                        <div class="view-btn">
                            <a href="{{ asset('assets/images/gallery/image-1.jpg') }}" class="lightbox-image" data-fancybox="gallery"><i class="icon-63"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 col-sm-12 gallery-block mb_30">
                <div class="gallery-block-one">
                    <div class="inner-box">
                        <figure class="image-box">
                            <img src="{{ asset('assets/images/gallery/image-2.jpg') }}" alt="Gallery Image">
                        </figure>
                        <div class="view-btn">
                            <a href="{{ asset('assets/images/gallery/image-2.jpg') }}" class="lightbox-image" data-fancybox="gallery"><i class="icon-63"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 col-sm-12 gallery-block mb_30">
                <div class="gallery-block-one">
                    <div class="inner-box">
                        <figure class="image-box">
                            <img src="{{ asset('assets/images/gallery/image-3.jpg') }}" alt="Gallery Image">
                        </figure>
                        <div class="view-btn">
                            <a href="{{ asset('assets/images/gallery/image-3.jpg') }}" class="lightbox-image" data-fancybox="gallery"><i class="icon-63"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 col-sm-12 gallery-block mb_30">
                <div class="gallery-block-one">
                    <div class="inner-box">
                        <figure class="image-box">
                            <img src="{{ asset('assets/images/gallery/image-4.jpg') }}" alt="Gallery Image">
                        </figure>
                        <div class="view-btn">
                            <a href="{{ asset('assets/images/gallery/image-4.jpg') }}" class="lightbox-image" data-fancybox="gallery"><i class="icon-63"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 col-sm-12 gallery-block mb_30">
                <div class="gallery-block-one">
                    <div class="inner-box">
                        <figure class="image-box">
                            <img src="{{ asset('assets/images/gallery/image-5.jpg') }}" alt="Gallery Image">
                        </figure>
                        <div class="view-btn">
                            <a href="{{ asset('assets/images/gallery/image-5.jpg') }}" class="lightbox-image" data-fancybox="gallery"><i class="icon-63"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 col-sm-12 gallery-block mb_30">
                <div class="gallery-block-one">
                    <div class="inner-box">
                        <figure class="image-box">
                            <img src="{{ asset('assets/images/gallery/image-6.jpg') }}" alt="Gallery Image">
                        </figure>
                        <div class="view-btn">
                            <a href="{{ asset('assets/images/gallery/image-6.jpg') }}" class="lightbox-image" data-fancybox="gallery"><i class="icon-63"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 col-sm-12 gallery-block mb_30">
                <div class="gallery-block-one">
                    <div class="inner-box">
                        <figure class="image-box">
                            <img src="{{ asset('assets/images/gallery/image-7.jpg') }}" alt="Gallery Image">
                        </figure>
                        <div class="view-btn">
                            <a href="{{ asset('assets/images/gallery/image-7.jpg') }}" class="lightbox-image" data-fancybox="gallery"><i class="icon-63"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 col-sm-12 gallery-block mb_30">
                <div class="gallery-block-one">
                    <div class="inner-box">
                        <figure class="image-box">
                            <img src="{{ asset('assets/images/gallery/image-8.jpg') }}" alt="Gallery Image">
                        </figure>
                        <div class="view-btn">
                            <a href="{{ asset('assets/images/gallery/image-8.jpg') }}" class="lightbox-image" data-fancybox="gallery"><i class="icon-63"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 col-sm-12 gallery-block mb_30">
                <div class="gallery-block-one">
                    <div class="inner-box">
                        <figure class="image-box">
                            <img src="{{ asset('assets/images/gallery/image-9.jpg') }}" alt="Gallery Image">
                        </figure>
                        <div class="view-btn">
                            <a href="{{ asset('assets/images/gallery/image-9.jpg') }}" class="lightbox-image" data-fancybox="gallery"><i class="icon-63"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Gallery Section End -->
@endsection