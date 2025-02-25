<?php
require_once "config.php"; 

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";
$retrieved_data = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $amount_paid = $_POST['amount_paid'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $cancel_type = $_POST['cancel_type'];
    $payment_id = $_POST['payment_id'];

    // Table selection based on cancel type
    $table = ($cancel_type == "event_cancelation") ? "bookings" : "consultations";

    
// Determine table and column mappings based on cancellation type
if ($cancel_type == "event_cancelation") {
    $table = "bookings";
    $columns = [
        "name" => "user_name",
        "date" => "event_date",
        "time" => "event_time",
        "seatsselected" => "seats_selected",
        "amount"=>"total_amount",
        // "message" => "event_message",
        "payment_status" => "payment_status",
        "payment_id" => "payment_id",
        // "location" => "event_location",
        // "country" => "event_country",
    "email" => "email",
        "phone" => "phone",
    ];
} else {
    $table = "consultations";
    $columns = [
        "name" => "name",
        "date" => "date",
        "time" => "time",
        "amount"=>"amuount",
        "category" => "category",
        "message" => "message",
        "payment_status" => "payment_status",
        "payment_id" => "payment_id",
        "location" => "location",
        "country" => "country",
        "email" => "email",
        "phone" => "phone",
    ];
}
//Retrieve data from the database
    $query = "SELECT * FROM $table WHERE payment_id = ? and phone = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $payment_id,$phone);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    if ($data) {
        // Dynamically build retrieved data output based on available columns
        $retrieved_data = "<p><strong>Name:</strong> {$data[$columns['name']]}</p>";
        $retrieved_data .= isset($columns['date']) && isset($data[$columns['date']]) 
            ? "<p><strong>Date:</strong> {$data[$columns['date']]}</p>" : "";
        $retrieved_data .= isset($columns['time']) && isset($data[$columns['time']]) 
            ? "<p><strong>Time:</strong> {$data[$columns['time']]}</p>" : "";
        $retrieved_data .= isset($columns['category']) && isset($data[$columns['category']]) 
            ? "<p><strong>Category:</strong> {$data[$columns['category']]}</p>" : "";
        $retrieved_data .= isset($columns['message']) && isset($data[$columns['message']]) 
            ? "<p><strong>Message:</strong> {$data[$columns['message']]}</p>" : "";
        $retrieved_data .= isset($columns['seatsselected']) && isset($data[$columns['seatsselected']]) 
            ? "<p><strong>Seats Selected:</strong> {$data[$columns['seatsselected']]}</p>" : "";
        $retrieved_data .= isset($columns['amount']) && isset($data[$columns['amount']]) 
            ? "<p><strong>Amount:</strong> {$data[$columns['amount']]}</p>" : "";
        $retrieved_data .= "<p><strong>Payment Status:</strong> {$data[$columns['payment_status']]}</p>";
        $retrieved_data .= "<p><strong>Payment ID:</strong> {$data[$columns['payment_id']]}</p>";
        $retrieved_data .= isset($columns['location']) && isset($data[$columns['location']]) 
            ? "<p><strong>Location:</strong> {$data[$columns['location']]}</p>" : "";
        $retrieved_data .= isset($columns['country']) && isset($data[$columns['country']]) 
            ? "<p><strong>Country:</strong> {$data[$columns['country']]}</p>" : "";
        $retrieved_data .= "<p><strong>Email:</strong> {$data[$columns['email']]}</p>";
        $retrieved_data .= "<p><strong>Phone:</strong> {$data[$columns['phone']]}</p>";

        $message = "Details retrieved successfully. Please review below.";
    } else {
        $retrieved_data = "<p>No data found with the provided Payment ID.</p>";
        $message = "";
    }


    if (isset($_POST['confirm_cancel']) && $data) {
        // Dynamically prepare email content for the user
        $user_email_content = "
        Dear {$data[$columns['name']]},
    
        We have received your cancellation request for the following details:
    
        - Name: {$data[$columns['name']]}";
    
        if (isset($columns['date']) && isset($data[$columns['date']])) {
            $user_email_content .= "\n- Date: {$data[$columns['date']]}";
        }
    
        if (isset($columns['time']) && isset($data[$columns['time']])) {
            $user_email_content .= "\n- Time: {$data[$columns['time']]}";
        }
    
        if (isset($columns['category']) && isset($data[$columns['category']])) {
            $user_email_content .= "\n- Category: {$data[$columns['category']]}";
        }
    
        if (isset($columns['location']) && isset($data[$columns['location']])) {
            $user_email_content .= "\n- Location: {$data[$columns['location']]}";
        }
    
        $user_email_content .= "
        - Payment ID: {$data[$columns['payment_id']]}
        - Amount Paid: $amount_paid
    
        Our team will review your cancellation request. The refund will be processed and reflected in your account within 2 to 7 business days.
    
        If you have any questions, please feel free to contact us.
    
        Thank you,
        NORSANG";
    
        // Dynamically prepare email content for the owner
        $owner_email_content = "
        Dear Team,
    
        A cancellation request has been received with the following details:
    
        - Name: {$data[$columns['name']]}
        - Email: {$data[$columns['email']]}
        - Phone: {$data[$columns['phone']]}";
    
        if (isset($columns['date']) && isset($data[$columns['date']])) {
            $owner_email_content .= "\n- Date: {$data[$columns['date']]}";
        }
    
        if (isset($columns['time']) && isset($data[$columns['time']])) {
            $owner_email_content .= "\n- Time: {$data[$columns['time']]}";
        }
    
        if (isset($columns['category']) && isset($data[$columns['category']])) {
            $owner_email_content .= "\n- Category: {$data[$columns['category']]}";
        }
    
        if (isset($columns['location']) && isset($data[$columns['location']])) {
            $owner_email_content .= "\n- Location: {$data[$columns['location']]}";
        }
    
        $owner_email_content .= "
        - Payment ID: {$data[$columns['payment_id']]}
        - Amount Paid: $amount_paid
    
        Please review this request and process the refund accordingly.
    
        Thank you,
        NORSANG";
    
        // Send emails
        $user_mail_sent = mail($email, "Cancellation Received", $user_email_content);
        $owner_mail_sent = mail("owner@example.com", "Cancellation Request", $owner_email_content);

        if ($user_mail_sent && $owner_mail_sent) {
            // Delete data from the table
            $delete_query = "DELETE FROM $table WHERE payment_id = ?";
            $delete_stmt = $conn->prepare($delete_query);
            $delete_stmt->bind_param("s", $payment_id);
            $delete_stmt->execute();
            $updatequery = "UPDATE available_slots SET is_booked = FALSE WHERE date = ? AND time = ?";
            $stmt = $conn->prepare($updatequery);
            $stmt->bind_param("ss", $data['date'], $data['time']); // "ss" for two string parameters
            if ($stmt->execute()) {
                // echo "Slot updated successfully!";
            } else {
                echo "Error updating slot: " . $stmt->error;
            }
            $message = "<p class='success'>Thank you, your cancellation has been received. A confirmation mail has been sent, and the refund will be reflected in 2 to 7 business days.</p>";
        } else {
            $message = "<p class='error'>Failed to send cancellation email. Please contact our team.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel Request</title>
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
.cancel_form{
    margin:20px auto;
    padding:auto 20px;
}

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 700px;
            margin: 20px auto;
            background: #fff;
            padding:20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            color: #555;
        }
        input, select, .button {
            width: 90%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .button {
            background-color: #28a745;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        .details {
            margin-top: 20px;
        }
        .success {
            color: #28a745;
            font-weight: bold;
        }
        .error {
            color: #dc3545;
            font-weight: bold;
        }
    </style>
</head>

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
  <body>
    <br>
    <br>
    
  <section class="cancel_form">
    <div class="container">
        <h1>Cancel Request</h1>
        <form method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="amount_paid">Amount Paid:</label>
            <input type="text" id="amount_paid" name="amount_paid" required>

            <label for="email">Email ID:</label>
            <input type="email" id="email" name="email" required>

            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" required>

            <label for="cancel_type">Cancel Type:</label>
            <select id="cancel_type" name="cancel_type" required>
                <option value="event_cancelation">Event Cancellation</option>
                <option value="consultation_cancelation">Consultation Cancellation</option>
            </select>

            <label for="payment_id">Payment ID:</label>
            <input type="text" id="payment_id" name="payment_id" required>

            <button type="submit" class="button">Retrieve Details</button>
        </form>

        <?php if (!empty($retrieved_data)): ?>
            <div class="details">
                <h2>Retrieved Details</h2>
                <?php echo $retrieved_data; ?>
                <p>Check if your details are correct. If correct, click the cancel button or contact our team.</p>
                <form method="POST">
                    <input type="hidden" name="name" value="<?php echo htmlspecialchars($name); ?>">
                    <input type="hidden" name="amount_paid" value="<?php echo htmlspecialchars($amount_paid); ?>">
                    <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
                    <input type="hidden" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
                    <input type="hidden" name="cancel_type" value="<?php echo htmlspecialchars($cancel_type); ?>">
                    <input type="hidden" name="payment_id" value="<?php echo htmlspecialchars($payment_id); ?>">
                    <button type="submit" name="confirm_cancel" class="button">Confirm Cancel</button>
                </form>
            </div>
        <?php endif; ?>

        <p><?php echo $message; ?></p>
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
</body>
</html>