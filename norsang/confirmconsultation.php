<?php
session_start();
require 'vendor/autoload.php';
use Razorpay\Api\Api;
require_once "config.php"; // Database connection
require('fpdf/fpdf.php');
require 'vendor/autoload.php'; // Ensure PHPMailer is included
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$username =    $_GET['user']   ?? null  ;
$email =       $_GET['email'] ?? null  ;
$phone =       $_GET['phone']  ?? null ;
$country=       $_GET['country']  ?? null  ;
$message=$_GET['message']  ?? null  ;
$location=       $_GET['location']  ?? null  ;
$date=       $_GET['date']  ?? null  ;
$amountPaid =  $_GET['totalamount'] ?? null  ;
$time =     $_GET['time']?? null;
$categorylist=$_GET['categorylist']?? null;
$paymentId = $_GET['razorpay_payment_id'] ?? null;
$orderId = $_GET['razorpay_order_id'] ?? null;
$signature = $_GET['razorpay_signature'] ?? null;

// Verify payment details
if (!$paymentId || !$orderId || !$signature) {
    die("Payment details not found!");
}

$attributes = [
    'razorpay_order_id' => $orderId,
    'razorpay_payment_id' => $paymentId,
    'razorpay_signature' => $signature
];
// Initialize Razorpay API
$api = new Api('rzp_test_DKguLp35yM2JI4', 'HpxspjsOZfs84d5Ii7GLc0oS');

// Ensure user session exists
// if (isset($_GET['user'], $_SESSION['event_id'], $_SESSION['seats'], $_SESSION['amount'])) {
//     die("Session details are missing!");
//     echo $_SESSION['user'];
//     echo $_SESSION['event_id'];
//     echo $_SESSION['email'];
//     echo $_SESSION['phone'];
//     echo $_SESSION['seats'];
//     echo $_SESSION['amount'];
// }

try {
    // Verify the payment signature
    $api->utility->verifyPaymentSignature($attributes);

    // Fetch event details
    // $sql = "SELECT title, event_date ,time,seats_available FROM events WHERE id = ?";
    // $stmt = $conn->prepare($sql);
    // $stmt->bind_param("i", $eventId);
    // $stmt->execute();
    // $result = $stmt->get_result();
    // $event = $result->fetch_assoc();

    // if (!$event) {
    //     die("Event not found!");
    // }
if(isset($paymentId)&&isset($orderId)){
    $paymentstatus="success";

}
else{
    $paymentstatus="failed";
}
    $sql = "INSERT INTO consultations (name, date, time, category, message,payment_status,payment_id,razorpay_order_id,location,country,phone,email,amount) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare the statement
    $stmt = $conn->prepare($sql);
    
    // Bind the parameters and execute the statement
    $stmt->bind_param("ssssssssssssd", $username, $date, $time, $categorylist,$message,$paymentstatus,$paymentId,$orderId,$location,$country, $phone,$email,$amountPaid);
    $stmt->execute();

    // if (!$stmt->execute()) {
    //     die("Failed to store booking details: " . $stmt->error);
    // }
    if ($stmt->affected_rows > 0) {
        // If consultation booked successfully, mark the slot as booked
        $updateQuery = "UPDATE available_slots SET is_booked = TRUE WHERE date = ? AND time = ?";
        $updateStmt = $conn->prepare($updateQuery);
    
        if (!$updateStmt) {
            die("Error preparing update statement: " . $conn->error);
        }
    
        // Bind the parameters
        if (!$updateStmt->bind_param("ss", $date, $time)) {
            die("Error binding parameters in update query: " . $updateStmt->error);
        }
    
        // Execute the statement
        if (!$updateStmt->execute()) {
            die("Error executing update query: " . $updateStmt->error);
        }
    
        // Check if the slot was updated
        if ($updateStmt->affected_rows > 0) {
            echo "Slot successfully marked as booked.";
        } else {
            echo "No slot was updated. Please check if the date and time match any available slots.";
        }
    
        $updateStmt->close();
    } 


else {
    echo "Error: " . $stmt->error;
}

// }
    $smsBody = "Booking Confirmed!\nConsultation Confirmation: ". "\nDate: " . htmlspecialchars($date) . "\nTime: " . htmlspecialchars($time) ."\nConsultation Category: " . htmlspecialchars($categorylist) . "\nName: " . htmlspecialchars($username) . "\nAmount Paid: ₹500" .  "\nEmail: " . htmlspecialchars($email). "\nPhone: " . htmlspecialchars($phone)  ."\nLocation: " . htmlspecialchars($location). "\nCountry: " . htmlspecialchars($country). "\nMessage: " . htmlspecialchars($message);

 // Send SMS via Twilio
//  $twilio->messages->create(
    // $phone, 
    // User's phone number
    // [
        // 'from' => $twilio_phone_number,
        // 'body' => $smsBody
    // ]
// );
    // Generate ticket PDF
    $pdf = new FPDF();
    $pdf->AddPage();

    // Title
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Consultation Confirmation', 0, 1, 'C');
    $pdf->Ln(10);

    // Event Details
    $pdf->SetFont('Arial', '', 12);
    

    $pdf->Ln(5);
    $pdf->Cell(50, 10, 'Name:', 0, 0);
    $pdf->Cell(0, 10, htmlspecialchars($username), 0, 1);
    $pdf->Cell(50, 10, 'Email:', 0, 0);
    $pdf->Cell(0, 10, htmlspecialchars($email), 0, 1);
    $pdf->Cell(50, 10, 'Phone:', 0, 0);
    $pdf->Cell(0, 10, htmlspecialchars($phone), 0, 1);
    $pdf->Cell(50, 10, 'Consultation Category:', 0, 0);
    $pdf->Cell(0, 10, htmlspecialchars($categorylist), 0, 1);
    $pdf->Cell(50, 10, 'Location:', 0, 0);
    $pdf->Cell(0, 10, htmlspecialchars($location), 0, 1);
    $pdf->Cell(50, 10, 'Country:', 0, 0);
    $pdf->Cell(0, 10, htmlspecialchars($country), 0, 1);
    $pdf->Cell(50, 10, 'Message:', 0, 0);
    $pdf->Cell(0, 10, htmlspecialchars($message), 0, 1);
    $pdf->Cell(50, 10, 'Date:', 0, 0);
    $pdf->Cell(0, 10, htmlspecialchars($date), 0, 1);
    $pdf->Cell(50, 10, 'Time:', 0, 0);
    $pdf->Cell(0, 10, htmlspecialchars($time), 0, 1);
    $pdf->Cell(50, 10, 'Amount Paid:', 0, 0);
    $pdf->Cell(0, 10, '₹ INR :500', 0, 1);
    $pdf->Cell(50, 10, 'Payment Id:', 0, 0);
    $pdf->Cell(0, 10,  htmlspecialchars($paymentId), 0, 1);
    $pdf->Cell(50, 10, 'Booking Id:', 0, 0);
    $pdf->Cell(0, 10,  htmlspecialchars($orderId), 0, 1);

    $pdf->Ln(10);
    $pdf->Cell(0, 10, 'Thank you for booking with us! keep safe of your PaymentId & BookingId ', 0, 1, 'C');

   // Generate a unique ticket file name using the payment ID and timestamp
$uniqueFileName = 'ticket_' . $paymentId . '_' . time() . '.pdf';
$filePath = __DIR__ . '/tickets/' . $uniqueFileName;
$pdf->Output('F', $filePath);
if (file_exists($filePath)) {
    echo "
    <div class='card'>
        <h2>Consultation Booking Confirmed!</h2>
        <p>Your Consultation Confirmation  has been successfully generated.</p>
        <p class='caution'>⚠️ Caution: After clicking the download button, the ticket page will close in 2 seconds. Please make sure to download your ticket.</p>
        <a href='tickets/" . $uniqueFileName . "' target='_blank' onclick='delayedClearForm()' class='btn'>Download Ticket</a>
    </div>";
} else {
    echo "<p class='error'>Ticket generation failed. Please try again.</p>";
}

} catch (\Exception $e) {
    die("Payment verification failed: " . $e->getMessage());
}

