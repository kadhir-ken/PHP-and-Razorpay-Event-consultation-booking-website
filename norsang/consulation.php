<?php
session_start();
require_once "config.php"; 
require 'vendor/autoload.php';// Database connection file
use Razorpay\Api\Api;

$api = new Api('rzp_test_DKguLp35yM2JI4', 'HpxspjsOZfs84d5Ii7GLc0oS');

require_once "config.php"; // Database connection

// Ensure user session exists
if (isset($_SESSION['admin'])) {
    $username = $_SESSION['admin'];
}
//ilable dates and times
$query = "SELECT * FROM available_slots WHERE is_booked = FALSE ORDER BY date, time";
$result = $conn->query($query);
$slots = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $slots[] = $row;
    }
} else {
    $slots = [];
}
$inc=0;



// // Check for success and handle accordingly
// if ($stmt->affected_rows > 0) {
//   // If consultation booked successfully, mark the slot as booked
//   $updateQuery = "UPDATE available_slots SET is_booked = TRUE WHERE date = ? AND time = ?";
//   $updateStmt = $conn->prepare($updateQuery);
//   $updateStmt->bind_param("ss", $date, $time);
//   $updateStmt->execute();

//   if ($updateStmt->affected_rows > 0) {
//     $inc=1;
//   } else {
//       echo "consultation was booked succesfully .";
//   } 
// }else {
//     echo "Error: " . $stmt->error;
// }

// }

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = $_POST['name'];
    $date = $_POST['date'];  // Date selected by user
    $time = $_POST['time'];  // Time selected by user
    $categories = $_POST['category'];  // Categories of consultation
    $message = $_POST['message'];  // User's message
    $phone=$_POST['phone'];
    $country=$_POST['country'];
    $email=$_POST['email'];
    $location=$_POST['location'];
    // You can store categories as a serialized string or handle them separately
    $categoryList = implode(', ', $categories); 
    $show_confirmation = true;
    // Convert to paise
    // $_SESSION['phone']=$phone;
    // $_SESSION['seats']=$seats_selected; 
    // $_SESSION['amount']=$total_amount; 
    // $_SESSION['email']=$email;
    // $_SESSION['user']=$user_name;
    // Save booking to database
    // $sql_insert = "INSERT INTO bookings (event_id, user_name, email, phone, seats_selected, total_amount) VALUES (?, ?, ?, ?, ?, ?)";
    // $stmt = $conn->prepare($sql_insert);
    // $stmt->bind_param("issssd", $event_id, $user_name, $email, $phone, $seats_selected, $total_amount);
    // $stmt->execute();

    // $ticket_id = $conn->insert_id;

    // Create Razorpay order
    $orderData = [
        'receipt' => 'order_rcptid_' . time(),
        'amount' => '5000',
        'currency' => 'INR',
        'payment_capture' => 1 // Auto capture
    ];
    $razorpayOrder = $api->order->create($orderData);
    $razorpayOrderId = $razorpayOrder['id'];
}
// Handle seat booking and payment


    // $_SESSION['razorpay_order_id'] = $razorpayOrderId;

    // Generate ticket PDF
    // require('fpdf/fpdf.php');
    // $pdf = new FPDF();
    // $pdf->AddPage();
    // $pdf->SetFont('Arial', 'B', 16);

    // Ticket Header
    // $pdf->Cell(0, 10, 'Event Ticket', 0, 1, 'C');
    // $pdf->Ln(10);

    // Event Info
    // $pdf->SetFont('Arial', '', 12);
    // $pdf->Cell(50, 10, 'Event:', 0, 0);
    // $pdf->Cell(0, 10, htmlspecialchars($event['title']), 0, 1);
    // $pdf->Cell(50, 10, 'Date:', 0, 0);
    // $pdf->Cell(0, 10, '2024-12-25', 0, 1); // Example date
    // $pdf->Cell(50, 10, 'Time:', 0, 0);
    // $pdf->Cell(0, 10, '7:00 PM', 0, 1); // Example time

    // User Info
    // $pdf->Ln(5);
    // $pdf->Cell(50, 10, 'Name:', 0, 0);
    // $pdf->Cell(0, 10, htmlspecialchars($user_name), 0, 1);
    // $pdf->Cell(50, 10, 'Email:', 0, 0);
    // $pdf->Cell(0, 10, htmlspecialchars($email), 0, 1);
    // $pdf->Cell(50, 10, 'Phone:', 0, 0);
    // $pdf->Cell(0, 10, htmlspecialchars($phone), 0, 1);

    // Booking Info
    // $pdf->Ln(5);
    // $pdf->Cell(50, 10, 'Seats:', 0, 0);
    // $pdf->Cell(0, 10, htmlspecialchars($seats_selected), 0, 1);
    // $pdf->Cell(50, 10, 'Total Amount:', 0, 0);
    // $pdf->Cell(0, 10, '₹' . ($total_amount / 100), 0, 1);

    // Footer
    // $pdf->Ln(10);
    // $pdf->SetFont('Arial', 'I', 10);
    // $pdf->Cell(0, 10, 'Thank you for booking with us!', 0, 1, 'C');

    // $filePath = __DIR__ . '/tickets/ticket_' . $ticket_id . '.pdf';
    // $pdf->Output('F', $filePath);

    // echo "Ticket successfully booked and PDF generated: <a href='tickets/ticket_" . $ticket_id . ".pdf'>Download Ticket</a>";
