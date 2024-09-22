<?php
include 'includes/header.php';

if ($_SESSION['role'] === 'User') {
    echo "<script>
        alert('You are not authorized to access this page.\\nPlease login as Admin or Designer.');
        window.location.href = '/DecorVista/decorvista/login.php';
    </script>";
    exit();
}
if (!isset($_SESSION['role'])) {
    echo "<script>
        alert('Please register to access this page.');
        window.location.href = '/DecorVista/decorvista/register.php';
    </script>";
    exit();
}

if ($_SESSION['role'] === 'Admin' || $_SESSION['role'] === 'Designer') {

// Fetch user ID from URL
$user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update user logic
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $contact = mysqli_real_escape_string($con, $_POST['contact']);
    $first_name = mysqli_real_escape_string($con, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($con, $_POST['last_name']);
    $role = mysqli_real_escape_string($con, $_POST['role']);

    // Handle profile photo upload
    $profile_photo = $_FILES['profile_photo']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($profile_photo);
    $uploadOk = 1;

    // Check if file is an image
    if ($profile_photo) {
        $check = getimagesize($_FILES['profile_photo']['tmp_name']);
        if ($check === false) {
            echo "<script>alert('File is not an image.');</script>";
            $uploadOk = 0;
        }
    }

    // Check if uploadOk is still true
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $target_file)) {
            // Update query with profile photo
            $sql = "UPDATE `users` SET 
                        `username`='$username', 
                        `email`='$email', 
                        `contact`='$contact', 
                        `first_name`='$first_name', 
                        `last_name`='$last_name', 
                        `role`='$role', 
                        `profile_photo`='$target_file' 
                    WHERE `user_id`='$user_id'";
        } else {
            // If file upload fails, still update other fields without changing the photo
            $sql = "UPDATE `users` SET 
                        `username`='$username', 
                        `email`='$email', 
                        `contact`='$contact', 
                        `first_name`='$first_name', 
                        `last_name`='$last_name', 
                        `role`='$role' 
                    WHERE `user_id`='$user_id'";
        }
    }

    // Execute the query
    if ($con->query($sql) === TRUE) {
        echo "<script>alert('User updated successfully'); window.location.href='users.php';</script>";
    } else {
        echo "<script>alert('Error: " . $con->error . "');</script>";
    }
}

// Fetch existing user data
$sql = "SELECT * FROM `users` WHERE `user_id`='$user_id'";
$result = $con->query($sql);
$user = $result->fetch_assoc();

if (!$user) {
    echo "User not found.";
    exit;
}
?>

<!-- Add the form with basic JavaScript validation -->
<div class="card card-primary col-12">
  <div class="card-header">
    <h3 class="card-title">Edit User</h3>
  </div>
  <form method="POST" enctype="multipart/form-data" onsubmit="return validateForm()" id="yourFormId">
    <div class="card-body">
      <div class="row">
        <!-- Username -->
        <div class="form-group col-sm-6">
          <label for="username">Username</label>
          <input type="text" class="form-control" id="username" name="username" value="<?php echo $user['username']; ?>" required>
        </div>
        
        <!-- Email -->
        <div class="form-group col-sm-6">
          <label for="email">Email address</label>
          <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>" required>
        </div>

        <!-- First Name -->
        <div class="form-group col-sm-6">
          <label for="first_name">First Name</label>
          <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $user['first_name']; ?>" required>
        </div>
        
        <!-- Last Name -->
        <div class="form-group col-sm-6">
          <label for="last_name">Last Name</label>
          <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $user['last_name']; ?>" required>
        </div>

        <!-- Contact Number -->
        <div class="form-group col-sm-6">
          <label for="contact">Contact Number</label>
          <input type="text" class="form-control" id="contact" name="contact" value="<?php echo $user['contact']; ?>" required>
        </div>

        <!-- Role -->
        <div class="col-sm-6">
          <div class="form-group">
            <label>Role</label>
            <select class="form-control" id="role" name="role" required>
              <option value="" disabled>Select Role</option>
              <option value="User" <?php echo $user['role'] === 'User' ? 'selected' : ''; ?>>User</option>
              <option value="Designer" <?php echo $user['role'] === 'Designer' ? 'selected' : ''; ?>>Designer</option>
              <option value="Admin" <?php echo $user['role'] === 'Admin' ? 'selected' : ''; ?>>Admin</option>
            </select>
          </div>
        </div>

        <!-- Profile Photo -->
        <div class="form-group col-sm-6">
          <label for="profile_photo">Profile Photo</label>
          <input type="file" class="form-control" id="profile_photo" name="profile_photo">
          <?php if (!empty($user['profile_photo'])): ?>
            <img src="<?php echo $user['profile_photo']; ?>" alt="Profile Photo" width="100" class="mt-2">
          <?php endif; ?>
        </div>
      </div>
    </div>

    <div class="card-footer">
      <button type="submit" class="btn btn-primary">Update</button>
    </div>
  </form>
</div>

<script>
    document.getElementById('yourFormId').addEventListener('submit', function(event) {
        // Clear previous validation messages
        clearValidationMessages();

        // Fetch form field values
        var username = document.getElementById('username').value;
        var email = document.getElementById('email').value;
        var firstName = document.getElementById('first_name').value;
        var lastName = document.getElementById('last_name').value;
        var contact = document.getElementById('contact').value;
        var role = document.getElementById('role').value;

        var isValid = true;  // To track the validation state

        // Check if fields are empty
        if (username === "") {
            showValidationMessage('username', 'Username is required.');
            isValid = false;
        }
        if (email === "") {
            showValidationMessage('email', 'Email is required.');
            isValid = false;
        }
        if (firstName === "") {
            showValidationMessage('first_name', 'First name is required.');
            isValid = false;
        }
        if (lastName === "") {
            showValidationMessage('last_name', 'Last name is required.');
            isValid = false;
        }
        if (contact === "") {
            showValidationMessage('contact', 'Contact is required.');
            isValid = false;
        }
        if (role === "") {
            showValidationMessage('role', 'Role is required.');
            isValid = false;
        }

        // Validate email format
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (email && !emailPattern.test(email)) {
            showValidationMessage('email', 'Please enter a valid email address.');
            isValid = false;
        }

        // Validate contact number format
        var contactPattern = /^03\d{9}$/;
        if (contact && !contactPattern.test(contact)) {
            showValidationMessage('contact', 'Please enter a valid contact number (e.g., 03001234567).');
            isValid = false;
        }

        // If any validation failed, prevent form submission
        if (!isValid) {
            event.preventDefault();
        }
    });

    // Function to display validation message below the respective field
    function showValidationMessage(fieldId, message) {
        var field = document.getElementById(fieldId);
        var messageElement = document.createElement('small');
        messageElement.className = 'form-text text-danger';
        messageElement.innerHTML = message;
        field.parentElement.appendChild(messageElement);
    }

    // Function to clear all validation messages
    function clearValidationMessages() {
        var messages = document.querySelectorAll('.form-text.text-danger');
        messages.forEach(function(message) {
            message.remove();
        });
    }
</script>


<?php
include 'includes/footer.php';
  }
?>
