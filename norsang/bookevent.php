


<?php
session_start();
require 'vendor/autoload.php';
use Razorpay\Api\Api;

$api = new Api('rzp_test_DKguLp35yM2JI4', 'HpxspjsOZfs84d5Ii7GLc0oS');

require_once "config.php"; // Database connection

// Ensure user session exists
if (isset($_SESSION['admin'])) {
    $username = $_SESSION['admin'];
}
$ticket_id = $conn->insert_id;
// $_SESSION['ticket_id'] = $ticket_id; 
// Store the booking ID in session

$event_id = $_GET['event_id'] ?? null;
// $_SESSION['event_id'];
if (!$event_id) {
    die("Event ID not provided!");
}
//  $_SESSION['email']=$email; // Assuming email is stored in session
//  $_SESSION['phone']=$phone; // Assuming phone number is stored in session
//  $_SESSION['seats']=$seats_selected; // Assuming seat number is stored in session
//  $_SESSION['amount']=$total_amount; 
// $_SESSION['event_id']=$event_id;
// Fetch event details
$sql = "SELECT title, seats_available,location FROM events WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();
$event = $result->fetch_assoc();

if (!$event) {
    die("Event not found!");
}
$available_seats = $event['seats_available'];

 if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $user_name = $_POST['user_name'];
    
 
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $seats_selected = implode(", ", $_POST['seats']);
    $seat_price = 100; // Price per seat in INR
    $total_amount = count($_POST['seats']) * $seat_price; 
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
        'amount' => $total_amount*100,
        'currency' => 'INR',
        'payment_capture' => 1 // Auto capture
    ];
    $razorpayOrder = $api->order->create($orderData);
    $razorpayOrderId = $razorpayOrder['id'];}
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

// Fetch already booked seats
$sql_booked = "SELECT seats_selected FROM bookings WHERE event_id = ?";
$stmt = $conn->prepare($sql_booked);
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result_booked = $stmt->get_result();
$booked_seats = [];
while ($row = $result_booked->fetch_assoc()) {
    $booked_seats = array_merge($booked_seats, explode(", ", $row['seats_selected']));
}
$booked_seats = array_map('intval', $booked_seats);

?>

<!DOCTYPE html>
<html lang="en">
<head> <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NORSANG-EVENT-BOOKING</title>
  <link rel="stylesheet" href="styles.css">
    <style>
        /* .seat-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 10px;
            margin: 20px 0;
        }
        .seat {
            width: 40px;
            height: 40px;
            background: #ccc;
            text-align: center;
            line-height: 40px;
            border-radius: 5px;
            cursor: pointer;
         
        }
        
        .seat.selected {
            background: #28a745;
            color: white;
        } */
       
