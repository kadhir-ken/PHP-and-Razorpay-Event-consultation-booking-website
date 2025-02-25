<?php
require_once "config.php"; // Database connection file
// Simulate logged-in user (replace this with your session user logic)
session_start(); 
if (isset($_SESSION['admin'])) {
  $username =$_SESSION['admin'];
}

// Fetch username from session




$user = "norsang";

// Handle delete action
if (isset($_GET['delete']) && isset($_GET['id'])) {
    $eventId = intval($_GET['id']);
    $sqlDelete = "DELETE FROM events WHERE id = ?";
    $stmt = $conn->prepare($sqlDelete);
    $stmt->bind_param("i", $eventId);
    $stmt->execute();
    header("Location: event.php"); // Redirect back to events page
    exit();
}

// Fetch all events
$sql = "SELECT * FROM events ORDER BY event_date ASC";
$result = $conn->query($sql);
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Event Page</title>
  <link rel="stylesheet" href="event.css">
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <style>
    /* General Reset */
    body {
        background-color: #f5f7fa;
        color: #333;
        line-height: 1.6;
    }

    h1.eve-head {
        text-align: center;
        font-size: 2.5rem;
        color: #2c3e50;
        margin: 20px 0;
        font-weight: bold;
    }

    /* Event Section */
    .event {
        display: flex;
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin: 30px auto;
        max-width: 1400px;
        transition: transform 0.3s ease-in-out;
    }

    .event:hover {
        transform: translateY(-10px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
    }

    /* Event Image */
    .event-image img {
        width: 500px;
        height: 100%;
        object-fit: cover;
    }

    /* Event Content */
    .event-content {
        padding: 30px;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .event-details h1 {
        font-size: 1.8rem;
        color: #34495e;
        margin-bottom: 10px;
    }

    .event-details p {
        font-size: 1rem;
        color: #666;
        margin-bottom: 15px;
    }

    .event-meta span {
        display: block;
        font-size: 0.9rem;
        color: #555;
        margin-bottom: 5px;
    }

    /* Calendar Section */
    .calendar {
        text-align: center;
        margin-top: 20px;
        /* position: relative;
        left:30%; */
    }

    .calendar h2 {
        font-size: 1.2rem;
        color: #2980b9;
        margin-bottom: 10px;
        font-weight: bold;
    }
    .event_btn{
      padding:  10px;
      background-color: #28a745;
      position:relative;
        margin:10px auto;
            color: white;
            /* border:1px solid black; */
            text-decoration:none;
            border-radius:14px;
            cursor: pointer;
            width: 100px;
          
    }
    .event_btn:hover{
    background-color: #218838;
     }

    /* Calendar Container Styling */
    .calendar-container {
        border: 2px solid #2980b9;
        border-radius: 15px;
        padding:10px;
        display: grid;
       /* width:400px; */
        
        grid-template-columns: repeat(7, 1fr);
        gap: 15px;
        background-color: #fdfdfd;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Days of the Week */
    .calendar-header {
        display: contents;
     
    }

    .calendar-header span {
        font-size: 0.9rem;
        font-weight: bold;
        color: #2c3e50;
        /* text-align: center; */
        background: #ecf0f1;
        padding: 10px 0;
        border-radius: 5px;
        position:relative;
        left:60px;
    }

    .calendar-dates div {
        padding: 10px;
        text-align: center;
        background: #ecf0f1;
        border-radius: 8px;
        font-size: 0.9rem;
        color: #555;
        transition: background-color 0.3s, transform 0.3s;
    }

    .calendar-dates div:hover {
        background-color: #3498db;
        color: #fff;
        transform: scale(1.1);
    }

    /* Highlighted Date */
    /* .calendar-dates  */
    .highlight {
        background:rgb(22, 40, 141);
        color: #fff;
        font-weight: bold;
        padding:0px 4px;
        /* margin:20px; */
        /* border: 2px solidrgb(29, 52, 135); */
        border-spacing: 30px;
        border-radius: 50%;
    }
    .delete-btn {
            background-color: #e74c3c;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 0.9rem;
        }
        .delete-btn:hover {
            background-color: #c0392b;
        }

    /* Responsive Design */
    @media (max-width: 768px) {
        .event {
            flex-direction: column;
        }

        .event-image img {
            width: 100%;
            height: 200px;
        }

        .calendar h2 {
            font-size: 1rem;
        }

        .calendar-dates div {
            padding: 8px;
        }
    }
</style>





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


  <!-- Event Section -->
   
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
    <video autoplay loop muted>
      <source src="images/event-page.mp4" type="video/mp4">
      Your browser does not support the video tag.
  </video>
 
    <div class="controls">
      <span class="arrow left">&larr;</span>
      <span class="arrow right">&rarr;</span>
    </div>
  </section>

  <h1 class="eve-head" style="text-align:center;">Upcoming Events</h1>

<?php while ($row = $result->fetch_assoc()): ?>
<section class="event">
    <!-- Image -->
    <div class="event-image">
        <img src="<?php echo htmlspecialchars($row['image_path']); ?>" alt="Event Image">
    </div>

    <!-- Content and Calendar -->
    <div class="event-content">
        <div class="event-details">
            <h1><?php echo htmlspecialchars($row['title']); ?></h1>
            <p><?php echo htmlspecialchars($row['description']); ?></p>
            <div class="event-meta">
                <span class="location">Location: 📌 <div><?php echo htmlspecialchars($row['location']); ?></div></span><br><br>
                <span class="time">Time: <?php echo htmlspecialchars($row['time']); ?></span><br><br>
                <span class="date time">Date: <?php echo htmlspecialchars($row['event_date']); ?></span>
            </div>
        </div>

        <!-- Calendar Section -->
        <div class="calendar">
            <h2><?php echo date("F Y", strtotime($row['event_date'])); ?></h2>
            <div class="calendar-container">
                <?php
                $daysInMonth = date("t", strtotime($row['event_date']));
                $dayOfWeek = date("w", strtotime(date("Y-m-01", strtotime($row['event_date']))));

                for ($i = 0; $i < $dayOfWeek; $i++) echo "<div></div>";
                for ($i = 1; $i <= $daysInMonth; $i++) {
                    $highlight = ($i == date("j", strtotime($row['event_date']))) ? "highlight" : "";
                    echo "<div class='$highlight'>$i</div>";
                }
                ?>
             
            </div>
        </div>
         <a href="bookevent.php?event_id=<?= $row['id'] ?>" class="event_btn">Book Now</a>   <a href="cancel.php">Cancel and Refund &rarr;</a>
         <!-- Delete Button (Only visible for user 'norsang') -->
         <?php if ($username == "norsang"): ?>
                    <form method="GET" action="event.php" onsubmit="return confirm('Are you sure you want to delete this event?');">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="delete" class="delete-btn">Delete</button>
                    </form>
                <?php endif; ?>
    </div>
</section>
<?php endwhile; ?>

<?php if ($result->num_rows == 0): ?>
    <p style="text-align:center;">No upcoming events.</p>
<?php endif; ?>
 




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