// }

?>

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




        /* Your styles here */
        h1 {
    text-align: center;
    margin: 30px;
    color: #333;
}

.form-container {
    background-color: #fff;
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    max-width: 650px;
    margin: 50px auto;
}

.form-group {
    margin: 30px 0; /* Adjusted margin for spacing */
}

.label {
    font-weight: bold;
    display: block;
    margin-bottom: 5px;
    color: #555;
}

input, textarea {
    /* width: 100%; */
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

input[type="date"] {
    appearance: none;
    -webkit-appearance: none;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background: #fff url('calendar-icon.png') no-repeat right 10px center;
    background-size: 20px 20px;
    cursor: pointer;
}

/* Checkbox group styling */
.checkbox-group {
    /* display: flex; */
    /* justify-content: center; */
    gap: 15px;
    margin-top: 20px;
    flex-wrap: wrap;
}

.checkbox-item {
    display: flex;
    align-items: center;
    gap: 10px;
}

.checkbox-item img {
    width: 80px;
    height: 80px;
    border-radius: 5px;
    object-fit: cover;
}

.button {
    background-color: #28a745;
    color: #fff;
    padding: 10px 20px;
    font-size: 18px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}




#payButton {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        #submitbutton {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
    .clearbutton {
            padding: 10px 20px;
            background-color:rgb(189, 27, 27);
            color: white;
            
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        #payButton:hover {
            background-color: #218838;
        }
        #submitbutton:hover {
            background-color: #218838;
        }

        #loading {
            display: none;
            color: #555;
        }

       
        .booking-confirmation {
  font-family: Arial, sans-serif;
  margin: 20px auto;
  width: 80%;
  max-width: 600px;
  border: 1px solid #ccc;
  padding: 20px;
  border-radius: 8px;
  background-color: #f9f9f9;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.booking-confirmation h3 {
  text-align: center;
  margin-bottom: 20px;
  font-size: 1.5em;
  color: #333;
}

.table {
  display: table;
  width: 100%;
  border-collapse: collapse;
}

.row {
  display: table-row;
}

.cell {
  display: table-cell;
  padding: 8px 12px;
  border-bottom: 1px solid #ddd;
  vertical-align: top;
}

.cell:first-child {
  font-weight: bold;
  color: #555;
  width: 40%;
}

.cell:last-child {
  color: #333;
}

.row:last-child .cell {
  border-bottom: none;
}


        .seat[style*="not-allowed"] {
    pointer-events: none; /* Make the seat unclickable */
    opacity: 0.7;
}



button:hover {
    background-color: #218838;
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


/* Agreement checkbox */
#agreement {
    width: 10%;
}.add-slot{
    background:rgba(88, 186, 60, 0.48);
    padding:20px;
    border:1px solid green;
    border-radius: 12px;
    color:rgb(15, 45, 7);
}

/* Mobile Responsiveness */
@media (max-width: 768px) {
    h1 {
        font-size: 1.5rem; /* Adjust font size for smaller screens */
        margin: 20px;
    }

    .form-container {
        padding: 20px; /* Reduced padding for mobile */
        max-width: 90%;
        margin: 30px auto;
    }

    .form-group {
        margin: 20px 0; /* Reduced margin for mobile */
    }

    input, textarea {
        font-size: 14px; /* Smaller font size for inputs on mobile */
    }

    button {
        font-size: 16px; /* Slightly smaller button font on mobile */
        padding: 10px 15px; /* Reduced button padding */
    }

    /* Adjust checkbox group and image size for mobile */
    .checkbox-group {
        gap: 10px;
        flex-direction: column;
    }

    .checkbox-item img {
        width: 60px; /* Smaller images on mobile */
        height: 60px;
    }

    #agreement {
        width: 15%; /* Adjust width for mobile */
    }
}
    </style>