body{
    padding-top:40px;
}
        .bookevent_sec {
            margin:60px 30px;
            padding:30px;
            background-color: #f4f4f4;
            text-align: center;
        }

        .seat-grid {
            display: grid;
            grid-template-columns: repeat(10, 0fr);
            gap: 10px;
            margin:20px;
            justify-content: center;
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
        .seat {
            width: 40px;
            height: 40px;
            background-color: #ccc;
            text-align: center;
            line-height: 40px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .seat.selected {
            background-color: #28a745;
            color: white;
        }

        .seat:hover {
            background-color: #bbb;
        }
        
        .form-container {
            margin: 20px 0;
            text-align: left;
            
        }

        .form-container label {
            display: block;
            margin: 10px 0 5px;
            /* padding: 50px; */
        }

        input {
            width:20%;
            padding:8px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .button-container {
    display: flex;
    justify-content: center; /* Center horizontally */
    align-items: center; 
    gap:20px;    /* Center vertically */
    height:60px;     /* Full viewport height */
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
  width: 100%;
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

        
/* For screens 768px and smaller */
@media (max-width: 768px) {
    .bookevent_sec {
        margin: 30px 15px;
        padding: 20px;
    }

    .seat-grid {
        grid-template-columns: repeat(5, 0fr); /* Reduce the number of columns */
    }

    .seat {
        width: 35px;
        height: 35px;
        line-height: 35px;
    }
  
    input {
        width: 60%; /* Increase input width for smaller screens */
    }

    #payButton {
        padding: 8px 15px; /* Adjust padding for smaller buttons */
    }
    #submitbutton{
        padding: 8px 15px;
    }
}

/* For screens 480px and smaller */
@media (max-width: 480px) {
    .bookevent_sec {
        margin: 20px 10px;
        padding: 15px;
    }

    .seat-grid {
        grid-template-columns: repeat(3, 0fr); /* Further reduce the number of columns */
        gap: 5px;
    }

    .seat {
        width: 30px;
        height: 30px;
        line-height: 30px;
    }

    input {
        width: 80%; /* Make inputs occupy most of the width */
    }

    #payButton {
        width: 100%; /* Button spans full width */
        padding: 10px;
    }
}
    </style>
    <script>
        function toggleSeat(seat) {
            seat.classList.toggle("selected");
            const checkbox = seat.querySelector("input");
            checkbox.checked = !checkbox.checked;
        }
    </script>
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

    <section class="bookevent_sec">
          <!-- Legend Section -->
<div style="margin: 20px 0; display: flex; align-items: center;">
    <div style="display: flex; align-items: center; margin-right: 20px;">
        <div style="width: 20px; height: 20px; background-color: #ff4d4d; margin-right: 5px; border-radius: 3px;"></div>
        <span>Booked Seats</span>
    </div>
    <div style="display: flex; align-items: center; margin-right: 20px;">
        <div style="width: 20px; height: 20px; background-color: #ccc; margin-right: 5px; border-radius: 3px;"></div>
        <span>Available Seats</span>
    </div>
    <div style="display: flex; align-items: center;">
        <div style="width: 20px; height: 20px; background-color: #28a745; margin-right: 5px; border-radius: 3px;"></div>
        <span>Selected Seats</span>
    </div>
</div>
 
    
       <h1>Book Seats for <?= htmlspecialchars($event['title']) ?></h1><br><br>
       <form method="POST" id="myForm">
        <label>Name: <input type="text" name="user_name" id = "user_name "required></label><br>
        <label>Email: <input type="email" name="email" id="email" required></label><br>
        <label>Phone: <input type="text" name="phone" id="phone"required></label><br>

        <h3>Select Your Seats</h3>
        <div class="seat-grid">
    <?php for ($i = 1; $i <= $available_seats; $i++): ?>
        <?php if (in_array($i, $booked_seats)): ?>
            <div class="seat" style="background-color: #ff4d4d; cursor: not-allowed; color: white;">
                <?= $i ?> 
            </div>
        <?php else: ?>
            <div class="seat" onclick="toggleSeat(this)">
                <?= $i ?>
                <input type="checkbox" name="seats[]" value="<?= $i ?>" style="display:none;">
            </div>
            <?php endif; ?>
        
    <?php endfor; ?>
</div>
<br><?php if(!isset($show_confirmation)){?>
<button type="submit" name="submitbutton" id="submitbutton">Book</button>
   
      
<?php
}?>
        
    </form> 
    <?php if(isset($user_name)){?>
    
        <div class="booking-confirmation">
  <h3>Booking Confirmation</h3>
  <div class="table">
    <div class="row">
      <div class="cell"><strong>Name:</strong></div>
      <div class="cell"><?= htmlspecialchars($user_name) ?></div>
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
      <div class="cell"><strong>Selected Seats:</strong></div>
      <div class="cell"><?= htmlspecialchars($seats_selected) ?></div>
    </div>
    <div class="row">
      <div class="cell"><strong>Total Amount:</strong></div>
      <div class="cell">₹<?= htmlspecialchars($total_amount) ?></div>
    </div>
  </div>
  <?php if(isset($show_confirmation)){?>
    <div class="button-container">
  <button type="button" onclick="clearForm()" class="clearbutton" style="padding:10px;">clear</button>
  
        <button type="submit" name="payButton" id="payButton" style="padding:10px;">click to Pay</button><br>
        <div id="loading" style="display:none;">Processing...</div></div>
       
  <?php
}?>
</div>

        
   <?php }?>
    </section>
    
    <?php if(isset($show_confirmation)){
        ?>
      
        <?php
    }?>


<footer class="footer">

    <div class="footer-content">
      <nav class="footer-links">
        <a href="index.php">Home</a>
        <a href="story.php">Story</a>
       <a href="About.php">About</a>
       
          <a href="event.php">
            <!-- Events <img src="images/new.png" alt="new" class="image-navbar"> -->
          </a>
       
        <a href="booking.php">Booking</a>
        <a href="contact.php">Contacts</a>
      </nav><div class="contact-footer">
        <!-- <h2>Queriess</h2> -->
        <h2>Email : ask@norbusangpo.com</h2>
      </div>      
      <div class="footer-logo">
        <h2> N O R S A N G </h2>
        <span class="footer-icon"></span>
      </div>
      <div class="footer-copyright">
        <p>Norsang &copy; 2024. All Rights Reserved.</p>
      </div>
    </div>
  </footer>
  
  <script src="script.js"></script><script src="https://checkout.razorpay.com/v1/checkout.js"></script>
  <script>
    const options = {
        "key": "rzp_test_DKguLp35yM2JI4", // Replace with your Razorpay key ID
        "amount": <?= $total_amount*100 ?>, // Amount in the smallest currency unit
        "currency": "INR",
        "name": "<?= $user_name ?>",
        "description": "Event Booking",
        "order_id": "<?= isset($razorpayOrderId) ? $razorpayOrderId : '' ?>",
        "handler": function (response) {
            const paymentId = response.razorpay_payment_id;
            const orderId = response.razorpay_order_id;
            const signature = response.razorpay_signature;
const user="<?php echo $user_name?>";
const email="<?php echo $email?>";
const seatsselected="<?php echo $seats_selected?>";
const phone="<?php echo $phone?>";
const totalamount="<?php echo $total_amount?>";
const eventid="<?php echo $event_id?>";
const location="<?= $event['location']?>";
 // Validate fetched inputs
 if (!user || !email || !phone || !eventid) {
        console.error("Missing required input fields.");
        return;
    }
    console.log(paymentId);
    console.log(orderId);
    console.log(signature);
    console.log(user);
    console.log(email);
    console.log(seatsselected);
    console.log(phone);
    console.log(totalamount);
    console.log(eventid);

            // Redirect to success.php with query parameters
            window.location.href = `success.php?razorpay_payment_id=${paymentId}&location=${location}&event_id=${eventid}&user=${user}&email=${email}&phone=${phone}&totalamount=${totalamount}&seats=${seatsselected}&razorpay_order_id=${orderId}&razorpay_signature=${signature}`;
        },
        "prefill": {
            "name": "<?= $user_name ?>",
            "email": "<?= $email ?>",
            "contact": "<?= $phone ?>"
        },
        "theme": {
            "color": "#F37254"
        }
    };

    const rzp1 = new Razorpay(options);
    document.getElementById('payButton').onclick = function (e) {
        rzp1.open();
        e.preventDefault();
    }
</script>

<script>
        document.querySelector("form").addEventListener("submit", function() {
            document.getElementById("payButton").style.display = "none";
            document.getElementById("loading").style.display = "block";
            
        });
        let selectedSeatsCount = 0; // Track the number of selected seats

function toggleSeat(seat) {
    // Check if the seat is already selected
    if (seat.classList.contains("selected")) {
        // If selected, unselect it
        seat.classList.remove("selected");
        selectedSeatsCount--; // Decrease the count
    } else {
        // If not selected and less than 4 seats are selected, select the seat
        if (selectedSeatsCount < 4) {
            seat.classList.add("selected");
            selectedSeatsCount++; // Increase the count
        } else {
            alert("You can only select up to 4 seats!");
        }
    }

    // Toggle the checkbox state
    const checkbox = seat.querySelector("input");
    checkbox.checked = !checkbox.checked;
}
function clearForm() {
    const eventid=<?=$event_id?>;
        // Reset the form values
        window.location.href = `bookevent.php?event_id=${eventid}` ; 
    }
    </script>
<?php 
// $_SESSION['razorpay_order_id'] = $razorpayOrderId;
// $_POST['user'] = $user_name;

// $_post['email']=$email;

// echo "Razorpay Order ID: " . $_SESSION['razorpay_order_id']; 
// echo "Razorpay Order ID: " . $_SESSION['user']; 
?>
</body>
</html>
