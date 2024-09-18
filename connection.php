<?php
session_start(); // Ensure session is started
// Database credentials
$host = 'localhost';   // Hostname (usually localhost)
$dbname = 'decorvista_db';  // Name of the database
$username = 'root';    // Database username (default for XAMPP is root)
$password = '';        // Database password (default for XAMPP is empty)

// Creating a connection
$con = new mysqli($host, $username, $password, $dbname);

// Checking the connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

echo "Connected successfully!";
?>
