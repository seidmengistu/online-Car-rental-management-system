<meta charset="utf-8">
<title>{{ $title ?? 'Online Car Rental Management System' }}</title>

<!-- Stylesheets -->
<link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/fontawesome-all.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/iconfont.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/owl.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/global.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/jquery.fancybox.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/elements-css/header.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/elements-css/footer.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/elements-css/booking-form.css') }}" rel="stylesheet">
<link href="{{ asset('assets/language-switcher/polyglot-language-switcher.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/daterangepicker.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/jquery-ui.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">

<!-- Fav Icon -->
<link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
<link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">

<!-- Additional CSS -->
{{ $slot ?? '' }} 