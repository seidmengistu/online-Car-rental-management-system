@extends('layouts.main')

@section('content')
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
<section id="car-collection" class="car-type-section pt_120 pb_90 home-three">
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
<section id="available-cars" class="featured-cars-section">
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
@endsection

@section('scripts')
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
@endsection
