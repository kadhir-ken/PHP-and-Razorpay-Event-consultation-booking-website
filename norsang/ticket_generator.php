<?php
// Function to generate the ticket
function generateTicket($seats, $email) {
    // Generate a unique ticket ID
    $ticket_id = uniqid();
    $ticket_filename = "ticket_$ticket_id.pdf";
    $ticket_path = 'tickets/' . $ticket_filename;

    // Logic to generate and save the ticket (using a library like TCPDF, FPDF, etc.)
    // Example: using FPDF to generate a simple PDF ticket

    require_once('fpdf.php');  // Include the FPDF library (or any PDF library you use)

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(40, 10, 'Ticket for ' . $email);
    $pdf->Ln(10);
    $pdf->Cell(40, 10, "Seats Booked: " . $seats);
    $pdf->Output('F', $ticket_path); // Save the PDF to the 'tickets' directory

    // Optionally, store ticket information in the database (if required)
    // Example: INSERT INTO tickets (ticket_id, email, seats, file_path) VALUES ('$ticket_id', '$email', '$seats', '$ticket_path');

    // Return the ticket ID for later use
    return $ticket_id;
}
?>
