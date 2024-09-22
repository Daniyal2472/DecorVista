<?php

// Include database connection file
include 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the submitted form data
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $contact = $_POST['contact'];
    $portfolio_url = $_POST['portfolio_url'];
    $years_of_experience = $_POST['years_of_experience'];
    $specialization = $_POST['specialization'];

    // Update query
    $sql = "UPDATE users SET 
            email = ?, 
            first_name = ?, 
            last_name = ?, 
            contact = ?, 
            portfolio_url = ?, 
            years_of_experience = ?, 
            specialization = ? 
            WHERE username = ?";

    // Prepare the statement
    if ($stmt = $con->prepare($sql)) {
        $stmt->bind_param(
            "ssssssss", 
            $email, $first_name, $last_name, $contact, $portfolio_url, $years_of_experience, $specialization, $_SESSION['username']
        );

        // Execute the statement
        if ($stmt->execute()) {
            // Update session variables
            $_SESSION['email'] = $email;
            $_SESSION['first_name'] = $first_name;
            $_SESSION['last_name'] = $last_name;
            $_SESSION['contact'] = $contact;
            $_SESSION['portfolio_url'] = $portfolio_url;
            $_SESSION['years_of_experience'] = $years_of_experience;
            $_SESSION['specialization'] = $specialization;

         
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }


}
?>
<!-- Add custom styling -->
<style>
    /* Ensure the entire page takes up the full height */
    html, body {
        height: 100%;
        margin: 0;
        font-family: 'Poppins', sans-serif; /* Modern font choice */
        background: linear-gradient(135deg, #e09, #ff9); /* Background gradient */
    }

    .content {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh; /* Full viewport height */
        margin: 0; /* Reset default margins */
        padding-left: 350px;
        height: 100%;
        padding-top: 20px;
        padding-bottom: 15px;
    }

    .profile-card {
        width: 100%;
        max-width: 500px; /* Smaller card size */
        background-color: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2); /* Stylish shadow */
        padding: 20px;
        transition: transform 0.3s ease; /* Add smooth hover effect */
        height: 100%;
        padding-top: 20px;
        padding-bottom: 15px;
    }

    .profile-card:hover {
        transform: translateY(-10px); /* Lift card on hover */
    }

    .card-primary.card-outline {
        border: none; /* Remove outline border for a clean look */
    }

    .profile-user-img {
        border-radius: 50%;
        border: 4px solid #007bff;
        width: 120px;
        height: 120px; /* Smaller image */
        object-fit: cover;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2); /* Add shadow to image */
    }

    .profile-username {
        font-weight: bold;
        color: #222;
        font-size: 1.5rem;
        margin-top: 10px;
    }

    .text-muted {
        font-size: 0.9rem;
        color: #888;
        margin-bottom: 20px;
    }

    .list-group-item {
        border: none;
        padding: 10px 0;
        font-size: 1rem;
        color: #555;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .list-group-item b {
        color: #007bff;
        margin-right: 10px;
    }

    .form-control {
        border-radius: 5px;
        border: 1px solid #ddd;
        width: 65%;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        border-radius: 50px;
        padding: 10px 20px;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    /* Customize the floating numbers */
    .float-right {
        color: #222;
        font-weight: bold;
    }

    /* Add a subtle effect to the Follow button */
    .btn-primary {
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
    }
</style>

<!-- Main content -->
<section class="content">
  <div class="profile-card">
    <!-- Profile Image -->
    <div class="text-center">
      <img class="profile-user-img img-fluid img-circle" src="uploads/profile_pictures/<?php echo $_SESSION['profile_photo']; ?>" alt="Profile Image">
    </div>

    <h3 class="profile-username text-center"><?php echo $_SESSION['username']; ?></h3>
    <p class="text-muted text-center"><?php echo $_SESSION['role']; ?></p>

    <!-- Display update message -->
    <?php if (isset($update_message)): ?>
      <div class="alert alert-info"><?php echo $update_message; ?></div>
    <?php endif; ?>

    <!-- Form for editing profile fields -->
    <form action="" method="POST"> 
      <ul class="list-group list-group-unbordered mb-3">
        <li class="list-group-item">
          <b>Email:</b>
          <input type="email" class="form-control" name="email" value="<?php echo $_SESSION['email']; ?>" required>
        </li>
        <li class="list-group-item">
          <b>First Name:</b>
          <input type="text" class="form-control" name="first_name" value="<?php echo $_SESSION['first_name']; ?>" required>
        </li>
        <li class="list-group-item">
          <b>Last Name:</b>
          <input type="text" class="form-control" name="last_name" value="<?php echo $_SESSION['last_name']; ?>" required>
        </li>
        <li class="list-group-item">
          <b>Phone no:</b>
          <input type="text" class="form-control" name="contact" value="<?php echo $_SESSION['contact']; ?>" required>
        </li>
        <li class="list-group-item">
          <b>Portfolio URL:</b>
          <input type="url" class="form-control" name="portfolio_url" value="<?php echo $_SESSION['portfolio_url']; ?>" required>
        </li>
        <li class="list-group-item">
          <b>Experience:</b>
          <input type="number" class="form-control" name="years_of_experience" value="<?php echo $_SESSION['years_of_experience']; ?>" required>
        </li>
        <li class="list-group-item">
          <b>Specialization:</b>
          <input type="text" class="form-control" name="specialization" value="<?php echo $_SESSION['specialization']; ?>" required>
        </li>
      </ul>
      <button type="submit" class="btn btn-primary btn-block">Update Profile</button>
    </form>
  </div>
</section>


<?php
include 'includes/footer.php';
?>
