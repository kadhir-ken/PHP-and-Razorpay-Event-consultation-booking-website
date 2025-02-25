
<?php
session_start();
require_once "config.php";
 // Database connection file

if (isset($_SESSION['admin'])) {
  $username =$_SESSION['admin'];
}?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NORSANG-STORY</title>
  <link rel="stylesheet" href="story.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  
  <link rel="stylesheet" href="styles.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Afacad+Flux:wght@100..1000&family=Bebas+Neue&family=Edu+AU+VIC+WA+NT+Arrows:wght@400..700&family=Patrick+Hand&family=Playwrite+GB+S:ital,wght@0,100..400;1,100..400&display=swap" rel="stylesheet">
</head>
<body>
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
 
   </style>
   
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
  
    <div class="master-norsang-wrapper">
        <!-- Title Section -->
        <div class="title-section" data-scroll="fade-in">
          <br><h1 class="main-title">
            Introducing Master Norsang
          </h1>
          <h2 class="subtitle">
            A Renowned Feng Shui Expert and Meditation Mentor
          </h2>
        </div>
      
        <!-- Content Sections -->
        <div class="content-section left" data-scroll="slide-left">
          <p>
            <strong>Master Norsang</strong> is a highly esteemed Feng Shui expert with nearly 20 years of hands-on experience in the art of harmonizing spaces and guiding personal growth. Under the mentorship of the legendary <strong>Grandmaster Rao</strong>, Master Ong honed his skills to become one of the most trusted names in the field.
          </p>
        </div>
      
        <div class="content-section right" data-scroll="slide-right">
          <p>
            Throughout his illustrious career, Master Norsang has been sought after by clients from around the world, including in China and Thailand, to design Feng Shui solutions for homes and businesses. His meticulous attention to detail and profound understanding of energy dynamics have consistently brought prosperity and harmony to the spaces he works with.
          </p>
        </div>
      
        <div class="content-section left" data-scroll="slide-left">
          <p>
            In addition to his expertise in Feng Shui, Master Norsang is a respected meditation mentor. With a deep spiritual foundation, he has helped countless individuals achieve inner balance and clarity, enabling them to lead more fulfilling lives.
          </p>
        </div>
      
        <div class="content-section right" data-scroll="slide-right">
          <p>
            With two decades of experience and a reputation for excellence, Master Norsang continues to inspire confidence and trust in those who seek his wisdom. Whether optimizing environments or nurturing spiritual journeys, he is a true master dedicated to bringing harmony and success to every aspect of life.
          </p>
        </div>
      </div>
      
    

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
<script src="script.js"></script>
</body>
</html>
