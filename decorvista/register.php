<?php
include __DIR__ . '/../connection.php';

// Handling form submission
if (isset($_POST['registerUser'])) {
    // Get user inputs
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $userName = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate the inputs
    if (empty($firstName) || empty($lastName) || empty($userName) || empty($email) || empty($password)) {
        echo "<script>alert('Please fill all fields.');</script>";
    } else {
        // Check if the email already exists
        $stmt = $con->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('Email already registered. Please use another email.');</script>";
        } else {
            // Hash the password for security
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Profile Photo Upload Handling
            if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] == 0) {
                $uploadDir = __DIR__ . '/../admin/uploads/';
                $profilePicsDir = $uploadDir . 'profile_pictures/';

                // Check if directories exist, if not, create them
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                if (!is_dir($profilePicsDir)) {
                    mkdir($profilePicsDir, 0755, true);
                }

                $fileName = basename($_FILES['profile_photo']['name']);
                $targetFile = $profilePicsDir . $fileName;

                // Check if the file is a valid image
                $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
                $validExtensions = array("jpg", "jpeg", "png", "gif");

                if (in_array($fileType, $validExtensions)) {
                    if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $targetFile)) {
                        $profilePhotoPath = 'admin/uploads/profile_pictures/' . $fileName;

                        // Prepare SQL query to insert the user
                        $stmt = $con->prepare("INSERT INTO users (first_name, last_name, username, email, password, profile_photo, role) VALUES (?, ?, ?, ?, ?, ?, 'User')");
                        $stmt->bind_param("ssssss", $firstName, $lastName, $userName, $email, $hashed_password, $fileName);

                        if ($stmt->execute()) {
                            echo "<script>alert('User registered successfully!'); window.location.href = 'login.php';</script>";
                        } else {
                            echo "<script>alert('Error during registration. Please try again later.');</script>";
                        }
                    } else {
                        echo "<script>alert('Error uploading the profile photo.');</script>";
                    }
                } else {
                    echo "<script>alert('Only JPG, JPEG, PNG, and GIF files are allowed.');</script>";
                }
            } else {
                echo "<script>alert('Please upload a profile photo.');</script>";
            }

            $stmt->close();
        }
    }
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
  height: 100%;
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
  margin-right: 5%;
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
    <form action="register.php" method="POST" id="registerForm" enctype="multipart/form-data">
      <h2>REGISTER FORM</h2>

      <div class="input-field">
        <input type="text" name="first_name" required>
        <label>
            <i class="fas fa-user pr-1"></i>Enter your First Name
        </label>
        <span class="form-text text-danger" id="firstNameError"></span>
      </div>

      <div class="input-field">
        <input type="text" name="last_name" required>
        <label>
            <i class="fas fa-user pr-1"></i>Enter your Last Name
        </label>
        <span class="form-text text-danger" id="lastNameError"></span>
      </div>

      <div class="input-field">
        <input type="text" name="username" required>
        <label>
            <i class="fas fa-user pr-1"></i>Enter your Username
        </label>
        <span class="form-text text-danger" id="usernameError"></span>
      </div>

      <div class="input-field">
        <input type="text" name="email" required>
        <label>
            <i class="fas fa-envelope pr-1"></i>Enter your email
        </label>
        <span class="form-text text-danger" id="emailError"></span>
      </div>

      <div class="input-field">
        <input type="password" name="password" required>
        <label>
            <i class="fas fa-lock pr-1"></i>Enter your password
        </label>
        <span class="form-text text-danger" id="passwordError"></span>
      </div>

      <label class="pr-5"><i class="fas fa-user"></i> Profile Photo</label>
      <div class="input-field">
        <input type="file" id="profile_photo" name="profile_photo" accept="image/*" required>
      </div>

      <button type="submit" name="registerUser" class="mt-3">Register</button>
      <div class="register">
          <p>Do you have an account? <a href="login.php">login</a></p>
      </div>
    </form>

    <script>
        document.getElementById('registerForm').addEventListener('submit', function(event) {
            clearValidationMessages();

            var valid = true;

            // Validate first name
            var firstName = document.querySelector('input[name="first_name"]');
            if (firstName.value.trim() === '') {
                valid = false;
                document.getElementById('firstNameError').innerText = 'First name is required.';
            }

            // Validate last name
            var lastName = document.querySelector('input[name="last_name"]');
            if (lastName.value.trim() === '') {
                valid = false;
                document.getElementById('lastNameError').innerText = 'Last name is required.';
            }

            // Validate username
            var username = document.querySelector('input[name="username"]');
            if (username.value.trim() === '') {
                valid = false;
                document.getElementById('usernameError').innerText = 'Username is required.';
            }

            // Validate email
            var email = document.querySelector('input[name="email"]');
            if (email.value.trim() === '') {
                valid = false;
                document.getElementById('emailError').innerText = 'Email is required.';
            } else if (!validateEmail(email.value.trim())) {
                valid = false;
                document.getElementById('emailError').innerText = 'Please enter a valid email.';
            }

            // Validate password
            var password = document.querySelector('input[name="password"]');
            if (password.value.trim() === '') {
                valid = false;
                document.getElementById('passwordError').innerText = 'Password is required.';
            } else if (password.value.length < 8) {
                valid = false;
                document.getElementById('passwordError').innerText = 'Password must be at least 8 characters.';
            }

            if (!valid) {
                event.preventDefault();
            }
        });

        function validateEmail(email) {
            var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        function clearValidationMessages() {
            var messages = document.querySelectorAll('.form-text.text-danger');
            messages.forEach(function(message) {
                message.innerText = '';
            });
        }
    </script>

  </div>
</body>
</html>
