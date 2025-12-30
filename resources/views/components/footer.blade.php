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
                            <li><a href="{{ route('about') }}">About Team</a></li>
                            <li><a href="#">Policies</a></li>
                            <li><a href="#">Careers</a></li>
                            <li><a href="#">Press</a></li>
                            <li><a href="#">Open Road</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                    <div class="footer_widget footer_contact_widget">
                        <h4 class="footer_widget_title">Contact</h4>
                        <p>Medhanialem, Bole, Addis Ababa, Ethiopia</p>
                        <ul class="footer-info-list">
                            <li><a href="mailto:info@zerihuncarrent.com">info@zerihuncarrent.com</a></li>
                            <li><a href="tel:09-23-43-39-67">09-23-43-39-67</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom-outer">
            <div class="copyright">Copyright &copy; {{ date('Y') }} &nbsp;<a href="{{ route('home') }}">Ethio-Rental</a> , Inc. All Rights Reserved</div>
        </div>
    </div>
</footer>
<!-- Main Footer End -->

<!-- Scroll to Top -->
<button class="scroll-top scroll-to-target" data-target="html">
    <i class="icon-13"></i>
</button>
<!--End Scroll to Top --> 