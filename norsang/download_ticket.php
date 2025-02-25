<?php
// Get ticket ID from URL
$ticket_id = $_GET['ticket_id'];

// Retrieve ticket information (file path) from the database
// Example: SELECT * FROM tickets WHERE ticket_id = '$ticket_id'

// Send file for download
$ticket_file = 'tickets/ticket_' . $ticket_id . '.pdf'; // Path to the ticket

if (file_exists($ticket_file)) {
    // Set headers for file download
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="ticket_' . $ticket_id . '.pdf"');
    header('Content-Length: ' . filesize($ticket_file));
    readfile($ticket_file);
    exit;
} else {
    echo "Ticket not found!";
}
?>
