<?php
include __DIR__ . '/../connection.php';

if (isset($_POST['registerDesigner'])) {
  // Retrieve form data and sanitize inputs
  $username = htmlspecialchars($_POST['username']);
  $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
  $firstName = htmlspecialchars($_POST['firstName']);
  $lastName = htmlspecialchars($_POST['lastName']);
  $contact = htmlspecialchars($_POST['contact']);
  $experience = (int)$_POST['experience'];
  $specialization = htmlspecialchars($_POST['specialization']);
  $portfolio = filter_var($_POST['portfolio'], FILTER_VALIDATE_URL);
  $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Secure password hashing
  $role = 'Designer';

  // Profile Photo Upload Handling
  if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] == 0) {
      $uploadDir = __DIR__ . '/../admin/uploads/';
      $profilePicsDir = $uploadDir . 'profile_pictures/'; // Additional folder for profile pictures

      // Check if uploads and profile_pictures directories exist, if not, create them
      if (!is_dir($uploadDir)) {
          mkdir($uploadDir, 0755, true); // Create the uploads directory if it doesn't exist
      }
      if (!is_dir($profilePicsDir)) {
          mkdir($profilePicsDir, 0755, true); // Create the profile_pictures directory
      }

      $fileName = basename($_FILES['profile_photo']['name']);
      $targetFile = $profilePicsDir . $fileName;

      // Check if the file is a valid image
      $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
      $validExtensions = array("jpg", "jpeg", "png", "gif");

      if (in_array($fileType, $validExtensions)) {
          // Move the file to the profile_pictures directory
          if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $targetFile)) {
              $profilePhotoPath = 'admin/uploads/profile_pictures/' . $fileName; // Save relative path
          } else {
              echo "<script>alert('Error uploading the profile photo.');</script>";
              exit;
          }
      } else {
          echo "<script>alert('Only JPG, JPEG, PNG, and GIF files are allowed.');</script>";
          exit;
      }
  } else {
      echo "<script>alert('Please upload a profile photo.');</script>";
      exit;
  }

  // Check if username or email already exists
  $check_sql = "SELECT * FROM users WHERE username = ? OR email = ?";
  $stmt_check = $con->prepare($check_sql);
  $stmt_check->bind_param("ss", $username, $email);
  $stmt_check->execute();
  $result = $stmt_check->get_result();

  if ($result->num_rows > 0) {
      echo "<script>alert('Username or Email already exists. Please choose another.');</script>";
  } else {
      // Insert query with the profile photo path
      $sql = "INSERT INTO `users` (`username`, `email`, `first_name`, `last_name`, `contact`, `password`, `role`, `portfolio_url`, `years_of_experience`, `specialization`, `profile_photo`) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

      $stmt = $con->prepare($sql);
      $stmt->bind_param(
          "ssssssssiss", 
          $username, 
          $email, 
          $firstName, 
          $lastName, 
          $contact, 
          $password, 
          $role, 
          $portfolio, 
          $experience, 
          $specialization, 
          $fileName
      );

      if ($stmt->execute()) {
          echo "<script>alert('Designer registered successfully!');</script>";
          echo "<script>window.location.href='login.php';</script>";
      } else {
          echo "Error: " . $stmt->error;
      }

      $stmt->close();
  }

  $stmt_check->close();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DecorVista</title>
  <!-- slider stylesheet -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css" />
  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Poppins:400,700&display=swap" rel="stylesheet">
  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<style>
  /* login  */
@import url("https://fonts.googleapis.com/css2?family=Open+Sans:wght@200;300;400;500;600;700&display=swap");

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Open Sans", sans-serif;
}

body {
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
  width: 100%;
  padding: 0 10px;
  background: rgba(0, 0, 0, 0.6);
}

body::before {
  content: "";
  position: absolute;
  width: 100%;
  height: 1000px;
  background: url("https://img.freepik.com/premium-psd/living-room-wall-mockup-psd-modern-interior-design_53876-130139.jpg") no-repeat center center/cover;
  filter: blur(4px) brightness(50%);
  z-index: -1;
}

.wrapper {
  width: 400px;
  background: rgba(255, 255, 255, 0.1);
  border-radius: 12px;
  padding: 30px;
  text-align: center;
  border: 3px solid #24d278;
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
  position: relative;
  margin: 50px auto; /* Adds space at the top and bottom */
}

form {
  display: flex;
  flex-direction: column;
}

h2 {
  font-size: 2.5rem;
  margin-bottom: 20px;
  color: #000000;
  letter-spacing: 1px;
}

.input-field {
  position: relative;
  border-bottom: 2px solid #000000;
  margin: 15px 0;
}

