<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Carola Car Rental | Register</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="title" content="Carola Car Rental | Register" />
  <meta name="author" content="Carola Car Rental" />
  <meta name="description" content="Register for Carola Car Rental system" />
  
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  
  <style>
    :root {
      --bg-primary: #0a0a1a;
      --bg-secondary: #1a1a3e;
      --bg-tertiary: #2d1b4e;
      --accent-gold: #d4a853;
      --accent-gold-light: #f0d78c;
      --accent-coral: #ff6b6b;
      --accent-purple: #9d4edd;
      --text-primary: rgba(255, 255, 255, 0.95);
      --text-secondary: rgba(255, 255, 255, 0.7);
      --text-muted: rgba(255, 255, 255, 0.5);
      --glass-bg: rgba(255, 255, 255, 0.03);
      --glass-border: rgba(255, 255, 255, 0.08);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Outfit', sans-serif;
      min-height: 100vh;
      background: linear-gradient(135deg, var(--bg-primary) 0%, var(--bg-secondary) 50%, var(--bg-tertiary) 100%);
      padding: 40px 20px;
      position: relative;
      overflow-x: hidden;
    }

    /* Animated Background */
    body::before {
      content: "";
      position: fixed;
      top: -50%;
      right: -20%;
      width: 800px;
      height: 800px;
      background: radial-gradient(circle, rgba(212, 168, 83, 0.12) 0%, transparent 70%);
      animation: float-glow 10s ease-in-out infinite;
      pointer-events: none;
    }

    body::after {
      content: "";
      position: fixed;
      bottom: -30%;
      left: -15%;
      width: 600px;
      height: 600px;
      background: radial-gradient(circle, rgba(157, 78, 221, 0.1) 0%, transparent 70%);
      animation: float-glow 12s ease-in-out infinite reverse;
      pointer-events: none;
    }

    @keyframes float-glow {
      0%, 100% { transform: scale(1) translate(0, 0); opacity: 0.5; }
      50% { transform: scale(1.2) translate(30px, -30px); opacity: 0.8; }
    }

    /* Particles */
    .particles {
      position: fixed;
      inset: 0;
      background-image: 
        radial-gradient(2px 2px at 20px 30px, rgba(212, 168, 83, 0.3), transparent),
        radial-gradient(2px 2px at 40px 70px, rgba(255, 255, 255, 0.2), transparent),
        radial-gradient(2px 2px at 50px 160px, rgba(157, 78, 221, 0.3), transparent),
        radial-gradient(2px 2px at 90px 40px, rgba(212, 168, 83, 0.2), transparent),
        radial-gradient(2px 2px at 130px 80px, rgba(255, 255, 255, 0.15), transparent);
      background-repeat: repeat;
      background-size: 200px 200px;
      animation: sparkle 25s linear infinite;
      pointer-events: none;
      z-index: 0;
    }

    @keyframes sparkle {
      0% { transform: translateY(0); }
      100% { transform: translateY(-200px); }
    }

    .register-container {
      position: relative;
      z-index: 10;
      width: 100%;
      max-width: 700px;
      margin: 0 auto;
      animation: fadeInUp 0.8s ease-out;
    }

    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* Logo Section */
    .logo-section {
      text-align: center;
      margin-bottom: 2rem;
    }

    .logo-section img {
      height: 70px;
      margin-bottom: 1rem;
      filter: drop-shadow(0 0 30px rgba(212, 168, 83, 0.3));
    }

    .logo-section h1 {
      font-size: 1.75rem;
      font-weight: 700;
      color: var(--text-primary);
      margin: 0;
    }

    .logo-section h1 span {
      background: linear-gradient(135deg, var(--accent-gold) 0%, var(--accent-gold-light) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    /* Card */
    .register-card {
      background: var(--glass-bg);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border: 1px solid var(--glass-border);
      border-radius: 24px;
      padding: 2.5rem;
      box-shadow: 
        0 25px 50px rgba(0, 0, 0, 0.3),
        inset 0 1px 0 rgba(255, 255, 255, 0.05);
    }

    .card-header-text {
      text-align: center;
      margin-bottom: 2rem;
    }

    .card-header-text h2 {
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--text-primary);
      margin-bottom: 0.5rem;
    }

    .card-header-text p {
      color: var(--text-secondary);
      font-size: 0.95rem;
      margin: 0;
    }

    /* Section Title */
    .section-title {
      display: flex;
      align-items: center;
      gap: 10px;
      margin: 1.5rem 0 1rem;
      padding-bottom: 0.75rem;
      border-bottom: 1px solid var(--glass-border);
    }

    .section-title i {
      color: var(--accent-gold);
      font-size: 1.1rem;
    }

    .section-title h3 {
      font-size: 1rem;
      font-weight: 600;
      color: var(--text-primary);
      margin: 0;
    }

    .section-title:first-of-type {
      margin-top: 0;
    }

    /* Alert */
    .alert-danger {
      background: rgba(255, 107, 107, 0.15);
      border: 1px solid rgba(255, 107, 107, 0.3);
      border-radius: 12px;
      color: #ff8585;
      padding: 1rem;
      margin-bottom: 1.5rem;
    }

    .alert-danger ul {
      margin: 0;
      padding-left: 1.25rem;
    }

    /* Form Inputs */
    .form-group {
      margin-bottom: 1rem;
    }

    .form-label {
      display: block;
      color: var(--text-secondary);
      font-size: 0.85rem;
      font-weight: 500;
      margin-bottom: 0.4rem;
    }

    .form-label .required {
      color: var(--accent-coral);
    }

    .input-wrapper {
      position: relative;
    }

    .input-wrapper i {
      position: absolute;
      left: 14px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--text-muted);
      font-size: 1rem;
      transition: color 0.3s ease;
    }

    .form-control {
      width: 100%;
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid var(--glass-border);
      border-radius: 10px;
      padding: 12px 14px 12px 42px;
      font-size: 0.95rem;
      color: var(--text-primary);
      transition: all 0.3s ease;
    }

    .form-control.no-icon {
      padding-left: 14px;
    }

    .form-control::placeholder {
      color: var(--text-muted);
    }

    .form-control:focus {
      outline: none;
      border-color: var(--accent-gold);
      background: rgba(212, 168, 83, 0.05);
      box-shadow: 0 0 0 3px rgba(212, 168, 83, 0.1);
    }

    .input-wrapper:focus-within i.input-icon {
      color: var(--accent-gold);
    }

    .form-control.is-invalid {
      border-color: var(--accent-coral);
    }

    /* Password Toggle */
    .password-toggle {
      position: absolute;
      right: 14px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: var(--text-muted);
      cursor: pointer;
      padding: 4px;
      font-size: 1rem;
      transition: color 0.3s ease;
      z-index: 5;
    }

    .password-toggle:hover {
      color: var(--accent-gold);
    }

    .input-wrapper.has-toggle .form-control {
      padding-right: 44px;
    }

    /* Fix all input text colors */
    .form-control,
    input[type="password"],
    input[type="text"],
    input[type="email"],
    input[type="tel"],
    input[type="date"],
    input[type="number"] {
      color: var(--text-primary) !important;
      -webkit-text-fill-color: var(--text-primary) !important;
      caret-color: var(--text-primary) !important;
    }

    /* Fix autofill styles for all browsers */
    input:-webkit-autofill,
    input:-webkit-autofill:hover,
    input:-webkit-autofill:focus,
    input:-webkit-autofill:active,
    input:-internal-autofill-selected {
      -webkit-box-shadow: 0 0 0 30px #0d0d20 inset !important;
      box-shadow: 0 0 0 30px #0d0d20 inset !important;
      -webkit-text-fill-color: rgba(255, 255, 255, 0.95) !important;
      color: rgba(255, 255, 255, 0.95) !important;
      caret-color: rgba(255, 255, 255, 0.95) !important;
      background-color: #0d0d20 !important;
      transition: background-color 5000s ease-in-out 0s;
    }

    /* Force text color on focus */
    .form-control:focus {
      color: var(--text-primary) !important;
      -webkit-text-fill-color: var(--text-primary) !important;
    }

    .invalid-feedback {
      color: #ff8585;
      font-size: 0.8rem;
      margin-top: 0.4rem;
    }

    /* Grid Layouts */
    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1rem;
    }

    .form-row-3 {
      display: grid;
      grid-template-columns: 1fr 1fr 1fr;
      gap: 1rem;
    }

    @media (max-width: 600px) {
      .form-row,
      .form-row-3 {
        grid-template-columns: 1fr;
      }
    }

    /* Terms Checkbox */
    .form-check {
      display: flex;
      align-items: flex-start;
      gap: 10px;
      margin: 1.5rem 0;
    }

    .form-check-input {
      width: 18px;
      height: 18px;
      min-width: 18px;
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid var(--glass-border);
      border-radius: 4px;
      cursor: pointer;
      margin-top: 2px;
    }

    .form-check-input:checked {
      background: var(--accent-gold);
      border-color: var(--accent-gold);
    }

    .form-check-label {
      color: var(--text-secondary);
      font-size: 0.9rem;
      cursor: pointer;
    }

    .form-check-label a {
      color: var(--accent-gold);
      text-decoration: none;
      transition: color 0.3s ease;
    }

    .form-check-label a:hover {
      color: var(--accent-gold-light);
      text-decoration: underline;
    }

    /* Submit Button */
    .btn-submit {
      width: 100%;
      background: linear-gradient(135deg, var(--accent-gold) 0%, #c49a47 100%);
      color: var(--bg-primary);
      font-size: 1rem;
      font-weight: 700;
      padding: 14px 24px;
      border: none;
      border-radius: 12px;
      cursor: pointer;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      box-shadow: 0 4px 20px rgba(212, 168, 83, 0.3);
      position: relative;
      overflow: hidden;
    }

    .btn-submit::before {
      content: "";
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
      transition: left 0.5s ease;
    }

    .btn-submit:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 30px rgba(212, 168, 83, 0.4);
    }

    .btn-submit:hover::before {
      left: 100%;
    }

    .btn-submit:active {
      transform: translateY(0);
    }

    /* Divider */
    .divider {
      display: flex;
      align-items: center;
      gap: 1rem;
      margin: 1.5rem 0;
    }

    .divider::before,
    .divider::after {
      content: "";
      flex: 1;
      height: 1px;
      background: linear-gradient(90deg, transparent, var(--glass-border), transparent);
    }

    .divider span {
      color: var(--text-muted);
      font-size: 0.85rem;
    }

    /* Links */
    .auth-links {
      text-align: center;
    }

    .auth-links a {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      color: var(--text-secondary);
      text-decoration: none;
      font-size: 0.95rem;
      transition: color 0.3s ease;
      margin: 0.5rem 0;
    }

    .auth-links a:hover {
      color: var(--accent-gold);
    }

    .auth-links .login-link {
      color: var(--accent-gold);
      font-weight: 600;
    }

    .auth-links .login-link:hover {
      color: var(--accent-gold-light);
    }

    /* Back to home */
    .back-home {
      text-align: center;
      margin-top: 2rem;
    }

    .back-home a {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      color: var(--text-muted);
      text-decoration: none;
      font-size: 0.9rem;
      padding: 10px 20px;
      border-radius: 10px;
      background: var(--glass-bg);
      border: 1px solid var(--glass-border);
      transition: all 0.3s ease;
    }

    .back-home a:hover {
      color: var(--accent-gold);
      border-color: rgba(212, 168, 83, 0.3);
      background: rgba(212, 168, 83, 0.05);
    }

    /* Info hint */
    .form-hint {
      font-size: 0.8rem;
      color: var(--text-muted);
      margin-top: 0.4rem;
    }

    .form-hint i {
      margin-right: 4px;
    }
  </style>
