
<?php
session_start();
require_once "config.php";
 // Database connection file

if (isset($_SESSION['admin'])) {
  $username =$_SESSION['admin'];
}?>
<!DOCTYPE html>
<html lang="en">
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
  
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NORSANG-STORY</title>
  <link rel="stylesheet" href="About.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <link rel="stylesheet" href="styles.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Afacad+Flux:wght@100..1000&family=Bebas+Neue&family=Edu+AU+VIC+WA+NT+Arrows:wght@400..700&family=Patrick+Hand&family=Playwrite+GB+S:ital,wght@0,100..400;1,100..400&display=swap" rel="stylesheet">
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

      
      <!-- Hero Section -->
      <section class="hero">
        <div class="image-overlay"></div>
        <!-- <img src="images/bg.png" alt="Hero Image" class="hero-image"> -->
        <video autoplay loop muted>
            <source src="images/ourstory.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
     
        <div class="controls">
          <span class="arrow left">&larr;</span>
          <span class="arrow right">&rarr;</span>
        </div>
      </section>
  <main class="story-content">
    <section class="story-section">
      <h2>A Deep Spiritual Calling</h2>
      <p>
        Tibetan Buddhism offered Karma Norsang more than just a spiritual practice—it provided a sanctuary for profound self-discovery. Its meditative practices and philosophical depth became the foundation of his quest for inner peace, clarity, and spiritual growth. This ancient wisdom resonated deeply with his innate desire for a meaningful and transformative spiritual path.
      </p>
    </section>

    <section class="story-section">
      <h2>Guided by Inspiring Mentors</h2>
      <p>
        The guidance of influential mentors and teachers during Karma Norsang’s formative years was pivotal. Their wisdom and unwavering dedication to Tibetan Buddhist principles inspired him to embrace this path wholeheartedly. Through their teachings, he cultivated a strong connection to the values of compassion, mindfulness, and wisdom.
      </p>
    </section>

    <section class="story-section">
      <h2>A Heritage of Compassion and Wisdom</h2>
      <p>
        The cultural and spiritual heritage of Tibetan Buddhism is a tapestry of interconnectedness and altruism. Its emphasis on compassion and the well-being of all beings aligned seamlessly with Karma Norsang’s aspirations, fueling his journey toward a life dedicated to service and growth.
      </p>
    </section>

    <section class="story-section">
      <h2>A Holistic Vision of Healing</h2>
      <p>
        Karma Norsang was also deeply inspired by the holistic healing practices of Tibetan Buddhism. By integrating the physical, mental, and spiritual realms, these practices nurtured his passion for traditional healing methods, leading to a holistic approach to life and well-being.
      </p>
    </section>

    <section class="story-section">
      <h2>A Commitment to Community and Service</h2>
      <p>
        The communal spirit of Tibetan monastic life further enriched his journey. With a focus on serving others and fostering well-being within the community, Karma Norsang found a purpose beyond personal growth—a commitment to positively impact the lives of those around him.
      </p>
    </section>

    <section class="story-section">
      <h2>The Unique Essence of Tibetan Monkhood</h2>
      <ul>
        <li><strong>Meditative Depth:</strong> Tibetan Buddhism's focus on mindfulness and meditation offered tools to cultivate inner peace and compassion.</li>
        <li><strong>Profound Philosophy:</strong> The study of texts like the Lamrim and the teachings of great masters enriched his understanding of life’s deeper truths.</li>
        <li><strong>Transformative Rituals:</strong> Elaborate ceremonies and rituals created a sacred atmosphere that deeply resonated with him.</li>
        <li><strong>Healing Arts:</strong> Tibetan Buddhism’s integration of traditional medicine and healing practices aligned with his holistic vision of well-being.</li>
        <li><strong>Compassion as a Pillar:</strong> The teachings of compassion and altruism became central to his path.</li>
      </ul>
    </section>
  </main>
      
    

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
