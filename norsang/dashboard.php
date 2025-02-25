<?php
session_start();
include 'config.php'; // Include your DB connection file

 // Database connection file

if (isset($_SESSION['admin'])) {
  $username =$_SESSION['admin'];
}

// Update attendance status if admin clicks
if (isset($_POST['update_attendance'])) {
    $booking_id = $_POST['booking_id'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE bookings SET attendance_status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $booking_id);
    $stmt->execute();
}

// Fetch all unique event names for the filter dropdown
$events_query = "SELECT id, title FROM events";
$events_result = $conn->query($events_query);

// Set up the event filter
$selected_event = isset($_GET['event_id']) ? $_GET['event_id'] : "";

// Fetch bookings based on selected event filter
$query = "SELECT 
            bookings.id, 
            bookings.user_name, 
            bookings.email,
            bookings.payment_status,
            bookings.payment_id,
            bookings.order_id,
            bookings.phone,
            bookings.seats_selected, 
            bookings.attendance_status, 
            events.title AS event_name, 
            events.event_date
          FROM bookings
          JOIN events ON bookings.event_id = events.id";

if (!empty($selected_event)) {
    $query .= " WHERE events.id = ?";
}

$query .= " ORDER BY events.event_date DESC";

$stmt = $conn->prepare($query);

// Bind parameter if a specific event is selected
if (!empty($selected_event)) {
    $stmt->bind_param("i", $selected_event);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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

        .dash_sec{
            margin:20px;
            padding:30px;
            /* width:100%; */
            border:2px solid red;
            border-radius:8px;
        }
        .tilt{
          display:none;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color:rgb(31, 32, 84);
            color: white;
        }
        .btn {
            cursor: pointer;
            border: none;
            background: none;
            font-size: 18px;
            margin: 5px;
        }
        .btn-green { color: green; }
        .btn-red { color: red; }
        .status-pending { color: orange; }
        .status-attended { color: green; }
        .status-not-attended { color: red; }
        /* Style for the navigation menu */
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
.status-pending {
            color: orange;
        }

        .status-success {
            color: green;
        }

        .status-failed {
            color: red;
        }
        @media (max-width: 480px) {
          .tilt{
            display:block;
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
    <li><a href="logout.php">Logout</a></li>
        
<?php endif ?>
      </ul>
    
    </nav>
  </header>
    <h1 style="padding-top:70px; text-align:center; padding-top:80px;">Booked Customers Detail</h1>
    <div class="tilt-div">
<h5 class="tilt">Tilt Your Mobile for Full view<h5></div>
    <!-- Filter Form -->
     <section class="dash_sec">
    <form method="GET" action="" style="margin-bottom: 20px;">
        <label for="event_id">Filter by Event:</label>
        <select name="event_id" id="event_id" onchange="this.form.submit()">
            <option value="">-- Select Event --</option>
            <?php while ($event = $events_result->fetch_assoc()): ?>
                <option value="<?= htmlspecialchars($event['id']) ?>" 
                    <?= ($event['id'] == $selected_event) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($event['title']) ?>
                </option>
            <?php endwhile; ?>
        </select>
        <noscript><button type="submit">Filter</button></noscript>
    </form>

    <table >
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>User Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Event Name</th>
                <th>Event Date</th>
                <th>Seat Number</th>
                <th>Attendance Status</th>
                <th>Payment Status</th>
                <th>PaymentId</th>
                <th>OrderId</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['user_name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['phone']) ?></td>
                    <td><?= htmlspecialchars($row['event_name']) ?></td>
                    <td><?= htmlspecialchars($row['event_date']) ?></td>
                    <td><?= htmlspecialchars($row['seats_selected']) ?></td>
                    <td>
                        <?php 
                            if ($row['attendance_status'] == 'attended') {
                                echo "<span class='status-attended'>Attended</span>";
                            } elseif ($row['attendance_status'] == 'not_attended') {
                                echo "<span class='status-not-attended'>Not Attended</span>";
                            } else {
                                echo "<span class='status-pending'>Pending</span>";
                            }
                        ?>
                    </td>
                    <td><?php 
                                if ($row['payment_status'] == 'pending') {
                                    echo "<span class='status-pending'>Pending</span>";
                                } elseif ($row['payment_status'] == 'success') {
                                    echo "<span class='status-attended'>Success</span>";
                                } else {
                                    echo "<span class='status-not-attended'>Failed</span>";
                                }
                            ?>
                        </td>
                        <td><?= htmlspecialchars($row['payment_id']) ?></td>
                        <td><?= htmlspecialchars($row['order_id']) ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="booking_id" value="<?= $row['id'] ?>">
                            <button type="submit" name="update_attendance" value="attended" class="btn btn-green" title="Mark as Attended">
                                ✅
                            </button>
                            <input type="hidden" name="status" value="attended">
                        </form>

                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="booking_id" value="<?= $row['id'] ?>">
                            <button type="submit" name="update_attendance" value="not_attended" class="btn btn-red" title="Mark as Not Attended">
                                ❌
                            </button>
                            <input type="hidden" name="status" value="not_attended">
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
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
</body>
</html>