$mail = new PHPMailer(true);

try {
    // Configure the mailer
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'kadhirdj007@gmail.com'; // Your email address
    $mail->Password = 'sgwl itif lhwf efdu'; // Your email password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Set email parameters
    $mail->setFrom('kadhirdj007@gmail.com', 'Event Organizer'); // Replace with sender details
    $mail->addAddress($email, $username); // Recipient's email and name

    // Attach the generated PDF
    $mail->addAttachment($filePath, 'EventTicket.pdf');

    // Email content
    $mail->isHTML(true);
    $mail->Subject =    'Consultation Confirmation Mail';
    $mail->Body = "
        <h2>Booking Confirmed!</h2>
        <p>Thank you for booking with us. Please find your attachment.</p>
        <p><strong>Name:</strong> " . htmlspecialchars($username) . "</p>
         <p><strong>Phone:</strong> " . htmlspecialchars($phone) . "</p>
          <p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>
        <p><strong>Location:</strong> " . htmlspecialchars($location) . "</p>
        <p><strong>Time:</strong> " . htmlspecialchars($time) . "</p>
        <p><strong>date:</strong> " . htmlspecialchars($date) . "</p>
        <p><strong>Amount Paid:</strong> ₹ 500</p>
      
        <p>Keep safe of your Payment ID and Booking ID for future reference.</p>
    ";

    // Send the email
    $mail->send();
    // echo "<p>Email sent successfully with the ticket attached!</p>";
} catch (Exception $e) {
    echo "<p class='error'>Failed to send email: {$mail->ErrorInfo}</p>";
}

?>
<style>
    .card {
    width: 90%;
    max-width: 400px;
    margin: 20px auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    background-color: #fff;
    text-align: center;
}

.card h2 {
    margin-bottom: 10px;
    color: #333;
    font-size: 24px;
}

.card p {
    font-size: 16px;
    color: #555;
    margin-bottom: 15px;
}

.card .caution {
    color: #d9534f;
    font-weight: bold;
    font-size: 14px;
    margin-bottom: 20px;
}

.card .btn {
    display: inline-block;
    padding: 10px 20px;
    font-size: 16px;
    font-weight: bold;
    color: #fff;
    background-color: #007bff;
    border: none;
    border-radius: 5px;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.card .btn:hover {
    background-color: #0056b3;
}

.error {
    color: #d9534f;
    text-align: center;
    font-size: 16px;
}

</style>
<script>
     function delayedClearForm() {
        // Wait for the navigation to complete, then call clearform
        setTimeout(() => {
            clearform();
        }, 2000); // Adjust the delay (in milliseconds) if necessary
    }
    function clearform(){
       
        
            window.location.href = `booking.php`;
       
    }
    
</script>