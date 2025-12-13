<!-- Scripts -->
<script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery-ui.js') }}"></script>
<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/daterangepicker.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.fancybox.js') }}"></script>
<script src="{{ asset('assets/js/appear.js') }}"></script>
<script src="{{ asset('assets/js/wow.js') }}"></script>
<script src="{{ asset('assets/js/owl.js') }}"></script>
<script src="{{ asset('assets/js/validation.js') }}"></script>
<script src="{{ asset('assets/language-switcher/jquery.polyglot.language.switcher.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
<script src="{{ asset('assets/js/booking-form.js') }}"></script>

<!-- AdminLTE JS -->
<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

<!-- Smooth Scrolling Script -->
<script>
$(document).ready(function() {
  // Add smooth scrolling to all hash links
  $('a[href^="#"]').on('click', function(event) {
    // Make sure this.hash has a value before overriding default behavior
    if (this.hash !== "") {
      // Prevent default anchor click behavior
      event.preventDefault();

      // Store hash
      var hash = this.hash;

      // Using jQuery's animate() method to add smooth page scroll
      $('html, body').animate({
        scrollTop: $(hash).offset().top - 100 // Offset by 100px to account for fixed header
      }, 800, function(){
        // Add hash (#) to URL when done scrolling (default click behavior)
        window.location.hash = hash;
      });
    }
  });
});
</script>

<!-- Google Translate Widget -->
<script>
function googleTranslateElementInit() {
  if (document.getElementById('google_translate_landing')) {
    new google.translate.TranslateElement({
      pageLanguage: 'en',
      includedLanguages: 'en,am,om,so',
      layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
      autoDisplay: false
    }, 'google_translate_landing');
  }
}

// Hide Google Translate top banner
function hideGoogleTranslateBanner() {
  var banner = document.querySelector('.goog-te-banner-frame');
  if (banner) {
    banner.style.display = 'none';
  }
  document.body.style.top = '0px';
  document.body.style.position = 'relative';
}

// Run periodically to ensure banner stays hidden
setInterval(hideGoogleTranslateBanner, 250);
document.addEventListener('DOMContentLoaded', hideGoogleTranslateBanner);

// Custom Language Switcher
document.addEventListener('DOMContentLoaded', function() {
  var langSwitcher = document.querySelector('.custom-language-switcher');
  var langToggle = document.getElementById('langToggle');
  var langDropdown = document.getElementById('langDropdown');
  var langOptions = document.querySelectorAll('.lang-option');
  var currentLangSpan = document.querySelector('.current-lang');
  
  // Language display names
  var langNames = {
    'en': 'English',
    'am': 'አማርኛ',
    'om': 'Oromoo',
    'so': 'Soomaali'
  };
  
  // Toggle dropdown
  if (langToggle) {
    langToggle.addEventListener('click', function(e) {
      e.stopPropagation();
      langSwitcher.classList.toggle('open');
    });
  }
  
  // Close dropdown when clicking outside
  document.addEventListener('click', function(e) {
    if (langSwitcher && !langSwitcher.contains(e.target)) {
      langSwitcher.classList.remove('open');
    }
  });
  
  // Handle language selection
  langOptions.forEach(function(option) {
    option.addEventListener('click', function() {
      var lang = this.getAttribute('data-lang');
      
      // Update active state
      langOptions.forEach(function(opt) {
        opt.classList.remove('active');
      });
      this.classList.add('active');
      
      // Update current language display
      if (currentLangSpan) {
        currentLangSpan.textContent = langNames[lang] || lang;
      }
      
      // Close dropdown
      langSwitcher.classList.remove('open');
      
      // Trigger Google Translate
      changeGoogleTranslateLanguage(lang);
    });
  });
  
  // Set initial active state based on current language
  function detectCurrentLanguage() {
    var currentLang = 'en';
    var googleCookie = document.cookie.match(/googtrans=\/[a-z]{2}\/([a-z]{2})/);
    if (googleCookie && googleCookie[1]) {
      currentLang = googleCookie[1];
    }
    
    langOptions.forEach(function(opt) {
      if (opt.getAttribute('data-lang') === currentLang) {
        opt.classList.add('active');
        if (currentLangSpan) {
          currentLangSpan.textContent = langNames[currentLang] || currentLang;
        }
      }
    });
  }
  
  detectCurrentLanguage();
});

// Function to change Google Translate language
function changeGoogleTranslateLanguage(lang) {
  // Method 1: Using the Google Translate select element
  var select = document.querySelector('.goog-te-combo');
  if (select) {
    select.value = lang;
    select.dispatchEvent(new Event('change'));
    return;
  }
  
  // Method 2: Using cookies and reload (fallback)
  var domain = window.location.hostname;
  document.cookie = 'googtrans=/en/' + lang + ';path=/;domain=' + domain;
  document.cookie = 'googtrans=/en/' + lang + ';path=/';
  
  // Reload to apply translation
  if (lang === 'en') {
    // Reset to English
    document.cookie = 'googtrans=;path=/;domain=' + domain + ';expires=Thu, 01 Jan 1970 00:00:00 GMT';
    document.cookie = 'googtrans=;path=/;expires=Thu, 01 Jan 1970 00:00:00 GMT';
  }
  
  window.location.reload();
}
</script>
<script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

{{ $slot ?? '' }} 