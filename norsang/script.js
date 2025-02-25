document.addEventListener("DOMContentLoaded", function () {
    const scrollElements = document.querySelectorAll("[data-scroll]");
  
    const scrollHandler = () => {
      scrollElements.forEach((el) => {
        const rect = el.getBoundingClientRect();
        if (rect.top < window.innerHeight * 0.85) {
          el.classList.add("active");
        }
      });
    };
  
    window.addEventListener("scroll", scrollHandler);
    scrollHandler(); // Trigger on page load
  });
  // Toggle Navbar on Mobile View
const mobileMenuBtn = document.getElementById("mobile-menu-btn");
const navLinks = document.getElementById("nav-links");

mobileMenuBtn.addEventListener("click", () => {
  navLinks.classList.toggle("active");
});
// Wait for the DOM to be fully loaded before attaching event listener
document.addEventListener('DOMContentLoaded', function () {
  const passwordField = document.getElementById('password');
  const eyeIcon = document.getElementById('toggle-password');

  // Add event listener to the eye icon to toggle password visibility
  eyeIcon.addEventListener('click', function () {
      // Toggle the type between password and text
      if (passwordField.type === 'password') {
          passwordField.type = 'text';
          eyeIcon.innerHTML = '&#128065;'; // Open eye (show password)
      } else {
          passwordField.type = 'password';
          eyeIcon.innerHTML = '&#128078;'; // Closed eye (hide password)
      }
  });
});
 
const phoneInput = document.querySelector("#phoneInput");

// Initialize intlTelInput
const iti = window.intlTelInput(phoneInput, {
  utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/js/utils.min.js"
});

// Set initial country based on the user's location
iti.promise.then(() => {
  const countryCode = iti.getSelectedCountryData().iso2;
  iti.setCountry(countryCode);
});

// Listen for the country change event
phoneInput.addEventListener("countrychange", function() {
  const countryCode = iti.getSelectedCountryData().iso2;
  console.log("Selected country code:", countryCode);
});