.input-field label {
  position: absolute;
  top: 50%;
  left: 0;
  transform: translateY(-50%);
  color: #000000;
  font-size: 16px;
  pointer-events: none;
  transition: 0.3s ease;
}

.input-field input {
  width: 100%;
  height: 40px;
  background: transparent;
  border: none;
  outline: none;
  font-size: 16px;
  color: #000000;
}

.input-field input:focus~label,
.input-field input:valid~label {
  font-size: 0.8rem;
  top: 10px;
  transform: translateY(-120%);
}

.forget {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin: 25px 0 35px 0;
  color: #000000;
}

#remember {
  accent-color: #24d278;
}

.forget label {
  display: flex;
  align-items: center;
}

.forget label p {
  margin-left: 8px;
}

.wrapper a {
  color: #000000;
  text-decoration: none;
}

.wrapper a:hover {
  text-decoration: underline;
}

button {
  background: #24d278;
  color: #000000;
  font-weight: 600;
  border: none;
  padding: 12px 20px;
  cursor: pointer;
  border-radius: 3px;
  font-size: 16px;
  border: 2px solid transparent;
  transition: 0.3s ease;
  
}

button:hover {
  color: #24d278;
  border-color: #000000;
  background: #000000;
}

.register {
  text-align: center;
  margin-top: 30px;
  color: #000000;
}
.pr-5 {
  text-align: left;
}

</style>
<body>
  <div class="wrapper">
  <form id="designerForm" method="POST" action="" enctype="multipart/form-data">
      <h2>DESIGNER FORM </h2>

      <!-- Username -->
      <div class="input-field">
        <input type="text" id="username" name="username" required pattern="[A-Za-z0-9]+" title="Username should only contain letters and numbers">
        <label><i class="fas fa-user"></i> Username</label>
      </div>

      <!-- First Name -->
      <div class="input-field">
        <input type="text" id="firstName" name="firstName" required pattern="[A-Za-z\s]+" title="First Name should only contain letters and spaces">
        <label><i class="fas fa-user"></i> First Name</label>
      </div>

      <!-- Last Name -->
      <div class="input-field">
        <input type="text" id="lastName" name="lastName" required pattern="[A-Za-z\s]+" title="Last Name should only contain letters and spaces">
        <label><i class="fas fa-user"></i> Last Name</label>
      </div>

      <!-- Email -->
      <div class="input-field">
        <input type="email" id="email" name="email" required>
        <label><i class="fas fa-envelope"></i> Email</label>
      </div>

      <!-- Contact Number -->
      <div class="input-field">
        <input type="tel" id="contact" name="contact" required pattern="^\d{10}$" title="Please enter a valid 10-digit phone number">
        <label><i class="fas fa-phone"></i> Contact Number</label>
      </div>

      <!-- Profile Photo -->
  <label class="pr-5"><i class="fas fa-user"></i> Profile Photo</label>
  <div class="input-field">
    <input type="file" id="profile_photo" name="profile_photo" accept="image/*" required>
  </div>

      <!-- Years of Experience -->
      <div class="input-field">
        <input type="number" id="experience" name="experience" required min="0" max="50">
        <label><i class="fas fa-calendar"></i> Years of Experience</label>
      </div>

      <!-- Specialization -->
      <div class="input-field">
        <input type="text" id="specialization" name="specialization" required>
        <label><i class="fas fa-certificate"></i> Specialization</label>
      </div>

      <!-- Portfolio -->
      <div class="input-field">
        <input type="url" id="portfolio" name="portfolio" required pattern="https?://.+" title="Please enter a valid URL">
        <label><i class="fas fa-briefcase"></i> Portfolio (URL)</label>
      </div>

      <!-- Password -->
      <div class="input-field">
        <input type="password" id="password" name="password" required minlength="8">
        <label><i class="fas fa-lock"></i> Password</label>
      </div>

      <button type="submit" name="registerDesigner" class="mt-3">Register</button>
      <p class="pt-3">Do you have an account? <a href="login.php">Login</a></p>

    </form>
  </div>

  <script>
    document.getElementById('designerForm').addEventListener('submit', function(event) {
      let valid = true;
      
      // Custom validations
      const contactInput = document.getElementById('contact');
      if (!/^\d{10}$/.test(contactInput.value)) {
        alert('Please enter a valid 10-digit contact number');
        valid = false;
      }
      
      const portfolioInput = document.getElementById('portfolio');
      if (!/^https?:\/\/.+$/.test(portfolioInput.value)) {
        alert('Please enter a valid portfolio URL (starting with http or https)');
        valid = false;
      }

      if (!valid) {
        event.preventDefault(); // Prevent form submission if validation fails
      }
    });
  </script>
</body>
</html>
 