</head>
<body>

<header>
    <nav>
        <div class="logo">NORSANG</div>
        <button class="menu-toggle" id="mobile-menu-btn">☰</button>
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
                <li><a href="logout.php">Profile</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<section class="hero">
    <div class="image-overlay"></div>
    <video autoplay loop muted>
        <source src="images/consultation-page.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <div class="controls">
        <span class="arrow left">&larr;</span>
        <span class="arrow right">&rarr;</span>
    </div>
</section>

<h1>Book a Personal Consultation</h1>
<div class="form-container">
    <form action="consulation.php" method="POST">
        <!-- Name -->
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" placeholder="Enter your Name" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" placeholder="Enter your Email" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" placeholder="Enter your Phone Number" required>
        </div>
        <div class="form-group">
            <label for="location">Address:</label>
            <input type="text" id="location" name="location" placeholder="Enter your Location" required>
        </div>
        <div class="form-group">
            <label for="country">Country:</label>
            <input type="text" id="country" name="country" placeholder="Enter your Country" required>
        </div>
        <!-- Available Dates -->
        <div class="form-group">
            <label for="date">Available Dates:</label>
            <select id="date" name="date" required>
                <?php
                // Assuming $slots contains available dates fetched from the database
                $dates = [];
                foreach ($slots as $slot) {
                    $dates[] = $slot['date'];
                }
                $dates = array_unique($dates); // Remove duplicate dates
                foreach ($dates as $date) {
                    echo "<option value='$date'>$date</option>";
                }
                ?>
            </select>
        </div>

        <!-- Available Times -->
        <div class="form-group">
            <label>Available Times:</label>
            <div class="radio-group" id="time-options">
                <!-- Times will be updated here dynamically based on selected date -->
            </div>
        </div>

        

        <!-- Category -->
        <div class="form-group">
            <label>Category of Consultation:</label>
            <div class="checkbox-group">
                <div class="checkbox-item">
                    <input type="checkbox" id="category1" name="category[]" value="Acupuncture">
                    <img src="images/acupuncture.jpg" alt="Acupuncture">
                    <label for="category1">Acupuncture</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="category2" name="category[]" value="Feng Shui">
                    <img src="images/fengshui.png" alt="Feng Shui">
                    <label for="category2">Feng Shui</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="category3" name="category[]" value="Facial Gua Sha">
                    <img src="images/guasha.jpg" alt="Facial Gua Sha">
                    <label for="category3">Facial Gua Sha</label>
                </div>
            </div>
        </div>

        <!-- Message -->
        <div class="form-group">
            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="4" placeholder="Write your message here..."></textarea>
        </div>

        <!-- Submit Button -->
        <div class="form-group"><?php if(!isset($show_confirmation)){?>
<button type="submit" name="submitbutton" id="submitbutton" class="button">Book</button>
   
      
<?php
}?>
        </div>
        <?php 
        if($inc==1){
echo "<p class='add-slot'>Consultation Booked Successfully</p>";
        }?>
    </form>
</div>



</div>
 

    <?php if(isset($name)){
        ?>
    
        <div class="booking-confirmation">
         <h3>Booking Confirmation</h3>
         <div class="table">
        <div class="row">
          <div class="cell"><strong>Name:</strong></div>
         <div class="cell"><?= htmlspecialchars($name) ?></div>
        </div>
       <div class="row">
      <div class="cell"><strong>Email:</strong></div>
      <div class="cell"><?= htmlspecialchars($email) ?></div>
    </div>
    <div class="row">
      <div class="cell"><strong>Phone:</strong></div>
      <div class="cell"><?= htmlspecialchars($phone) ?></div>
    </div>
    <div class="row">
      <div class="cell"><strong>Country:</strong></div>
      <div class="cell"><?= htmlspecialchars($country) ?></div>
    </div>
    <div class="row">
      <div class="cell"><strong>Category:</strong></div>
      <div class="cell"><?= htmlspecialchars($categoryList) ?></div>
    </div>
    <div class="row">
      <div class="cell"><strong>Location:</strong></div>
      <div class="cell"><?= htmlspecialchars($location) ?></div>
    </div>
    <div class="row">
      <div class="cell"><strong>Time:</strong></div>
      <div class="cell"><?= htmlspecialchars($time) ?></div>
    </div>
    <div class="row">
      <div class="cell"><strong>Message:</strong></div>
      <div class="cell"><?= htmlspecialchars($message) ?></div>
    </div>
    <div class="row">
      <div class="cell"><strong>Total Amount:</strong></div>
      <div class="cell">₹<?= 5000 ?></div>
    </div>
  </div>
  <?php if(isset($show_confirmation)){?>
    <div class="button-container">
  <button type="button" onclick="clearForm()" class="clearbutton" style="padding:10px;">clear</button>
  
        <button type="submit" name="payButton" id="payButton" style="padding:10px;">click to Pay</button><br>
        <div id="loading" style="display:none;">Processing...</div></div>
  </div>
  <?php }?>

<?php }?>
    





