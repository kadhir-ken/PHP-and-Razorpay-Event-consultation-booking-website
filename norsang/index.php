<?php
session_start();
require_once "config.php";
 // Database connection file

if (isset($_SESSION['admin'])) {
  $username =$_SESSION['admin'];
}
$sql = "SELECT * FROM events WHERE event_date >= CURDATE() ORDER BY event_date ASC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $event = $result->fetch_assoc();
    $eventName = $event['title'];
    $eventDate = $event['event_date'];
    $eventImage = $event['image_path']; // Assuming there's an 'image' column storing the image path
    $eventLink = 'event.php'; // Replace with dynamic link if available

    echo "
    <div id='eventPopup' class='popup'>
        <div class='popup-content'>
            <span class='close' onclick='closePopup()'>&times;</span>
            <img src='$eventImage' alt='$eventName' class='event-image'>
            <h2 class='event-title'>Upcoming Event</h2>
            <p class='event-details'><span class='event-name'>$eventName</span><br> is happening on <br><span class='event-date'>$eventDate</span>.</p>
            <a href='$eventLink' class='book-now' target='_blank'>Book Now</a>
        </div>
    </div>
    <script>
        function closePopup() {
            document.getElementById('eventPopup').style.display = 'none';
        }
    </script>
    <style>
        /* Popup container */
        .popup {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        /* Popup content */
        .popup-content {
            // background: #fff;
             background-image: url('images/pop-index.jpg'); /* Replace with your image path */
        background-size: cover; /* Ensures the image covers the entire background */
        background-position: center; /* Centers the image */
        background-repeat: no-repeat; /* Prevents tiling */
            padding: 40px;
            border-radius: 12px;
            text-align: center;
            position: relative;
            width:600px;
            max-width: 90%;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.4);
            animation: fadeIn 0.5s ease-in-out;
        }

        /* Image */
        .popup-content .event-image {
            width: 100%;
            height: auto;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        /* Event title */
        .popup-content .event-title {
            font-size: 28px;
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
            font-family: 'Arial', sans-serif;
        }

        /* Event details */
        .popup-content .event-details {
            font-size: 18px;
            color: #555;
            font-family: 'Verdana', sans-serif;
            line-height: 1.6;
        }

        /* Event name */
        .popup-content .event-name {
            font-weight: 600;
            color: #007bff;
        }

        /* Event date */
        .popup-content .event-date {
            font-weight: 600;
            color: #28a745;
        }

        /* Close button */
        .popup-content .close {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 26px;
            font-weight: bold;
            color: #999;
            cursor: pointer;
            transition: color 0.3s;
        }

        .popup-content .close:hover {
            color: #ff0000;
        }

        /* Book Now button */
        .popup-content .book-now {
            display: inline-block;
            margin-top: 25px;
            padding: 15px 30px;
            background: linear-gradient(45deg, #6a11cb, #2575fc);
            color: #fff;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
            border-radius: 25px;
            transition: background 0.3s ease, transform 0.2s ease;
            font-family: 'Tahoma', sans-serif;
        }

        .popup-content .book-now:hover {
            background: linear-gradient(45deg, #2575fc, #6a11cb);
            transform: scale(1.05);
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>
    ";
} else {
    echo "<!-- No upcoming events to display -->";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NORSANG-HOME</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<body>
  <!-- Navigation Bar -->
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
  <?php if (!empty($upcomingEvents)): ?>
<div id="event-notification" style="position: fixed; top: 10%; left: 50%; transform: translate(-50%, -10%); z-index: 1000; background: #fff; border: 2px solid #2980b9; border-radius: 10px; padding: 20px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); display: none;">
    <h2 style="margin: 0 0 10px 0; color: #2980b9;">Upcoming Event Alert!</h2>
    <?php foreach ($upcomingEvents as $event): ?>
        <p><strong>Event:</strong> <?= htmlspecialchars($event['title']); ?></p>
        <p><strong>Date:</strong> <?= htmlspecialchars($event['event_date']); ?></p>
        <p><strong>Location:</strong> <?= htmlspecialchars($event['location']); ?></p>
        <a href="event.php" style="color: #fff; background: #2980b9; padding: 10px 15px; text-decoration: none; border-radius: 5px;">View Details</a>
    <?php endforeach; ?>
    <button onclick="closeNotification()" style="margin-top: 10px; background: #e74c3c; color: #fff; border: none; padding: 10px 15px; cursor: pointer; border-radius: 5px;">Close</button>
</div>
<?php endif; ?>

  <div class="whatsapp-icon">
  <a href="https://wa.me/+6590681135?text=Hi%2C%20I%20would%20like%20to%20know%20more!" target="_blank">
    <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp Icon">
  </a>
  <!-- <a href="https://wa.me/1234567890?text=Hi%2C%20I%20would%20like%20to%20know%20more!" target="_blank">
    <img src="https://upload.wikimedia.org/wikipedia/commons/1/1b/Facebook_icon.svg"  width="20px" alt="WhatsApp Icon">
  </a>
  <a href="https://wa.me/1234567890?text=Hi%2C%20I%20would%20like%20to%20know%20more!" target="_blank">
    <img src="https://upload.wikimedia.org/wikipedia/commons/a/a5/Instagram_icon.png" alt="WhatsApp Icon">
  </a>
  <a href="https://wa.me/1234567890?text=Hi%2C%20I%20would%20like%20to%20know%20more!" target="_blank">
  
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#FFFFFF" width="40" height="40">
      <rect width="24" height="24" fill="#000000" />
      <path d="M6.5 4.5L12 12L6.5 19.5H8.5L12 14.5L15.5 19.5H17.5L12 12L17.5 4.5H15.5L12 9.5L8.5 4.5H6.5Z" fill="white" />
    </svg>
  </a> -->
</div>

  <!-- Hero Section -->
  <section class="hero">
    <div class="image-overlay"></div>
    <img src="images/bg.png" alt="Hero Image" class="hero-image">
    <div class="quote-section">
      <h1>"The mind is everything.  <br>What you think you become."</h1>
      <p class="author">– Buddha</p>
    </div>
    <div class="controls">
      <span class="arrow left">&larr;</span>
      <span class="arrow right">&rarr;</span>
    </div>
  </section>



  <!-- Section 1 -->
  <section class="section">
    <div class="image">
      <video autoplay loop muted playsinline height="100px">
        <source src="images/mind.mp4" type="video/mp4">
        Your browser does not support the video tag.
      </video>
    </div>
    <div class="content">
      <h2>Mind and Energy Recreation</h2>
      <p>
        Mind and energy recreation involves activities and practices that rejuvenate the mental and physical energy, promoting relaxation, clarity, and vitality. This can include mindfulness exercises, meditation, yoga, hobbies, physical activities, or even creative pursuits that help reduce stress, enhance focus, and restore a sense of well-being.</p>
    </div>
  </section>

  <!-- Section 2 -->
  <section class="section">
    <div class="image">
      <video autoplay loop muted playsinline>
        <source src="images/fenshui.mp4" type="video/mp4">
        Your browser does not support the video tag.
      </video>
    </div>
    <div class="content">
      <h2>Feng Shui</h2>
      <p>Feng Shui as a Treatment Feng Shui is often referred to as a holistic approach to improving various aspects of life, such as health, relationships, career, and overall happiness. By aligning your surroundings with Feng Shui principles.</p>
    </div>
  </section>

  <!-- Section 3 -->
  <section class="section">
    <div class="image">
      <video autoplay loop muted playsinline>
        <source src="images/gua1.mp4" type="video/mp4">
        Your browser does not support the video tag.
      </video>
    </div>
    <div class="content">
      <h2>Facial Gua Sha</h2>
      <p>Facial Gua Sha is a traditional Chinese skincare technique that involves gently scraping the skin of the face with a smooth-edged tool, typically made of jade, rose quartz, or other semi-precious stones. Derived from the ancient practice of Gua Sha, which is used on the body for therapeutic purposes, the facial version is much gentler and focuses on improving skin health and appearance.
      </p>
    </div>
  </section>

  <!-- Section 4 -->
  <section class="section">
    <div class="image">
      <video autoplay loop muted playsinline>
        <source src="images/accu.mp4" type="video/mp4">
        Your browser does not support the video tag.
      </video>
    </div>
    <div class="content">
      <h2>Acupuncture</h2>
      <p>Acupuncture is an ancient Chinese healing practice that involves inserting thin needles into specific points on the body to restore energy flow (Qi). It is widely used to relieve pain, reduce stress, and improve overall wellness. By stimulating nerves, muscles, and tissues, acupuncture promotes natural healing. This holistic approach is safe, minimally invasive, and trusted for its therapeutic benefits.</p>
    </div>
  </section>

  <!-- Section 5 -->
  <section class="section">
    <div class="image">
      <video autoplay loop muted playsinline>
        <source src="images/meditation1.mp4" type="video/mp4">
        Your browser does not support the video tag.
      </video>
    </div>
    <div class="content">
      <h2>Meditation Training</h2>
      <p>Meditation training helps individuals develop mindfulness, focus, and inner calm through guided techniques. It involves practices like breathwork, visualization, and body awareness to reduce stress and enhance mental clarity. Regular meditation promotes emotional balance, resilience, and overall well-being. It’s a powerful tool for personal growth and achieving a peaceful state of mind.</p>
    </div>
  </section>
 
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
  <script>
    window.onload = function() {
        const notification = document.getElementById('event-notification');
        if (notification) {
            notification.style.display = 'block';
        }
    };

    function closeNotification() {
        const notification = document.getElementById('event-notification');
        if (notification) {
            notification.style.display = 'none';
        }
    }
</script>

</body>
</html>
