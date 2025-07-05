@extends('layouts.main', ['title' => 'FAQ - Online Car Rental Management System'])

@section('content')
<!-- FAQ Section -->
<section class="faq-section pt_120 pb_120">
    <div class="container">
        <div class="section-title centred mb_60">
            <span class="sub-title">FAQ</span>
            <h2 class="title">Common Questions About Our Services</h2>
            <p class="info-text">Find answers to the most frequently asked questions about our car rental services.</p>
        </div>
        
        <div class="row">
            <div class="col-lg-6">
                <div class="faq-block mb_50">
                    <h3 class="faq-category-title">Rental Process</h3>
                    
                    <div class="accordion" id="rentalProcessAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading1">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                    How do I make a reservation?
                                </button>
                            </h2>
                            <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="heading1" data-bs-parent="#rentalProcessAccordion">
                                <div class="accordion-body">
                                    <p>You can make a reservation through our website by selecting your desired car, rental dates, and providing your personal information. Alternatively, you can call our customer service line or visit one of our rental locations in person.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading2">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                    What documents do I need to rent a car?
                                </button>
                            </h2>
                            <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#rentalProcessAccordion">
                                <div class="accordion-body">
                                    <p>To rent a car, you'll need a valid driver's license, a credit card in your name for the security deposit, and a form of identification (passport or ID card). International customers may need an International Driving Permit along with their national driver's license.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading3">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                    Can I modify or cancel my reservation?
                                </button>
                            </h2>
                            <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#rentalProcessAccordion">
                                <div class="accordion-body">
                                    <p>Yes, you can modify or cancel your reservation through your account on our website or by contacting our customer service. Please note that cancellation fees may apply depending on how close to the pickup date you cancel.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="faq-block">
                    <h3 class="faq-category-title">Payment & Pricing</h3>
                    
                    <div class="accordion" id="paymentAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading4">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                    What payment methods do you accept?
                                </button>
                            </h2>
                            <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#paymentAccordion">
                                <div class="accordion-body">
                                    <p>We accept all major credit cards including Visa, MasterCard, American Express, and Discover. For the security deposit, we require a credit card in the main driver's name. Debit cards may be accepted for payment but not for the security deposit.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading5">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                                    Is there a security deposit?
                                </button>
                            </h2>
                            <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#paymentAccordion">
                                <div class="accordion-body">
                                    <p>Yes, a security deposit is required when you pick up the car. The amount varies depending on the car category. This deposit is held (not charged) on your credit card and released after the car is returned in the same condition as when it was rented.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="faq-block mb_50">
                    <h3 class="faq-category-title">Car Rental Policies</h3>
                    
                    <div class="accordion" id="policiesAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading6">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                                    What is your fuel policy?
                                </button>
                            </h2>
                            <div id="collapse6" class="accordion-collapse collapse" aria-labelledby="heading6" data-bs-parent="#policiesAccordion">
                                <div class="accordion-body">
                                    <p>Our standard policy is "full-to-full." This means you'll receive the car with a full tank and are expected to return it with a full tank. If you return the car with less fuel than when you received it, you'll be charged for the missing fuel plus a refueling service fee.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading7">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
                                    What happens if I return the car late?
                                </button>
                            </h2>
                            <div id="collapse7" class="accordion-collapse collapse" aria-labelledby="heading7" data-bs-parent="#policiesAccordion">
                                <div class="accordion-body">
                                    <p>If you return the car later than the agreed time, you may be charged for an additional day's rental. We typically provide a grace period of 29 minutes, but after that, late fees will apply. If you know you'll be late, please contact us as soon as possible.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="faq-block">
                    <h3 class="faq-category-title">Insurance & Coverage</h3>
                    
                    <div class="accordion" id="insuranceAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading8">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse8" aria-expanded="false" aria-controls="collapse8">
                                    What insurance coverage is included in my rental?
                                </button>
                            </h2>
                            <div id="collapse8" class="accordion-collapse collapse" aria-labelledby="heading8" data-bs-parent="#insuranceAccordion">
                                <div class="accordion-body">
                                    <p>Basic insurance coverage is included in your rental rate, which typically covers collision damage waiver (CDW) and theft protection with a deductible. Additional coverage options like Personal Accident Insurance, Super CDW (reducing or eliminating the deductible), and Third Party Liability are available for purchase.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading9">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse9" aria-expanded="false" aria-controls="collapse9">
                                    What should I do in case of an accident?
                                </button>
                            </h2>
                            <div id="collapse9" class="accordion-collapse collapse" aria-labelledby="heading9" data-bs-parent="#insuranceAccordion">
                                <div class="accordion-body">
                                    <p>In case of an accident, first ensure everyone's safety and call emergency services if needed. Then, contact our 24/7 emergency number provided in your rental agreement. You'll need to fill out an accident report and provide details of any other vehicles involved and witnesses. Do not admit liability at the scene.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="contact-info-box mt_70 text-center">
            <h3>Still Have Questions?</h3>
            <p>If you couldn't find the answer to your question, please contact our customer support team.</p>
            <a href="{{ route('contact') }}" class="btn-style-one mt_20">Contact Us</a>
        </div>
    </div>
</section>
<!-- FAQ Section End -->
@endsection