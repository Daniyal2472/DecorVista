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
    // Check if ID is provided
    if (isset($_GET['id'])) {
        $portfolio_id = intval($_GET['id']); // Sanitize input

        // Fetch existing portfolio data
        $sql = "SELECT * FROM `designer_portfolio` WHERE `id` = $portfolio_id";
        $result = $con->query($sql);
        
        if ($result->num_rows > 0) {
            $portfolio = $result->fetch_assoc();
        } else {
            echo "<script>alert('Portfolio not found.'); window.location.href = 'designer_portfolio.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Invalid request.'); window.location.href = 'designer_portfolio.php';</script>";
        exit();
    }

    if (isset($_POST['edit_design'])) {
        $title = mysqli_real_escape_string($con, $_POST['title']);
        $category_id = intval($_POST['category_id']);
        $description = mysqli_real_escape_string($con, $_POST['description']);
        
        // Handle file upload
        $image_url = $portfolio['image']; // Keep current image by default
        if (isset($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $target_dir = "uploads/portfolio_images/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            $image_url = basename($_FILES["image"]["name"]); // Update with new image name
    
            if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                echo "<script>alert('Error uploading file.');</script>";
            }
        }
    
        // Update query to save the changes
        $sql = "UPDATE `designer_portfolio` SET `title`='$title', `category_id`='$category_id', `description`='$description', `image`='$image_url' WHERE `id`=$portfolio_id";
    
        if ($con->query($sql) === TRUE) {
            echo "<script>window.location.href='designer_portfolio.php';</script>";
        } else {
            echo "<script>alert('Error: " . $con->error . "');</script>";
        }
    }
?>
<div class="card card-primary col-12">
    <div class="card-header">
        <h3 class="card-title">Edit Design</h3>
    </div>
    <form method="POST" enctype="multipart/form-data" onsubmit="return validateForm();">
        <div class="card-body">
            <div class="row">
                <div class="form-group col-sm-6">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?php echo $portfolio['title']; ?>" placeholder="Enter design title" required>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control" id="category_id" name="category_id" required>
                            <option value="" disabled>Select category</option>
                            <?php
                            $sql = "SELECT * FROM `categories`";
                            $result = $con->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $selected = ($row['category_id'] == $portfolio['category_id']) ? 'selected' : '';
                            ?>
                            <option value="<?php echo $row['category_id']?>" <?php echo $selected; ?>><?php echo $row['category_name']?></option>
                            <?php
                                }
                            } else {
                                echo "<option value='' disabled>No categories found</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group col-sm-6">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" placeholder="Enter description" required><?php echo $portfolio['description']; ?></textarea>
                </div>
                <div class="form-group col-sm-6">
                    <label for="image">Image</label>
                    <input type="file" class="form-control-file" id="image" name="image">
                    <small>Leave blank to keep the current image.</small>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" name="edit_design" class="btn btn-primary">Update Design</button>
        </div>
    </form>
</div>

<?php
include 'includes/footer.php';
}
?>
