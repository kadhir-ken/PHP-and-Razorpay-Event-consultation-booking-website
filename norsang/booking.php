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
  <title>NORSANG-HOME</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


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


 
   
      /* Dropdown Container */
.dropdown-1 {
    position: relative;
    display: inline-block;
}

/* Book Now Button */
.book-now-btn {
    margin-top: 10px;
    padding: 15px 20px;
    font-size: 16px;
    color: #000000;
    border: 1px solid black;
    background-color: transparent;
    border-radius: 30px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.book-now-btn:hover {
    background-color: #000000;
    color: #fff;
}

/* Dropdown Content (Hidden by Default) */
.dropdown-content-1 {
    display: none;
    position: absolute;
    top: 100%; /* Appears below the button */
    left: 0;
    background-color: #ffffff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    border-radius: 5px;
    z-index: 1;
    width: 100%;
    text-align: center;
}

.dropdown-content-1 a {
    color: #333;
    padding: 10px 15px;
    text-decoration: none;
    display: block;
    transition: background-color 0.3s ease;
    font-size: 14px;
}

.dropdown-content-1 a:hover {
    background-color: #000;
    color: #fff;
}

/* Show Dropdown on Hover */
.dropdown-1:hover .dropdown-content-1 {
    display: block;
}

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            /* padding: 20px; */
            background-color: #f8f9fa;
        }

        .video-row {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
            margin-bottom:100px;
        }

        .video-container {
            /* border: 5px solid #33333342; */
            border-radius: 10px;
            padding: 10px;
            width: 30%;
            text-align: center;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        video {
            width: 100%;
            border-radius: 8px;
        }

        .button {
            margin-top: 10px;
            padding: 15px 20px;
            font-size: 16px;
            color: #000000;
            border:1px solid black;
            background-color: transparent;
            /* border: none; */
            border-radius: 30px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #000000;
            color: #fff;
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
        h1 {
            text-align: center;
            margin:50px;
        }
      /* Mobile View */
@media (max-width: 768px) {
  h1 {
    font-size: 20px;
    margin: 20px 10px;
  }

  .video-row {
    flex-direction: column;
    align-items: center;
    gap: 10px;
  }

  .video-container {
    width: 90%; /* Use most of the screen width */
    max-width: 100%; /* Allow full width */
  }

  .book-now-btn {
    font-size: 12px;
    padding: 10px 15px;
  }

  .dropdown-content a {
    font-size: 12px;
    padding: 8px 12px;
  }
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
        <li><a href="Story.php">Story</a></li>
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
    
      <!-- Hero Section -->
      <section class="hero">
        <div class="image-overlay"></div>
        <!-- <img src="images/bg.png" alt="Hero Image" class="hero-image"> -->
        <video autoplay loop muted>
            <source src="images/booking.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
     
        <div class="controls">
          <span class="arrow left">&larr;</span>
          <span class="arrow right">&rarr;</span>
        </div>
      </section>
    
     
     
      <h1>Book Your Spot</h1>
 

    <div class="video-row">
        
        <!-- Video 1 -->
        <div class="video-container">
            <video autoplay loop muted>
                <source src="images/consultation.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <button onclick="window.location.href='consulation.php'" class="button">Book Now</button>
        </div>

        <!-- Video 2 -->
        <div class="video-container">
            <video autoplay loop muted>
                <source src="images/corporate.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <button  onclick="window.location.href='personalconsultation.php'" class="button">Book Now</button>
        </div>

        <!-- Video 3 -->
       <!-- Video 3 -->
<div class="video-container">
  <video autoplay loop muted>
      <source src="images/event1.mp4" type="video/mp4">
      Your browser does not support the video tag.
  </video>

  <!-- Dropdown Container -->
  <div class="dropdown-1">
      <button class="book-now-btn">Book Now</button>
      <div class="dropdown-content-1">
          <a href="training.php">Facial Gua Sha</a>
          <a href="training.php">Fengshui</a>
          <a href="training.php">Meditation</a>
          <a href="training.php">Acupuncture</a>
      </div>
  </div>
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
