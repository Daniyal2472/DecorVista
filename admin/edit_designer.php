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

// Fetch designer details based on the passed designer ID (via GET or POST)
if (isset($_GET['id'])) {
    $designer_id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE user_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('i', $designer_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $designer = $result->fetch_assoc();

    if (!$designer) {
        echo "Designer not found.";
        exit;
    }
}

// Handle the form submission for updating designer details
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $portfolio_url = $_POST['portfolio_url'];
    $years_of_experience = $_POST['years_of_experience'];
    $specialization = $_POST['specialization'];
    $contact = $_POST['contact'];
    $profile_photo = $designer['profile_photo']; // Preserve the existing profile photo by default

    // Check if a new profile photo has been uploaded
    if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
        $file_name = $_FILES['profile_photo']['name'];
        $file_tmp = $_FILES['profile_photo']['tmp_name'];
        $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

        // Validate the file extension
        if (in_array($file_extension, $allowed_extensions)) {
            // Define the upload path and move the file
            $new_file_name = "profile_" . time() . "." . $file_extension;
            $upload_path = "uploads/" . $new_file_name;
            if (move_uploaded_file($file_tmp, $upload_path)) {
                // Update the profile photo path if the file is successfully uploaded
                $profile_photo = $new_file_name;
            }
        } else {
            echo "Invalid file format. Only JPG, JPEG, PNG, and GIF are allowed.";
        }
    }

    // Update designer details in the database
    $update_sql = "UPDATE users SET email = ?, portfolio_url = ?, years_of_experience = ?, specialization = ?, contact = ?, profile_photo = ? WHERE user_id = ?";
    $update_stmt = $con->prepare($update_sql);
    $update_stmt->bind_param('ssisssi', $email, $portfolio_url, $years_of_experience, $specialization, $contact, $profile_photo, $designer_id);

    if ($update_stmt->execute()) {
        // Redirect to the designers list or a success message page
        echo "<script>alert('Designer updated successfully'); window.location.href='interior_designers.php';</script>";
        header('Location: interior_designers.php');
        exit;
    } else {
        echo "Error updating designer details: " . $con->error;
    }
}
?>

<div class="card card-primary col-12">
    <div class="card-header">
        <h3 class="card-title">Edit Designer</h3>
    </div>
    <form method="POST" enctype="multipart/form-data" id="editDesignerForm">
        <div class="card-body">
            <div class="row">
                <div class="form-group col-sm-6">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($designer['email']); ?>" required>
                </div>
                <div class="form-group col-sm-6">
                    <label for="portfolio_url">Portfolio URL</label>
                    <input type="url" class="form-control" id="portfolio_url" name="portfolio_url" value="<?php echo htmlspecialchars($designer['portfolio_url']); ?>" required>
                </div>
                <div class="form-group col-sm-6">
                    <label for="years_of_experience">Experience (years)</label>
                    <input type="number" class="form-control" id="years_of_experience" name="years_of_experience" value="<?php echo htmlspecialchars($designer['years_of_experience']); ?>" required>
                </div>
                <div class="form-group col-sm-6">
                    <label for="specialization">Specialization</label>
                    <input type="text" class="form-control" id="specialization" name="specialization" value="<?php echo htmlspecialchars($designer['specialization']); ?>" required>
                </div>
                <div class="form-group col-sm-6">
                    <label for="profile_photo">Profile Photo</label>
                    <input type="file" class="form-control" id="profile_photo" name="profile_photo">
                    <?php if (!empty($designer['profile_photo'])): ?>
                        <img src="uploads/profile_pictures/<?php echo htmlspecialchars($designer['profile_photo']); ?>" alt="Profile Photo" width="100" class="mt-2">
                    <?php endif; ?>
                </div>
                <div class="form-group col-sm-6">
                    <label for="contact">Contact Number</label>
                    <input type="text" class="form-control" id="contact" name="contact" value="<?php echo htmlspecialchars($designer['contact']); ?>" required>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Update Designer</button>
        </div>
    </form>
</div>


<script>
    document.getElementById('editDesignerForm').addEventListener('submit', function(event) {
        // Fetch form fields
        var email = document.getElementById('email').value;
        var portfolio_url = document.getElementById('portfolio_url').value;
        var years_of_experience = document.getElementById('years_of_experience').value;
        var specialization = document.getElementById('specialization').value;
        var contact = document.getElementById('contact').value;

        // Email validation regex
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        // URL validation regex
        var urlPattern = /^(https?|ftp):\/\/[^\s/$.?#].[^\s]*$/i;

        // Contact number validation (digits only)
        var contactPattern = /^[0-9]{10,15}$/;

        // Clear any existing validation messages
        clearValidationMessages();

        // Validate email
        if (!emailPattern.test(email)) {
            event.preventDefault();
            showValidationMessage('email', 'Please enter a valid email address.');
        }

        // Validate portfolio URL
        if (!urlPattern.test(portfolio_url)) {
            event.preventDefault();
            showValidationMessage('portfolio_url', 'Please enter a valid URL.');
        }

        // Validate years of experience (must be a positive number)
        if (isNaN(years_of_experience) || years_of_experience <= 0) {
            event.preventDefault();
            showValidationMessage('years_of_experience', 'Please enter a valid number for years of experience.');
        }

        // Validate specialization (non-empty)
        if (specialization.trim() === '') {
            event.preventDefault();
            showValidationMessage('specialization', 'Please enter a specialization.');
        }

        // Validate contact number
        if (!contactPattern.test(contact)) {
            event.preventDefault();
            showValidationMessage('contact', 'Please enter a valid contact number (10-15 digits).');
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
