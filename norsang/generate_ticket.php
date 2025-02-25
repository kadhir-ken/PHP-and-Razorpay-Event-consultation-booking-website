<?php
session_start();
require('fpdf/fpdf.php');
require_once 'config.php'; // Database connection

// Decode Razorpay response
$data = json_decode(file_get_contents('php://input'), true);

// Validate Razorpay payment
$payment_id = $data['razorpay_payment_id'] ?? null;
$order_id = $data['razorpay_order_id'] ?? null;
$signature = $data['razorpay_signature'] ?? null;

// Assume successful payment validation for simplicity
if ($payment_id && $order_id) {
    // Generate ticket PDF
    $user_name = $_SESSION['user'];
    $email = $_SESSION['email'];
    $phone = $_SESSION['phone'];
    $seats_selected = $_SESSION['seats'];
    $total_amount = $_SESSION['amount'];
    $event_title = 'Sample Event'; // Replace with actual event title from the database
    
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Event Ticket', 0, 1, 'C');
    $pdf->Ln(10);

    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(50, 10, 'Event:', 0, 0);
    $pdf->Cell(0, 10, htmlspecialchars($event_title), 0, 1);
    $pdf->Cell(50, 10, 'Name:', 0, 0);
    $pdf->Cell(0, 10, htmlspecialchars($user_name), 0, 1);
    $pdf->Cell(50, 10, 'Email:', 0, 0);
    $pdf->Cell(0, 10, htmlspecialchars($email), 0, 1);
    $pdf->Cell(50, 10, 'Seats:', 0, 0);
    $pdf->Cell(0, 10, htmlspecialchars($seats_selected), 0, 1);
    $pdf->Cell(50, 10, 'Total Amount:', 0, 0);
    $pdf->Cell(0, 10, '₹' . ($total_amount / 100), 0, 1);

    $ticket_id = time(); // Use a unique identifier for the ticket
    $filePath = __DIR__ . '/tickets/ticket_' . $ticket_id . '.pdf';
    $pdf->Output('F', $filePath);

    // Return download link
    echo json_encode([
        "success" => true,
        "download_link" => "tickets/ticket_" . $ticket_id . ".pdf"
    ]);
    exit;
}

echo json_encode(["success" => false]);
exit;
?>
