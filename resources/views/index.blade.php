@extends('layouts.main')

@section('head')
  <link href="{{ asset('assets/css/landing.css') }}" rel="stylesheet">
@endsection

@section('content')
  <!-- Hero Section -->
  <section class="hero-landing">
    <!-- Magical glow orbs -->
    <div class="hero-glow-1"></div>
    <div class="hero-glow-2"></div>
    <div class="hero-glow-3"></div>

    <div class="owl-carousel hero-slider owl-nav-none owl_dots_none theme_carousel owl-theme"
      data-options='{"loop": true, "margin": 0, "autoheight":true, "lazyload":true, "nav": false, "dots": false, "autoplay": true, "autoplayTimeout": 7000, "smartSpeed": 1800, "responsive":{ "0" :{ "items": "1" }, "768" :{ "items" : "1" } , "1000":{ "items" : "1" }}}'>
      <div class="hero-slide" style="background-image:url({{ asset('assets/images/sliders/slider-3.jpg') }})"></div>
      <div class="hero-slide" style="background-image:url({{ asset('assets/images/sliders/slider-3.jpg') }})"></div>
      <div class="hero-slide" style="background-image:url({{ asset('assets/images/sliders/slider-3.jpg') }})"></div>
    </div>

    <div class="container">
      <div class="hero-content">
        <h1 class="hero-title">
          Drive Your <span>Dream Car</span><br>Today
        </h1>
        <p class="hero-description">
          Experience luxury without the luxury price tag. Choose from our curated collection of premium vehicles for your
          next adventure.
        </p>
        <div class="hero-actions">
          <a href="#available-cars" class="btn-hero-primary">
            <i class="fas fa-car"></i>
            Explore Cars
          </a>
          <a href="#car-collection" class="btn-hero-secondary">
            <i class="fas fa-th-large"></i>
            Browse Collection
          </a>
        </div>
      </div>

      <div class="hero-stats d-none d-lg-flex">
        <div class="stat-item">
          <div class="stat-number">{{ $cars->count() }}+</div>
          <div class="stat-label">Available Cars</div>
        </div>
        <div class="stat-item">
          <div class="stat-number">{{ $carMakes->count() }}</div>
          <div class="stat-label">Car Brands</div>
        </div>
        <div class="stat-item">
          <div class="stat-number">24/7</div>
          <div class="stat-label">Support</div>
        </div>
      </div>
    </div>

    <div class="scroll-indicator">
      <a href="#car-collection">
        <span>Scroll Down</span>
        <i class="fas fa-chevron-down"></i>
      </a>
    </div>
  </section>
  <!-- Hero Section End -->

  <!-- Car Collection Section -->
  <section id="car-collection" class="collection-section">
    <div class="container">
      <div class="section-header">
        <div class="section-label">
          <i class="fas fa-layer-group"></i>
          Our Collection
        </div>
        <h2 class="section-title">Explore By Brand</h2>
        <p class="section-subtitle">Find your perfect ride from our diverse range of premium car manufacturers</p>
      </div>

      <div class="collection-grid">
        @foreach($carMakes as $carMake)
          <div class="collection-card wow fadeInUp" data-wow-delay="{{ $loop->index * 0.1 }}s">
            <div class="collection-card-image">
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
              <div class="collection-count">{{ $carMake->total_count }}</div>
            </div>
            <h6><a href="{{ route('cars.index', ['make' => $carMake->make]) }}">{{ $carMake->make }}</a></h6>
            <p>{{ $carMake->total_count }} {{ Str::plural('car', $carMake->total_count) }}</p>
          </div>
        @endforeach
      </div>
    </div>
  </section>
  <!-- Car Collection Section End -->

  <!-- Brands Section -->
  <section class="brands-section">
    <div class="brands-track">
      <div class="brand-item"><img src="{{ asset('assets/images/brands/brand-1.png') }}" alt="Brand"></div>
      <div class="brand-item"><img src="{{ asset('assets/images/brands/brand-2.png') }}" alt="Brand"></div>
      <div class="brand-item"><img src="{{ asset('assets/images/brands/brand-3.png') }}" alt="Brand"></div>
      <div class="brand-item"><img src="{{ asset('assets/images/brands/brand-4.png') }}" alt="Brand"></div>
      <div class="brand-item"><img src="{{ asset('assets/images/brands/brand-5.png') }}" alt="Brand"></div>
      <div class="brand-item"><img src="{{ asset('assets/images/brands/brand-6.png') }}" alt="Brand"></div>
      <!-- Duplicate for seamless loop -->
      <div class="brand-item"><img src="{{ asset('assets/images/brands/brand-1.png') }}" alt="Brand"></div>
      <div class="brand-item"><img src="{{ asset('assets/images/brands/brand-2.png') }}" alt="Brand"></div>
      <div class="brand-item"><img src="{{ asset('assets/images/brands/brand-3.png') }}" alt="Brand"></div>
      <div class="brand-item"><img src="{{ asset('assets/images/brands/brand-4.png') }}" alt="Brand"></div>
      <div class="brand-item"><img src="{{ asset('assets/images/brands/brand-5.png') }}" alt="Brand"></div>
      <div class="brand-item"><img src="{{ asset('assets/images/brands/brand-6.png') }}" alt="Brand"></div>
    </div>
  </section>
  <!-- Brands Section End -->

  <!-- Available Cars Section -->
  <section id="available-cars" class="cars-section">
    <div class="container">
      <div class="section-header">
        <div class="section-label">
          <i class="fas fa-fire"></i>
          Featured Vehicles
        </div>
        <h2 class="section-title">Available Cars</h2>
        <p class="section-subtitle">Choose from our selection of quality vehicles ready for your next journey</p>
      </div>

      @if($cars->count() > 0)
        <div class="cars-grid">
          @foreach($cars as $car)
            <div class="car-card wow fadeInUp" data-wow-delay="{{ ($loop->index % 3) * 0.1 }}s">
              <div class="car-card-image">
                @if($car->image)
                  <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->full_name }}">
                @else
                  <div class="no-image-placeholder">
                    <i class="fas fa-car"></i>
                    <span>No image</span>
                  </div>
                @endif
                <div class="car-price-badge">
                  <span>Br {{ number_format($car->daily_rate, 2) }}</span>
                  <small>/day</small>
                </div>
              </div>
              <div class="car-card-body">
                <h4 class="car-card-title">{{ $car->full_name }}</h4>
                <div class="car-specs">
                  <span class="car-spec"><i class="fas fa-palette"></i> {{ $car->color }}</span>
                  <span class="car-spec"><i class="fas fa-users"></i> {{ $car->seats }} seats</span>
                  <span class="car-spec"><i class="fas fa-gas-pump"></i> {{ ucfirst($car->fuel_type) }}</span>
                  <span class="car-spec"><i class="fas fa-cog"></i> {{ ucfirst($car->transmission) }}</span>
                </div>
                <p class="car-description">{{ Str::limit($car->description, 100) }}</p>
                <div class="car-card-actions">
                  <button type="button" class="btn-view"
                    onclick="showCarDetails({{ $car->id }}, '{{ $car->full_name }}', '{{ $car->color }}', {{ $car->seats }}, '{{ ucfirst($car->fuel_type) }}', '{{ ucfirst($car->transmission) }}', '{{ $car->description }}', {{ $car->daily_rate }}, '{{ $car->image ? asset('storage/' . $car->image) : '' }}')">
                    <i class="fas fa-eye"></i> Details
                  </button>
                  @auth
                    <a href="{{ route('reservations.create', ['car_id' => $car->id]) }}" class="btn-reserve">
                      <i class="fas fa-calendar-plus"></i> Reserve
                    </a>
                  @else
                    <a href="{{ route('login') }}" class="btn-login">
                      <i class="fas fa-sign-in-alt"></i> Login
                    </a>
                  @endauth
                </div>
              </div>
            </div>
          @endforeach
        </div>

        <div class="text-center mt-5">
          <a href="{{ route('cars.index') }}" class="view-all-btn">
            <i class="fas fa-th-list"></i>
            <span>View All Cars</span>
          </a>
        </div>
      @else
        <div class="empty-state">
          <i class="fas fa-car-side"></i>
          <h4>No Cars Available</h4>
          <p>Our fleet is currently being updated. Please check back soon!</p>
        </div>
      @endif
    </div>
  </section>
  <!-- Available Cars Section End -->

  <!-- Car Details Modal -->
  <div class="modal fade" id="carDetailsModal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><i class="fas fa-car me-2"></i>Car Details</h4>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="car-image-container text-center mb-3">
                <img id="modalCarImage" src="" alt="Car Image" class="img-fluid rounded"
                  style="max-height: 300px; width: auto;">
                <div id="modalNoImage" class="no-image-placeholder d-none" style="padding: 60px 0;">
                  <i class="fas fa-car fa-5x text-muted"></i>
                  <p class="text-muted mt-2">No image available</p>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <h5 id="modalCarName" class="mb-3"
                style="font-family: 'Outfit', sans-serif; font-weight: 700; color: var(--text-primary);"></h5>
              <div class="car-specs">
                <div class="row mb-2">
                  <div class="col-6"><strong><i class="fas fa-palette me-2"
                        style="color: var(--accent-gold);"></i>Color:</strong></div>
                  <div class="col-6" id="modalCarColor"></div>
                </div>
                <div class="row mb-2">
                  <div class="col-6"><strong><i class="fas fa-users me-2"
                        style="color: var(--accent-gold);"></i>Seats:</strong></div>
                  <div class="col-6" id="modalCarSeats"></div>
                </div>
                <div class="row mb-2">
                  <div class="col-6"><strong><i class="fas fa-gas-pump me-2" style="color: var(--accent-gold);"></i>Fuel
                      Type:</strong></div>
                  <div class="col-6" id="modalCarFuelType"></div>
                </div>
                <div class="row mb-2">
                  <div class="col-6"><strong><i class="fas fa-cog me-2"
                        style="color: var(--accent-gold);"></i>Transmission:</strong></div>
                  <div class="col-6" id="modalCarTransmission"></div>
                </div>
                <div class="row mb-3">
                  <div class="col-6"><strong><i class="fas fa-tag me-2" style="color: var(--accent-gold);"></i>Daily
                      Rate:</strong></div>
                  <div class="col-6">
                    <span class="badge badge-success" id="modalCarPrice"></span>
                  </div>
                </div>
              </div>
              <div class="car-description mt-3">
                <h6 style="font-weight: 700;"><i class="fas fa-info-circle me-2"
                    style="color: var(--accent-gold);"></i>Description:</h6>
                <p id="modalCarDescription" class="text-muted" style="line-height: 1.7;"></p>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i>Close
          </button>
          <div>
            @auth
              <a href="#" id="modalReserveBtn" class="btn-reserve" style="padding: 10px 24px;">
                <i class="fas fa-calendar-plus"></i> Reserve Now
              </a>
            @else
              <a href="{{ route('login') }}" class="btn-login" style="padding: 10px 24px;">
                <i class="fas fa-sign-in-alt"></i> Login to Reserve
              </a>
            @endauth
          </div>
        </div>
      </div>
    </div>
  </div>
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
      document.getElementById('modalCarPrice').textContent = 'Br ' + parseFloat(dailyRate).toFixed(2) + ' /day';
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