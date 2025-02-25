<?php
session_start();
require_once "config.php"; // Database connection file

// Ensure the user is logged in as an admin
if (!isset($_SESSION['admin'])) {
    header("Location: admin.php");
    exit();
}

if (isset($_SESSION['admin'])) {
    $username = $_SESSION['admin'];
}
$inc=0;
// Handle form submission for adding consultation
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $consultation_date = $_POST['consultation_date'];
    $consultation_time = $_POST['consultation_time'];

    // Insert into available_slots table
    $sql = "INSERT INTO available_slots (date, time) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $consultation_date, $consultation_time);  // Bind parameters for date and time

    if ($stmt->execute()) {
        $inc=1;
    }
    else {
        echo "<p style='color:red;'>Error adding consultation slot: " . $conn->error . "</p>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Consultation Slot</title>
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

 
        /* General Styles */
        .addconsultation_sec {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 900px;
            margin:30px  auto;
        }

.form_title {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
            margin-top:70px;
        }

        /* Form Styles */
        .addconsultation_form {
            width: 100%;
        }

        .addconsultation_form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        .addconsultation_form input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1em;
        }

        .addconsultation_form button {
            width: 100%;
            padding: 14px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 4px;
            margin-bottom: 40px;
            font-size: 1.1em;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        

        .addconsultation_form button:hover {
            background-color: #ff7f50;
        }
.add-slot{
    background:rgba(88, 186, 60, 0.48);
    padding:20px;
    border:1px solid green;
    border-radius: 12px;
    color:rgb(15, 45, 7);
}  .nav-links li {
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
        /* Responsive Styles */
        @media (max-width: 768px) {
            .addconsultation_sec {
                margin: 20px;
            }

            .addconsultation_form button {
                font-size: 1em;
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
            <li><a href="story.php">Story</a></li>
            <li><a href="About.html">About</a></li>
            <li><a href="event.php">Events</a></li>
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
                <li> <a href="logout.php">Logout</a></li>
            <?php endif ?>
        </ul>
    </nav>
</header>

<section class="addconsultation_sec">
    <h2 class="form_title">Add Personal Consultation Slot</h2>
    <form method="POST" action="addconsultation.php" class="addconsultation_form">
        <label for="consultation_date">Consultation Date:</label>
        <input type="date" id="consultation_date" name="consultation_date" required><br><br>

        <label for="consultation_time">Consultation Time:</label>
        <input type="text" id="consultation_time" name="consultation_time" placeholder="Example:10:30PM - 12:30PM SST" required><br><br>

        <button type="submit">Add Consultation Slot</button>
        <?php 
        if ($inc==1) {
            echo "<p style='' class='add-slot'>Consultation slot added successfully!</p>";
        }?>
    </form>
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
   
      <h2>Contact : +6590681135</h2>
      <h2>Address: 2A, Jalan Taiping, Taman Lim, 30100 Ipoh, Perak, Malaysia</h2>
      <div class="footer-logo">
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