<script>
    function clearForm() {
        // Reset the form values
        window.location.href = `consulation.php` ; 
    }
</script><script>
    document.addEventListener('DOMContentLoaded', function() {
        const dateSelect = document.getElementById('date');
        const timeOptionsContainer = document.getElementById('time-options');

        const availableTimes = <?php echo json_encode($slots); ?>;

        // Function to update the available times when a date is selected
        function updateTimes() {
            const selectedDate = dateSelect.value;
            const timesForSelectedDate = availableTimes.filter(slot => slot.date === selectedDate);
            
            // Clear previous time options
            timeOptionsContainer.innerHTML = '';

            // Create new radio buttons for available times for the selected date
            // Create new radio buttons for available times for the selected date
timesForSelectedDate.forEach(slot => {
    const timeLabel = document.createElement('label');
    const timeInput = document.createElement('input');
    timeInput.type = 'radio';
    timeInput.name = 'time';
    timeInput.value = slot.time;  // <-- Now we only pass the time value, not concatenating date
    timeInput.required = true;
    
    timeLabel.appendChild(timeInput);
    timeLabel.appendChild(document.createTextNode(slot.time));
    
    timeOptionsContainer.appendChild(timeLabel);
    timeOptionsContainer.appendChild(document.createElement('br'));
});

        }

        // Add event listener to update times when the date is changed
        dateSelect.addEventListener('change', updateTimes);

        // Initialize the time options when the page loads
        if (dateSelect.value) {
            updateTimes();
        }
    });
</script>

<script src="script.js"></script><script src="https://checkout.razorpay.com/v1/checkout.js"></script>
  <script>
    const options = {
        "key": "rzp_test_DKguLp35yM2JI4", // Replace with your Razorpay key ID
        "amount":5000, // Amount in the smallest currency unit
        "currency": "INR",
        "name": "<?= $name ?>",
        "description": "Consultation Booking",
        "order_id": "<?= isset($razorpayOrderId) ? $razorpayOrderId : '' ?>",
        "handler": function (response) {
            const paymentId = response.razorpay_payment_id;
            const orderId = response.razorpay_order_id;
            const signature = response.razorpay_signature;
const user="<?php echo $name?>";
const email="<?php echo $email?>";
const phone="<?php echo $phone?>";
const country="<?php echo $country?>";
const location="<?php echo $location?>";
const categorylist="<?= $categoryList?>";
const time="<?php echo $time?>";
const date="<?php echo $date?>";
const message="<?=$message?>";

const totalamount= 500;

 // Validate fetched inputs
 if (!user || !email || !phone || !time) {
        console.error("Missing required input fields.");
        return;
    }
    console.log(paymentId);
    console.log(orderId);
    console.log(signature);
    console.log(user);
    console.log(email);
    console.log(date);
    console.log(phone);
    console.log(totalamount);
    console.log(time);

            // Redirect to success.php with query parameters
            window.location.href = `confirmconsultation.php?razorpay_payment_id=${paymentId}&message=${message}&categorylist=${categorylist}&user=${user}&date=${date}&location=${location}&country=${country}&email=${email}&phone=${phone}&totalamount=${totalamount}&time=${time}&razorpay_order_id=${orderId}&razorpay_signature=${signature}`;
        },
        "prefill": {
            "name": "<?= $name ?>",
           
        },
        "theme": {
            "color": "#F37254"
        }
    };

    const rzp1 = new Razorpay(options);
    document.getElementById('payButton').onclick = function (e) {
        rzp1.open();
        e.preventDefault();
    };
    
    </script>
 


</body>
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
</html>