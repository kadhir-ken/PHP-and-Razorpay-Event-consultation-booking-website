<?php
session_start();
require_once "config.php"; // Include database connection file

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_username = $_POST['username'];
    $admin_password = $_POST['password'];

    // SQL query to check admin credentials
    $sql = "SELECT * FROM admin WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $admin_username, $admin_password);
    $stmt->execute();
    $result = $stmt->get_result();

    // If credentials are correct
    if ($result->num_rows == 1) {
        $_SESSION['admin'] = $admin_username; // Store username in session
        header("Location: addbook.php"); // Redirect to addbook.php
        exit();
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NORSANG-HOME</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    /* General Styles */
 
  .admin_sec{
    margin: 20px;
    padding: 30px;

  }
 /* Admin Form */
 .admin_form {
  width: 90%;
  max-width: 400px;
  background-color: #fff;
  margin: 50px auto;
  padding: 30px;
  border: 1px solid #ddd;
  border-radius: 8px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}

.admin_form h2 {
  text-align: center;
  margin-bottom: 20px;
  color: #333;
}

.admin_form label {
  display: block;
  margin-bottom: 8px;
  font-weight: bold;
}

.admin_form input {
  width: 100%;
  padding: 8px;
  margin-bottom: 15px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 1em;
}

.admin_form button {
  width: 100%;
  padding: 10px;
  background-color: #333;
  color: white;
  border: none;
  border-radius: 4px;
  font-size: 1.1em;
  cursor: pointer;
  transition: background-color 0.3s;
}

.admin_form button:hover {
  background-color: #ff7f50;
}

p {
  text-align: center;
}

.password-container {
    position: relative;
    width: 100%;
}

.password-container input {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 1em;
}

.eye-icon {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    font-size: 1.5em;
    color: #333;
}

.eye-icon:hover {
    color: #ff7f50;
}


  </style>
</head>


  <!-- Navigation Bar -->
   
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
      </ul>
    
    </nav>
  </header>
  <body>  
    <section class="admin_sec">
   
    <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
    <form method="POST" action="admin.php" class="admin_form">
       <h2>Admin Login</h2>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Password:</label>
    <div class="password-container">
        <input type="password" id="password" name="password" required>
        <span id="toggle-password" class="eye-icon">&#128065;</span>
    </div>
        <button type="submit">Login</button>
    </form>
    </section>

    
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
  <script src="script.js"></script>
</body>
</html>
