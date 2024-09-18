<?php
// Include database connection
include '../connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $contact = mysqli_real_escape_string($con, $_POST['contact']); // New contact field
    $role = mysqli_real_escape_string($con, $_POST['role']);
    
    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // SQL query to insert user data into the users table
    $sql = "INSERT INTO users (username, email, password, contact, role, created_at)
            VALUES ('$username', '$email', '$hashed_password', '$contact', '$role', NOW())";
    
    // Try to execute the query
    try {
        $con->query($sql);
        // If successful, redirect to users.php
        header("Location: users.php");
        exit();
    } catch (mysqli_sql_exception $e) {
        // If there's a duplicate email error
        if ($e->getCode() == 1062) {
            // Set session variable for duplicate email error
            $_SESSION['error'] = "Email already exists!";
            // Redirect back to users.php
            header("Location: users.php");
            exit();
        } else {
            // Handle other possible SQL errors
            echo "Error: " . $e->getMessage();
        }
    }
    
    // Close the database connection
    $con->close();
}
?>