</head>
<body>
  <div class="particles"></div>
  
  <div class="register-container">
    <div class="logo-section">
      <h1><span>Carola</span> Car Rental</h1>
    </div>

    <div class="register-card">
      <div class="card-header-text">
        <h2>Create Account</h2>
        <p>Join us and start your journey</p>
      </div>

      @if ($errors->any())
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="POST" action="{{ route('register') }}">
        @csrf
        
        <!-- Personal Information -->
        <div class="section-title">
          <i class="bi bi-person-circle"></i>
          <h3>Personal Information</h3>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Full Name <span class="required">*</span></label>
            <div class="input-wrapper">
              <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                     placeholder="Enter your full name" value="{{ old('name') }}" required />
              <i class="bi bi-person"></i>
            </div>
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label class="form-label">Email Address <span class="required">*</span></label>
            <div class="input-wrapper">
              <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                     placeholder="Enter your email" value="{{ old('email') }}" required />
              <i class="bi bi-envelope"></i>
            </div>
            @error('email')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Phone Number <span class="required">*</span></label>
            <div class="input-wrapper">
              <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                     placeholder="Enter phone number" value="{{ old('phone') }}" required />
              <i class="bi bi-telephone"></i>
            </div>
            @error('phone')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label class="form-label">Date of Birth <span class="required">*</span></label>
            <div class="input-wrapper">
              <input type="date" name="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror" 
                     value="{{ old('date_of_birth') }}" required />
              <i class="bi bi-calendar"></i>
            </div>
            @error('date_of_birth')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <!-- Address Information -->
        <div class="section-title">
          <i class="bi bi-geo-alt"></i>
          <h3>Address Information</h3>
        </div>

        <div class="form-group">
          <label class="form-label">Street Address <span class="required">*</span></label>
          <div class="input-wrapper">
            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" 
                   placeholder="Enter your street address" value="{{ old('address') }}" required />
            <i class="bi bi-house"></i>
          </div>
          @error('address')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">City <span class="required">*</span></label>
            <div class="input-wrapper">
              <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" 
                     placeholder="Enter city" value="{{ old('city') }}" required />
              <i class="bi bi-building"></i>
            </div>
            @error('city')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label class="form-label">State/Region <span class="required">*</span></label>
            <div class="input-wrapper">
              <input type="text" name="state" class="form-control @error('state') is-invalid @enderror" 
                     placeholder="Enter state/region" value="{{ old('state') }}" required />
              <i class="bi bi-map"></i>
            </div>
            @error('state')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Zip/Postal Code <span class="required">*</span></label>
            <div class="input-wrapper">
              <input type="text" name="zip_code" class="form-control @error('zip_code') is-invalid @enderror" 
                     placeholder="Enter zip code" value="{{ old('zip_code') }}" required />
              <i class="bi bi-mailbox"></i>
            </div>
            @error('zip_code')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label class="form-label">Country <span class="required">*</span></label>
            <div class="input-wrapper">
              <input type="text" name="country" class="form-control @error('country') is-invalid @enderror" 
                     placeholder="Enter country" value="{{ old('country', 'Ethiopia') }}" required />
              <i class="bi bi-globe"></i>
            </div>
            @error('country')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <!-- Driving License Information -->
        <div class="section-title">
          <i class="bi bi-card-text"></i>
          <h3>Driving License Information</h3>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">License Number <span class="required">*</span></label>
            <div class="input-wrapper">
              <input type="text" name="driving_license_number" class="form-control @error('driving_license_number') is-invalid @enderror" 
                     placeholder="Enter license number" value="{{ old('driving_license_number') }}" required />
              <i class="bi bi-credit-card"></i>
            </div>
            @error('driving_license_number')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label class="form-label">License Expiry Date <span class="required">*</span></label>
            <div class="input-wrapper">
              <input type="date" name="driving_license_expiry" class="form-control @error('driving_license_expiry') is-invalid @enderror" 
                     value="{{ old('driving_license_expiry') }}" required />
              <i class="bi bi-calendar-check"></i>
            </div>
            <p class="form-hint"><i class="bi bi-info-circle"></i>Must be a future date</p>
            @error('driving_license_expiry')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <!-- Account Security -->
        <div class="section-title">
          <i class="bi bi-shield-lock"></i>
          <h3>Account Security</h3>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Password <span class="required">*</span></label>
            <div class="input-wrapper has-toggle">
              <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" 
                     placeholder="Create password" required />
              <i class="bi bi-lock input-icon"></i>
              <button type="button" class="password-toggle" onclick="togglePassword('password', this)">
                <i class="bi bi-eye"></i>
              </button>
            </div>
            <p class="form-hint"><i class="bi bi-info-circle"></i>Minimum 8 characters</p>
            @error('password')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label class="form-label">Confirm Password <span class="required">*</span></label>
            <div class="input-wrapper has-toggle">
              <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" 
                     placeholder="Confirm password" required />
              <i class="bi bi-lock-fill input-icon"></i>
              <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation', this)">
                <i class="bi bi-eye"></i>
              </button>
            </div>
          </div>
        </div>

        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="terms" id="terms" required />
          <label class="form-check-label" for="terms">
            I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
          </label>
        </div>

        <button type="submit" class="btn-submit">
          <i class="bi bi-person-plus me-2"></i>Create Account
        </button>
      </form>

      <div class="divider">
        <span>or</span>
      </div>

      <div class="auth-links">
        <p style="color: var(--text-secondary); margin-bottom: 0.5rem;">Already have an account?</p>
        <a href="{{ route('login') }}" class="login-link">
          <i class="bi bi-box-arrow-in-right"></i>Sign In
        </a>
      </div>
    </div>

    <div class="back-home">
      <a href="{{ route('home') }}">
        <i class="bi bi-arrow-left"></i>Back to Home
      </a>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Toggle password visibility
    function togglePassword(inputId, button) {
      var input = document.getElementById(inputId);
      var icon = button.querySelector('i');
      
      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
      } else {
        input.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
      }
    }
  </script>
</body>
</html>
