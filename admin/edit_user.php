<?php
include '../connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $contact = mysqli_real_escape_string($con, $_POST['contact']); // New contact field
    $role = mysqli_real_escape_string($con, $_POST['role']);
    
    // Hash the password if provided
    $hashed_password = !empty($password) ? password_hash($password, PASSWORD_DEFAULT) : null;

    // SQL query to update user data
    $sql = "UPDATE users SET username = '$username', email = '$email', contact = '$contact', role = '$role'"; // Include contact in the update query
    
    if ($hashed_password) {
        $sql .= ", password = '$hashed_password'";
    }

    $sql .= " WHERE user_id = '$user_id'";

    // Execute the query
    if ($con->query($sql) === TRUE) {
        $_SESSION['message'] = "User updated successfully!";
    } else {
        $_SESSION['error'] = "Error updating user: " . $con->error;
    }

    // Redirect to users.php
    header("Location: users.php");
    exit();
}
?>
