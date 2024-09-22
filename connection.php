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

// Handling the login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare the SQL statement to check the credentials
    $stmt = $con->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // If a user with the given email is found
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc(); // Fetch the entire row as an associative array

        // Verifying the password
        if (password_verify($password, $user['password'])) {
            // Loop through each value and store it in the session
            foreach ($user as $key => $value) {
                $_SESSION[$key] = $value; // Store each column's value in session
            }

            // Redirect based on user role
            if ($user['role'] == 'Designer' || $user['role'] == 'Admin') {
                echo "<script>window.location.href='/DecorVista/admin/index.php';</script>";
            } else if ($user['role'] == 'User'){
                echo "<script>window.location.href='/DecorVista/decorvista/index.php';</script>";
            }
            exit();
        } else {
            echo "<script>alert('Incorrect password. Please try again.');</script>";
            echo "<script>window.location.href='/DecorVista/decorvista/login.php';</script>";
        }
    } else {
        echo "<script>alert('No user found with this email.');</script>";
    }

    $stmt->close();
}
?>
