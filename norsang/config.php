<?php
$host = "localhost"; // Database host
$username = "root"; // Database username
$password = "Bhaimere@2003"; // Database password (use your password)
$database = "norsang"; // Database name

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
