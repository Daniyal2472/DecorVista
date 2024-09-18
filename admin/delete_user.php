<?php
// Start session and include database connection
session_start();
include '../connection.php';

// Check if the user_id is received from the form
if (isset($_POST['user_id'])) {
    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);
    
    // SQL query to delete the user
    $sql = "DELETE FROM users WHERE user_id = '$user_id'";
    
    if ($con->query($sql) === TRUE) {
        // Redirect to users.php with a success message
        $_SESSION['message'] = "User deleted successfully!";
        header("Location: users.php");
        exit();
    } else {
        // Handle error
        $_SESSION['error'] = "Error deleting user: " . $con->error;
        header("Location: users.php");
        exit();
    }
} else {
    $_SESSION['error'] = "Invalid request!";
    header("Location: users.php");
    exit();
}

// Close the database connection
$con->close();
?>
