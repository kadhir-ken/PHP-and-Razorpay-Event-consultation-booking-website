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
$seats =       $_GET['seats']  ?? null  ;
$amountPaid =  $_GET['totalamount'] ?? null  ;
$eventId =     $_GET['event_id']?? null;
$location =     $_GET['location']?? null;

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
    $sql = "SELECT title, event_date,location ,time,seats_available FROM events WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $eventId);
    $stmt->execute();
    $result = $stmt->get_result();
    $event = $result->fetch_assoc();

    if (!$event) {
        die("Event not found!");
    }
    
if(isset($paymentId)&&isset($orderId)){
    $paymentstatus="success";

}
else{
    $paymentstatus="failed";
}

    // Insert booking details into the database
    $sql_insert = "INSERT INTO bookings (event_id, user_name, email, phone, seats_selected, total_amount,payment_status,payment_id,order_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("issssdsss", $eventId, $username, $email, $phone, $seats, $amountPaid,$paymentstatus,$paymentId,$orderId);
    if (!$stmt_insert->execute()) {
        die("Failed to store booking details: " . $stmt_insert->error);
    }
    $smsBody = "Booking Confirmed!\nEvent: " . htmlspecialchars($event['title']) . "\nDate: " . htmlspecialchars($event['event_date']) . "\nTime: " . htmlspecialchars($event['time']) ."\nLocation".htmlspecialchars($event['location']). "\nSeats: " . htmlspecialchars($seats) . "\nAmount Paid: ₹" . htmlspecialchars($amountPaid). "\nName: ₹" . htmlspecialchars($username). "\nEmail: ₹" . htmlspecialchars($email). "\nPhone: ₹" . htmlspecialchars($phone);

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
    $pdf->Cell(0, 10, 'Norsang Event Ticket', 0, 1, 'C');
    $pdf->Ln(10);

    // Event Details
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(50, 10, 'Event:', 0, 0);
    $pdf->Cell(0, 10, htmlspecialchars($event['title']), 0, 1);
    $pdf->Cell(50, 10, 'Date:', 0, 0);
    $pdf->Cell(0, 10, htmlspecialchars($event['event_date']), 0, 1); // Replace with actual date if available
    $pdf->Cell(50, 10, 'Location:', 0, 0);
    $pdf->Cell(0, 10, htmlspecialchars($event['location']), 0, 1); // Replace with actual date if available
    $pdf->Cell(50, 10, 'Time:', 0, 0);
    $pdf->Cell(0, 10, htmlspecialchars($event['time']), 0, 1); // Replace with actual time if available
    $pdf->Ln(5);
    $pdf->Cell(50, 10, 'Name:', 0, 0);
    $pdf->Cell(0, 10, htmlspecialchars($username), 0, 1);
    $pdf->Cell(50, 10, 'Email:', 0, 0);
    $pdf->Cell(0, 10, htmlspecialchars($email), 0, 1);
    $pdf->Cell(50, 10, 'Phone:', 0, 0);
    $pdf->Cell(0, 10, htmlspecialchars($phone), 0, 1);
    $pdf->Cell(50, 10, 'Seats Booked:', 0, 0);
    $pdf->Cell(0, 10, htmlspecialchars($seats), 0, 1);
    $pdf->Cell(50, 10, 'Amount Paid:', 0, 0);
    $pdf->Cell(0, 10, '₹ INR :' . htmlspecialchars($amountPaid), 0, 1);
    $pdf->Cell(50, 10, 'Payment Id:', 0, 0);
    $pdf->Cell(0, 10,  htmlspecialchars($paymentId), 0, 1);
    // $pdf->Cell(50, 10, 'Booking Id:', 0, 0);
    // $pdf->Cell(0, 10,  htmlspecialchars($orderId), 0, 1);

    $pdf->Ln(10);
    $pdf->Cell(0, 10, 'Thank you for booking with us! keep safe of your PaymentId & BookingId ', 0, 1, 'C');

   // Generate a unique ticket file name using the payment ID and timestamp
$uniqueFileName = 'ticket_' . $paymentId . '_' . time() . '.pdf';
$filePath = __DIR__ . '/tickets/' . $uniqueFileName;
$pdf->Output('F', $filePath);
if (file_exists($filePath)) {
    echo "
    <div class='card'>
        <h2>Booking Confirmed!</h2>
        <p>Your ticket has been successfully generated.</p>
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
    $mail->Subject = 'Your Event Ticket';
    $mail->Body = "
        <h2>Booking Confirmed!</h2>
        <p>Thank you for booking with us. Please find your event ticket attached.</p>
        <p><strong>Event:</strong> " . htmlspecialchars($event['title']) . "</p>
        <p><strong>Date:</strong> " . htmlspecialchars($event['event_date']) . "</p>
        <p><strong>Time:</strong> " . htmlspecialchars($event['time']) . "</p>
        <p><strong>Seats:</strong> " . htmlspecialchars($seats) . "</p>
        <p><strong>Amount Paid:</strong> ₹" . htmlspecialchars($amountPaid) . "</p>
        <p>Keep safe of your Payment ID and Booking ID for future reference.</p>
        <a href='http://localhost/norsang/norsang/norsang/cancel.php' style='padding:10px;border:1px solid black;color:black;border-radius:12px;'>Cancel and Refund</a>
    ";

    // Send the email
    $mail->send();
    // echo "<p>Email sent successfully with the ticket attached!</p>";
} catch (Exception $e) {
    echo "<p class='error'>Failed to send email: {$mail->ErrorInfo}</p>";
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
        const eventid=<?= json_encode($eventId) ?>;
        if (eventid) {
            window.location.href = `bookevent.php?event_id=${eventid}`;
        }
    }
    
</script>