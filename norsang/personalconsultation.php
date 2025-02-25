<?php
session_start();
require_once "config.php";
 // Database connection file

if (isset($_SESSION['admin'])) {
  $username =$_SESSION['admin'];
}

?>





<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Consultation Form</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/css/intlTelInput.min.css">
  <style>
      footer {
      background-color: #333;
      padding: 20px;
      text-align: center;
      color: white;
      }

      .social-icons {
       display: flex;
       justify-content: center;
      gap: 15px;
       }

      .social-icon {
      font-size: 24px;
      transition: transform 0.3s ease;
      }

      /* Original color for each icon */
      .social-icon i.fab.fa-weixin {
         color: #1aad19;
         padding:10px; /* WeChat green */
        }

        .social-icon i.fab.fa-tiktok {
          color:rgb(255, 255, 255); /* TikTok teal */
         padding:10px;
         }

       .social-icon i.fab.fa-facebook-f {
       color: #1877f2; /* Facebook blue */ 
       padding:10px;
       }

       .social-icon i.fab.fa-instagram {
         color: #e1306c; /* Instagram pink */
        padding:10px;
         }

          .social-icon i.fab.fa-youtube {
           color: #ff0000; /* YouTube red */
           padding:10px;
           }
  
       .social-icon i.fab.fa-twitter {
        color: #1da1f2; /* Twitter blue */
        padding:10px;
        }

       .social-icon:hover {
        transform: scale(1.1); /* Slight scale-up effect on hover */
       }

       .nav-links li {
       position: relative;
      }

/* Style for the dropdown */
.dropdown {
    display: none; /* Hide dropdown by default */
    position: absolute;
    background-color: #fff;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    z-index: 1;
    list-style: none;
    padding: 10px 0;
    margin: 0;
    border-radius: 5px;
}

.dropdown li {
    padding: 8px 20px;
    text-align: left;
}

.dropdown li a {
    color: #333;
    text-decoration: none;
    display: block;
}

.dropdown li a:hover {
    background-color: #f1f1f1;
}

/* Show the dropdown when hovering over the Add link */
.nav-links li:hover .dropdown {
    display: block;
}

 

    



/* 
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
      padding: 0;
    } */
     .personal_consult_form{
        margin:20px;
        padding:20px;
     }
    form {
      max-width:730px;
      margin: 0px auto;
      padding: 20px ;
      border: 1px solid #ccc;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
    }
    input, select, textarea, .button {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 1rem;
    }
    .button {
      background-color: #4CAF50;
      color: white;
      cursor: pointer;
      border: none;
    }
    .button:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>
<header>
    <nav>
      <div class="logo">NORSANG</div>
      <!-- Hamburger Button -->
      <button class="menu-toggle" id="mobile-menu-btn">
        ☰
      </button>
      <ul class="nav-links" id="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="story.php">Story</a></li>
        <li><a href="About.php">About</a></li>
        <li>
          <a href="event.php">
            Events <img src="images/new.png" alt="new" class="image-navbar">
          </a>
        </li>
        <li><a href="booking.php">Booking</a></li>
        <li><a href="contact.php">Contacts</a></li>
         <?php if ($username == "norsang"): ?>
          <li>
        <a href="#">Add</a>
        <ul class="dropdown">
            <li><a href="addbook.php">Add Events</a></li>
            <li><a href="addconsultation.php">Add Consultations</a></li>
            
        </ul>
    </li>
          <li>
        <a href="#">Profile</a>
        <ul class="dropdown">
            <li><a href="dashboard.php">Booked Events</a></li>
            <li><a href="bookedconsult.php">Booked Consultation</a></li>
            
        </ul>
    </li>
          <li> <a href="logout.php">logout</a></li>
<?php endif ?>
      </ul>
    
    </nav>
  </header>
  <br>
  <br> 
  <section class="personal_consult_form">
  <center><h1>Consultation Form</h1></center><br>
  <form action="https://formspree.io/f/mqaawzqy" method="POST">
    <label for="name">Name</label>
    <input type="text" id="name" name="name" required>

    <label for="email">Email</label>
    <input type="email" id="email" name="email" required>

    <label for="company">Company Name</label>
    <input type="text" id="company" name="company">

    <label for="country">Country</label>
    <input type="text" id="country" name="country">

    <label for="location">Location</label>
    <input type="text" id="location" name="location">

    <label for="employees">Number of Employees</label>
    <input type="number" id="employees" name="employees">

    <label for="mobile">Mobile Number</label>
   
    <input type="tel" id="phoneInput" name="mobile" placeholder="Enter phone number">
    <input type="hidden" id="countryCode" name="mobile">
    <label for="consultation">Type of Consultation</label>
    <select id="consultation" name="consultation" required>
      <option value="fengshui">Feng Shui</option>
      <option value="facial_gua_sha">Facial Gua Sha</option>
      <option value="meditation">Meditation</option>
      <option value="acupuncture">Acupuncture</option>
    </select>

    <label for="message">Message</label>
    <textarea id="message" name="message" rows="5"></textarea>

    <button type="submit" class="button">Submit</button>
  </form>
  
  <script src="script.js"></script>
  </section>
  
      
     <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/js/intlTelInput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/js/utils.min.js"></script>
    <script>
      const phoneInput = document.querySelector("#phoneInput");
     const countryCodeInput = document.querySelector("#countryCode");

  // Initialize intlTelInput
     const iti = window.intlTelInput(phoneInput, {
      utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/js/utils.min.js"
     });

  // Update the hidden input with the selected country code
  phoneInput.addEventListener("countrychange", function() {
    const countryCode = iti.getSelectedCountryData().dialCode;
    countryCodeInput.value = countryCode;
  });

  // Set initial value for the hidden input
  iti.promise.then(() => {
    const initialCountryCode = iti.getSelectedCountryData().dialCode;
    countryCodeInput.value = initialCountryCode;
  });
  </script>
 <script src="script.js"> </script>
 <footer class="footer">
    <div class="footer-content">
      <nav class="footer-links">
        <a href="index.php">Home</a>
        <a href="story.php">Story</a>
       <a href="About.php">About</a>
        <a href="booking.php">Booking</a>
        <a href="contact.php">Contacts</a>
      </nav><div class="contact-footer">
        <!-- <h2>Queriess</h2> -->
          <a href="https://weixin.qq.com" target="_blank" class="social-icon"><i class="fab fa-weixin"></i></a>
        <a href="https://www.tiktok.com" target="_blank" class="social-icon"><i class="fab fa-tiktok"></i></a>
        <a href="https://www.facebook.com" target="_blank" class="social-icon"><i class="fab fa-facebook-f"></i></a>
        <a href="https://www.instagram.com" target="_blank" class="social-icon"><i class="fab fa-instagram"></i></a>
        <a href="https://www.youtube.com" target="_blank" class="social-icon"><i class="fab fa-youtube"></i></a>
        <a href="https://twitter.com" target="_blank" class="social-icon">
          <img src="images/x.png" 
          alt="Twitter (X)" 
          style="width: 28px; height: 28px;">
        </a>

      </div>      
      <!-- <h2>Email : ask@norbusangpo.com</h2> -->
      <h2>Contact : +6590681135</h2>
      <h2>Address: 2A, Jalan Taiping, Taman Lim, 30100 Ipoh, Perak, Malaysia</h2>
      <div class="footer-logo">
     
        <!-- <h2> N O R S A N G </h2> -->
        <span class="footer-icon"></span>
      </div>
      <div class="footer-copyright">
        <p>Norsang &copy; 2024. All Rights Reserved.</p>
      </div>
    </div>
  </footer>


</body>
</html>
