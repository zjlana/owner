<?php
// Include the database connection file
include 'connection.php';

// Start a session (if not already started)
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

// Logout functionality
if (isset($_GET['log-out'])) {
  // Unset all session variables and destroy the session
  session_unset();
  session_destroy();

  // Redirect back to login page after logout
  header("Location: index.php");
  exit;
}

// Check if the user is NOT logged in
if (isset($_SESSION['username'])) {
  // User is logged in, perform actions here
  $username = $_SESSION['username'];
  
} else {
// Redirect to the login page if the user is not logged in
  header("Location: index.php");
  exit();
}
